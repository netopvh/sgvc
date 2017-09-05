<?php

namespace App\Http\Controllers;

use App\Repositories\Application\Contracts\ContratoRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * @var $contrato
     */
    private $contrato;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContratoRepository $contratoRepository)
    {
        $this->middleware('auth');
        $this->contrato = $contratoRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return
     */
    public function index()
    {
        return view('home')
            ->with('contratos',$this->contrato->getAllByVencimento())
            ->with('user',auth()->user()->id);
    }
}
