<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
use App\Http\Controllers\ProdutoController;
// use App\Http\Controllers\ServicoController;
use App\Servico;
use App\Detalhe_Solicitacao_Produto;
use App\Detalhe_Solicitacao_Servico;
use Validator;
//use Request;
use Auth;
//use Input;
use Illuminate\Http\Request;


//TROCAR VARIAVEL DA TABELA SOLICITACAO PARA ENUM('A','P','I');

class SolicitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }
    
    public function nova(){
        
        //verificando se session não existe
        if(!session()->has('novaSolicitacao')){
            session(['novaSolicitacao' => new \stdClass() ]);
        }
        
        return view('solicitacao.nova');      
    }
    
    public function listar(){
        
        $solicitacoes = Solicitacao::all();
        //mandar para tela listar com os produtos e com os servicos
        return view('solicitacao.listar', ['solicitacoes'=> $solicitacoes]);

    }

    
    public function detalhe($id){
        //pegando solicitacao
        $solicitacao = Solicitacao::find($id);
        return view('solicitacao.detalhe',['solicitacao'=> $solicitacao]);        
    }


    public function cadastrar_solicitacao(Request $request){
        $this->validate($request,[
            'descricao'=>'required',
        ]);

        
        //cria uma solicitacao
        $solicitacao = new Solicitacao();
        $solicitacao->status = 'P';
        $solicitacao->descricao = $request->input('descricao');
        $solicitacao->id_criador = Auth::user()->id;
        $solicitacao->data_criacao = time();
        $solicitacao->id_modificador = Auth::user()->id;
        $solicitacao->data_modificacao = time();
        $solicitacao->save();
        
        //pegando solicitacao da session
        $solicitacaoSession = session('novaSolicitacao');
        // dd($solicitacaoSession);
        // dd($solicitacaoSession);
        foreach ($solicitacaoSession as $key => $categoria) {
            if($key == 'produtos'){
                foreach($categoria as $item){
                    
                    //cadastrando produto
                    $produtoController = new ProdutoController();
                    $produto = $produtoController->cadastrar_produto($item);
                    $produto->save();
                    
                    //cadastrando tabela auxiliar
                    $detalhe_solicitacao_produto = new Detalhe_Solicitacao_Produto_Controller();
                    $solicitacao_produto = $detalhe_solicitacao_produto->cadastrar();
                    $solicitacao_produto->save();
                }
            }
            
           
            if($key == 'servicos'){
                // dd($categoria);
                foreach($categoria as $item){
                    $servico = new Servico();
                    $servico->id_contrato = 0;
                    $servico->nome = $item->nome;
                    // $servico->quantidade = $item->quantidade;
                    $servico->valor = $item->valor;
                    $servico->valor_imposto = $item->valor_imposto;
                    $servico->descricao = $item->descricao;
                    // $servico->link_oferta = $item->link_oferta;
                    // $servico->id_criador = $item->id_criador;
                    // $servico->data_criacao = $item->data_criacao;
                    // $servico->id_modificador = $item->id_modificador;
                    // $servico->data_modificacao = $item->data_modificacao;
                    $servico->save();

                    $solicitacao_servico  = new Detalhe_Solicitacao_Servico();
                    $solicitacao_servico->id_solicitacao = $solicitacao->id;
                    $solicitacao_servico->id_servico = $servico->id;
                    $solicitacao_servico->save();
                }

            }
        }

        return redirect()->route('listar_solicitacao');

    }

    public function novo_produto(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao        
        if(session()->has('novaSolicitacao')){
            $produto = new \stdClass;
            $produto->nome = "";
            $produto->quantidade = "";
            $produto->valor = "";
            $produto->valor_imposto = "";
            $produto->descricao = "";
            $produto->link_oferta = "";

            return view('modal.produto',['produto' => $produto , 'tipo' => 'solicitacao']);
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_produto(Request $request){
        $this->validate($request,[
            'nome' => 'required',
            'quantidade' => 'required',
             'valor'=> 'required',
            // 'imposto'=>'',
            // 'descricao'=>'required',
            // 'link-oferta'=>'',
         ]);

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');
        
        $produtoController = new ProdutoController();
        $produto = $produtoController->cadastrar_produto($request);
        

        //adicionando o novo produto na sessao
        $solicitacao->produtos[]= $produto;

        session()->put('novaSolicitacao', $solicitacao);
        
        return redirect()->route('nova_solicitacao');
    }

    public function editar_produto($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $produto = new \stdClass;
            $produto->nome = session('novaSolicitacao')->produtos[$id]->nome;
            $produto->quantidade = session('novaSolicitacao')->produtos[$id]->quantidade;
            $produto->valor = session('novaSolicitacao')->produtos[$id]->valor;
            $produto->valor_imposto = session('novaSolicitacao')->produtos[$id]->valor_imposto;
            $produto->descricao = session('novaSolicitacao')->produtos[$id]->descricao;
            $produto->link_oferta = session('novaSolicitacao')->produtos[$id]->link_oferta;

            return view('modal.produto',['produto' => $produto , 'tipo' => 'solicitacao','id' => $id]);    
        }
        return back();
    }

    public function salvar_produto(Request $request){
        $this->validate($request,[
            'id_produto' => 'required',
            'nome' => 'required',
            'quantidade' => 'required',
            'valor'=> 'required',
            // 'imposto'=>'',
            // 'descricao'=>'required',
            // 'link-oferta'=>'',
         ]);

        
        //pegando o id do produto
        $id = $request->input('id_produto');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
        
        //alterar produto ja existente na session
            // $solicitacao = ProdutoController::salvar_produto($solicitacao, $id, $request);
        $produtoController = new ProdutoController();
        $solicitacao = $produtoController->salvar_produto($solicitacao, $id, $request);
        
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        return redirect()->route('nova_solicitacao');
    }


    public function novo_servico(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao        
        if(session()->has('novaSolicitacao')){
            $servico = new \stdClass;
            $servico->nome = "";
            $servico->quantidade = "";
            $servico->valor = "";
            $servico->valor_imposto = "";
            $servico->descricao = "";
            $servico->link_oferta = "";

            return view('modal.servico',['servico' => $servico , 'tipo' => 'solicitacao']);
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_servico(Request $request){

        $this->validate($request,[
           'nome' => 'required',
        //    'quantidade' => 'required',
            'valor'=> 'required',
           // 'imposto'=>'',
           'descricao'=>'required',
           // 'link-oferta'=>'',
        ]);

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');

        $servicoController = new ServicoController();
        $servico = $servicoController->cadastrar_servico($request);
        
        
        //adicionando o novo produto na sessao
        $solicitacao->servicos[]= $servico;

        session()->put('novaSolicitacao', $solicitacao);
        
        return redirect()->route('nova_solicitacao');
        
    }


    public function editar_servico($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $servico = new \stdClass;
            $servico->nome = session('novaSolicitacao')->servicos[$id]->nome;
            $servico->quantidade = session('novaSolicitacao')->servicos[$id]->quantidade;
            $servico->valor = session('novaSolicitacao')->servicos[$id]->valor;
            $servico->valor_imposto = session('novaSolicitacao')->servicos[$id]->valor_imposto;
            $servico->descricao = session('novaSolicitacao')->servicos[$id]->descricao;
            $servico->link_oferta = session('novaSolicitacao')->servicos[$id]->link_oferta;

            return view('modal.servico',['servico' => $servico , 'tipo' => 'solicitacao','id' => $id]);    
        }
        return back();
    }


    public function salvar_servico(Request $request){
        $this->validate($request,[
            'id_servico' => 'required',
            'nome' => 'required',
            // 'quantidade' => 'required',
            'valor'=> 'required',
            // 'imposto'=>'',
            'descricao'=>'required',
            // 'link-oferta'=>'',
         ]);

        
        //pegando o id do servico
        $id = $request->input('id_servico');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
        
        //alterar produto ja existente na session
            // $solicitacao->servicos[$id]->nome = $request->input('nome');
            // $solicitacao->servicos[$id]->quantidade = $request->input('quantidade');
            // $solicitacao->servicos[$id]->valor = $request->input('valor');
            // $solicitacao->servicos[$id]->valor_imposto =  $request->input('imposto');
            // $solicitacao->servicos[$id]->descricao = $request->input('descricao');
            // $solicitacao->servicos[$id]->link_oferta = $request->input('link_oferta');
            // $solicitacao->servicos[$id]->id_criador = Auth::user()->id;
            // $solicitacao->servicos[$id]->id_modificador = Auth::user()->id;
        $servicoController = new ServicoController();
        $solicitacao = $servicoController->salvar_servico($solicitacao, $id, $request);
        
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        return redirect()->route('nova_solicitacao');
    }




}
