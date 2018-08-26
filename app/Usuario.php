<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_modificacao';

    protected $fillable = [
        'name', 'email', 'senha',
    ];

    protected $hidden = [
        'senha', 'remember_token',
    ];

    public function getAuthPassword() {
        return $this->senha;
    }

    



}
