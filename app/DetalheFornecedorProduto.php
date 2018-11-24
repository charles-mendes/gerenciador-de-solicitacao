<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalheFornecedorProduto extends Model
{
    protected $table = 'detalhe_fornecedor_produto';
    
    //desabilitando update_at e create_at
    public $timestamps = false;


    public function detalhe_produto()
    {
        return $this->hasMany('App\Produto','id','id_produto');
    }
}
