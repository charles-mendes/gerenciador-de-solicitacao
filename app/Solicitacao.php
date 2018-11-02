<?php

namespace App;
use App\Produto;
use App\Servico;
// use App\Detalhe_Solicitacao_Produto;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    protected $table = 'solicitacao';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_modificacao';



    public function produtos()
    {
        return $this->belongsToMany('App\Produto','detalhe_solicitacao_produto','id_solicitacao','id_produto');
    }


    public function servicos()
    {
                                   //tabela       nome da tab de relacionamento , 
        return $this->belongsToMany('App\Servico','detalhe_solicitacao_servico','id_solicitacao','id_servico');
    }
    
}
