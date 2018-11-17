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
        $solicitacao = session('novaSolicitacao');
        
        return view('solicitacao.solicitacao',['solicitacao' => $solicitacao ,'status' => 'criando']);
    }
    
    public function listar(){
        //caso usuario for do tipo 'S' == solicitante faz filtro mostrando apenas solicitações dele
        if(Auth::user()->tipo_conta == 'S'){
            $solicitacoes = Solicitacao::all()->where('id_criador',Auth::user()->id);
        }else if(Auth::user()->tipo_conta == 'A'){
            //so pode mostrar solicitações que estão pendentes
            $solicitacoes = Solicitacao::all()->where('status','P');
        }else{
            $solicitacoes = Solicitacao::all();
        }
        
        //mandar para tela listar com os produtos e com os servicos
        return view('solicitacao.listar', ['solicitacoes'=> $solicitacoes]);

    }

    
    public function detalhe($id){
        //pegando solicitacao
        $solicitacao = Solicitacao::find($id);
        return view('solicitacao.detalhe',['solicitacao'=> $solicitacao,'id'=> $id]);        
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

    public function editar_solicitacao($id){
        
        if($id){
            //verifica se o usuario tipo solicitante tem permissão para editar essa soliciitação
            if(Auth::user()->tipo_conta == "S"){
                $solicitacoes = Solicitacao::all()->where('id_criador',Auth::user()->id);
                $verify = false;
                foreach($solicitacoes as $solicitacao){
                    if($solicitacao->id == $id){
                        $verify = true;
                    }
                }
                if(!($verify)){
                    return back()->withErrors('Você não tem permissão para editar esta solicitação.');
                }
            }

            //pegando a url da onde o usuario venho 
            $url_previous = explode('/',url()->previous());
            $previous = end($url_previous);
            //verifica se usuario venho ta url solicitação, caso venho faz o find da solicitação requerida e coloca na session novaSolicitação
            if(!is_numeric($previous)){
                $solicitacao = Solicitacao::find($id);
                session(['novaSolicitacao' => $solicitacao ]);
            }
            return view('solicitacao.solicitacao',['status' => 'editando' ,'id_solicitacao' => $id]);
        }
        return back();
    }


    public function salvar_solicitacao(Request $request){
        // dd($request->input());
        $this->validate($request,[
            // 'id_solicitacao'=>'required',
            'descricao' => 'required',
        ]);

        if(session()->has('novaSolicitacao')){
            $solicitacao = session('novaSolicitacao');
            $solicitacao->descricao = $request->input('descricao');
            $solicitacao->id_modificador = Auth::user()->id;
            $solicitacao->data_modificacao = time();
            $solicitacao->save();
            
            //salvando alterações no produto
            foreach($solicitacao->produtos as $produto){
                if(isset($produto->id) && is_numeric($produto->id)){
                    //salvando alteração em objeto
                    $produto->save();
                }else{
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

            //salvando alterações no servico
            foreach($solicitacao->servicos as $servico){
                if(isset($servico->id) && is_numeric($servico->id)){
                    //salvando alteração em objeto
                    $servico->save();
                }else{
                    $servicoController = new ServicoController();
                    $servico = $servicoController->cadastrar_servico($servico);

                    //salva registro na tabela auxiliar
                    $solicitacao_servico  = new Detalhe_Solicitacao_Servico();
                    $solicitacao_servico->id_solicitacao = $solicitacao->id;
                    $solicitacao_servico->id_servico = $servico->id;
                    $solicitacao_servico->save();
                }
            }

            //salvando alteração na descricao


            return redirect()->route('listar_solicitacao');
        }
    }


    public function mostrar_verificacao_solicitacao($id){
         //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        $id = (int) $id;
        
        if($id != null){
            $solicitacao = Solicitacao::find($id);
            return view('solicitacao.modal.verifica_solicitacao',['solicitacao'=> $solicitacao]);    
        }
        return back();
    }

    public function excluir_solicitacao(Request $request){
        $this->validate($request,[
            'id_solicitacao' => 'required|numeric',
        ]);

        $id_solicitacao = (int) request()->input('id_solicitacao');

        $solicitacao = Solicitacao::find($id_solicitacao);
        $solicitacao->status = 'E';
        $solicitacao->save();

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

    private function redireciona_solicitacao(){
        $url_previous = explode('/',url()->previous());
        
        if(end($url_previous) == 'nova'){
            return route('nova_solicitacao');
        }else if(is_numeric(end($url_previous))){   
            $id = (int) end($url_previous);
            return route('editar_solicitacao',[$id]);
        }
        
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
    
        //redireciona solicitação
        return redirect($this->redireciona_solicitacao());
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

        //redirecionando solicitação
        return redirect($this->redireciona_solicitacao());
    }

    public function mostrar_verificacao_produto($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $solicitacao = session('novaSolicitacao');
            //verifica se existe o vetor produtos e se o produto que foi escolhido existe no array de produtos cadastrados
            if($solicitacao->produtos !== [] && isset($solicitacao->produtos[$id]) ){
                return view('solicitacao.modal.verifica_produto',['id'=> $id]);    
            }
        }
        return back();
    }

    public function excluir_produto(Request $request){
        $this->validate($request,[
            'id_produto' => 'required',
        ]);
        $id_produto = (int) request()->input('id_produto');

        if(session()->has('novaSolicitacao')){
            $solicitacao = session('novaSolicitacao');
            if( isset($solicitacao->produtos) && isset($solicitacao->produtos[$id_produto])){
                
                if(isset($solicitacao->produtos[$id_produto]->id)){
                    //deleta servico no banco
                    $produto = Produto::find($solicitacao->produtos[$id_produto]->id);
                    $produto->delete();

                    //detelar relação entre servico e solicitacao
                    $solicitacao_produto = Detalhe_Solicitacao_Produto::where('id_produto',$solicitacao->produtos[$id_produto]->id)->get()->first();
                    $solicitacao_produto->delete();
                
                }
                
                $produtos = $solicitacao->produtos;
                if(count($produtos) !== 0){
                    //excluindo produto
                    unset($produtos[$id_produto]);
                    
                    //ordenando vetor depois da exclusão de um produto
                    $produtos = array_values($produtos);
                }
                session('novaSolicitacao')->produtos = $produtos;
                
                //redirecionando solicitação
                return redirect($this->redireciona_solicitacao());
            }

        }
        return back();

    }


    public function mostrar_form_servico(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao        
        if(session()->has('novaSolicitacao')){
            $servico = new \stdClass;
            $servico->nome = "";
            $servico->valor = "";
            $servico->valor_imposto = "";
            $servico->descricao = "";
            $servico->link_oferta = "";

            //habilita campos para colocar valor da solicitacao
            $habilitaCampo = Auth::user()->tipo_conta !== 'S' ? true : false;

            return view('solicitacao.modal.servico',['servico' => $servico , 'habilitaCampo' => $habilitaCampo]);
        }
        return back();
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
        
        //redirecionando solicitação
        return redirect($this->redireciona_solicitacao());
    }


    public function editar_servico($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $servico = new \stdClass;
            $servico->nome = session('novaSolicitacao')->servicos[$id]->nome;
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

        //redirecionando solicitação
        return redirect($this->redireciona_solicitacao());
    }


    public function mostrar_verificacao_servico($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if($id != null && session()->has('novaSolicitacao')){
            $id = (int) $id;
            $solicitacao = session('novaSolicitacao');
            //verifica se existe o vetor produtos e se o produto que foi escolhido existe no array de produtos cadastrados
            if($solicitacao->servicos !== [] && isset($solicitacao->servicos[$id]) ){
                return view('solicitacao.modal.verifica_servico',['id'=> $id]);    
            }
        }
        return back();
    }

    public function excluir_servico(Request $request){
        $this->validate($request,[
            'id_servico' => 'required',
        ]);
        $id_servico = (int) request()->input('id_servico');

        if(session()->has('novaSolicitacao')){
            $solicitacao = session('novaSolicitacao');
            // tem que excluir no banco quando é objeto 

            if( isset($solicitacao->servicos) && isset($solicitacao->servicos[$id_servico])){
                //verifica se produto ja esta cadastrado no banco
                //caso tiver deleta do banco 
                if(isset($solicitacao->servicos[$id_servico]->id)){
                    //deleta servico no banco
                    $servico = Servico::find($solicitacao->servicos[$id_servico]->id);
                    $servico->delete();

                    //detelar relação entre servico e solicitacao
                    $solicitacao_servico = Detalhe_Solicitacao_Servico::where('id_servico',$solicitacao->servicos[$id_servico]->id)->get()->first();
                    $solicitacao_servico->delete();
                }

                //para ajustar visualização de edição de solicitação
                $servicos = $solicitacao->servicos;
                
                if(count($servicos) !== 0){
                    //excluindo servico
                    unset($servicos[$id_servico]);
                    //ordenando vetor depois da exclusão de um servico
                    $servicos = array_values($servicos);
                }
                session('novaSolicitacao')->servicos = $servicos;
                
                //redirecionando solicitação
                return redirect($this->redireciona_solicitacao());

            }   
        }
        return back();

    }




}
