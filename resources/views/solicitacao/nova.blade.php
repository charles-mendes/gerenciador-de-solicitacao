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

@push('scripts')
  <script> 
    function submit_form(){
      $('#cadastrar_produto').submit();
    }
  </script>
@endpush



@section('content')

  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Cadastrar produto</button>
  <table id="" class="display" style="width:100%"></table>
  <table id="" class="display" style="width:100%"></table>



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
          <p>itens obrigatorios (*)</p>
          <form id="cadastrar_produto" action="{{route('cadastrar_produto')}}" method="POST">
            @csrf
            <div class="form-group mb-0">
              <label for="name" class="col-form-label">Nome do Produto*</label>
              <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group mb-0">
              <label for="quantidade" min="1" class="col-form-label">Quantidade *</label>
              <input type="number" class="form-control" id="quantidade" name="quantidade">
            </div>
            <div class="form-group mb-0">
              <label for="valor" class="col-form-label">Valor Produto *</label>
              <input type="number" class="form-control" id="valor" name="valor">
            </div>
            <div class="form-group mb-0">
              <label for="imposto" class="col-form-label">Valor Imposto (Total)</label>
              <input type="number" class="form-control" id="imposto" name="imposto">
            </div>
            <div class="form-group mb-0">
              <label for="descricao" class="col-form-label">Descricao *</label>
              <textarea class="form-control" id="descricao" name="descricao"></textarea>
            </div>
            <div class="form-group mb-0">
              <label for="link-oferta" class="col-form-label">Link Oferta</label>
              <textarea class="form-control" type="text" id="link-oferta" name="link-oferta"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" onclick="submit_form()">Cadastrar</button>
        </div>
      </div>
    </div>
</div>
@endsection