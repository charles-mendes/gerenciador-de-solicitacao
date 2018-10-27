
function novaSolicitacao(){
    window.location.href = '/solicitacao/nova';
}

function visualizarSoliciticoes(solicitacao){
    
    let id = $(solicitacao).attr("data-id");

    $('#detalhe-solicitacao .modal-content').load('/solicitacao/detalhe/'+ id, function () {
        $('#detalhe-solicitacao').modal('show');
        $('table.display').DataTable();
    });

    
}

function alterarStatus(soliciticao){

}

// function submit_form(){
//     $('#cadastrar_produto').submit();
// }

$(document).ready(function () {
    // $('#example').DataTable({
    //     "language": {"url":"/plugins/datatables-plugins/i18n/Portuguese-Brasil.lang"},
    //     "columnDefs": [ {
    //         "targets"  : 'no-sort',
    //         "orderable": false,
    //         "order": []
    //     }]
    // });

    $('#example').DataTable({});
});