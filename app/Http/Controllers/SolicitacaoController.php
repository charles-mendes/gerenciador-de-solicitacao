<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
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
    }
    
    // public function index(){
        
    // }

    public function novo_produto(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.produto');
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_produto(Request $request){

        $this->validate($request,[
           'name' => 'required',
           'quantidade' => 'required',
            'valor'=> 'required',
           // 'imposto'=>'',
           // 'descricao'=>'required',
           // 'link-oferta'=>'',
        ]);

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');
        
        $produto = new \stdClass();
        $produto->nome = $request->input('name');
        $produto->quantidade = $request->input('quantidade');
        $produto->valor = $request->input('valor');
        $produto->valor_imposto = $request->input('imposto');
        $produto->descricao = $request->input('descricao');
        $produto->link_oferta = $request->input('link_oferta');
        $produto->id_criador = Auth::user()->id;
        $produto->id_modificador = Auth::user()->id;

        
        //adicionando o novo produto na sessao
        $solicitacao->produtos[]= $produto;

        session()->put('novaSolicitacao', $solicitacao);
        
        return redirect()->route('nova_solicitacao');
        
    }

    public function edita_produto($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.produto',['id' => $id]);    
        }
        
        return redirect()->route('nova_solicitacao');
    }

    public function salvar_produto(Request $request){
        $this->validate($request,[
            'id_produto' => 'required',
            'name' => 'required',
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
        $solicitacao->produtos[$id]->nome = $request->input('name');
        $solicitacao->produtos[$id]->quantidade = $request->input('quantidade');
        $solicitacao->produtos[$id]->valor = $request->input('valor');
        $solicitacao->produtos[$id]->valor_imposto =  $request->input('imposto');
        $solicitacao->produtos[$id]->descricao = $request->input('descricao');
        $solicitacao->produtos[$id]->link_oferta = $request->input('link_oferta');
        $solicitacao->produtos[$id]->id_criador = Auth::user()->id;
        $solicitacao->produtos[$id]->id_modificador = Auth::user()->id;
        
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        return redirect()->route('nova_solicitacao');
    }



    
    public function novo_servico(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.servico');
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_servico(Request $request){
        // dd($request->input());
        $this->validate($request,[
           'name' => 'required',
        //    'quantidade' => 'required',
            'valor'=> 'required',
           // 'imposto'=>'',
           'descricao'=>'required',
           // 'link-oferta'=>'',
        ]);

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');
        
        $servico = new \stdClass();
        $servico->nome = $request->input('name');
        $servico->quantidade = $request->input('quantidade');
        $servico->valor = $request->input('valor');
        $servico->valor_imposto = $request->input('imposto');
        $servico->descricao = $request->input('descricao');
        $servico->link_oferta = $request->input('link_oferta');
        $servico->id_criador = Auth::user()->id;
        $servico->id_modificador = Auth::user()->id;

        
        //adicionando o novo produto na sessao
        $solicitacao->servicos[]= $servico;

        session()->put('novaSolicitacao', $solicitacao);
        
        return redirect()->route('nova_solicitacao');
        
    }


    public function edita_servico($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.servico',['id' => $id]);    
        }
        
        return redirect()->route('nova_solicitacao');
    }


    public function salvar_servico(Request $request){
        $this->validate($request,[
            'id_servico' => 'required',
            'name' => 'required',
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
        $solicitacao->servicos[$id]->nome = $request->input('name');
        $solicitacao->servicos[$id]->quantidade = $request->input('quantidade');
        $solicitacao->servicos[$id]->valor = $request->input('valor');
        $solicitacao->servicos[$id]->valor_imposto =  $request->input('imposto');
        $solicitacao->servicos[$id]->descricao = $request->input('descricao');
        $solicitacao->servicos[$id]->link_oferta = $request->input('link_oferta');
        $solicitacao->servicos[$id]->id_criador = Auth::user()->id;
        $solicitacao->servicos[$id]->id_modificador = Auth::user()->id;
        
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        return redirect()->route('nova_solicitacao');
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
        foreach ($solicitacaoSession as $key => $categoria) {
            //categoria = servico ou produto
            // dd($key,$categoria,$solicitacaoSession);
            if($key == 'produtos'){
                foreach($categoria as $item){
                    $produto = new Produto();
                    $produto->id_contrato = 0;
                    $produto->nome = $item->nome;
                    $produto->quantidade = $item->quantidade;
                    $produto->valor = $item->valor;
                    $produto->valor_imposto = $item->valor_imposto;
                    $produto->descricao = $item->descricao;
                    $produto->link_oferta = $item->link_oferta;
                    $produto->id_criador = $item->id_criador;
                    $produto->data_criacao = $item->data_criacao;
                    $produto->id_modificador = $item->id_modificador;
                    $produto->data_modificacao = $item->data_modificacao;
                    $produto->save();

                    $solicitacao_produto  = new Detalhe_Solicitacao_Produto();
                    $solicitacao_produto->id_solicitacao = $solicitacao->id;
                    $solicitacao_produto->id_produto = $produto->id;
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

        return redirect()->route('lista_solicitacao');

    }






    public function listar(){
        
       
        $solicitacoes = Solicitacao::all();
        //mandar para tela listar com os produtos e com os servicos
        return view('solicitacao.listar', ['solicitacoes'=> $solicitacoes]);

    }

    public function nova(){
        
        //verificando se session não existe
        if(!session()->has('novaSolicitacao')){
            session(['novaSolicitacao' => new \stdClass() ]);
        }
        
        return view('solicitacao.nova');      
    }




    public function detalhe($id){
        //pegando solicitacao
        $solicitacao = Solicitacao::find($id);
        return view('solicitacao.detalhe',['solicitacao'=> $solicitacao]);        
    }

}
