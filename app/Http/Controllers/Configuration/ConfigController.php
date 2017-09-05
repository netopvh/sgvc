<?php

namespace App\Http\Controllers\Configuration;

use App\Exceptions\Access\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Efriandika\LaravelSettings\Facades\Settings;
use Zizaco\Entrust\EntrustFacade as Entrust;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Entrust::can('manage-config')){
            abort(404,'Não possui permissão');
        }

        $data = ['fq_90' => settings('fq_90'), 'fq_60' => settings('fq_60'), 'fq_30' => settings('fq_30')];
        
        return view('modules.configuration.index')
            ->with('setting',$data);
    }


    public function store(Request $request)
    {

        try{
            Settings::set('fq_90', $request->fq_90);
            Settings::set('fq_60', $request->fq_60);
            Settings::set('fq_30', $request->fq_30);
            notify()->flash('Parâmetros definidos com sucesso!!', 'success');
            return redirect()->route('config.index');
        }catch (GeneralException $e){
            notify()->flash($e->getMessage(), 'danger');
            return redirect()->route('config.index');
        }
    }
}
