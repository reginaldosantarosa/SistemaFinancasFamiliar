<?php


Route::group(['middleware' => ['auth'],'namespace'=>'Admin','prefix'=>'admin'], function () {
    //Route::get('admin/balanco', 'BalancoController@index')->name('admin.balanco');
    Route::get('balanco', 'BalancoController@index')->name('admin.balanco'); // ja com prefixo admin
    Route::post('deposito', 'BalancoController@depositoStore')->name('deposito.store');
    Route::get('deposito', 'BalancoController@deposito')->name('balanco.deposito');
    Route::get('/', 'AdminController@index')->name('admin.home');  // ja com prefixo, referencia ao admin
});

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();

