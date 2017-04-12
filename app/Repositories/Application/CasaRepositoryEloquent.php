<?php

namespace App\Repositories\Application;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Application\Contracts\CasaRepository;
use App\Models\Application\Casa;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use App\Exceptions\Access\GeneralException;
//use App\Validators\CasaValidator;

/**
 * Class CasaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CasaRepositoryEloquent extends BaseRepository implements CasaRepository, CacheableInterface
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
        return Casa::class;
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * Cria um novo registro no banco de dados
     *
     * @param array $attributes
     * @return mixed
     * @throws GeneralException
     */
    public function create(array $attributes)
    {
        if (!is_null($this->validator)) {
            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }
        //Verifica se Existe Unidade
        if ($this->model->query()->where('name', $attributes['name'])->first()){
            throw new GeneralException('Registro já cadastrado no sistema!');
        }

        $model = $this->model->newInstance($attributes);
        if ($model->save()){
            $this->resetModel();
            event(new RepositoryEntityCreated($this, $model));
            return $this->parserResult($model);

        }else{
            throw new GeneralException('Erro ao gravar registro no banco');
        }
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();

        if (!is_null($this->validator)) {

            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

            $this->validator->with($attributes)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        }
        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->find($id);

        $model->fill($attributes);
        if ($model->save()){

            $this->skipPresenter($temporarySkipPresenter);
            $this->resetModel();

            event(new RepositoryEntityUpdated($this, $model));

            return $this->parserResult($model);

        }else{
            throw new GeneralException('Erro ao gravar registro no banco');
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findCasa($id)
    {
        $result = $this->model->query()->find($id);
        if (is_null($result)){
            throw new GeneralException("Não foi localizado registro no banco de dados!");
        }
        return $result;
    }
}
