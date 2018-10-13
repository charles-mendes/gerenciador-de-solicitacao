<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    protected $table = 'solicitacao';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_modificacao';


    public function produtos()
    {
        return $this->hasMany('App\Produto');
    }
    
}
