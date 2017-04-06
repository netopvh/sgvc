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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home')
            ->withContratos($this->contrato->getAllByVencimento())
            ->withUser(auth()->user()->id);
    }
}
