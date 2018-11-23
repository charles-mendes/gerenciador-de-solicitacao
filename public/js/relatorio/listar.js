
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

function visualizarSoliciticoes(solicitacao){
    
    let id = $(solicitacao).attr("data-id");

    $('#detalhe-solicitacao .modal-content').load('/relatorios/gerar/'+ id, function () {
        $('#table-produto-detalhe').DataTable(montando_tabela());
        $('#table-servico-detalhe').DataTable(montando_tabela());
        $('#detalhe-solicitacao').modal('show');
    });

    
}

$(document).ready(function () {

    // $("#example").tableExport({
    //     headings: false,                    // (Boolean), display table headings (th/td elements) in the <thead>
    //     footers: false,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
    //     formats: ["xls", "csv", "txt"],    // (String[]), filetypes for the export
    //     fileName: "id",                    // (id, String), filename for the downloaded file
    //     bootstrap: true,                   // (Boolean), style buttons using bootstrap
    //     position: "bottom",                 // (top, bottom), position of the caption element relative to table
    //     ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file(s)
    //     ignoreCols: null,                  // (Number, Number[]), column indices to exclude from the exported file(s)
    //     ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
    //     emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
    //     trimWhitespace: false              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
    // });

    // $('#example').DataTable({
    //     "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
    // });

   

    // $('example').each(function () {
    //     montarTabela($(this).attr('id'));
    // });

   

});



// function montarTabela(id) {

//     const coluna = $('#' + id + ' thead th').map(function (itens) {
//         return {"orderable": false};
//     });

// 		$('#' + id).DataTable({
//                 "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
// 				// "bPaginate": false,
// 				// "bScrollCollapse": false,
// 				 columns: coluna,
//                 //  bSort: false,
//                  dom: 'Bfrtip',
//                  buttons: [
//                     'copy', 'csv', 'excel', 'pdf', 'print'
//                 ],
// 		});
// }
