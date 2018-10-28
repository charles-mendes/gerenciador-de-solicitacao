<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">{{!$id ? 'Novo Produto' : 'Editar Produto' }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>itens obrigatorios (*)</p>
        <form id="cadastrar_produto" action="{{route( !$id ? 'cadastrar_produto' : 'salva_produto')}}" method="POST">
          @csrf
          <div class="form-group mb-0">
            <label for="name" class="col-form-label">Nome do Produto*</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$id: session('novaSolicitacao')->produtos[$id]->nome ? ''}}"">
          </div>
          <div class="form-group mb-0">
            <label for="quantidade" min="1" class="col-form-label">Quantidade *</label>
          <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{$id : sesion('novaSolicitacao')->produtos[$id]->quantidade ? ''}}">
          </div>
          <div class="form-group mb-0">
            <label for="valor" class="col-form-label">Valor Produto *</label>
          <input type="number" class="form-control" id="valor" name="valor" value="{{$id : session('novaSolicitacao')->produtos[$id]->valor : ''}}">
          </div>
          <div class="form-group mb-0">
            <label for="imposto" class="col-form-label">Valor Imposto (Total)</label>
            <input type="number" class="form-control" id="imposto" name="imposto" value="{{$id : session('novaSolicitacao')->produtos[$id]->imposto : ''}}">
          </div>
          <div class="form-group mb-0">
            <label for="descricao" class="col-form-label">Descricao *</label>
            <textarea class="form-control" id="descricao" name="descricao" value="{{$id : session('novaSolicitacao')->produtos[$id]->descricao : ''}}"></textarea>
          </div>
          <div class="form-group mb-0">
            <label for="link-oferta" class="col-form-label">Link Oferta</label>
            <textarea class="form-control" type="text" id="link-oferta" name="link-oferta" value="{{$id : session('novaSolicitacao')->produtos[$id]->link_oferta : ''}}"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button id="btn-cadastro-produto" type="submit" class="btn btn-primary">Cadastrar</button>
      </div>
    </div>