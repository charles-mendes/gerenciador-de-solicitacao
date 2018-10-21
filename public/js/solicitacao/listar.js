
function novaSolicitacao(){
    window.location.href = 'nova/';
}

// function submit_form(){
//     $('#cadastrar_produto').submit();
// }

$(document).ready(function () {
    $('#example').DataTable({
        "language": {"url":"/plugins/datatables-plugins/i18n/Portuguese-Brasil.lang"},
        "columnDefs": [ {
            "targets"  : 'no-sort',
            "orderable": false,
            "order": []
        }]
    });
});