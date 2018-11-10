<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    // const CREATED_AT = 'data_criacao';
    // const UPDATED_AT = 'data_modificacao';

    public $timestamps = false;

    // protected $dates = ['data_criacao'];
}
