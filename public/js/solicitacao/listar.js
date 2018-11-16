
function novaSolicitacao(){
    window.location.href = '/solicitacao/nova';
}

function editarSolicitacao(solicitacao){
    let id = $(solicitacao).attr("data-id");
    console.log(id);

    window.location.href = '/solicitacao/editar/'+ id;
}

function visualizarSoliciticoes(solicitacao){
    
    let id = $(solicitacao).attr("data-id");

    $('#detalhe-solicitacao .modal-content').load('/solicitacao/detalhe/'+ id, function () {
        $('#detalhe-solicitacao').modal('show');
        $('table-produto').DataTable({
            "searching": false
        });
        $('table-servico').DataTable({
            "searching": false
        });
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

    $('#example').DataTable({
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
    });
});