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

    public function fornecedores()
    {
        return $this->belongsToMany('App\Fornecedor','detalhe_fornecedor_produto','id_produto','id_fornecedor');
    }

    public function detalhe_fornecedor()
    {
        return $this->hasMany('App\DetalheFornecedor','id_produto','id');
    }
}
