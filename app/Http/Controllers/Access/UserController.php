<?php
namespace App\Http\Controllers\Access;

use App\Exceptions\Access\GeneralException;
use App\Http\Controllers\Controller;
use App\Repositories\Access\Contracts\RoleRepository;
use App\Repositories\Access\Contracts\UserRepository;
use Illuminate\Http\Request;
use App\Contracts\Facades\ChannelLog as Log;
use Zizaco\Entrust\EntrustFacade as Entrust;

class UserController extends Controller
{

    /**
     * Variável instancia do repositório
     *
     * @var $user
     */
    private $user;

    /**
     * Variável instancia do repositório
     *
     * @var $role
     */
    private $role;


    /**
     * RoleController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user, RoleRepository $role)
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Método de exibição de dados principais
     *
     * @return mixed
     */
    public function index(Request $request)
    {

        if (!Entrust::can('manage-users')){
            abort(404,'Não possui permissão');
        }

        if (($search = $request->get('search'))) {
            $data = $this->user->searchWithRoles('name', $search);
        } else {
            $data = $this->user->getAllWithRoles();
        }
        return view('modules.access.users.index')
            ->withUsers($data);
    }


    /**
     * Método de alteração de registro
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if (!Entrust::can('manage-users')){
            abort(404,'Não possui permissão');
        }
        
        try{
            return view('modules.access.users.edit')
                ->withUser($this->user->findUser($id))
                ->withRoles($this->role->all());

        }catch (GeneralException $e){
            notify()->flash($e->getMessage(),'danger');
            return redirect()->route('users.index');
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
        try {

            if ($this->user->update($request->all(), $id)) {
                Log::write('event','Usuário '. $request->name .' alterado por ' . auth()->user()->name);
            }
            return redirect()->route('users.index');
        } catch (GeneralException $e) {
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('users.index');
        }

    }


}