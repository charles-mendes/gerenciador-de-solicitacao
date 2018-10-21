$(document).ready(function () {

    // $('table.display').DataTable({
    //     "language": {"url":"/plugins/datatables-plugins/i18n/Portuguese-Brasil.lang"},
    //     "columnDefs": [ {
    //         "targets"  : 'no-sort',
    //         "orderable": false,
    //         "order": []
    //     }]
    // });

    $('table.display').DataTable();


    $('#btn-cadastro-produto').click(function(){
        $('#cadastrar_produto').submit();
    });

    $('#btn-cadastro-servico').click(function(){
        $('#cadastrar_servico').submit();
    });

});