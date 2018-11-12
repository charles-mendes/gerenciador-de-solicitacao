<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ServicoController;
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
        $url_previous = explode('/',url()->previous());
        $previous = end($url_previous);  

        //verificando se session não existe ou se venho da tela solicitação
        if(!session()->has('novaSolicitacao') || $previous == 'solicitacao'){
            session(['novaSolicitacao' => new \stdClass() ]);
        }
        
        return view('solicitacao.nova');      
    }
    
    public function listar(){
        //caso usuario for do tipo 'S' == solicitante faz filtro mostrando apenas solicitações dele
        if(Auth::user()->tipo_conta == 'S'){
            $solicitacoes = Solicitacao::all()->where('id_criador',Auth::user()->id);
        }else{
            $solicitacoes = Solicitacao::all();
        }
        
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
                    //criado produto para enviar
                    $produto = new \stdClass;
                    $produto->nome = $item->nome;
                    $produto->quantidade = $item->quantidade;
                    $produto->valor = $item->valor;
                    $produto->id_contrato = $item->id_contrato;
                    $produto->valor_imposto = $item->valor_imposto;
                    $produto->descricao = $item->descricao;
                    $produto->link_oferta = $item->link_oferta;
                    $produto->id_criador = $item->id_criador;
                    $produto->id_modificador = $item->id_modificador;
                    $produto->data_modificacao = $item->data_modificacao;

                    //salva produto
                    $produtoController = new ProdutoController();
                    $produto = $produtoController->cadastrar_produto($produto);
                    
                    //salva registro na tabela auxiliar
                    $solicitacao_produto = new Detalhe_Solicitacao_Produto();
                    $solicitacao_produto->id_solicitacao = $solicitacao->id;
                    $solicitacao_produto->id_produto = $produto->id;
                    $solicitacao_produto->save();
                }
            }
            
           
            if($key == 'servicos'){
                // dd($categoria);
                foreach($categoria as $item){
                    //criado produto para enviar
                    $servico = new \stdClass;
                    $servico->nome = $item->nome;
                    $servico->valor = $item->valor;
                    $servico->id_contrato = $item->id_contrato;
                    $servico->valor_imposto = $item->valor_imposto;
                    $servico->descricao = $item->descricao;
                    $servico->id_criador = $item->id_criador;
                    $servico->id_modificador = $item->id_modificador;
                    $servico->data_modificacao = $item->data_modificacao;

                    $servicoController = new ServicoController();
                    $servico = $servicoController->cadastrar_servico($servico);

                    //salva registro na tabela auxiliar
                    $solicitacao_servico  = new Detalhe_Solicitacao_Servico();
                    $solicitacao_servico->id_solicitacao = $solicitacao->id;
                    $solicitacao_servico->id_servico = $servico->id;
                    $solicitacao_servico->save();
                }

            }
        }

        return redirect()->route('listar_solicitacao');

    }

    public function mostrar_form_produto(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao        
        if(session()->has('novaSolicitacao')){
            $produto = new \stdClass;
            $produto->nome = "";
            $produto->quantidade = "";
            $produto->valor = "";
            $produto->valor_imposto = "";
            $produto->descricao = "";
            $produto->link_oferta = "";

            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.produto',['produto' => $produto , 'habilitaCampo' => $habilitaCampo]);
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_produto(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required',
                //  'valor'=> 'required',
                // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
             ]);

        }else{
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required',
                'valor'=> 'required',
                // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
             ]);

        }
        
        // pegando a sessao novaSolicitacao e atribuindo a uma var local
        $solicitacao = session('novaSolicitacao');

        //criando produto que sera enviado para ser cadastrado
        $produto = new \stdClass;
        $produto->nome = $request->input('nome');
        $produto->quantidade = $request->input('quantidade');
        $produto->valor = $request->input('valor');
        $produto->valor_imposto = $request->input('imposto');
        $produto->id_contrato = '0';
        $produto->descricao = $request->input('descricao');
        $produto->link_oferta = $request->input('link_oferta');
        $produto->id_criador = Auth::user()->id;
        $produto->data_criacao = time();
        $produto->id_modificador = Auth::user()->id;
        $produto->data_modificacao = time();
        
        //adicionando o novo produto a variavel local solicitacao
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


            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.produto',['produto' => $produto ,'id'=> $id ,'habilitaCampo' => $habilitaCampo]);    
        }
        return back();
    }

    public function salvar_produto(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required',
                //  'valor'=> 'required',
                // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
                'id_produto' => 'required'
             ]);

        }else{
            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required',
                'valor'=> 'required',
                // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
                'id_produto' => 'required'
             ]);

        }

        //pegando o id do produto
        $id = $request->input('id_produto');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
    
        //alterar produto ja existente na session
        $solicitacao->produtos[$id]->nome = $request->input('nome');
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


    public function mostrar_form_servico(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao        
        if(session()->has('novaSolicitacao')){
            $servico = new \stdClass;
            $servico->nome = "";
            $servico->quantidade = "";
            $servico->valor = "";
            $servico->valor_imposto = "";
            $servico->descricao = "";
            $servico->link_oferta = "";

            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.servico',['servico' => $servico , 'habilitaCampo' => $habilitaCampo]);
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_servico(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                 // 'quantidade' => 'required',
                //  'valor'=> 'required',
                 // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
             ]);
        }else{
            $this->validate($request,[
                'nome' => 'required',
                 // 'quantidade' => 'required',
                 'valor'=> 'required',
                 // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
             ]);

        }

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');


        //criando produto que sera enviado para ser cadastrado
        $servico = new \stdClass;
        $servico->nome = $request->input('nome');
        $servico->valor = $request->input('valor');
        $servico->valor_imposto = $request->input('imposto');
        $servico->id_contrato = '0';
        $servico->descricao = $request->input('descricao');
        $servico->id_criador = Auth::user()->id;
        $servico->data_criacao = time();
        $servico->id_modificador = Auth::user()->id;
        $servico->data_modificacao = time();
        
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

            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.servico',['servico' => $servico , 'tipo' => 'solicitacao','id' => $id , 'habilitaCampo' => $habilitaCampo]);    
        }
        return back();
    }


    public function salvar_servico(Request $request){
        if(Auth::user()->tipo_conta == 'S'){
            $this->validate($request,[
                'nome' => 'required',
                 // 'quantidade' => 'required',
                //  'valor'=> 'required',
                 // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
                'id_servico' => 'required',
             ]);
        }else{
            $this->validate($request,[
                'nome' => 'required',
                 // 'quantidade' => 'required',
                 'valor'=> 'required',
                 // 'imposto'=>'',
                'descricao'=>'required',
                // 'link-oferta'=>'',
                'id_servico' => 'required',
             ]);

        }
        
        //pegando o id do servico
        $id = $request->input('id_servico');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
        
        //alterar servico ja existente na session
        $solicitacao->servicos[$id]->nome = $request->input('nome');
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




}
