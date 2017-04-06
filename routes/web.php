<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 * Rotas de Autenticação
 */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logoutt');

/**
 * Rotas de Registro (Desabilitadas)
 */
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

/**
 * Rotas de Resetar Senha (Desabilitadas)
 */
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Access'], function () {
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RoleController@index')->name('roles.index');
        Route::get('/create', 'RoleController@create')->name('roles.create');
        Route::post('/create','RoleController@store')->name('roles.store');
        Route::get('/{id}/edit', 'RoleController@edit')->name('roles.edit');
        Route::patch('/{id}/update', 'RoleController@update')->name('roles.update');
    });
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('users.index');
        Route::get('/{id}/edit', 'UserController@edit')->name('users.edit');
        Route::patch('/{id}/update', 'UserController@update')->name('users.update');
    });
    Route::get('logs', 'LogViewController@index')->name('logs.index');
});

Route::group(['namespace' => 'Configuration'], function(){
    Route::group(['prefix' => 'config'], function(){
        Route::get('/', 'ConfigController@index')->name('config.index');
    });
});

Route::group(['namespace' => 'Application'], function(){
    Route::group(['prefix' => 'contractors'], function(){
        Route::get('/','CasaController@index')->name('casas.index');
        Route::get('/create', 'CasaController@create')->name('casas.create');
        Route::post('/create','CasaController@store')->name('casas.store');
        Route::get('/{id}/edit', 'CasaController@edit')->name('casas.edit');
        Route::patch('/{id}/update', 'CasaController@update')->name('casas.update');
    });
    Route::group(['prefix' => 'units'], function(){
        Route::get('/','UnidadeController@index')->name('unidades.index');
        Route::get('/create', 'UnidadeController@create')->name('unidades.create');
        Route::post('/create','UnidadeController@store')->name('unidades.store');
        Route::get('/{id}/edit', 'UnidadeController@edit')->name('unidades.edit');
        Route::patch('/{id}/update', 'UnidadeController@update')->name('unidades.update');
        Route::delete('/{id}/delete','UnidadeController@delete')->name('unidades.delete');
        Route::get('/{id}','UnidadeController@getUnidades');
    });
    Route::group(['prefix' => 'companies'], function(){
        Route::get('/','EmpresaController@index')->name('empresas.index');
        Route::get('/create', 'EmpresaController@create')->name('empresas.create');
        Route::post('/create','EmpresaController@store')->name('empresas.store');
        Route::get('/{id}/edit', 'EmpresaController@edit')->name('empresas.edit');
        Route::patch('/{id}/update', 'EmpresaController@update')->name('empresas.update');
    });
    Route::group(['prefix' => 'contracts'], function(){
        Route::get('/','ContratoController@index')->name('contratos.index');
        Route::get('/excel','ContratoController@excel')->name('contratos.excel');
        Route::get('/{id}/view','ContratoController@view')->name('contratos.view');
        Route::get('/create', 'ContratoController@create')->name('contratos.create');
        //Normal
        Route::get('/create/normal', 'ContratoController@createNormal')->name('contratos.normal');
        Route::post('/create/normal','ContratoController@storeNormal')->name('contratos.normal.store');
        Route::get('/{id}/edit/normal', 'ContratoController@editNormal')->name('contratos.normal.edit');
        Route::patch('/{id}/update/normal', 'ContratoController@updateNormal')->name('contratos.normal.update');
        //Credenciamento
        Route::get('/{id}/edit', 'ContratoController@edit')->name('contratos.edit');
        Route::patch('/{id}/update', 'ContratoController@update')->name('contratos.update');
    });
    Route::group(['prefix' => 'additions'], function(){
        Route::get('/','ContratoAditivoController@index')->name('aditivos.index');
        Route::post('/create','ContratoAditivoController@store')->name('aditivos.store');
    });
});
