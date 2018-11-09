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
    }
    
    public function cadastrar_servico(Request $request, $item = null){
        $verifica = isset($item) ? true : false;
        $servico = new Servico();
        //verificar nome do campo name ou nome
        $servico->nome = $verifica? $item->nome : $request->input('nome');
        $servico->quantidade = $verifica ? $item->quantidade : $request->input('quantidade');
        $servico->valor = $verifica ? $item->valor : $request->input('valor');
        $servico->id_contrato = '0';
        $servico->valor_imposto = $verifica ? $item->imposto : $request->input('imposto');
        $servico->descricao = $verifica ? $item->descricao : $request->input('descricao');
        $servico->link_oferta = $verifica ? $item->link_oferta : $request->input('link_oferta');
        $servico->id_criador = Auth::user()->id;
        $servico->data_criacao = time();
        $servico->id_modificador = Auth::user()->id;
        $servico->data_modificacao = time();
    
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
