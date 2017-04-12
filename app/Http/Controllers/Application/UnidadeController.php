<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Repositories\Application\Contracts\CasaRepository;
use App\Repositories\Application\Contracts\UnidadeRepository;
use Illuminate\Http\Request;
use App\Contracts\Facades\ChannelLog as Log;
use App\Exceptions\Access\GeneralException;
use Zizaco\Entrust\EntrustFacade as Entrust;

class UnidadeController extends Controller
{

    /**
     * Instancia a repositório
     *
     * @var $unidade
     */
    protected $unidade;

    /**
     * Instancia a repositório
     *
     * @var $casa
     */
    protected $casa;

    /**
     * Inicializa a classe usando o middleware de verificação de autenticação
     *
     * CasaController constructor.
     */
    public function __construct(UnidadeRepository $unidade, CasaRepository $casa)
    {
        $this->middleware('auth');
        $this->unidade = $unidade;
        $this->casa = $casa;
    }

    /**
     * Pagina inicial da tela de casas
     *
     * @return mixed
     */
    public function index()
    {
        if (!Entrust::can('manage-unidades')){
            abort(404,'Não possui permissão');
        }

        return view('modules.application.cadastros.unidades.index')
            ->withUnidades($this->unidade->getAll());
    }

    /**
     * Inserir um novo registro no banco de dados
     *
     * @return mixed
     */
    public function create()
    {
        if (!Entrust::can('manage-unidades')){
            abort(404,'Não possui permissão');
        }

        return view('modules.application.cadastros.unidades.create')
            ->withCasas($this->casa->all());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try{
            if($this->unidade->create($request->all())){
                Log::write('event','Unidade '. $request->name .' cadastrada por '. auth()->user()->name);
            }
            return redirect()->route('unidades.index');

        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('unidades.index');
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
        if (!Entrust::can('manage-unidades')){
            abort(404,'Não possui permissão');
        }

        try{
            return view('modules.application.cadastros.unidades.edit')
                ->withUnidade($this->unidade->findUnidade($id))
                ->withCasas($this->casa->all());
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('unidades.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            if($this->unidade->update($request->all(), $id)){
                Log::write('event','Unidade ' . $request->name .' alterada por '. auth()->user()->name);
            }
            return redirect()->route('unidades.index');
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('unidades.index');
        }
    }

    public function delete($id)
    {
        if (!Entrust::can('manage-unidades')){
            abort(404,'Não possui permissão');
        }

        try{
            $unidade = $this->unidade->find($id)->name;
            if ($this->unidade->delete($id)){
                Log::write('event','Unidade '. $unidade .' removida por '. auth()->user()->name);
            }
            return redirect()->route('unidades.index');
        }catch (GeneralException $e) {
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('unidades.index');
        }
    }

    public function getUnidades($id)
    {
        $casa = $this->casa->find($id);
        $unidades = $casa->unidades()->pluck('name','id')->all();

        return response()->json($unidades);
    }
}