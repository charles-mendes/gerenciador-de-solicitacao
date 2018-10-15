<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalhe_servico_fornecedor extends Model
{
    protected $table = 'detalhe_solicitacao_fornecedor';

     //desabilitando update_at e create_at
     public $timestamps = false;
}
