<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contrato';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_modificacao';

}
