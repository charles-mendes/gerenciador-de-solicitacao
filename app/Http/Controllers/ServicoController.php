<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Servico;

class ServicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }
    
    public function cadastrar_servico($item){
       
        $servico = new Servico();
        //verificar nome do campo name ou nome
        $servico->nome = $item->nome;
        $servico->valor = $item->valor;
        $servico->descricao = $item->descricao;
        // $servico->id_criador = $item->id_criador;
        // $servico->data_criacao = isset($item->data_criacao) ?  $item->data_criacao : time();
        // $servico->id_modificador = $item->id_modificador;
        // $servico->data_modificacao = isset($item->data_modificacao) ? $item->data_modificacao : time();
        $servico->save();
        
        return $servico;
    }


    public static function salvar_servico($tipo, $id, Request $request){
        
        //alterar produto ja existente na session
        $tipo->servicos[$id]->nome = $request->input('nome');
        $tipo->servicos[$id]->quantidade = $request->input('quantidade');
        $tipo->servicos[$id]->valor = $request->input('valor');
        $tipo->servicos[$id]->valor_imposto =  $request->input('imposto');
        $tipo->servicos[$id]->descricao = $request->input('descricao');
        $tipo->servicos[$id]->link_oferta = $request->input('link_oferta');
        $tipo->servicos[$id]->id_criador = Auth::user()->id;
        $tipo->servicos[$id]->id_modificador = Auth::user()->id;
        
        return $tipo;
    }
    
}
