<?php
namespace App\Http\Controllers\Application;

use App\Enum\TipoContrato;
use App\Enum\TipoPessoa;
use App\Http\Controllers\Controller;
use App\Repositories\Access\Contracts\UserRepository;
use App\Repositories\Application\Contracts\CasaRepository;
use App\Repositories\Application\Contracts\EmpresaRepository;
use App\Repositories\Application\Contracts\UnidadeRepository;
use App\Repositories\Application\Contracts\ContratoRepository;
use Illuminate\Http\Request;
use App\Contracts\Facades\ChannelLog as Log;
use App\Exceptions\Access\GeneralException;
use Maatwebsite\Excel\Facades\Excel;

class ContratoController extends Controller
{

    /**
     * Instancia a repositório
     *
     * @var $contrato
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
    public function __construct(ContratoRepository $contrato,
                                CasaRepository $casa,
                                UnidadeRepository $unidade,
                                EmpresaRepository $empresa,
                                UserRepository $user)
    {
        $this->middleware('auth');
        $this->contrato = $contrato;
        $this->casa = $casa;
        $this->unidade = $unidade;
        $this->empresa = $empresa;
        $this->user = $user;
    }

    /**
     * Pagina inicial dos registros de contratos
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        if (!empty($request->all())) {
            $fieldsSearch = $this->unsetCleanFields($request->all());
            $data = $this->contrato->searchWithRelations($fieldsSearch);
        } else {
            $data = $this->contrato->getAllWithRelations();
        }
        return view('modules.application.contratos.index')
            ->withContratos($data)
            ->withCasas($this->casa->all())
            ->withTiposContrato(TipoContrato::getConstants())
            ->withUser(auth()->user()->id);
    }


    /**
     * Visualiza informações de um determinado registro
     *
     * @param $id
     * @return mixed
     */
    public function view($id)
    {
        try {
            return view('modules.application.contratos.view')
                ->withContrato($this->contrato->viewContrato($id))
                ->withTipoPessoa(TipoPessoa::getConstants());
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('contratos.index');
        }
    }

    /**
     * Seleciona o Tipo de Contrato a ser cadastrado no Sistema
     *
     * @return mixed
     */
    public function create()
    {
        return view('modules.application.contratos.create')
            ->withTipos(TipoContrato::getConstants());
    }

    /**
     * Inserir um novo registro de contrato tipo normal
     *
     * Realiza buscar nas tabelas
     * - Casas
     * - Unidades
     * - Usuários
     * - Empresas
     *
     * @internal Normal
     * @return mixed
     */
    public function createNormal()
    {
        return view('modules.application.contratos.normal.create')
            ->withCasas($this->casa->all())
            ->withUnidades($this->unidade->all())
            ->withUsers($this->user->all())
            ->withEmpresas($this->empresa->all());
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
    public function storeNormal(Request $request)
    {
        try {

            if ($model = $this->contrato->createNormal($request->all())) {

                if ($request->hasFile('arquivo')) {
                    $this->fileName = str_random(16);
                    $file = $this->contrato->find($model->id);
                    $file->arquivo = $this->fileName . '.pdf';
                    if ($file->save()) {
                        $this->uploadFile($request->file('arquivo'));
                    }
                }

                Log::write('event', 'Contrato Nº ' . $request->numero . '/' . $request->ano . ' cadastrado no sistema por ' . auth()->user()->name);

            }
            notify()->flash('Contrato cadastrado com sucesso!', 'success');
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
        try {

            //Localiza o contrato no banco de dados
            $contrato = $this->contrato->findContrato($id);
            //Faz a mesclagem dos arrays gestores e fiscais.
            $fiscaisGestores = array_merge($contrato->gestores->pluck('id')->toArray(),$contrato->fiscais->pluck('id')->toArray());

            //Verifica se o usuário faz parte dos gestores ou fiscais para editar o contrato
            if (! in_array(auth()->user()->id,$fiscaisGestores)){
                notify()->flash('Você não tem permissão para editar este contrato', 'danger');
                return redirect()->route('contratos.index');
            }

            return view('modules.application.contratos.normal.edit')
                ->withContrato($contrato)
                ->withCasas($this->casa->all())
                ->withUnidades($this->unidade->all())
                ->withUsers($this->user->all())
                ->withEmpresas($this->empresa->all())
                ->withGestores($this->contrato->findGestores($id))
                ->withFiscais($this->contrato->findFiscais($id))
                ->withEmpresasField($this->contrato->findEmpresas($id));
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('contratos.index');
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
                    $file->arquivo = $this->fileName . '.pdf';
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
        try {
            $unidade = $this->unidade->find($id)->name;
            if ($this->unidade->delete($id)) {
                Log::write('event', 'Unidade ' . $unidade . ' removida por ' . auth()->user()->name);
            }
            return redirect()->route('unidades.index');
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('unidades.index');
        }
    }

    public function excel()
    {
        $data = $this->contrato->excelExport();

        Excel::create('contratos', function ($excel) use ($data) {
            $excel->sheet('Contratos', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    /**
     *
     * Private Functions
     *
     */

    /**
     * Limpa campos vazios
     *
     * @param array $attributes
     * @return array
     */
    private function unsetCleanFields(array $attributes)
    {
        $data = [];
        foreach ($attributes as $key => $value) {
            if (!is_null($value)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

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