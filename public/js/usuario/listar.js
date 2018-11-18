function novoUsuario(){
    //desabilitando botão
    $('#btn-novoUsuario').prop("disabled", true);
    //chamando modal
    $('#usuario .modal-content').load('/usuarios/novo-usuario/', function () {
        $('#usuario').modal('show');
        //habilitando botão para criar novo usuario
        $('#btn-novoUsuario').prop("disabled", false);
    });
    
}

function editaUsuario(usuario){
    
    let id = $(usuario).attr("data-id");

    $('#usuario .modal-content').load('/usuarios/edita-usuario/'+ id, function () {
        $('#usuario').modal('show');
    });
    
}

function mudarSituacao(usuario){

    let id = $(usuario).attr("data-id");

    $('.btn-situacao').prop("disabled", true);

    $('#situacao .modal-content').load('/usuarios/mudar-situacao/'+ id, function () {
        $('#situacao').modal('show');
        //habilitando botão que muda situação do usuario
        $('.btn-situacao').prop("disabled", false);
    });


}


$(document).ready(function () {
    $('#example').DataTable({
        "language": {"url":"/plugins/datatables/language/Portuguese-Brasil.json"},
    });
});