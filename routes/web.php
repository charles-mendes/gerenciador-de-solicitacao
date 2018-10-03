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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('layouts.principal');
});

Route::get('/u', 'UsuarioController@index');


//Solicitacao
Route::get('/solicitacao', 'SolicitacaoController@index');
Route::get('/nova-solicitacao', 'SolicitacaoController@nova');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
