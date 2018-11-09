<?php

namespace App\Http\Controllers;
use App\DetalheFornecedorProduto;
use Illuminate\Http\Request;

class DetalheFornecedorProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function cadastrar( $id_fornecedor, $id_produto){
        $fornecedor_produto = new DetalheFornecedorProduto();
        $fornecedor_produto->id_fornecedor = $id_fornecedor;
        $fornecedor_produto->id_produto = $id_produto;
    
        return $fornecedor_produto;
    }
}
