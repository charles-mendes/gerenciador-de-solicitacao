// function novaSolicitacao(){
//     window.location.href = '/solicitacao/nova';
// }

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

// function visualizarSoliciticoes(solicitacao){
    
//     let id = $(solicitacao).attr("data-id");

//     $('#detalhe-solicitacao .modal-content').load('/solicitacao/detalhe/'+ id, function () {
//         $('#table-produto-detalhe').DataTable(montando_tabela());
//         $('#table-servico-detalhe').DataTable(montando_tabela());
//         $('#detalhe-solicitacao').modal('show');
//     });

    
// }

// function excluirSolicitacao(solicitacao){
//     let id = $(solicitacao).attr("data-id");

//     $('#excluir-solicitacao .modal-content').load('/solicitacao/excluir-solicitacao/'+ id, function () {
//         $('#table-produto-solicitacao').DataTable(montando_tabela());
//         $('#table-servico-solicitacao').DataTable(montando_tabela());
//         $('#excluir-solicitacao').modal('show');
//     });

// }

function aprovarSolicitacao(){
    $('#cadastrar_aprovacao').submit();
}

function justificarMotivo(solicitacao){
    let id = $(solicitacao).attr("data-id");

    $('#justificativa .modal-content').load('/solicitacao/justificativa/'+ id, function () {
        $('#justificativa').modal('show');
    });
}

$(document).ready(function () {
    $('#table-produto-detalhe').DataTable(montando_tabela());
    $('#table-servico-detalhe').DataTable(montando_tabela());
});

function finalizarCotacao(solicitacao){

    let id = $(solicitacao).attr("data-id");

    $('#finaliza_cotacao .modal-content').load('/solicitacao/finaliza_cotacao/'+ id, function () {
        $('#table-produto-solicitacao').DataTable(montando_tabela());
        $('#table-servico-solicitacao').DataTable(montando_tabela());
        $('#finaliza_cotacao').modal('show');
    });
}

function finalizarProcesso(solicitacao){
    let id = $(solicitacao).attr("data-id");

    // $('#finaliza_solicitacao .modal-content').load('/solicitacao/finaliza_solicitacao/'+ id, function () {
    //     // $('#table-produto-solicitacao').DataTable(montando_tabela());
    //     // $('#table-servico-solicitacao').DataTable(montando_tabela());
    //     $('#finaliza_solicitacao').modal('show');
    // });

    window.location.href = '/solicitacao/finaliza_solicitacao/'+ id;
}


function enviarEmailDiretoria(solicitacao){
    let id = $(solicitacao).attr("data-id");

    $('#email .modal-content').load('/solicitacao/email_diretoria/'+ id, function () {
        $('#email').modal('show');
    });
}


function faltaPreencher(solicitacao){
    let id = $(solicitacao).attr("data-id");

    $('#falta_preencher .modal-content').load('/solicitacao/falta_preencher/'+ id, function () {
        $('#falta_preencher').modal('show');
    });
}