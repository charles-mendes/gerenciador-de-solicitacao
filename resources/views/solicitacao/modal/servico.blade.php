@php
// dd(session('novaSolicitacao')->servicos)
@endphp
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{!isset($id) ? 'Novo Serviço' : 'Editar Serviço' }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p>itens obrigatorios (*)</p>
    <form id="cria-edita-servico" action="{{route( !isset($id) ? 'cadastrar_servico_solicitacao' : 'salvar_servico_solicitacao')}}" method="POST">
        @csrf
        <input type="hidden" name="id_servico" value="{{isset($id) ? $id :''}}">
        <div class="form-group mb-0">
            <label for="nome" class="col-form-label">Nome do Serviço*</label>
            <input maxlength="100" type="text" class="form-control" id="nome" name="nome" value="{{$servico->nome}}">
        </div>
        @if($habilitaCampo)
        <div class="form-group mb-0">
            <label for="valor" class="col-form-label">Valor Serviço *</label>
            <input type="number" min="1"  class="form-control" id="valor" name="valor" value="{{$servico->valor}}">
        </div>
        @endif
        <div class="form-group mb-0">
            <label for="descricao" class="col-form-label">Descrição *</label>
            <textarea class="form-control" id="descricao" name="descricao">{{$servico->descricao}}</textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button id="btn-cadastro-produto" onclick="$('#cria-edita-servico').submit();" type="submit" class="btn btn-primary">Cadastrar</button>
</div>
</div>