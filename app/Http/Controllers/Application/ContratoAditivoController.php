<?php
namespace App\Http\Controllers\Application;

use App\Enum\TipoContrato;
use App\Enum\TipoPessoa;
use App\Http\Controllers\Controller;
use App\Repositories\Access\Contracts\UserRepository;
use App\Repositories\Application\Contracts\CasaRepository;
use App\Repositories\Application\Contracts\ContratoAditivoRepository;
use App\Repositories\Application\Contracts\EmpresaRepository;
use App\Repositories\Application\Contracts\UnidadeRepository;
use App\Repositories\Application\Contracts\ContratoRepository;
use Illuminate\Http\Request;
use App\Contracts\Facades\ChannelLog as Log;
use App\Exceptions\Access\GeneralException;
use Zizaco\Entrust\EntrustFacade as Entrust;

class ContratoAditivoController extends Controller
{

    /**
     * Instancia a repositório
     *
     * @var $aditivo
     */
    protected $aditivo;

    /**
     * Instancia a repositório
     *
     * @var $aditivo
     */
    protected $contrato;

    /**
     * Instancia a repositório
     *
     * @var $casa
     */
    protected $casa;

    /**
     * Instancia a repositório
     *
     * @var $unidade
     */
    protected $unidade;
    /**
     * Instancia a repositório
     *
     * @var $empresa
     */
    protected $empresa;
    /**
     * Instancia a repositório
     *
     * @var $user
     */
    protected $user;

    /**
     * @var
     */
    protected $fileName;

    /**
     * Inicializa a classe usando o middleware de verificação de autenticação
     *
     * CasaController constructor.
     */
    public function __construct(
        ContratoAditivoRepository $aditivo,
        ContratoRepository $contrato,
        CasaRepository $casa,
        UnidadeRepository $unidade,
        EmpresaRepository $empresa,
        UserRepository $user)
    {
        $this->middleware('auth');
        $this->aditivo = $aditivo;
        $this->contrato = $contrato;
        $this->casa = $casa;
        $this->user = $user;
    }

    /**
     * Pagina inicial dos registros de contratos
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        if (!Entrust::can('manage-aditivos')){
            abort(404,'Não possui permissão');
        }

        try {
            if (!empty($request->all())) {
                $data = $this->contrato->searchForAdditions($request->all());
                $gestoresFicais = array_merge($data->gestores->pluck('id')->toArray(),$data->fiscais->pluck('id')->toArray());
                if (! in_array(auth()->user()->id,$gestoresFicais)){
                    notify()->flash('Você não tem permissão para aditivar este contrato', 'danger');
                    return redirect()->route('aditivos.index');
                }
            } else {
                $data = null;
            }
            return view('modules.application.aditivos.index')
                ->withContrato($data);
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('aditivos.index');
        }
    }

    /**
     * Salva registro no banco, contrato tipo Normal
     *
     * O método tambem realizar o upload do arquivo para o servidor
     * utilizando o método privado uploadFile.
     *
     * @internal Normal
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {

            if ($model = $this->aditivo->create($request->all())) {

                if ($request->hasFile('arquivo')) {
                    $this->fileName = str_random(16);
                    $file = $this->aditivo->findAltFilename($model->toArray());
                    $file->arquivo = $this->fileName . '.pdf';
                    if ($file->save()) {
                        $this->uploadFile($request->file('arquivo'));
                    }
                }

                Log::write('event', 'Contrato Nº ' . $this->contrato->find($request->contrato_id)->numero . '/' . $request->ano . ' aditivado por ' . auth()->user()->name);

            }
            notify()->flash('Contrato aditivado com sucesso!', 'success');
            return redirect()->route('contratos.index');

        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('contratos.index');
        }
    }

    /**
     * Busca dados para edição
     *
     * @param $id
     * @return mixed
     */
    public function editNormal($id)
    {
        if (!Entrust::can('manage-aditivos')){
            abort(404,'Não possui permissão');
        }

        try {
            return view('modules.application.contratos.normal.edit')
                ->withContrato($this->contrato->findContrato($id))
                ->withCasas($this->casa->all())
                ->withUnidades($this->unidade->all())
                ->withUsers($this->user->all())
                ->withEmpresas($this->empresa->all())
                ->withGestores($this->contrato->findGestores($id))
                ->withFiscais($this->contrato->findFiscais($id))
                ->withEmpresasField($this->contrato->findEmpresas($id));
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('unidades.index');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateNormal(Request $request, $id)
    {
        try {
            if ($model = $this->contrato->update($request->all(), $id)) {

                if ($request->hasFile('arquivo')) {
                    $this->fileName = str_random(16);
                    $file = $this->contrato->find($model->id);
                    $file->arquivo = '\''.$this->fileName . '.pdf\'';
                    if ($file->save()) {
                        $this->uploadFile($request->file('arquivo'));
                    }
                }

                Log::write('event', 'Unidade ' . $request->name . ' alterada por ' . auth()->user()->name);
            }
            notify()->flash('Contrato alterado com sucesso!', 'success');
            return redirect()->route('contratos.index');
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('contratos.index');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!Entrust::can('manage-aditivos')){
            abort(404,'Não possui permissão');
        }

        try {
            $unidade = $this->contrato->find($id)->name;
            if ($this->contrato->delete($id)) {
                Log::write('event', 'Contrato ' . $unidade . ' removido por ' . auth()->user()->name);
            }
            return redirect()->route('unidades.index');
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('unidades.index');
        }
    }

    /**
     *
     * Private Functions
     *
     */

    /**
     * Realiza o upload do arquivo
     *
     * @param $file
     */
    private function uploadFile($file)
    {
        if ($file) {
            $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'PDF';
            $folderName = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'files';
            $destinationPath = public_path() . $folderName;
            $safeName = $this->fileName . '.' . $extension;
            $file->move($destinationPath, $safeName);
        }
    }
}