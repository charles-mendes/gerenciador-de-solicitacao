<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalhe_Solicitacao_Produto extends Model
{
    protected $table = 'detalhe_solicitacao_produto';
    
    //desabilitando update_at e create_at
    public $timestamps = false;
}
