<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diretoria extends Model
{
    protected $table = 'diretoria';

    // const CREATED_AT = 'data_criacao';
    // const UPDATED_AT = 'data_modificacao';

    public $timestamps = false;


    public function solicitacao()
    {
        return $this->hasMany('App\Solicitacao','id','id_solicitacao');
    }



}




