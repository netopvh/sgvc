<?php

namespace App\Repositories\Access;

use App\Exceptions\Access\GeneralException;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Access\Contracts\RoleRepository;
use App\Models\Access\Role;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Repository\Events\RepositoryEntityCreated;

//use App\Validators\Access\RoleValidator;

/**
 * Class RoleRepositoryEloquent
 * @package namespace App\Repositories\Access;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository, CacheableInterface
{

    /**
     * Trait com os métodos do CacheableInterface
     */
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->model->query()->count();
    }

    public function findRole($id)
    {
        $result = $this->model->query()->find($id);
        if (is_null($result)){
            throw new GeneralException('Registro não localizado no banco de dados');
        }
        return $this->model->with('perms')->find($id);
    }

    /**
     * Insere Registro no Banco de Dados
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        if (!is_null($this->validator)) {
            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }
        if ($this->model->query()->where('name', $attributes['name'])->first()){
            throw new GeneralException('Registro já cadastrado no sistema!');
        }
        //Verifica se possui permissões de acesso total
        $all = $attributes['associated-permissions'] == 'all' ? true : false;

        if (! isset($attributes['permissions'])){
            $attributes['permissions'] = [];
        }

        //Essa verificação só é requirida se o all for falso.
        if(! $all){
            if (count($attributes['permissions']) == 0){
                throw new GeneralException('É obrigatório inserir permissões');
            }
        }

        $this->model->name = $attributes['name'];
        $this->model->sort = isset($attributes['sort']) && strlen($attributes['sort']) > 0 && is_numeric($attributes['sort']) ? (int) $attributes['sort'] : 0;

        //Veja se esta função tem todas as permissões e defina o sinalizador na função
        $this->model->all = $all;

        if ($this->model->save()){
            if (! $all){
                $permissions = [];

                if (is_array($attributes['permissions']) && count($attributes['permissions'])){
                    foreach ($attributes['permissions'] as $perm){
                        if (is_numeric($perm)){
                            array_push($permissions, $perm);
                        }
                    }
                    $this->model->attachPermissions($permissions);
                }

            }
            event(new RepositoryEntityCreated($this, $this->model));

            return true;

        }else{
            throw new GeneralException('Erro ao gravar registro no banco');
        }
    }

    /**
     * Salva as modificações no banco de dados
     *
     * @param array $attributes
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function update(array $attributes, $id)
    {
        $role = $this->model->find($id);

        //verifica se o perfil tem acesso, o administrador sempre tem acesso
        if ($role->id == 1){
            $all = true;
        }else{
            $all = $attributes['associated-permissions'] == 'all' ? true : false;
        }

        if (! isset($attributes['permissions'])){
            $attributes['permissions'] = [];
        }

        // Esta configuração só é necessária se tudo for falso
        if (! $all){
            //Verifica se a perfil possui alguma permissão, que é obrigatória
            if (count($attributes['permissions']) == 0){
                throw new GeneralException('É obrigatório inserir permissões');
            }
        }
        $role->name = $attributes['name'];
        $role->sort = isset($attributes['sort']) && strlen($attributes['sort']) > 0 && is_numeric($attributes['sort']) ? (int) $attributes['sort'] : 0;

        //Atribui caso seja administrador true ou false
        $role->all = $all;

        if ($role->save()){
            //Se a perfil tem o acesso desanexar todas as permissões porque elas não são necessárias
            if ($all){
                $role->perms()->sync([]);
            }else{
                //Remove todas as permissões
                $role->perms()->sync([]);

                //atribui permissões se o perfil não tiver todos os direitos de acesso
                $permissions = [];

                if (is_array($attributes['permissions']) && count($attributes['permissions'])){
                    foreach ($attributes['permissions'] as $perm) {
                        if (is_numeric($perm)){
                            array_push($permissions, $perm);
                        }
                    }
                }
                $role->attachPermissions($permissions);
            }

            event(new RepositoryEntityUpdated($this, $this->model));
            return true;
        }else{
            throw new GeneralException('Erro ao gravar registro no banco');
        }
    }
}
