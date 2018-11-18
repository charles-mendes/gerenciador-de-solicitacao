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



    public function produtos()
    {
        return $this->belongsToMany('App\Produto','detalhe_fornecedor_produto','id_fornecedor','id_produto');
    }


    public function servicos()
    {
        return $this->belongsToMany('App\Servico','detalhe_fornecedor_servico','id_fornecedor','id_servico');
    }

    public function endereco()
    {
        //um fornecedor tem varios enderecos
        // return $this->belongsToMany('App\Servico','detalhe_fornecedor_servico','id_fornecedor','id_servico');
        return $this->hasMany('App\Endereco','id_fornecedor','id');
    }

    public function contrato()
    {
        return $this->hasMany('App\Contrato','id_fornecedor','id');
    }
}
