$(document).ready(function () {

    $('table.display').DataTable();
});


function cadastrarProduto(){    
    $('#cadastrar-produto .modal-content').load('/fornecedor/novo-produto/', function () {
        $('#cadastrar-produto').modal('show');
        $('table.display').DataTable();
    });
}


function editarProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#editar-produto .modal-content').load('/fornecedor/edita-produto/'+ id, function () {
        $('#editar-produto').modal('show');
        $('table.display').DataTable();
    });
    
}


function cadastrarServico(){
    
    $('#cadastrar-servico .modal-content').load('/fornecedor/novo-servico/', function () {
        $('#cadastrar-servico').modal('show');
        $('table.display').DataTable();
    });
}


function editarServico(servico){
    
    let id = $(servico).attr("data-id");

    $('#editar-servico .modal-content').load('/fornecedor/edita-servico/'+ id, function () {
        $('#editar-servico').modal('show');
        $('table.display').DataTable();
    });
    
}