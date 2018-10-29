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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('layouts.principal');
})->name('dashboard');

Route::get('/table', function () {
    return view('table');
});


Route::get('/u', 'UsuarioController@index');

Route::get('/solicitacao', 'SolicitacaoController@listar')->name('lista_solicitacao');
// Route::get('/solicitacao/listar', 'SolicitacaoController@listar')->name('listar_solicitacao');
Route::get('/solicitacao/nova', 'SolicitacaoController@nova')->name('nova_solicitacao');

//Produto
Route::get('/solicitacao/novo-produto/', 'SolicitacaoController@novo_produto');
Route::post('/solicitacao/cadastrar_produto', 'SolicitacaoController@cadastrar_produto')->name('cadastrar_produto');
Route::get('/solicitacao/edita-produto/{id}', 'SolicitacaoController@edita_produto');
Route::post('/solicitacao/salvar_produto', 'SolicitacaoController@salvar_produto')->name('salvar_produto');

//Servico
Route::get('/solicitacao/novo-servico/', 'SolicitacaoController@novo_servico');
Route::post('/solicitacao/cadastrar_servico', 'SolicitacaoController@cadastrar_servico')->name('cadastrar_servico');
Route::get('/solicitacao/edita-servico/{id}', 'SolicitacaoController@edita_servico');
Route::post('/solicitacao/salvar_servico', 'SolicitacaoController@salvar_servico')->name('salvar_servico');

//Solicitacao
Route::post('/solicitacao/cadastrar_solicitacao', 'SolicitacaoController@cadastrar_solicitacao')->name('cadastrar_solicitacao');





// Route::post('/solicitacao/cadastrar_servico', 'SolicitacaoController@cadastrar_servico')->name('cadastrar_servico');

Route::get('/solicitacao/detalhe/{id}', 'SolicitacaoController@detalhe')->where('id','[0-9]+');

// Route::get('user/{id}', function ($id) {
//     //
// })->where('id', '[0-9]+');

//Solicitacao Produtos

//Solicitacao Servicos


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
