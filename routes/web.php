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



Auth::routes();

Route::group(['middleware' => 'shareViews'], function () {
    Route::group(['middleware' => ['auth']], function () {

        Route::get('/', [
            'as' => '/',
            'uses' => 'HomeController@index'
        ]);

        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('cliente/index', [
            'as' => 'cliente.index',
            'uses' => 'ClientesController@index'
        ]);

        Route::post('cliente/save', [
            'as' => 'cliente.save',
            'uses' => 'ClientesController@save'
        ]);
        Route::get('cliente/save', [
            'as' => 'cliente.save',
            'uses' => 'ClientesController@save'
        ]);

        Route::get('cliente/edit/{id}', [
            'as' => 'cliente.edit',
            'uses' => 'ClientesController@edit'
        ]);

        Route::get('cliente/buscar', [
            'as' => 'cliente.buscar',
            'uses' => 'ClientesController@buscar'
        ]);

        Route::get('cliente/descarga/documento/{id}', [
            'as' => 'cliente.descarga.documento',
            'uses' => 'ClientesController@descarga'
        ]);

    });
});
