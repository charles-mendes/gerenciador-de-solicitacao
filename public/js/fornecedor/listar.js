
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

function editarFornecedor(fornecedor){
    let id = $(fornecedor).attr("data-id");

    $('#fornecedor .modal-content').load('/fornecedor/editar/'+ id, function () {
        $('#fornecedor').modal('show');

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
    $('#example').DataTable({
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
    });

});


function visualizarFornecedor(fornecedor){
    
    let id = $(fornecedor).attr("data-id");

    $('#detalhe-fornecedor .modal-content').load('/fornecedor/detalhe/'+ id, function () {
        $('#table-produto-detalhe').DataTable(montando_tabela());
        $('#table-servico-detalhe').DataTable(montando_tabela());
        $('#detalhe-fornecedor').modal('show');
    });

    
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