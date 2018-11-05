<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{!isset($id) ? 'Novo Produto' : 'Editar Produto' }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p>itens obrigatorios (*)</p>
    <form id="cria-edita-produto" action="
    @if($tipo == 'fornecedor')
        {{route( !isset($id) ? 'cadastrar_produto_fornecedor' : 'salvar_produto_fornecedor')}}
    @else
        {{route( !isset($id) ? 'cadastrar_produto_solicitacao' : 'salvar_produto_solicitacao')}}
    @endif
    " method="POST">
        @csrf
        <input type="hidden" name="id_produto" value="{{isset($id) ? $id :''}}">
        @if(isset($id_fornecedor))<input type="hidden" name="id_fornecedor" value="{{$id_fornecedor}}">@endif
        <div class="form-group mb-0">
            <label for="name" class="col-form-label">Nome do Produto*</label>
            <input type="text" class="form-control" id="name" name="name" value="{{isset($id) ? session('novaSolicitacao')->produtos[$id]->nome : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="quantidade" min="1" class="col-form-label">Quantidade *</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{isset($id) ? session('novaSolicitacao')->produtos[$id]->quantidade : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="valor" class="col-form-label">Valor Produto *</label>
            <input type="number" class="form-control" id="valor" name="valor" value="{{isset($id) ? session('novaSolicitacao')->produtos[$id]->valor : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="imposto" class="col-form-label">Valor Imposto (Total)</label>
            <input type="number" class="form-control" id="imposto" name="imposto" value="{{isset($id) ? session('novaSolicitacao')->produtos[$id]->valor_imposto : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="descricao" class="col-form-label">Descricao *</label>
            <textarea class="form-control" id="descricao" name="descricao">{{isset($id) ? session('novaSolicitacao')->produtos[$id]->descricao : ''}}</textarea>
        </div>
        <div class="form-group mb-0">
            <label for="link_oferta" class="col-form-label">Link Oferta</label>
            <textarea class="form-control" type="text" id="link_oferta" name="link_oferta">{{isset($id) ? session('novaSolicitacao')->produtos[$id]->link_oferta : ''}}</textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button id="btn-cadastro-produto" onclick="$('#cria-edita-produto').submit();" type="submit" class="btn btn-primary">Cadastrar</button>
</div>
</div>