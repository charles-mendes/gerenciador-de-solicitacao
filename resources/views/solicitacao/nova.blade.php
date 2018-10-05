@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'localizacoes' =>
            [
                ['Home', route('dashboard') ],
                ['nova-solicitacao', '']
            ]
        ]
    )
    @endcomponent
@endsection



@section('content')
    <button id="cadastrar_produto" onchange="">
        Cadastrar produto
    <!-- <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> -->
    <!-- <p>Envelope icon: <span class="glyphicon glyphicon-envelope"></span></p>     -->
    </button>

    <button id="cadastrar_servico" onchange="">
        Cadastrar serviço
    </button>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Cadastrar produto</button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Novo Produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="name" class="col-form-label">Nome:</label>
            <input type="text" class="form-control" id="name">
          </div>
          <div class="form-group">
            <label for="quantidade" class="col-form-label">Quantidade:</label>
            <input type="number" class="form-control" id="quantidade">
          </div>
          <div class="form-group">
            <label for="valor" class="col-form-label">Valor:</label>
            <input type="number" class="form-control" id="valor">
          </div>
          <div class="form-group">
            <label for="imposto" class="col-form-label">Valor Imposto:</label>
            <input type="number" class="form-control" id="imposto">
          </div>
          <div class="form-group">
            <label for="descricao" class="col-form-label">Descricao:</label>
            <textarea class="form-control" id="descricao"></textarea>
          </div>
          <div class="form-group">
            <label for="link-oferta" class="col-form-label">Link Oferta:</label>
            <textarea class="form-control" type="text" id="link-oferta"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
@endsection