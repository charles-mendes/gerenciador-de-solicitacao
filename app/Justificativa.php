<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Justificativa extends Model
{
    protected $table = 'justificativa';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_modificacao';
}
