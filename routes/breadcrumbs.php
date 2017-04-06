<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});


/**********
 *
 * APPLICATION BREADCRUMBS
 *
 */

/*
 * Gestão de Contratantes
 */
// Home > Contratantes
Breadcrumbs::register('casas.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contratantes', route('casas.index'));
});
Breadcrumbs::register('casas.create', function($breadcrumbs)
{
    $breadcrumbs->parent('casas.index');
    $breadcrumbs->push('Novo','');
});
Breadcrumbs::register('casas.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('casas.index');
    $breadcrumbs->push('Editar','');
});


/*
 * Gestão de Contratados
 */
// Home > Contratantes
Breadcrumbs::register('empresas.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contratados', route('empresas.index'));
});
Breadcrumbs::register('empresas.create', function($breadcrumbs)
{
    $breadcrumbs->parent('empresas.index');
    $breadcrumbs->push('Novo','');
});
Breadcrumbs::register('empresas.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('empresas.index');
    $breadcrumbs->push('Editar','');
});


/*
 * Gestão de Unidades
 */
// Home > Unidades
Breadcrumbs::register('unidades.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Unidades', route('unidades.index'));
});
Breadcrumbs::register('unidades.create', function($breadcrumbs)
{
    $breadcrumbs->parent('unidades.index');
    $breadcrumbs->push('Novo','');
});
Breadcrumbs::register('unidades.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('unidades.index');
    $breadcrumbs->push('Editar','');
});

/**
 * Gestão de Contratos
 */
//Home > Contratos
Breadcrumbs::register('contratos.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contratos', route('contratos.index'));
});
Breadcrumbs::register('contratos.tipo', function($breadcrumbs)
{
    $breadcrumbs->parent('contratos.index');
    $breadcrumbs->push('Tipo', '');
});
Breadcrumbs::register('contratos.normal', function($breadcrumbs)
{
    $breadcrumbs->parent('contratos.index');
    $breadcrumbs->push('Normal', '');
});
Breadcrumbs::register('contratos.view', function($breadcrumbs)
{
    $breadcrumbs->parent('contratos.index');
    $breadcrumbs->push('Visualizar', '');
});
Breadcrumbs::register('contratos.aditivos', function($breadcrumbs)
{
    $breadcrumbs->parent('contratos.index');
    $breadcrumbs->push('Aditivos', '');
});

/*********
 *
 * ACCESS BREADCRUMBS
 *
 */


/*
 * Gestão de Usuários
 */
// Home > Usuários
Breadcrumbs::register('users.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Usuários', route('users.index'));
});
Breadcrumbs::register('users.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Editar','');
});

/*
 * Gestão de Perfis
 */
// Home > Perfis
Breadcrumbs::register('roles.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Perfis', route('roles.index'));
});
Breadcrumbs::register('roles.create', function($breadcrumbs)
{
    $breadcrumbs->parent('roles.index');
    $breadcrumbs->push('Novo','');
});
Breadcrumbs::register('roles.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('roles.index');
    $breadcrumbs->push('Editar','');
});

/*
 * Gestão de Parâmetros
 */
// Home > Parâmetros
Breadcrumbs::register('config.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Parâmetros', route('config.index'));
});

/*
 * Gestão de Logs
 */
// Home > Logs
Breadcrumbs::register('logs.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Logs', route('logs.index'));
});