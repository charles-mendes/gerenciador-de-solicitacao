<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalhe_Produto_Solicitacao extends Model
{
    protected $table = 'detalhe_produto_solicitacao';
    //desabilitando update_at e create_at
    public $timestamps = false;
}
