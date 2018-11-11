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
// Route::redirect('/login', '/', 301);

Route::group(['middleware' => 'menu'], function () {

    
    /**
     * LOGIN
     **/
    Route::get('/login', function () { return view('auth.login');});
    Route::get('/', function () { return view('auth.login');});



    // Route::get('/table', function () {return view('table');});

    Route::get('/dashboard', function () {return view('layouts.principal');})->name('dashboard');

    // cadastrar novo usuario
    Route::get('cadastrar', 'Auth\RegisterController@showRegistrationForm')->name('cadastro_inicial');

    //Usuarios
    Route::get('/usuarios', 'UsuarioController@listar')->name('listar_usuarios');
    Route::get('/usuarios/novo-usuario/', 'UsuarioController@novo_usuario');
    Route::post('/usuarios/cadastrar_usuario', 'UsuarioController@cadastrar_usuario')->name('cadastrar_usuario');
    Route::get('/usuarios/edita-usuario/{id}', 'UsuarioController@editar_usuario');
    Route::post('/usuarios/salvar_usuario', 'UsuarioController@salvar_usuario')->name('salvar_usuario');

    Route::get('/usuarios/mudar-situacao/{id}', 'UsuarioController@mudar_situacao');
    Route::post('/usuarios/salvar_situacao', 'UsuarioController@salvar_situacao')->name('salvar_situacao');



    //Solicitacao - Produto 
    Route::get('/solicitacao/novo-produto/', 'SolicitacaoController@novo_produto');
    Route::post('/solicitacao/cadastrar_produto', 'SolicitacaoController@cadastrar_produto')->name('cadastrar_produto_solicitacao');
    Route::get('/solicitacao/edita-produto/{id}', 'SolicitacaoController@editar_produto');
    Route::post('/solicitacao/salvar_produto', 'SolicitacaoController@salvar_produto')->name('salvar_produto_solicitacao');

    //Solicitacao - Servico
    Route::get('/solicitacao/novo-servico/', 'SolicitacaoController@novo_servico');
    Route::post('/solicitacao/cadastrar_servico', 'SolicitacaoController@cadastrar_servico')->name('cadastrar_servico_solicitacao');
    Route::get('/solicitacao/edita-servico/{id}', 'SolicitacaoController@editar_servico');
    Route::post('/solicitacao/salvar_servico', 'SolicitacaoController@salvar_servico')->name('salvar_servico_solicitacao');



    //Solicitacao
    Route::get('/solicitacoes', 'SolicitacaoController@listar')->name('listar_solicitacao');
    Route::get('/solicitacao/nova', 'SolicitacaoController@nova')->name('nova_solicitacao');
    Route::post('/solicitacao/cadastrar_solicitacao', 'SolicitacaoController@cadastrar_solicitacao')->name('cadastrar_solicitacao');

    //Fornecedor
    Route::get('/fornecedores', 'FornecedorController@listar')->name('listar_fornecedores');
    Route::get('/fornecedor/novo/', 'FornecedorController@novo')->name('novo_fornecedor');
    Route::post('/fornecedor/cadastrar_fornecedor', 'FornecedorController@cadastrar_fornecedor')->name('cadastrar_fornecedor');
    Route::get('/fornecedor/cadastrar/{id}', 'FornecedorController@cadastrar')->name('cadastrar');

    //Fornecedor :: Produto
    Route::get('/fornecedor/novo-produto', 'FornecedorController@novo_produto');

    Route::post('/fornecedor/cadastrar_produto', 'FornecedorController@cadastrar_produto')->name('cadastrar_produto_fornecedor');
    Route::get('/fornecedor/edita-produto/{id}', 'FornecedorController@editar_produto');
    Route::post('/fornecedor/salvar_produto', 'FornecedorController@salvar_produto')->name('salvar_produto_fornecedor');

    // Route::post('/fornecedor/cadastrar_produto', 'ProdutoController@cadastrar_produto')->name('cadastrar_produto');
    // Route::get('/solicitacao/edita-produto/{id}', 'ProdutoController@editar_produto');
    // Route::post('/solicitacao/salvar_produto', 'ProdutoController@salvar_produto')->name('salvar_produto');



    // Route::post('/fornecedor/salvar_fornecedor', 'FornecedorController@salvar_fornecedor')->name('salvar_fornecedor');

    // /fornecedor/novo-fornecedor/


    // Route::group(['middleware' => ['']], function () {
        
    // });



    // Route::post('/solicitacao/cadastrar_servico', 'SolicitacaoController@cadastrar_servico')->name('cadastrar_servico');

    Route::get('/solicitacao/detalhe/{id}', 'SolicitacaoController@detalhe')->where('id','[0-9]+');

    // Route::get('user/{id}', function ($id) {
    //     //
    // })->where('id', '[0-9]+');

    //Solicitacao Produtos

    //Solicitacao Servicos

});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
