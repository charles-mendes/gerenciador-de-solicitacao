<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedor';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_modificacao';

    // public $timestamps = false;

    // protected $dates = ['data_criacao'];



    // public function produtos()
    // {
    //     return $this->belongsToMany('App\Produto','detalhe_solicitacao_produto','id_solicitacao','id_produto');
    // }


    // public function servicos()
    // {
    //                                //tabela       nome da tab de relacionamento , 
    //     return $this->belongsToMany('App\Servico','detalhe_solicitacao_servico','id_solicitacao','id_servico');
    // }
}
