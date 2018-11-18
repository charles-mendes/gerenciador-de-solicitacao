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

Route::group(['middleware' => 'menu'], function () {

    // Route::get('/teste/{id}', 'MailController@solicitacaoPendente');
    // Route::get('/testando', function () {return view('mail.solicitacao_pendente');});


    /**
     * LOGIN
     **/
    Route::get('/login', function () { return view('auth.login');});
    Route::get('/', function () { return view('auth.login');});


    //tela de dashboard
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


    //Solicitacao
    Route::get('/solicitacao', 'SolicitacaoController@listar')->name('listar_solicitacao');
    Route::get('/solicitacao/nova', 'SolicitacaoController@nova')->name('nova_solicitacao');
    Route::post('/solicitacao/cadastrar_solicitacao', 'SolicitacaoController@cadastrar_solicitacao')->name('cadastrar_solicitacao');
    Route::get('/solicitacao/editar/{id}', 'SolicitacaoController@editar_solicitacao')->name('editar_solicitacao');
    Route::post('/solicitacao/salvar_solicitacao', 'SolicitacaoController@salvar_solicitacao')->name('salvar_solicitacao');
    Route::get('/solicitacao/excluir-solicitacao/{id}', 'SolicitacaoController@mostrar_verificacao_solicitacao');
    Route::post('/solicitacao/excluir-solicitacao', 'SolicitacaoController@excluir_solicitacao')->name('excluir_solicitacao');
    Route::get('/solicitacao/detalhe/{id}', 'SolicitacaoController@detalhe')->where('id','[0-9]+');

    //visualizar solicitação
    Route::get('/solicitacao/visualizar/{id}', 'SolicitacaoController@visualizar')->name('visualizar_solicitacao');
    

    //Solicitacao - Produto 
    Route::get('/solicitacao/novo-produto/', 'SolicitacaoController@mostrar_form_produto');
    Route::post('/solicitacao/novo-produto', 'SolicitacaoController@cadastrar_produto')->name('cadastrar_produto_solicitacao');
    Route::get('/solicitacao/edita-produto/{id}', 'SolicitacaoController@editar_produto');
    Route::post('/solicitacao/salvar_produto', 'SolicitacaoController@salvar_produto')->name('salvar_produto_solicitacao');
    Route::get('/solicitacao/excluir-produto/{id}', 'SolicitacaoController@mostrar_verificacao_produto');
    Route::post('/solicitacao/excluir-produto', 'SolicitacaoController@excluir_produto')->name('excluir_produto_solicitacao');

    //Solicitacao - Servico
    Route::get('/solicitacao/novo-servico/', 'SolicitacaoController@mostrar_form_servico');
    Route::post('/solicitacao/novo-servico', 'SolicitacaoController@cadastrar_servico')->name('cadastrar_servico_solicitacao');
    Route::get('/solicitacao/edita-servico/{id}', 'SolicitacaoController@editar_servico');
    Route::post('/solicitacao/salvar_servico', 'SolicitacaoController@salvar_servico')->name('salvar_servico_solicitacao');
    Route::get('/solicitacao/excluir-servico/{id}', 'SolicitacaoController@mostrar_verificacao_servico');
    Route::post('/solicitacao/excluir-servico', 'SolicitacaoController@excluir_servico')->name('excluir_servico_solicitacao');

    //Fornecedor
    Route::get('/fornecedor', 'FornecedorController@listar')->name('listar_fornecedores');
    Route::get('/fornecedor/novo/', 'FornecedorController@novo')->name('novo_fornecedor');
    Route::post('/fornecedor/cadastrar_fornecedor', 'FornecedorController@cadastrar_fornecedor')->name('cadastrar_fornecedor');
    Route::get('/fornecedor/cadastrar/{id}', 'FornecedorController@cadastrar')->name('cadastrar');
    Route::get('/fornecedor/editar/{id}', 'FornecedorController@editar_fornecedor')->name('editar_fornecedor');
    Route::post('/fornecedor/salvar_fornecedor', 'FornecedorController@salvar_fornecedor')->name('salvar_fornecedor');
    Route::get('/fornecedor/detalhe/{id}', 'FornecedorController@detalhe')->where('id','[0-9]+');
    

    //Fornecedor :: Produto
    Route::get('/fornecedor/novo-produto', 'FornecedorController@novo_produto');
    Route::post('/fornecedor/cadastrar_produto', 'FornecedorController@cadastrar_produto')->name('cadastrar_produto_fornecedor');
    Route::get('/fornecedor/edita-produto/{id}', 'FornecedorController@editar_produto');
    Route::post('/fornecedor/salvar_produto', 'FornecedorController@salvar_produto')->name('salvar_produto_fornecedor');
    Route::get('/fornecedor/excluir-produto/{id}', 'FornecedorController@mostrar_verificacao_produto');
    Route::post('/fornecedor/excluir-produto', 'FornecedorController@excluir_produto')->name('excluir_produto_fornecedor');


    //Fornecedor :: Servico
    Route::get('/fornecedor/novo-servico', 'FornecedorController@novo_servico');
    Route::post('/fornecedor/novo-servico', 'FornecedorController@cadastrar_servico')->name('cadastrar_servico_fornecedor');
    Route::get('/fornecedor/edita-servico/{id}', 'FornecedorController@editar_servico');
    Route::post('/fornecedor/salvar_servico', 'FornecedorController@salvar_servico')->name('salvar_servico_fornecedor');
    Route::get('/fornecedor/excluir-servico/{id}', 'FornecedorController@mostrar_verificacao_servico');
    Route::post('/fornecedor/excluir-servico', 'FornecedorController@excluir_servico')->name('excluir_servico_fornecedor');



    // Route::post('/fornecedor/cadastrar_produto', 'ProdutoController@cadastrar_produto')->name('cadastrar_produto');
    // Route::get('/solicitacao/edita-produto/{id}', 'ProdutoController@editar_produto');
    // Route::post('/solicitacao/salvar_produto', 'ProdutoController@salvar_produto')->name('salvar_produto');



    // Route::post('/fornecedor/salvar_fornecedor', 'FornecedorController@salvar_fornecedor')->name('salvar_fornecedor');

    // /fornecedor/novo-fornecedor/


    // Route::group(['middleware' => ['']], function () {
        
    // });

  


    // Route::post('/solicitacao/cadastrar_servico', 'SolicitacaoController@cadastrar_servico')->name('cadastrar_servico');

    

    // Route::get('user/{id}', function ($id) {
    //     //
    // })->where('id', '[0-9]+');

    //Solicitacao Produtos

    //Solicitacao Servicos
      //relatorio 
    Route::get('/relatorios', 'RelatorioController@index')->name('relatorio');


});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');



