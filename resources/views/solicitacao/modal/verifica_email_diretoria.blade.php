@php
// dd(session('novaSolicitacao')->produtos)
@endphp
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Justificativa</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="email-diretoria" action="{{route('enviar_email_diretoria')}}" method="POST">
        @csrf
        <input type="hidden" name="id_solicitacao" value="{{isset($id) ? $id :''}}">
        <div class="form-group mb-0">
            <label for="email" class="col-form-label">Envie um email para a Diretoria, pois valor da solicitação esta acima de 5000 R$</label>
            <input class="form-control" id="email" name="email"/>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button id="btn-cadastro-produto" onclick="$('#email-diretoria').submit();" type="submit" class="btn btn-primary">Enviar</button>
</div>
</div>