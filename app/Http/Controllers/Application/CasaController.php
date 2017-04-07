<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Repositories\Application\Contracts\CasaRepository;
use Illuminate\Http\Request;
use App\Contracts\Facades\ChannelLog as Log;
use App\Exceptions\Access\GeneralException;
use Zizaco\Entrust\EntrustFacade as Entrust;

class CasaController extends Controller
{

    /**
     * Instancia a repositório
     *
     * @var $casa
     */
    protected $casa;

    /**
     * Cria uma collection de dados
     *
     * @var $collection
     */
    static private $collection;

    /**
     * Inicializa a classe usando o middleware de verificação de autenticação
     *
     * CasaController constructor.
     */
    public function __construct(CasaRepository $casa)
    {
        $this->middleware('auth');
        $this->casa = $casa;
    }

    /**
     * Pagina inicial da tela de casas
     *
     * @return mixed
     */
    public function index()
    {
        if (!Entrust::can('manage-contratantes')){
            abort(404,'Não possui permissão');
        }

        return view('modules.application.cadastros.casa.index')
            ->withCasas($this->casa->all());
    }

    /**
     * Inserir um novo registro no banco de dados
     *
     * @return mixed
     */
    public function create()
    {
        if (!Entrust::can('manage-contratantes')){
            abort(404,'Não possui permissão');
        }

        return view('modules.application.cadastros.casa.create');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try{
            if($this->casa->create($request->all())){
                Log::write('event','Casa '. $request->name .' cadastrada por '. auth()->user()->name);
            }
            return redirect()->route('casas.index');

        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('casas.index');
        }
    }

    /**
     * Busca dados para edição
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if (!Entrust::can('manage-contratantes')){
            abort(404,'Não possui permissão');
        }

        try{
            return view('modules.application.cadastros.casa.edit')
                ->withCasa($this->casa->findCasa($id));
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('casas.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            if($this->casa->update($request->all(), $id)){
                Log::write('event','Casa ' . $request->name .' alterada por '. auth()->user()->name);
            }
            return redirect()->route('casas.index');
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('casas.index');
        }
    }
}