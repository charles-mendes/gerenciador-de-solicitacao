<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalhe_produto_fornecedor extends Model
{
    protected $table = 'detalhe_solicitacao_forncedor';
    
    //desabilitando update_at e create_at
    public $timestamps = false;
}
