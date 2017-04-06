<?php
/**
 * Created by PhpStorm.
 * User: angelo.neto
 * Date: 03/04/2017
 * Time: 10:32
 */

namespace App\Repositories\Application;


use App\Models\Application\ContratoAditivo;
use App\Repositories\Application\Contracts\ContratoAditivoRepository;
use App\Repositories\Application\Contracts\ContratoRepository;
use Illuminate\Foundation\Application;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Repository\Events\RepositoryEntityCreated;
use App\Exceptions\Access\GeneralException;
use Carbon\Carbon;

class ContratoAditivoRepositoryEloquent extends BaseRepository implements ContratoAditivoRepository, CacheableInterface
{

    /**
     * Trait com os métodos do CacheableInterface
     */
    use CacheableRepository;

    /**
     * @var $contrato
     */
    private $contrato;

    public function __construct(Application $app, ContratoRepository $contrato)
    {
        parent::__construct($app);
        $this->contrato = $contrato;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContratoAditivo::class;
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
     */
    public function create(array $attributes)
    {
        if (!is_null($this->validator)) {

            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }

//        $result = $this->model->query()->where('contrato_id',$attributes['contrato_id'])->get()->last();
//
//        if (Carbon::createFromFormat('d/m/Y',$attributes['encerramento'])->format('Y-m-d') >= $result->encerramento){
//            dd("Maior");
//        }else{
//            dd("Menor");
//        }


        //Insere um contador de Aditivos
        $attributes = $this->atribuirContador($attributes);
        //Atribui valores para o Model
        $model = $this->model->newInstance($attributes);

        if ($model->save()) {
            $this->resetModel();

            $contrato = $this->contrato->find($attributes['contrato_id']);
            $contrato->fill($this->dataUpdate($attributes));

            if ($contrato->save()) {

                event(new RepositoryEntityCreated($this, $model));

                return $this->parserResult($model);
            } else {
                throw new GeneralException('Erro ao gravar registro no banco');
            }

        } else {
            throw new GeneralException('Erro ao gravar registro no banco');
        }

    }

    public function findAltFilename(array $attributes)
    {
        $result = $this->model
            ->query()
            ->where('contrato_id',$attributes['contrato_id'])
            ->where('aditivos',$attributes['aditivos'])
            ->get()
            ->first();

        return $result;

    }


    /**
     *
     * Métodos Privados
     *
     */

    /**
     * @param array $attributes
     * @return array
     */
    private function atribuirContador(array $attributes)
    {
        $data = [];
        $counter = $this->model->query()->where('contrato_id', $attributes['contrato_id'])->count() + 1;

        foreach ($attributes as $key => $value) {
            $data[$key] = $value;
        }
        $data['aditivos'] = $counter;
        return $data;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    private function dataUpdate(array $attributes)
    {
        $data['ano'] = $attributes['ano'];
        $data['inicio'] = $attributes['inicio'];
        $data['encerramento'] = $attributes['encerramento'];
        $data['total'] = $attributes['total'];
        $data['mensal'] = $attributes['mensal'];
        $data['objeto'] = $attributes['objeto'];
        $data['aditivado'] = 'S';

        return $data;
    }


}


