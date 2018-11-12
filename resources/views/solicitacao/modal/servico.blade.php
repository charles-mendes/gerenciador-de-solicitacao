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
            <input type="text" class="form-control" id="nome" name="nome" value="{{isset($id) ? session('novaSolicitacao')->servicos[$id]->nome : ''}}">
        </div>
        {{-- <div class="form-group mb-0">
            <label for="quantidade" min="1" class="col-form-label">Quantidade *</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{isset($id) ? session('novaSolicitacao')->servicos[$id]->quantidade : ''}}">
        </div> --}}
        @if($habilitaCampo)
        <div class="form-group mb-0">
            <label for="valor" class="col-form-label">Valor Serviço *</label>
            <input type="number" class="form-control" id="valor" name="valor" value="{{isset($id) ? session('novaSolicitacao')->servicos[$id]->valor : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="imposto" class="col-form-label">Valor Imposto (Total)</label>
            <input type="number" class="form-control" id="imposto" name="imposto" value="{{isset($id) ? session('novaSolicitacao')->servicos[$id]->valor_imposto : ''}}">
        </div>
        @endif
        <div class="form-group mb-0">
            <label for="descricao" class="col-form-label">Descricao *</label>
            <textarea class="form-control" id="descricao" name="descricao">{{isset($id) ? session('novaSolicitacao')->servicos[$id]->descricao : ''}}</textarea>
        </div>
        {{-- <div class="form-group mb-0">
            <label for="link_oferta" class="col-form-label">Link Oferta</label>
            <textarea class="form-control" type="text" id="link_oferta" name="link_oferta">{{isset($id) ? session('novaSolicitacao')->servicos[$id]->link_oferta : ''}}</textarea>
        </div> --}}
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button id="btn-cadastro-produto" onclick="$('#cria-edita-servico').submit();" type="submit" class="btn btn-primary">Cadastrar</button>
</div>
</div>