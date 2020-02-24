<?php


Route::group(['middleware' => ['auth'],'namespace'=>'Admin','prefix'=>'admin'], function () {
    //Route::get('admin/balanco', 'Admin\BalancoController@index')->name('admin.balanco');

    Route::get('tranferir', 'BalancoController@transferir')->name('balanco.transferir'); // ja com prefixo admin
    Route::post('confirmar-transferencia', 'BalancoController@confirmarTransferencia')->name('confirmar.transferencia'); // ja com prefixo admin

    Route::post('tranferir', 'BalancoController@transferirStore')->name('transferir.store'); // ja com prefixo admin

    Route::any('historico-buscar', 'BalancoController@historicoBusca')->name('historico.buscar'); // ja com prefixo admin
    Route::get('historico', 'BalancoController@historico')->name('admin.historico'); // ja com prefixo admin

    Route::get('sacar', 'BalancoController@sacar')->name('sacar.store'); // ja com prefixo admin
    Route::post('sacar', 'BalancoController@sacarStore')->name('balanco.sacar'); // ja com prefixo admin

    Route::get('balanco', 'BalancoController@index')->name('admin.balanco'); // ja com prefixo admin

    Route::post('deposito', 'BalancoController@depositoStore')->name('deposito.store');
    Route::get('deposito', 'BalancoController@deposito')->name('balanco.deposito');
    Route::get('/', 'AdminController@index')->name('admin.home');  // ja com prefixo, referencia ao admin
});


Route::group(['middleware' => ['auth'], 'namespace' => 'Gerencia', 'prefix' => 'gerencia'], function () {
    //Route::get('admin/balanco', 'Admin\BalancoController@index')->name('admin.balanco');

     //mostra todos registros
    Route::get('index-grupo', 'GrupoDespesaController@index')->name('grupo.index');


    //formulario de cadastro
    Route::get('create-grupo', 'GrupoDespesaController@create')->name('grupo.create');

    //salvar o dado do cadastro enviado
    Route::post('store-grupo', 'GrupoDespesaController@store')->name('grupo.store');


    //exibe consulta
    Route::any('show-grupo', 'GrupoDespesaController@show')->name('grupo.show');


    //apresenta o formulario editar
    Route::get('editar-grupo/{id}', 'GrupoDespesaController@edit')->name('grupo.edit');

    //salva o upgrate
    Route::post('update-grupo/{id}', 'GrupoDespesaController@update')->name('grupo.update');

    //exclui
    Route::get('destroy-grupo/{id}', 'GrupoDespesaController@destroy')->name('grupo.destroy');


    //rotas subgrupo despesas
    //formulario de cadastro
    Route::get('create-subgrupo', 'SubgrupoDespesaController@create')->name('subgrupo.create');
    Route::get('get-subgrupos/{idGrupo}', 'SubgrupoDespesaController@getSubgrupo')->name('subgrupo.getSubgrupo');
    //salvar o dado do cadastro enviado
    Route::post('store-subgrupo', 'SubgrupoDespesaController@store')->name('subgrupo.store');

    //mostra todos registros
    Route::get('index-subgrupo', 'SubgrupoDespesaController@index')->name('subgrupo.index');



});

Route::get('teste', 'Gerencia\TesteController@teste')->name('teste');
Route::get('teste2', 'Gerencia\TesteController@teste2')->name('teste2');
Route::get('teste3', 'Gerencia\TesteController@teste3')->name('teste3');

Route::post('atualiza-perfil', 'Admin\UserController@perfilUpdate')->name('perfil.update')->middleware('auth');
Route::get('meu-perfil', 'Admin\UserController@perfil')->name('perfil')->middleware('auth');


Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();

