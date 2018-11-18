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


function cadastrarProduto(){    
    $('#cadastrar-produto .modal-content').load('/fornecedor/novo-produto/', function () {
        $('#cadastrar-produto').modal('show');
    });
}


function editarProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#editar-produto .modal-content').load('/fornecedor/edita-produto/'+ id, function () {
        $('#editar-produto').modal('show');
    });
    
}

function excluirProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#excluir-produto .modal-content').load('/fornecedor/excluir-produto/'+ id, function () {
        $('#excluir-produto').modal('show');
    });
    
}


function cadastrarServico(){
    
    $('#cadastrar-servico .modal-content').load('/fornecedor/novo-servico/', function () {
        $('#cadastrar-servico').modal('show');
    });
}


function editarServico(servico){
    
    let id = $(servico).attr("data-id");

    $('#editar-servico .modal-content').load('/fornecedor/edita-servico/'+ id, function () {
        $('#editar-servico').modal('show');
    });
    
}


function excluirServico(servico){
    
    let id = $(servico).attr("data-id");

    $('#excluir-servico .modal-content').load('/fornecedor/excluir-servico/'+ id, function () {
        $('#excluir-servico').modal('show');
    });
    
}



