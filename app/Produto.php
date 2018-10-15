<?php

namespace App;
use App\Detalhe_Solicitacao_Produto;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produto';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_modificacao';


    public function solicitacoes()
    {
        return $this->belongsToMany('App\Solicitacao','detalhe_solicitacao_produto','id_produto','id_solicitacao');
    }
}
