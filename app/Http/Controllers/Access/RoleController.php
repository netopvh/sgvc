<?php
namespace App\Http\Controllers\Access;

use App\Exceptions\Access\GeneralException;
use App\Http\Controllers\Controller;
use App\Repositories\Access\Contracts\PermissionRepository;
use App\Repositories\Access\Contracts\RoleRepository;
use Illuminate\Http\Request;
use App\Contracts\Facades\ChannelLog as Log;
use Zizaco\Entrust\EntrustFacade as Entrust;

class RoleController extends Controller
{

    /**
     * Variável instancia do repositório
     *
     * @var $role
     */
    private $role;

    /**
     * Variável instancia do repositório
     *
     * @var $role
     */
    private $permission;

    /**
     * RoleController constructor.
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role, PermissionRepository $permission)
    {
        $this->middleware('auth');
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Método de exibição de dados principais
     *
     * @return mixed
     */
    public function index()
    {
        if (!Entrust::can('manage-roles')){
            abort(404,'Não possui permissão');
        }

        return view('modules.access.roles.index')
            ->with('roles',$this->role->all());
    }

    /**
     * Método para inserir novo registro no banco de dados
     *
     * @return mixed
     */
    public function create()
    {
        if (!Entrust::can('manage-roles')){
            abort(404,'Não possui permissão');
        }

        return view('modules.access.roles.create')
            ->with('permissions',$this->permission->all())
            ->with('role_count',$this->role->getCount());
    }

    /**
     * Efetua a inserção de registro no DB
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try{
            if($this->role->create($request->all())){
                Log::write('event','Perfil '. $request->name .' cadastrado por '. auth()->user()->name);
            }
            return redirect()->route('roles.index');

        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('roles.index');
        }
    }

    /**
     * Método de alteração de registro
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if (!Entrust::can('manage-roles')){
            abort(404,'Não possui permissão');
        }

        try{

            $role = $this->role->findRole($id);

            return view('modules.access.roles.edit')
                ->with('role',$role)
                ->with('role_permissions',$role->perms->pluck('id')->all())
                ->with('permissions',$this->permission->all());

        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('roles.index');
        }
    }

    /**
     * Salva alterações no banco de dados
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        try{
            if($this->role->update($request->all(), $id)){
                Log::write('event','Perfil ' . $request->name .' alterado por '. auth()->user()->name);
            }
            return redirect()->route('roles.index');
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('roles.index');
        }

    }

}