function mascaraIdentificacao(){
    $("#identificacao").keydown(function(){
        try {
            $("#identificacao").unmask();
        } catch (e) {}
    
        var tamanho = $("#identificacao").val().length;
    
        if(tamanho < 11){
            $("#identificacao").mask("999.999.999-99");
        } else if(tamanho >= 11){
            $("#identificacao").mask("99.999.999/9999-99");
        }
    
        // ajustando foco
        var elem = this;
        setTimeout(function(){
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
}

function mascaraParaTelefone(){
    var CelphoneMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(CelphoneMaskBehavior.apply({}, arguments), options);
        }
    };



    // $(function () {
        // $('#cpf, .mask-cpf').mask('999.999.999-99');
        // $('.valor').mask('000.000.000.000.000,00', {reverse: true});
        // $('.cep').mask('00000-000');
        $('#telefone').mask('(00) 0000-0000');
        $('#telefone').mask(CelphoneMaskBehavior, spOptions);
    // });
}

function naoDeixaNumero(id){
    $('#'+ id).blur(function(){
        let campo = $(this).val();
        if(!isNaN(parseFloat(campo)) && isFinite(campo)){
            $(this).val('');
        }

    });
}


function novoFornecedor(){
    $('#fornecedor .modal-content').load('/fornecedor/novo/', function () {
        $('#fornecedor').modal('show');
        
        //colocando mascara no cnpj/cpf
        mascaraIdentificacao();

        mascaraParaTelefone();

        $('#cep').mask('00000-000'); // mascara do cep

        naoDeixaNumero('nome');
        naoDeixaNumero('endereco');
        naoDeixaNumero('bairro');
        naoDeixaNumero('cidade');
        naoDeixaNumero('estado');
        naoDeixaNumero('pais');


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

        //colocando mascara no cnpj/cpf
        mascaraIdentificacao();

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