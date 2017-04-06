<?php

namespace App\Repositories\Application;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Application\Contracts\UnidadeRepository;
use App\Models\Application\Unidade;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Exceptions\Access\GeneralException;
use Prettus\Repository\Events\RepositoryEntityCreated;

//use App\Validators\UnidadeValidator;

/**
 * Class UnidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UnidadeRepositoryEloquent extends BaseRepository implements UnidadeRepository, CacheableInterface
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
        return Unidade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findUnidade($id)
    {
        $result = $this->model->query()->find($id);
        if (is_null($result)){
            throw new GeneralException("Não foi localizado registro no banco de dados!");
        }
        return $result;
    }

    /**
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
}
