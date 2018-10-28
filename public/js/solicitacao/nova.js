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

    // $('#btn-edit').click(function(){
        
    //     let id = $(this).attr("data-id");

        
    //     //alterar o action 
    //     $('cadastrar_produto');
    //     // $('#cadastrar_produto').submit();
    // });


    $('#btn-cadastro-produto').click(function(){
        $('#cadastrar_produto').submit();
    });

    $('#btn-cadastro-servico').click(function(){
        $('#cadastrar_servico').submit();
    });

});


function cadastrarProduto(){
    
    $('#produto .modal-content').load('/solicitacao/novo-produto/', function () {
        $('#produto').modal('show');
        $('table.display').DataTable();
    });

    // detalhe-solicitacao
}


function editarProduto(produto){
    
    let id = $(produto).attr("data-id");

    $('#produto .modal-content').load('/solicitacao/edita-produto/'+ id, function () {
        $('#produto').modal('show');
        $('table.display').DataTable();
    });

    
}