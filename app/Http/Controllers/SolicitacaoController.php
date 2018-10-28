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
        return view('solicitacao.modal.produto',[$id]);
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
        $produto->link_oferta = $request->input('link-oferta');
        $produto->id_criador = Auth::user()->id;
        $produto->id_modificador = Auth::user()->id;

        
        //adicionando o novo produto na sessao
        $solicitacao->produtos[]= $produto;

        session()->put('novaSolicitacao', $solicitacao);
        
        
        // // $produto = new Produto;
        // $produto->id_contrato = 0;
        // $produto->nome = $request->input('name');
        // $produto->quantidade = $request->input('quantidade');
        // $produto->valor = $request->input('valor');
        // $produto->valor_imposto = $request->input('imposto');
        // $produto->descricao = $request->input('descricao');
        // $produto->link_oferta = $request->input('link-oferta');
        // $produto->id_criador = Auth::user()->id;
        // //$produto->data_criacao = time();
        // $produto->id_modificador = Auth::user()->id;
        // //$produto->data_modificacao = time(); 
        
        
        // if($produto->save()){
        //     //adiciona produto a uma solicitacao
        //     $detalhe_produto_solicitacao = new Detalhe_Solicitacao_Produto;
        //     $detalhe_produto_solicitacao->id_solicitacao = session('solicitacao')->id;
        //     $detalhe_produto_solicitacao->id_produto = $produto->id ;
        //     $detalhe_produto_solicitacao->save();

        //     //Atualiza solicitação da session fazendo consulta no banco
        //     $solicitacao = Solicitacao::find(session('solicitacao')->id);
        //     session(['solicitacao' => $solicitacao]);
                        

        //     return view('solicitacao.nova',['solicitacao'=> session('solicitacao')]);
        // }

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
