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
    <form id="cria-edita-justificativa" action="{{route('cadastrar_justificativa')}}" method="POST">
        @csrf
        <input type="hidden" name="id_solicitacao" value="{{isset($id) ? $id :''}}">
        <div class="form-group mb-0">
            <label for="justificativa" class="col-form-label">Explique o porque da não aprovação a solicitação...</label>
            <textarea class="form-control" id="justificativa" name="justificativa"></textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button id="btn-cadastro-produto" onclick="$('#cria-edita-justificativa').submit();" type="submit" class="btn btn-primary">Salvar</button>
</div>
</div>