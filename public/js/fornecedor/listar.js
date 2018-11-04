
function novoFornecedor(){
    $('#fornecedor .modal-content').load('/fornecedor/novo/', function () {
        $('#fornecedor').modal('show');
        $('table.display').DataTable();

        //colocando ações no botão check enderco
        $("#check_endereco").click(function(){
            //verificar se botão ta check 
            if($("#check_endereco").is(":checked") == true){
                $('#fields_endereco').show();
                //adicionando required nos campos 
                $('.verify-required').prop('required',true);
            }else{
                $('#fields_endereco').hide();
                $('.verify-required').prop('required',false);
            }
            
        }); 

        $("#check_anexo").click(function(){
            //verificar se botão ta check 
            if($("#check_anexo").is(":checked") == true){
                $('#field_anexo').show();
                //adicionando required nos campos 
                $('#anexo').prop('required',true);
            }else{
                $('#field_anexo').hide();
                $('#anexo').prop('required',false);
            }
            
        }); 
    });

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