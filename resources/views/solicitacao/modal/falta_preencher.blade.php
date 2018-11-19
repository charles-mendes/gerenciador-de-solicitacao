<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Falta Preencher Solicitação</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <h4 class="text-center">Solicitação Não está totalmente preenchida.</h4>
    <h5 class="text-center pt-3" >Verifique se todos os campos </h5>
    <div class="row">
        <div class="col-4 offset-4 text-center pt-3">
            <div class="row">
                <div class="col-12">
                <a type="button" href="{{route('editar_solicitacao',['id' => $id])}}" class="btn btn-primary">Editar Cotação</a>
                </div>
            </div>
        </div>
    </div>
</div>