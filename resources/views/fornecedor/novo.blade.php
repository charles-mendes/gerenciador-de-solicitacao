@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
          'title' => 'Novo Fornecedor',
          'localizacoes' => [ ['Home', route('dashboard') ],['novo-fornecedor', ''] ] 
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
  <script src="{{ asset('js/fornecedor/novo.js') }}"></script>
@endpush


@section('content')
  <div class="col-lg-12">

      <div class="card">
          <div class="card-block">
              <h4 class="card-title">
                  Cadastrar Produto
                  {{-- cadastrarProduto() --}}
                  <button type="button" onclick="cadastrarFornecedor()" class="btn btn-primary">Cadastrar fornecedor</button>
              </h4>
              <div class="table-responsive">
                  <table id="" class="display" style="width:100%">
                      <thead>
                          <tr>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Valor</th>
                            <th>Valor Imposto</th>
                            <th>Descricao</th>
                            <th>Link Oferta</th>
                            <th>Ações</th>
                          </tr>
                      </thead>
                  
                      <tbody>
                        @if ( isset(session('novoFornecedor')->produtos) )
                          @foreach(session('novoFornecedor')->produtos as $key => $produto)
                              <tr>      
                                <td>{{$produto->nome}}</td>
                                <td>{{$produto->quantidade}}</td>
                                <td>{{$produto->valor}}</td>
                                <td>{{$produto->valor_imposto}}</td>
                                <td>{{$produto->descricao}}</td>
                                <td>{{$produto->link_oferta}}</td> 
                                <th>
                                  <button id="btn-edit" type="button" class="btn btn-primary" data-id="{{$key}}" 
                                    {{-- data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap" --}}
                                    onclick="editarProduto(this)"
                                  ><i class="ti-pencil"></i></button>
                                  {{-- <button type="button" class="btn btn-primary" data-id="{{$key}}" data-toggle="tooltip" data-target="#exampleModal" data-whatever="@getbootstrap"  data-placement="left" --}}
                                      {{-- data-original-title="Clique aqui para editar o produto"> --}}
                                          
                                  {{-- </button>    --}}
                                </th>                          
                              </tr>
                          @endforeach
                        @endif 
                      </tbody>
                  </table>
              </div>
             
          </div>
      </div>   
      
      <div class="card"> 
          <div class="card-block">
              <h4 class="card-title">
                Cadastrar Servicos
                <button type="button" onclick="cadastrarServico()" class="btn btn-primary">Cadastrar servico</button>
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalServico" data-whatever="@getbootstrap">Cadastrar solicitacao</button> --}}
              </h4>
              {{-- <h6 class="card-subtitle">Cadastrar Servicos</h6> --}}
              <div class="table-responsive">
                  <table id="" class="display" style="width:100%">
                      <thead>
                          <tr>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Valor Imposto</th>
                            <th>Descricao</th>
                            <th>Ações</th>
                          </tr>
                      </thead>
                      
                      <tbody>
                        @if ( isset(session('novaSolicitacao')->servicos) )
                          @foreach(session('novaSolicitacao')->servicos as $key => $servico)
                            <tr>
                                <td>{{$servico->nome}}</td>
                                <td>{{$servico->valor}}</td>
                                <td>{{$servico->valor_imposto}}</td>
                                <td>{{$servico->descricao}}</td>
                                <th>
                                  <button id="btn-edit" type="button" class="btn btn-primary" data-id="{{$key}}" onclick="editarServico(this)"><i class="ti-pencil"></i></button>
                                </th> 
                            </tr>
                          @endforeach
                        @endif
                      </tbody>
                  </table>
              </div>
          </div>  
      </div>  

      <div class="card"> 
          <div class="card-block">
              <form id="cadastra_solicitacao" action="{{route('cadastrar_solicitacao')}}" method="POST">
                  @csrf
                  <div class="form-group mb-0">
                      <label for="descricao" class="col-form-label">Descricao da solicitação</label>
                      <textarea class="form-control" id="descricao" name="descricao">{{isset($id) ? session('novaSolicitacao')->produtos[$id]->descricao : ''}}</textarea>
                  </div>
                  <button  type="submit" class="btn btn-primary float-right">Salvar Solicitação</button>
              </form>
          </div>  
      </div>
  </div>  
  
  <div class="modal fade" id="produto" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
                  
          </div>
      </div>
  </div>    

  <div class="modal fade" id="servico" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
                  
          </div>
      </div>
  </div>   

  
@endsection