<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use Auth;

use Illuminate\Http\Request;

class SolicitacaoController extends Controller
{
    
    public function index(){
        
    }

    public function nova(){
        $solicitacao = new Solicitacao;
        $solicitacao->status = "A";
        $solicitacao->descricao = "nao sei pq desse campo";
        $solicitacao->id_criador = Auth::user()->id;
        $solicitacao->data_criacao = time();
        $solicitacao->id_modificador = Auth::user()->id;
        $solicitacao->data_modificacao = time(); 
        
        if($solicitacao->save()){
            return view('solicitacao.nova',$solicitacao );
        }
        
    }



}
