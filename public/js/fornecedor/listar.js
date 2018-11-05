
function novoFornecedor(){
    $('#fornecedor .modal-content').load('/fornecedor/novo/', function () {
        $('#fornecedor').modal('show');
        $('table.display').DataTable();

        // ocultar/mostrar campo do endereco
        $("#check_endereco").click(function(){
            required(this,'#fields_endereco','.verify-required');
        }); 


        // ocultar/mostrar campo do CPF/CNPJ
        $("#check_identificacao").click(function(){
            required(this,'#field_identificacao','#identificacao');        
        }); 

        
         // ocultar/mostrar campo do documento em anexo
         $("#check_contrato").click(function(){
            required(this,'#fields_contrato','.verify-required-contrato');
        }); 
    });

}

function cadastrar(fornecedor){
    let id = $(fornecedor).attr("data-id");

    window.location.href = '/fornecedor/cadastrar/'+ id;


}

function required(botao,campo,identificador){
      //verificar se botão ta check 
      if($(botao).is(":checked") == true){
        $(campo).show();
        //adicionando required nos campos 
        $(identificador).prop('required',true);
    }else{
        $(campo).hide();
        $(identificador).prop('required',false);
    }
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