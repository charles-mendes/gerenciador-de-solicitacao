
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
        $('#table-produto-detalhe').DataTable(montando_tabela());
        $('#table-servico-detalhe').DataTable(montando_tabela());
        $('#detalhe-solicitacao').modal('show');
    });

    
}

function excluirSolicitacao(solicitacao){
    let id = $(solicitacao).attr("data-id");

    $('#excluir-solicitacao .modal-content').load('/solicitacao/excluir-solicitacao/'+ id, function () {
        $('#table-produto-solicitacao').DataTable(montando_tabela());
        $('#table-servico-solicitacao').DataTable(montando_tabela());
        $('#excluir-solicitacao').modal('show');
    });

}

function avaliaSolicitacao(solicitacao){
    let id = $(solicitacao).attr("data-id");

    window.location.href = '/solicitacao/avalia/'+ id;

}

$(document).ready(function () {
    $('#example').DataTable({
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
    });
});