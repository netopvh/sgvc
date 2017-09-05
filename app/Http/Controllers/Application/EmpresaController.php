<?php
namespace App\Http\Controllers\Application;

use App\Enum\Status;
use App\Http\Controllers\Controller;
use App\Repositories\Application\Contracts\EmpresaRepository;
use Illuminate\Http\Request;
use App\Contracts\Facades\ChannelLog as Log;
use App\Exceptions\Access\GeneralException;
use App\Enum\TipoPessoa;
use Zizaco\Entrust\EntrustFacade as Entrust;

class EmpresaController extends Controller
{

    /**
     * Instancia a repositório
     *
     * @var $empresa
     */
    protected $empresa;

    /**
     * Inicializa a classe usando o middleware de verificação de autenticação
     *
     * CasaController constructor.
     */
    public function __construct(EmpresaRepository $empresa)
    {
        $this->middleware('auth');
        $this->empresa = $empresa;
    }

    /**
     * Pagina inicial da tela de casas
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        if (!Entrust::can('manage-contratados')){
            abort(404,'Não possui permissão');
        }

        if (($search = $request->get('search'))) {
            $data = $this->empresa->searchPaginate('razao', $search);
        } else {
            $data = $this->empresa->getAll();
        }
        return view('modules.application.cadastros.empresas.index')
            ->with('empresas',$data)
            ->with('status',Status::getConstants());
    }

    /**
     * Inserir um novo registro no banco de dados
     *
     * @return mixed
     */
    public function create()
    {
        if (!Entrust::can('manage-contratados')){
            abort(404,'Não possui permissão');
        }

        return view('modules.application.cadastros.empresas.create')
            ->with('tipo_pessoa',TipoPessoa::getConstants());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try{

            if($this->empresa->create($request->all())){
                Log::write('event','Empresa '. $request->name .' cadastrada por '. auth()->user()->name);
            }
            return redirect()->route('empresas.index');

        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('empresas.index');
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
        if (!Entrust::can('manage-contratados')){
            abort(404,'Não possui permissão');
        }

        try{
            return view('modules.application.cadastros.empresas.edit')
                ->with('empresa',$this->empresa->findEmpresa($id))
                ->with('tipo_pessoa',TipoPessoa::getConstants())
                ->with('status',Status::getConstants());
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('empresas.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            if($this->empresa->update($request->all(), $id)){
                Log::write('event','Empresa ' . $request->name .' alterada por '. auth()->user()->name);
            }
            return redirect()->route('empresas.index');
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('empresas.index');
        }
    }
}