<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
use App\Detalhe_Solicitacao_Produto;
use Validator;
//use Request;
use Auth;
//use Input;
use Illuminate\Http\Request;


class SolicitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // public function index(){
        
    // }

    public function novo_produto(){
        return view('solicitacao.modal.produto');
    }

    public function edita_produto($id){
        return view('solicitacao.modal.produto',['id' => $id]);
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


    public function cadastrar_servico(Request $request){
        $this->validate($request,[
            // 'name' => 'required',
            // 'quantidade' => 'required',
            //  'valor'=> 'required',
            // 'imposto'=>'',
            // 'descricao'=>'required',
            // 'link-oferta'=>'',
        ]);
 
         // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');
        
        $servico = new \stdClass();
        $servico->nome = $request->input('name');
        $servico->valor = $request->input('valor');
        $servico->valor_imposto = $request->input('imposto');    
        $servico->descricao = $request->input('descricao');

        
        //adicionando o novo produto na sessao
        $solicitacao->servicos[]= $servico;

        session()->put('novaSolicitacao', $solicitacao);

        return redirect()->route('nova_solicitacao');

    }


    public function detalhe($id){
        //pegando solicitacao
        $solicitacao = Solicitacao::find($id);
        return view('solicitacao.detalhe',['solicitacao'=> $solicitacao]);        
    }

}
