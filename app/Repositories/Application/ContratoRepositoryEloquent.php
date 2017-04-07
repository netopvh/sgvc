<?php

namespace App\Repositories\Application;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Application\Contracts\ContratoRepository;
use App\Models\Application\Contrato;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Exceptions\Access\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

//use App\Validators\ContratoValidator;

/**
 * Class ContratoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ContratoRepositoryEloquent extends BaseRepository implements ContratoRepository, CacheableInterface
{

    use CacheableRepository;

    /**
     * @var $fileName
     */
    private $fileName;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contrato::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $attributes
     * @throws GeneralException
     */
    public function createNormal(array $attributes)
    {
        if (!is_null($this->validator)) {

            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }
        if ($this->model->query()->where('numero', $attributes['numero'])->where('ano', $attributes['ano'])->first()) {
            throw new GeneralException('Registro já cadastrado no sistema!');
        }

        $gestores = $attributes['gestores'];
        $fiscais = $attributes['fiscais'];
        $empresas = $attributes['empresas'];

        $attributes = $this->unsetItensArray($attributes);

        $model = $this->model->newInstance($attributes);

        if ($model->save()) {

            $this->resetModel();

            $model->gestores()->attach($gestores);
            $model->fiscais()->attach($fiscais);
            $model->empresas()->attach($empresas);

            event(new RepositoryEntityCreated($this, $model));

            return $model;
        } else {
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

        $gestores = $attributes['gestores'];
        $fiscais = $attributes['fiscais'];
        $empresas = $attributes['empresas'];

        $attributes = $this->unsetItensArray($attributes);

        $model = $this->model->find($id);

        $model->fill($attributes);

        if ($model->save()) {

            $model->gestores()->detach();
            $model->gestores()->attach($gestores);
            $model->fiscais()->detach();
            $model->fiscais()->attach($fiscais);
            $model->empresas()->detach();
            $model->empresas()->attach($empresas);

            $this->skipPresenter($temporarySkipPresenter);
            $this->resetModel();

            event(new RepositoryEntityUpdated($this, $model));

            return $this->parserResult($model);

        } else {
            throw new GeneralException('Erro ao gravar registro no banco');
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function viewContrato($id)
    {
        $result = $this->model->query()->with(['casa', 'unidade', 'empresas', 'gestores', 'fiscais'])->find($id);
        if (is_null($result)) {
            throw new GeneralException("Não foi localizado registro no banco de dados!");
        }
        return $result;
    }

    /**
     * Método falta implementar verificação se o contrato está aditivado ou não
     *
     * @param array $columns
     * @return mixed
     */
    public function getAllWithRelations($columns = ['*'])
    {
        if (!$this->allowedCache('getAllWithRelations') || $this->isSkippedCache()) {
            return parent::with(['casa', 'empresas', 'aditivos', 'gestores', 'fiscais'])->scopeQuery(function ($query) {
                $query->where('status', 'V');
                $query->orderBy('encerramento', 'asc');
                return $query;
            })->paginate(7, $columns);
        }

        $key = $this->getCacheKey('getAllWithRelations', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($columns) {
            return parent::with(['casa', 'empresas', 'aditivos', 'gestores', 'fiscais'])->scopeQuery(function ($query) {
                $query->where('status', 'V');
                $query->orderBy('encerramento', 'asc');
                return $query;
            })->paginate(7, $columns);
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
    public function searchWithRelations(array $attributes, $columns = ['*'])
    {
        $contaMes = Carbon::now()->addMonth()->format('Y-m-d');

        if (!$this->allowedCache('searchWithRelations') || $this->isSkippedCache()) {
            return parent::with(['casa', 'empresas', 'aditivos', 'gestores', 'fiscais'])->scopeQuery(function ($query) use ($attributes, $contaMes, $columns) {

                isset($attributes['numero']) ? $query->where('numero', $attributes['numero']) : null;
                isset($attributes['ano']) ? $query->where('ano', $attributes['ano']) : null;
                isset($attributes['tipo']) ? $query->where('tipo', $attributes['tipo']) : null;
                isset($attributes['casa']) ? $query->where('casa_id', $attributes['casa']) : null;
                isset($attributes['status']) ? $query->where('status', $attributes['status']) : null;
                isset($attributes['inicio']) ? $query->where('inicio', '>=', Carbon::createFromFormat('d/m/Y', $attributes['inicio'])->format('Y-m-d')) : null;
                isset($attributes['encerramento']) ? $query->where('encerramento', '<=', Carbon::createFromFormat('d/m/Y', $attributes['encerramento'])->format('Y-m-d')) : null;
                return $query->orderBy('encerramento', 'asc');

            })->paginate(7);
        }

        $key = $this->getCacheKey('searchWithRelations', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($attributes, $contaMes, $columns) {
            return parent::with(['casa', 'empresas', 'aditivos', 'gestores', 'fiscais'])->scopeQuery(function ($query) use ($attributes, $contaMes, $columns) {

                isset($attributes['numero']) ? $query->where('numero', $attributes['numero']) : null;
                isset($attributes['ano']) ? $query->where('ano', $attributes['ano']) : null;
                isset($attributes['tipo']) ? $query->where('tipo', $attributes['tipo']) : null;
                isset($attributes['casa']) ? $query->where('casa_id', $attributes['casa']) : null;
                isset($attributes['status']) ? $query->where('status', $attributes['status']) : null;
                isset($attributes['inicio']) ? $query->where('inicio', '>=', Carbon::createFromFormat('d/m/Y', $attributes['inicio'])->format('Y-m-d')) : null;
                isset($attributes['encerramento']) ? $query->where('encerramento', '<=', Carbon::createFromFormat('d/m/Y', $attributes['encerramento'])->format('Y-m-d')) : null;
                return $query->orderBy('encerramento', 'asc');
            })->paginate(7);
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
    public function searchForAdditions(array $attributes, $columns = ['*'])
    {
        $data = $this->countValues($attributes['search']);
        if (!$data) {
            throw new GeneralException("Digite o Numero e o Ano do Contrato");
        }

        $contrato = $this->model->query()
            ->with(['empresas', 'unidade', 'casa', 'aditivos', 'gestores', 'fiscais'])
            ->where('numero', $data[0])
            ->where('orig_ano', $data[1])
            ->first($columns);
        if (is_null($contrato)) {
            throw new GeneralException("Não foi localizado nenhum contrato");
        }
        return $contrato;

    }

    public function getAllByVencimento($columns = ['*'])
    {
        $todayWithDays = Carbon::now()->addDays(90);
        $today = $todayWithDays->toDateString();
        //dd($today);

        if (!$this->allowedCache('getAllByVencimento') || $this->isSkippedCache()) {
            return parent::with(['casa', 'empresas', 'aditivos', 'gestores', 'fiscais'])->scopeQuery(function ($query) use ($today) {
                $query->whereDate('encerramento','<=',$today);
                $query->where('status', 'V');
                $query->orderBy('encerramento', 'asc');
                return $query;
            })->paginate(7, $columns);
        }

        $key = $this->getCacheKey('getAllByVencimento', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($columns, $today) {
            return parent::with(['casa', 'empresas', 'aditivos', 'gestores', 'fiscais'])->scopeQuery(function ($query) use ($today) {
                $query->whereDate('encerramento','<=',$today);
                $query->where('status', 'V');
                $query->orderBy('encerramento', 'asc');
                return $query;
            })->paginate(7, $columns);
        });

        return $value;
    }

    public function getAllByVencimentoMail($columns = ['*'])
    {
        $todayWithDays = Carbon::now()->addDays(90);
        $today = $todayWithDays->toDateString();

        if (!$this->allowedCache('getAllByVencimento') || $this->isSkippedCache()) {
            return parent::with(['casa', 'empresas', 'gestores', 'fiscais'])->scopeQuery(function ($query) use ($today) {
                $query->whereDate('encerramento','<',$today);
                $query->where('status', 'V');
                $query->orderBy('encerramento', 'asc');
                return $query;
            })->all($columns);
        }

        $key = $this->getCacheKey('getAllByVencimento', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($columns, $today) {
            return parent::with(['casa', 'empresas', 'gestores', 'fiscais'])->scopeQuery(function ($query) use ($today) {
                $query->whereDate('encerramento','<',$today);
                $query->where('status', 'V');
                $query->orderBy('encerramento', 'asc');
                return $query;
            })->all($columns);
        });

        return $value;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findContrato($id)
    {
        if (!$this->allowedCache('findContrato') || $this->isSkippedCache()) {
            return parent::with(['casa', 'unidade', 'gestores', 'fiscais', 'empresas'])->find($id);
        }

        $key = $this->getCacheKey('findContrato', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($id) {
            return parent::with(['casa', 'unidade', 'gestores', 'fiscais', 'empresas'])->find($id);
        });

        return $value;
    }

    /**
     * @param $id
     * @return array
     */
    public function findGestores($id)
    {
        if (!$this->allowedCache('findGestores') || $this->isSkippedCache()) {
            $gestores = [];
            $contrato = parent::with('gestores')->find($id);
            foreach ($contrato->gestores->toArray() as $gestor) {
                $gestores[] = $gestor['id'];
            }
            return $gestores;

        }

        $key = $this->getCacheKey('findGestores', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($id) {
            $gestores = [];
            $contrato = parent::with('gestores')->find($id);
            foreach ($contrato->gestores->toArray() as $gestor) {
                $gestores[] = $gestor['id'];
            }
            return $gestores;
        });

        return $value;

    }

    /**
     * @param $id
     * @return array
     */
    public function findFiscais($id)
    {
        if (!$this->allowedCache('findFiscais') || $this->isSkippedCache()) {
            $fiscais = [];
            $contrato = parent::with('fiscais')->find($id);
            foreach ($contrato->fiscais->toArray() as $fiscal) {
                $fiscais[] = $fiscal['id'];
            }
            return $fiscais;

        }

        $key = $this->getCacheKey('findFiscais', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($id) {
            $fiscais = [];
            $contrato = parent::with('fiscais')->find($id);
            foreach ($contrato->fiscais->toArray() as $fiscal) {
                $fiscais[] = $fiscal['id'];
            }
            return $fiscais;
        });

        return $value;
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function findEmpresas($id)
    {
        if (!$this->allowedCache('findEmpresas') || $this->isSkippedCache()) {
            $empresas = [];
            $contrato = parent::with('empresas')->find($id);
            foreach ($contrato->empresas->toArray() as $empresa) {
                $empresas[] = $empresa['id'];
            }
            return $empresas;

        }

        $key = $this->getCacheKey('findEmpresas', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($id) {
            $empresas = [];
            $contrato = parent::with('empresas')->find($id);
            foreach ($contrato->empresas->toArray() as $empresa) {
                $empresas[] = $empresa['id'];
            }
            return $empresas;
        });

        return $value;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function excelExport()
    {
        $model = $this->model->query()
            ->join('casas', 'casas.id', 'contratos.casa_id')
            ->select(DB::raw('
            contratos.numero AS NUMERO,
            contratos.ano AS ANO,
            casas.name AS CONTRATANTE,
            CASE WHEN contratos.status = \'V\' THEN \'Vigente\' 
            WHEN contratos.status = \'C\' THEN \'Cancelado\' 
            ELSE \'Finalizado\' END AS STATUS,
            CASE WHEN contratos.tipo = \'N\' THEN \'Normal\' 
            WHEN contratos.tipo = \'P\' THEN \'Prestação de Serviço\' 
            ELSE \'Credenciamento\' END AS MODELO,
            contratos.modalidade AS MODALIDADE,
            contratos.tipo_servico AS TIPO,
            CASE WHEN contratos.aditivado = \'N\' THEN \'Não\' ELSE \'Sim\' END AS ADITIVADO,
            CASE WHEN contratos.ambito = \'M\' THEN \'Municipal\' ELSE \'Estadual\' END AS AMBITO,
            REPLACE(CONVERT(NVARCHAR,contratos.inicio,106),\' \',\'/\') AS INICIO,
            REPLACE(CONVERT(NVARCHAR,contratos.encerramento,106),\' \',\'/\') AS ENCERRAMENTO,
            FORMAT(contratos.total,\'C\',\'pt-br\') AS TOTAL,
            FORMAT(contratos.mensal,\'C\',\'pt-br\') AS MENSAL,
            contratos.objeto AS OBJETO'))
            ->where('contratos.status', 'V')
            ->get();
        return $model;
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function unsetItensArray(array $attributes)
    {
        $itens = ['gestores', 'fiscais', 'empresas', 'arquivo'];

        $data = [];
        foreach ($attributes as $key => $value) {
            if ($key == 'ano') {
                $data['orig_ano'] = $value;
            }
            if ($key == 'inicio') {
                $data['orig_inicio'] = $value;
            }
            if ($key == 'encerramento') {
                $data['orig_encerramento'] = $value;
            }
            if ($key == 'total') {
                $data['orig_total'] = $value;
            }
            if ($key == 'mensal') {
                $data['orig_mensal'] = $value;
            }
            if ($key == 'objeto') {
                $data['orig_objeto'] = $value;
            }
            if (!in_array($key, $itens)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * @param $data
     * @return bool
     */
    private function countValues($data)
    {

        $value = explode('/', $data);

        if (count($value) == 2) {
            return $value;
        }

        return false;

    }


}
