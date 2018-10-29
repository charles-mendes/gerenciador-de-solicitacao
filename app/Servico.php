<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servico';

    // const CREATED_AT = 'data_criacao';
    // const UPDATED_AT = 'data_modificacao';
    public $timestamps = false;


    public function solicitacoes()
    {
        return $this->belongsToMany('App\Solicitacao','detalhe_solicitacao_servico','id_servico','id_solicitacao');
    }
}
