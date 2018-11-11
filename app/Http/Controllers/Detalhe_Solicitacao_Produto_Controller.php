<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalhe_Solicitacao_Produto;

class Detalhe_Solicitacao_Produto_Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }


    public function cadastrar( $id_solicitacao, $id_produto){
        $solicitacao_produto = new Detalhe_Solicitacao_Produto();
        $solicitacao_produto->id_solicitacao = $id_solicitacao;
        $solicitacao_produto->id_produto = $id_produto;
    
        return $solicitacao_produto;
    }
}
