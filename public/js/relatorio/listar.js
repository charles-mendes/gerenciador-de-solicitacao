
function montando_tabela(){
    return {
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
        "searching": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false ,
    };
}

function visualizarSoliciticoes(solicitacao){
    
    let id = $(solicitacao).attr("data-id");

    $('#detalhe-solicitacao .modal-content').load('/relatorios/gerar/'+ id, function () {
        $('#table-produto-detalhe').DataTable(montando_tabela());
        $('#table-servico-detalhe').DataTable(montando_tabela());
        $('#detalhe-solicitacao').modal('show');
    });

    
}

$(document).ready(function () {

    $('#example').DataTable({
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
    });

});