<?php

namespace App\Repositories\Access;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Access\Contracts\UserRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use App\Models\Access\User;
use App\Exceptions\Access\GeneralException;
//use App\Validators\Access\UserValidator;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories\Access;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository, CacheableInterface
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
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findUser($id)
    {
        $model = $this->model->query()->find($id);
        if (is_null($model)){
            throw new GeneralException('Registro não localizado no banco de dados');
        }else{
            if ($model->roles()->count() == 0){
                $model->attachRole(3);
            }
        }

        if (!$this->allowedCache('findUser') || $this->isSkippedCache()) {
            return parent::with('roles')->find($id);
        }

        $key = $this->getCacheKey('findUser', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($id) {
            return parent::with('roles')->find($id);
        });

        return $value;
    }

    /**
     * Retornar todos os registros com relacionamentos
     *
     * @param array $columns
     * @return mixed
     */
    public function getAllWithRoles($columns = ['*'])
    {
        if (!$this->allowedCache('getAllWithRoles') || $this->isSkippedCache()) {
            return parent::with('roles')->paginate(8, $columns);
        }

        $key = $this->getCacheKey('getAllWithRoles', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($columns) {
            return parent::with('roles')->paginate(8, $columns);
        });

        return $value;
    }

    /**
     * Efetua a busca no Banco de dados e retorna com relacionamento
     *
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function searchWithRoles($field, $value, $columns = ['*']){
        if (!$this->allowedCache('searchWithRoles') || $this->isSkippedCache()) {
            return parent::scopeQuery(function($query) use ($field, $value, $columns){
                return $query->where($field,'like','%'. $value .'%');
            })->paginate(8);
        }

        $key = $this->getCacheKey('searchWithRoles', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($field, $value, $columns) {
            return parent::scopeQuery(function($query) use ($field, $value, $columns){
               return $query->where($field,'like','%'. $value .'%');
            })->paginate(8);
        });

        return $value;
    }

    public function update(array $attributes, $id)
    {
        $model = $this->model->with('roles')->find($id);
        //$model->all = ($attributes['all'] == 1 ? true : false );

        if ($model->save()){
            $model->roles()->detach();
            $model->roles()->attach($attributes['role_id']);

            event(new RepositoryEntityUpdated($this, $model));

            return $this->parserResult($model);
        }else{
            throw new GeneralException('Erro gravar no banco de dados');
        }
    }
}
