<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoSolicitacao extends Model
{
    protected $table = 'historico_solicitacao';

    public $timestamps = false;


    protected $dates = ['data_modificacao'];
}
