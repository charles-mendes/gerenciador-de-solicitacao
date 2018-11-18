
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{!isset($id) ? 'Novo Serviço' : 'Editar Serviço' }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p>itens obrigatorios (*)</p>
    <form id="cria-edita-servico" action="{{route( !isset($id) ? 'cadastrar_servico_fornecedor' : 'salvar_servico_fornecedor')}}" method="POST">
        @csrf
        <input type="hidden" name="id_servico" value="{{isset($id) ? $id :''}}">
        <input type="hidden" name="id_fornecedor" value="{{$id_fornecedor}}">
        <div class="form-group mb-0">
            <label for="nome" class="col-form-label">Nome do Serviço*</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{isset($id) ? session('novaSolicitacao')->servicos[$id]->nome : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="valor" class="col-form-label">Valor Serviço *</label>
            <input type="number" class="form-control" id="valor" name="valor" value="{{isset($id) ? session('novaSolicitacao')->servicos[$id]->valor : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="descricao" class="col-form-label">Descricao *</label>
            <textarea class="form-control" id="descricao" name="descricao">{{isset($id) ? session('novaSolicitacao')->servicos[$id]->descricao : ''}}</textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button id="btn-cadastro-produto" onclick="$('#cria-edita-servico').submit();" type="submit" class="btn btn-primary">Cadastrar</button>
</div>
</div>