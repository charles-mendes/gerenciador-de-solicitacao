<?php

namespace App\Http\Controllers;
use App\Fornecedor;
use App\Endereco;
use App\Contrato;
use App\Produto;
use App\Servico;
use App\DetalheFornecedorProduto;
use App\Detalhe_Fornecedor_Servico;
use App\Http\Controllers\DetalheFornecedorProdutoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ProdutoController;
use Auth;

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }

    public function listar(){
        $fornecedores = Fornecedor::all();
        return view('fornecedor.listar', ['fornecedores'=> $fornecedores]);
    }

    public function novo(){
        $fornecedor = new \stdClass;
        $fornecedor->nome = '';
        $fornecedor->cnpj = '';
        $fornecedor->status = '';
        $fornecedor->telefone = '';
        $fornecedor->email = '';
        $fornecedor->descricao = '';
        $fornecedor->endereco = (object)[
            'endereco' => '',
            'bairro' => '',
            'cidade' => '',
            'estado' => '',
            'numero' => '',
            'cep' => '',
            'pais' => '',
        ];
        $fornecedor->contrato = (object)[
            'numero_contrato' => '',
            'descricao' => '',
            'data_vencimento' => '',
        ];

        // isso é para habilitar e desabilitar os check na hora de cadastrar/editar fornecedor
        $check = new \stdClass;
        $check->check_identificacao = false;
        $check->check_endereco = false;
        $check->check_contrato = false;

        //mostra modal para cadastrar novo fornecedor
        return view('fornecedor.modal.fornecedor',['fornecedor' => $fornecedor, 'status' => 'criando' , 'check' => $check]);
    }

    public function detalhe($id){
        //pegando fornecedor
        $fornecedor = Fornecedor::find($id);
        return view('fornecedor.detalhe',['fornecedor'=> $fornecedor,'id'=> $id]);        
    }

   

    private function makeVerify($array){
        if($array['check_identificacao'] == 'on'){
            $check_identificacao = [
                'identificacao' => 'required',
            ];            
        }
        if($array['check_endereco'] == 'on'){
            $check_endereco = [
                'endereco' => 'required',
                'bairro' => 'required',
                'cidade' => 'required',
                'estado' => 'required',
                'numero' => 'required',
                'cep' => 'required',
                'pais' => 'required',
            ];
        }
        if($array['check_contrato'] == 'on'){
            $check_contrato = [
                'numero_contrato' => 'required',
                'descricao_contrato' => 'required',
                'data_vencimento' => 'required',
            ];  
        }

        if($array['check_anexo'] == 'on'){
            $check_anexo = [
                'anexo' => 'required',
            ];  
        }

        if(isset($array['id_fornecedor'])){
            $id_contrato = [
                'id_fornecedor' => 'required',
            ];
        }

        $checkPadrao = [
            'nome' => 'required',
            'telefone' => 'required',
            'email' => 'required',
        ];
        
        //mergeando todos os vetores de validação
        $checkFinal = array_merge(
            isset($check_identificacao) ? $check_identificacao : [],
            isset($check_endereco) ? $check_endereco : [] ,
            isset($check_contrato) ? $check_contrato : [] ,
            isset($check_anexo) ? $check_anexo : [] ,
            isset($id_contrato) ? $id_contrato : [] ,
            $checkPadrao
        );
        // dd($checkFinal);

        return $checkFinal;

    }


    public function cadastrar_fornecedor(Request $request){  
        $arrayCheck = [
            'check_identificacao' => $request->input('check_identificacao'),
            'check_endereco' => $request->input('check_endereco'),
            'check_contrato' => $request->input('check_contrato'),
            'check_anexo' => $request->input('check_anexo')
        ];

        //realizando validação
        $this->validate($request,$this->makeVerify($arrayCheck));

        $fornecedor = new Fornecedor();
        $fornecedor->nome = $request->input('nome');
        //grava informações sobre o cpf/cnpj
        if($request->input('check_identificacao') == 'on'){
            $fornecedor->cnpj = $request->input('identificacao');    
        }
        // $fornecedor->status_contato_forn = $request->input('#');
        $fornecedor->status = 'A';
        $fornecedor->telefone = $request->input('telefone');
        $fornecedor->email = $request->input('email');
        $fornecedor->descricao = $request->input('descricao');
        // $fornecedor->categoria = 'A';
        // $fornecedor->categoria = $request->input('categoria');
        $fornecedor->id_criador = Auth::user()->id;
        $fornecedor->data_criacao = time();
        $fornecedor->id_modificador = Auth::user()->id;
        $fornecedor->data_modificacao = time();
        $fornecedor->save();

        //grava endereco do fornecedor
        if($request->input('check_endereco') == 'on'){
            $endereco = new Endereco();
            $endereco->id_fornecedor = $fornecedor->id;           
            $endereco->endereco =  $request->input('endereco');
            $endereco->bairro =  $request->input('bairro');
            $endereco->cidade =  $request->input('cidade');
            $endereco->estado =  $request->input('estado');
            $endereco->numero =  $request->input('numero');
            $endereco->cep =  $request->input('cep');
            $endereco->pais =  $request->input('pais');
            $endereco->save();
        }
        
       //grava contrato do fornecedor
        if( $request->input('check_contrato') == 'on'){
           $contrato = new Contrato();
           $contrato->id_fornecedor = $fornecedor->id;           
           $contrato->numero_contrato = $request->input('numero_contrato');
           $contrato->status = 'A';
           $contrato->descricao = $request->input('descricao_contrato');
           $contrato->id_criador = Auth::user()->id;
           $contrato->data_criacao = time() ;
           $contrato->id_modificador = Auth::user()->id  ;
           $contrato->data_modificacao = time() ;
           $contrato->data_vencimento = $request->input('data_vencimento') ;
           $contrato->status_anexo = '0';
           $contrato->save();
        }

    
        return redirect()->route('listar_fornecedores');
        
    }

    public function editar_fornecedor($id){
        $id = (int) $id;
        if(is_numeric($id)){
            
            //pegando fornecedor
            $fornecedor = Fornecedor::find($id);
            $fornecedor->endereco = $fornecedor->endereco->first();
            $fornecedor->contrato = $fornecedor->contrato->first();
            
            // isso é para habilitar e desabilitar os check na hora de cadastrar/editar fornecedor
            $check = new \stdClass;
            $check->check_identificacao = $fornecedor->cnpj !== null ? true : false;
            $check->check_endereco = $fornecedor->endereco !== null ? true : false;
            $check->check_contrato = $fornecedor->contrato !== null ? true : false;

            //adicionando atributos dentro do objeto para passar para view
            if($fornecedor->endereco == null){
                $fornecedor->endereco = (object)[
                    'endereco' => '',
                    'bairro' => '',
                    'cidade' => '',
                    'estado' => '',
                    'numero' => '',
                    'cep' => '',
                    'pais' => '',
                ];
            }   
            if($fornecedor->contrato == null){
                $fornecedor->contrato = (object)[
                    'numero_contrato' => '',
                    'descricao' => '',
                    'data_vencimento' => '',
                ];
            }


            //mostra modal para editar fornecedor
            return view('fornecedor.modal.fornecedor',['fornecedor' => $fornecedor, 'check' => $check,'status' => 'editando' ,'id' => $id]);
        }
    }

    public function salvar_fornecedor(Request $request){
        $arrayCheck = [
            'check_identificacao' => $request->input('check_identificacao'),
            'check_endereco' => $request->input('check_endereco'),
            'check_contrato' => $request->input('check_contrato'),
            'check_anexo' => $request->input('check_anexo'),
            'id_fornecedor' => $request->input('id_fornecedor'),
        ];

        //realizando validação
        $this->validate($request,$this->makeVerify($arrayCheck));

        $fornecedor = Fornecedor::find($request->input('id_fornecedor'));
        $fornecedor->nome = $request->input('nome');
        $fornecedor->cnpj = $request->input('identificacao');
        $fornecedor->telefone = $request->input('telefone');
        $fornecedor->email = $request->input('email');
        $fornecedor->descricao = $request->input('descricao');
        $fornecedor->id_modificador = Auth::user()->id;
        $fornecedor->data_modificacao = time();
        $fornecedor->save();

        $endereco = Endereco::where('id_fornecedor',$request->input('id_fornecedor'))->get()->first();
        if($endereco !== null){
            $endereco->endereco = $request->input('endereco');
            $endereco->bairro = $request->input('bairro');
            $endereco->cidade = $request->input('cidade');
            $endereco->estado = $request->input('estado');
            $endereco->numero = $request->input('numero');
            $endereco->cep = $request->input('cep');
            $endereco->pais = $request->input('pais');
            $endereco->save();
        }else{
            //verificar se foi preenchido o endereco
            if($request->input('check_endereco') == 'on'){
                $endereco = new Endereco();
                $endereco->id_fornecedor = $fornecedor->id;           
                $endereco->endereco =  $request->input('endereco');
                $endereco->bairro =  $request->input('bairro');
                $endereco->cidade =  $request->input('cidade');
                $endereco->estado =  $request->input('estado');
                $endereco->numero =  $request->input('numero');
                $endereco->cep =  $request->input('cep');
                $endereco->pais =  $request->input('pais');
                $endereco->save();
            }
            
        }
        
        
        $contrato = Contrato::where('id_fornecedor',$request->input('id_fornecedor'))->get()->first();
        if($contrato !== null){
            $contrato->numero_contrato = $request->input('numero_contrato');
            $contrato->descricao = $request->input('descricao_contrato');
            $contrato->data_vencimento = $request->input('data_vencimento');
            $contrato->id_modificador = Auth::user()->id;
            $contrato->data_modificacao = time();
            $contrato->save();
        }else{
            if( $request->input('check_contrato') == 'on'){
                $contrato = new Contrato();
                $contrato->id_fornecedor = $fornecedor->id;           
                $contrato->numero_contrato = $request->input('numero_contrato');
                $contrato->status = 'A';
                $contrato->descricao = $request->input('descricao_contrato');
                $contrato->id_criador = Auth::user()->id;
                $contrato->data_criacao = time() ;
                $contrato->id_modificador = Auth::user()->id  ;
                $contrato->data_modificacao = time() ;
                $contrato->data_vencimento = $request->input('data_vencimento') ;
                $contrato->status_anexo = '0';
                $contrato->save();
            }
        }
        
    
        return redirect()->route('listar_fornecedores');
    }


    public function cadastrar($id){
        if($id){
           $fornecedor = Fornecedor::find($id);
            return view('fornecedor.cadastrar',['fornecedor' => $fornecedor]);  
        }
        return back();
          
    }
    public function novo_produto(Request $request){
        //pegar o id do fornecedor
        $url = explode('/',$request->headers->get('referer'));
        $id_fornecedor = end($url);  
        
        $produto = new \stdClass;
        $produto->nome = "";
        $produto->quantidade = "";
        $produto->valor = "";
        $produto->descricao = "";
        
        return view('fornecedor.modal.produto',['produto' => $produto,'id_fornecedor' => $id_fornecedor]);    
    }

    public function cadastrar_produto(Request $request){        
        //validando entrada
        $this->validate($request,[
            'id_fornecedor' => 'required',
            'nome' => 'required',
            'quantidade' => 'required',
            'valor'=> 'required',
            'descricao' => 'required',
         ]);

        //id do fornecedor na rota
        $id_fornecedor = $request->input('id_fornecedor');

        //criando produto que sera enviado para ser cadastrado
        $produto = new \stdClass;
        $produto->nome = $request->input('nome');
        $produto->quantidade = $request->input('quantidade');
        $produto->valor = $request->input('valor');
        $produto->descricao = $request->input('descricao');
        $produto->id_criador = Auth::user()->id;
        $produto->data_criacao = time();
        $produto->id_modificador = Auth::user()->id;
        $produto->data_modificacao = time();

        //cadastrando produto 
        $produtoController = new ProdutoController();
        $produto = $produtoController->cadastrar_produto($produto);

        //cadastrando relacionamento entre fornecedor e produto
        $fornecedor_produto = new DetalheFornecedorProduto();
        $fornecedor_produto->id_fornecedor = $id_fornecedor;
        $fornecedor_produto->id_produto = $produto->id;
        $fornecedor_produto->save();

        
        return redirect()->route('cadastrar',['id' => $id_fornecedor]);
    }

    public function editar_produto($id , Request $request){
        //chamar modal para usuario
        $id = (int) $id;
        if(is_numeric($id)){
            //pegar o id do fornecedor
            $url = explode('/',$request->headers->get('referer'));
            $id_fornecedor = end($url);  

            $produto = Produto::find($id);
            return view('fornecedor.modal.produto',['produto' => $produto,'id_fornecedor' => $id_fornecedor, 'id' => $id]);    
        }
        return back();

    }



    public function salvar_produto(Request $request){

            $this->validate($request,[
                'nome' => 'required',
                'quantidade' => 'required',
                'valor'=> 'required',                
                'descricao'=>'required',
                'id_produto' => 'required',
            ]);

        //pegar o id do fornecedor
        $url = explode('/',$request->headers->get('referer'));
        $id_fornecedor = end($url);      
        

        //pegando o id do produto
        $id_produto = $request->input('id_produto');
         
        //pegando produto
        $produto = Produto::find($id_produto);
    
        //alterar produto ja existente 
        $produto->nome = $request->input('nome');
        $produto->quantidade = $request->input('quantidade');
        $produto->valor = $request->input('valor');
        $produto->descricao = $request->input('descricao');
        $produto->id_modificador = Auth::user()->id;
        $produto->data_modificacao = time();
        $produto->save();

        return redirect()->route('cadastrar',['id' => $id_fornecedor]);

    }

    public function mostrar_verificacao_produto($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        $id = (int) $id;
        if(is_numeric($id) ){
            $produto = Produto::find($id);
            //verifica se existe o vetor produtos e se o produto que foi escolhido existe no array de produtos cadastrados
            if(isset($produto)){
                return view('fornecedor.modal.verifica_produto',['produto'=> $produto]);    
            }
        }
        return back();
    }

    public function excluir_produto(Request $request){
        $this->validate($request,[
            'id_produto' => 'required',
        ]);

        //pegar o id do fornecedor
        $url = explode('/',$request->headers->get('referer'));
        $id_fornecedor = end($url);     

        $id_produto = (int) request()->input('id_produto');

        $produto = Produto::find($id_produto);
        if($produto){
            //detelar relação entre produto e fornecedor
            $fornecedor_produto = DetalheFornecedorProduto::where('id_produto',$produto->id)->get()->first();
            $fornecedor_produto->delete();
            
            //deletando produto
            $produto->delete();

            return redirect()->route('cadastrar',['id' => $id_fornecedor]);

        }
        return back();
    }

  





    public function novo_servico(Request $request){
        //pegar o id do fornecedor
        $url = explode('/',$request->headers->get('referer'));
        $id_fornecedor = end($url);  
        
        $servico = new \stdClass;
        $servico->nome = "";
        $servico->valor = "";
        $servico->descricao = "";
        
        return view('fornecedor.modal.servico',['servico' => $servico,'id_fornecedor' => $id_fornecedor]);    
    }


    public function cadastrar_servico(Request $request){        
        //validando entrada
        $this->validate($request,[
            'id_fornecedor' => 'required',
            'nome' => 'required',
            'valor'=> 'required',
            'descricao' => 'required',
         ]);

        //id do fornecedor na rota
        $id_fornecedor = $request->input('id_fornecedor');

        //criando produto que sera enviado para ser cadastrado
        $servico = new \stdClass;
        $servico->nome = $request->input('nome');
        $servico->valor = $request->input('valor');
        $servico->descricao = $request->input('descricao');
        $servico->id_criador = Auth::user()->id;
        $servico->data_criacao = time();
        $servico->id_modificador = Auth::user()->id;
        $servico->data_modificacao = time();

        //cadastrando servico
        $servicoController = new ServicoController();
        $servico = $servicoController->cadastrar_servico($servico);


        //cadastrando relacionamento entre fornecedor e produto
        $fornecedor_servico = new Detalhe_Fornecedor_Servico();
        $fornecedor_servico->id_fornecedor = $id_fornecedor;
        $fornecedor_servico->id_servico = $servico->id;
        $fornecedor_servico->save();

        
        return redirect()->route('cadastrar',['id' => $id_fornecedor]);
    }

    public function editar_servico($id , Request $request){
        //chamar modal para usuario
        $id = (int) $id;
        if(is_numeric($id)){
            //pegar o id do fornecedor
            $url = explode('/',$request->headers->get('referer'));
            $id_fornecedor = end($url);  

            $servico = Servico::find($id);
            return view('fornecedor.modal.servico',['servico' => $servico,'id_fornecedor' => $id_fornecedor, 'id' => $id]);    
        }
        return back();

    }


    public function salvar_servico(Request $request){

        $this->validate($request,[
            'nome' => 'required',
            'valor'=> 'required',                
            'descricao'=>'required',
            'id_servico' => 'required',
        ]);

    //pegar o id do fornecedor
    $url = explode('/',$request->headers->get('referer'));
    $id_fornecedor = end($url);      
    

    //pegando o id do produto
    $id_servico = $request->input('id_servico');
     
    //pegando produto
    $servico = Servico::find($id_servico);

    //alterar produto ja existente 
    $servico->nome = $request->input('nome');
    $servico->valor = $request->input('valor');
    $servico->descricao = $request->input('descricao');
    // $servico->id_modificador = Auth::user()->id;
    // $servico->data_modificacao = time();
    $servico->save();

    return redirect()->route('cadastrar',['id' => $id_fornecedor]);

}


public function mostrar_verificacao_servico($id){
    //verifica se a session existe, se não existir ele redireciona a nova solicitacao
    $id = (int) $id;
    if(is_numeric($id) ){
        $servico = Servico::find($id);
        //verifica se existe o vetor produtos e se o produto que foi escolhido existe no array de produtos cadastrados
        if(isset($servico)){
            return view('fornecedor.modal.verifica_servico',['servico'=> $servico, 'id' => $id]);    
        }
    }
    return back();
}

public function excluir_servico(Request $request){
    $this->validate($request,[
        'id_servico' => 'required',
    ]);

    //pegar o id do fornecedor
    $url = explode('/',$request->headers->get('referer'));
    $id_fornecedor = end($url);     

    $id_servico = (int) request()->input('id_servico');

    $servico = Servico::find($id_servico);
    if($servico){
        //detelar relação entre servico e fornecedor
        $fornecedor_servico = Detalhe_Fornecedor_Servico::where('id_servico',$servico->id)->get()->first();
        $fornecedor_servico->delete();
        
        //deletando produto
        $servico->delete();

        return redirect()->route('cadastrar',['id' => $id_fornecedor]);

    }
    return back();
}



}
