<?php

namespace App\Repositories\Application;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Application\Contracts\EmpresaRepository;
use App\Models\Application\Empresa;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Exceptions\Access\GeneralException;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;

//use App\Validators\EmpresaValidator;

/**
 * Class EmpresaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EmpresaRepositoryEloquent extends BaseRepository implements EmpresaRepository, CacheableInterface
{

    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Empresa::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Retornar todos os registros com relacionamentos
     *
     * @param array $columns
     * @return mixed
     */
    public function getAll($columns = ['*'])
    {
        if (!$this->allowedCache('getAll') || $this->isSkippedCache()) {
            return parent::paginate(8, $columns);
        }

        $key = $this->getCacheKey('getAll', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($columns) {
            return parent::paginate(8, $columns);
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
    public function searchPaginate($field, $value, $columns = ['*'])
    {
        if (!$this->allowedCache('searchPaginate') || $this->isSkippedCache()) {
            return parent::scopeQuery(function($query) use ($field, $value, $columns){
                return $query->where($field,'like','%'. $value .'%')->orWhere('cpf_cnpj',$value);
            })->paginate(8);
        }

        $key = $this->getCacheKey('searchPaginate', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($field, $value, $columns) {
            return parent::scopeQuery(function($query) use ($field, $value, $columns){
                return $query->where($field,'like','%'. $value .'%')->orWhere('cpf_cnpj',$value);
            })->paginate(8);
        });

        return $value;
    }

    public function findEmpresa($id)
    {
        $result = $this->model->query()->find($id);
        if (is_null($result)){
            throw new GeneralException("Não foi localizado registro no banco de dados!");
        }
        return $result;
    }

    public function create(array $attributes)
    {
        if (!is_null($this->validator)) {
            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }
        if ($this->model->query()->where('cpf_cnpj', $attributes['cpf_cnpj'])->first()){
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
