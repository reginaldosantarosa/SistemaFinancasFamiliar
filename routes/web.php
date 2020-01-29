<?php


Route::group(['middleware' => ['auth'],'namespace'=>'Admin','prefix'=>'admin'], function () {
    //Route::get('admin/balanco', 'Admin\BalancoController@index')->name('admin.balanco');

    Route::get('sacar', 'BalancoController@sacar')->name('sacar.store'); // ja com prefixo admin
    Route::post('sacar', 'BalancoController@sacarStore')->name('balanco.sacar'); // ja com prefixo admin

    Route::get('balanco', 'BalancoController@index')->name('admin.balanco'); // ja com prefixo admin

    Route::post('deposito', 'BalancoController@depositoStore')->name('deposito.store');
    Route::get('deposito', 'BalancoController@deposito')->name('balanco.deposito');
    Route::get('/', 'AdminController@index')->name('admin.home');  // ja com prefixo, referencia ao admin
});

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();

