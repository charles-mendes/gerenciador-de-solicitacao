
function novaSolicitacao(){
    window.location.href = '/solicitacao/nova';
}

function editarSolicitacao(solicitacao){
    let id = $(solicitacao).attr("data-id");
    window.location.href = '/solicitacao/editar/'+ id;
}

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

    $('#detalhe-solicitacao .modal-content').load('/solicitacao/detalhe/'+ id, function () {
        $('#detalhe-solicitacao').modal('show');
        $('#table-produto').DataTable(montando_tabela());
        $('#table-servico').DataTable(montando_tabela());
    });

    
}

function excluirSolicitacao(solicitacao){
    let id = $(solicitacao).attr("data-id");

    $('#excluir-solicitacao .modal-content').load('/solicitacao/excluir-solicitacao/'+ id, function () {
        $('#excluir-solicitacao').modal('show');
        $('#table-produto').DataTable(montando_tabela());
        $('#table-servico').DataTable(montando_tabela());
    });

}

$(document).ready(function () {

    $('#example').DataTable({
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
    });
});