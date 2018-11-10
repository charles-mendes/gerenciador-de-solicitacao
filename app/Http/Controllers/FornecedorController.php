<?php

namespace App\Http\Controllers;
use App\Fornecedor;
use App\Endereco;
use App\Contrato;
use App\Produto;
use App\Http\Controllers\DetalheFornecedorProdutoController;
use App\Http\Controllers\ProdutoController;
use Auth;

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar(){
        $fornecedores = Fornecedor::all();
        return view('fornecedor.listar', ['fornecedores'=> $fornecedores]);
    }

    public function novo(){
        //mostra modal para cadastrar novo fornecedor
        return view('fornecedor.modal.fornecedor');
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
        $produto->valor_imposto = "";
        $produto->descricao = "";
        $produto->link_oferta = "";
        
        return view('modal.produto',['produto' => $produto,'id_fornecedor' => $id_fornecedor , 'tipo' => 'fornecedor' ,]);    
    }

    public function cadastrar_produto(Request $request){        
        //validando entrada
        $this->validate($request,[
            'id_fornecedor' => 'required',
            'name' => 'required',
            'quantidade' => 'required',
             'valor'=> 'required',
            // 'imposto'=>'',
            // 'descricao'=>'required',
            // 'link-oferta'=>'',
         ]);

        //id do fornecedor na rota
        $id_fornecedor = $request->input('id_fornecedor');

        //cadastrando produto 
        $produtoController = new ProdutoController();
        $produto = $produtoController->cadastrar_produto($request);
        $produto->save();

        //cadastrando relacionamento entre fornecedor e produto
        $detalhe = new DetalheFornecedorProdutoController();
        $detalhe = $detalhe->cadastrar($id_fornecedor,$produto->id);
        $detalhe->save();        

        
        return redirect()->route('cadastrar',['id' => $id_fornecedor]);
    }

    public function editar_produto($id){
        //chamar modal para usuario

        // if($id){
            $produto = Produto::find($id);
            return view('modal.produto',['produto' => $produto , 'tipo' => 'fornecedor']);    
        // }
        // return back();

        

    }

}
