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



Route::post('atualizar-perfil', 'Admin\UserController@perfilUpdate')->name('perfil.update')->middleware('auth');
Route::get('meu-perfil', 'Admin\UserController@perfil')->name('perfil')->middleware('auth');



Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();

