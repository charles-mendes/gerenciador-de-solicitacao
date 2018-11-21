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
    
    public function cadastrar_produto($item){
        $produto = new Produto();
        $produto->nome = $item->nome;
        $produto->quantidade = $item->quantidade;
        $produto->valor = $item->valor;
        $produto->descricao = $item->descricao;
        $produto->id_criador = $item->id_criador;
        $produto->data_criacao = $item->data_criacao;
        $produto->id_modificador = $item->id_modificador;
        $produto->data_modificacao = $item->data_modificacao;
        $produto->save();

        return $produto;
    }


    public static function salvar_produto($tipo, $id, Request $request){
        
        //alterar produto ja existente na session
        $tipo->produtos[$id]->nome = $request->input('nome');
        $tipo->produtos[$id]->quantidade = $request->input('quantidade');
        $tipo->produtos[$id]->valor = $request->input('valor');
        $tipo->produtos[$id]->descricao = $request->input('descricao');
        $tipo->produtos[$id]->id_criador = Auth::user()->id;
        $tipo->produtos[$id]->id_modificador = Auth::user()->id;
        
        return $tipo;
    }

}
