<?php
// use App\Http\Middleware\VerifySessionSolicitacao;
// dd(middleware());
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



Route::get('/table', function () {
    return view('table');
});

Route::get('/dashboard', function () {
    return view('layouts.principal');
})->name('dashboard');

Route::get('/solicitacao', 'SolicitacaoController@listar')->name('lista_solicitacao')->middleware(['verifySessionSolicitacao']);
Route::get('/solicitacao/listar', 'SolicitacaoController@listar')->name('listar_solicitacao')->middleware(['verifySessionSolicitacao']);
Route::get('/solicitacao/nova', 'SolicitacaoController@nova')->name('nova_solicitacao')->middleware(['verifySessionSolicitacao']);

//Produto
Route::get('/solicitacao/novo-produto/', 'ProdutoController@novo_produto');
Route::post('/solicitacao/cadastrar_produto', 'ProdutoController@cadastrar_produto')->name('cadastrar_produto');
Route::get('/solicitacao/edita-produto/{id}', 'ProdutoController@edita_produto');
Route::post('/solicitacao/salvar_produto', 'ProdutoController@salvar_produto')->name('salvar_produto');

//Servico
Route::get('/solicitacao/novo-servico/', 'ServicoController@novo_servico');
Route::post('/solicitacao/cadastrar_servico', 'ServicoController@cadastrar_servico')->name('cadastrar_servico');
Route::get('/solicitacao/edita-servico/{id}', 'ServicoController@edita_servico');
Route::post('/solicitacao/salvar_servico', 'ServicoController@salvar_servico')->name('salvar_servico');

//Solicitacao
Route::post('/solicitacao/cadastrar_solicitacao', 'SolicitacaoController@cadastrar_solicitacao')->name('cadastrar_solicitacao');

// Route::group(['middleware' => ['']], function () {
    
// });



// Route::post('/solicitacao/cadastrar_servico', 'SolicitacaoController@cadastrar_servico')->name('cadastrar_servico');

Route::get('/solicitacao/detalhe/{id}', 'SolicitacaoController@detalhe')->where('id','[0-9]+');

// Route::get('user/{id}', function ($id) {
//     //
// })->where('id', '[0-9]+');

//Solicitacao Produtos

//Solicitacao Servicos


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
