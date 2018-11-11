<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Produto;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }
    
    public function cadastrar_produto(Request $request, $item = null){
        $verifica = isset($item) ? true : false;
        $produto = new Produto();
        //verificar nome do campo name ou nome
        $produto->nome = $verifica? $item->nome : $request->input('nome');
        $produto->quantidade = $verifica ? $item->quantidade : $request->input('quantidade');
        $produto->valor = $verifica ? $item->valor : $request->input('valor');
        $produto->id_contrato = '0';
        $produto->valor_imposto = $verifica ? $item->imposto : $request->input('imposto');
        $produto->descricao = $verifica ? $item->descricao : $request->input('descricao');
        $produto->link_oferta = $verifica ? $item->link_oferta : $request->input('link_oferta');
        $produto->id_criador = Auth::user()->id;
        $produto->data_criacao = time();
        $produto->id_modificador = Auth::user()->id;
        $produto->data_modificacao = time();
    
        return $produto;
       
    }


    public static function salvar_produto($tipo, $id, Request $request){
        
        //alterar produto ja existente na session
        $tipo->produtos[$id]->nome = $request->input('nome');
        $tipo->produtos[$id]->quantidade = $request->input('quantidade');
        $tipo->produtos[$id]->valor = $request->input('valor');
        $tipo->produtos[$id]->valor_imposto =  $request->input('imposto');
        $tipo->produtos[$id]->descricao = $request->input('descricao');
        $tipo->produtos[$id]->link_oferta = $request->input('link_oferta');
        $tipo->produtos[$id]->id_criador = Auth::user()->id;
        $tipo->produtos[$id]->id_modificador = Auth::user()->id;
        
        return $tipo;
    }

}
