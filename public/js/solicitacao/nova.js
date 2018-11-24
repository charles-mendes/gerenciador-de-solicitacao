$(document).ready(function () {

    $('table.display').DataTable({
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
        "searching": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false 
    });


});

function naoDeixaApenasNumero(id){
    $('#'+ id).blur(function(){
        let campo = $(this).val();
        if(!isNaN(parseFloat(campo)) && isFinite(campo)){
            $(this).val('');
        }

    });
}


function naoDeixaLetra(id){
    $('#'+ id).blur(function(){
        let campo = $(this).val();
        if(!isNaN(parseFloat(campo)) && isFinite(campo)){
            
        }else{
            $(this).val('');
        }

    });
}


function cadastrarProduto(){
    
    $('#cadastrar-produto .modal-content').load('/solicitacao/novo-produto/', function () {
        naoDeixaApenasNumero('nome');
        naoDeixaApenasNumero('descricao');

        naoDeixaLetra('quantidade');
        naoDeixaLetra('valor');

        $('#cadastrar-produto').modal('show');
        $('table.display').DataTable();
    });
}


function editarProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#editar-produto .modal-content').load('/solicitacao/edita-produto/'+ id, function () {
        naoDeixaApenasNumero('nome');
        naoDeixaApenasNumero('descricao');

        naoDeixaLetra('quantidade');
        naoDeixaLetra('valor');

        $('#editar-produto').modal('show');
        $('table.display').DataTable();
    });
    
}

function excluirProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#excluir-produto .modal-content').load('/solicitacao/excluir-produto/'+ id, function () {
        $('#excluir-produto').modal('show');
        // $('table.display').DataTable();
    });
    
}


function cadastrarServico(){
    
    $('#cadastrar-servico .modal-content').load('/solicitacao/novo-servico/', function () {
        naoDeixaApenasNumero('nome');
        naoDeixaApenasNumero('descricao');

        naoDeixaLetra('valor');

        $('#cadastrar-servico').modal('show');
        $('table.display').DataTable();
    });
}


function editarServico(servico){
    
    let id = $(servico).attr("data-id");

    $('#editar-servico .modal-content').load('/solicitacao/edita-servico/'+ id, function () {
        naoDeixaApenasNumero('nome');
        naoDeixaApenasNumero('descricao');
        
        naoDeixaLetra('valor');

        $('#editar-servico').modal('show');
        $('table.display').DataTable();
    });
    
}

function excluirServico(servico){
    
    let id = $(servico).attr("data-id");

    $('#excluir-servico .modal-content').load('/solicitacao/excluir-servico/'+ id, function () {
        $('#excluir-servico').modal('show');
        // $('table.display').DataTable();
    });
    
}
