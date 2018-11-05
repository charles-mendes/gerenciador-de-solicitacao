$(document).ready(function () {

    $('table.display').DataTable();
});


function cadastrarProduto(){    
    $('#produto .modal-content').load('/fornecedor/novo-produto/', function () {
        $('#produto').modal('show');
        $('table.display').DataTable();
    });
}


function editarProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#produto .modal-content').load('/fornecedor/edita-produto/'+ id, function () {
        $('#produto').modal('show');
        $('table.display').DataTable();
    });
    
}


function cadastrarServico(){
    
    $('#servico .modal-content').load('/fornecedor/novo-servico/', function () {
        $('#servico').modal('show');
        $('table.display').DataTable();
    });
}


function editarServico(servico){
    
    let id = $(servico).attr("data-id");

    $('#produto .modal-content').load('/fornecedor/edita-servico/'+ id, function () {
        $('#produto').modal('show');
        $('table.display').DataTable();
    });
    
}