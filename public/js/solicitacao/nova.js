$(document).ready(function () {

    // $('table.display').DataTable({
    //     "language": {"url":"/plugins/datatables-plugins/i18n/Portuguese-Brasil.lang"},
    //     "columnDefs": [ {
    //         "targets"  : 'no-sort',
    //         "orderable": false,
    //         "order": []
    //     }]
    // });

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
    
    $('#cadastrar-produto .modal-content').load('/solicitacao/novo-produto/', function () {
        $('#cadastrar-produto').modal('show');
        $('table.display').DataTable();
    });
}


function editarProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#editar-produto .modal-content').load('/solicitacao/edita-produto/'+ id, function () {
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
        $('#cadastrar-servico').modal('show');
        $('table.display').DataTable();
    });
}


function editarServico(servico){
    
    let id = $(servico).attr("data-id");

    $('#editar-servico .modal-content').load('/solicitacao/edita-servico/'+ id, function () {
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
