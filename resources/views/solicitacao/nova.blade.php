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
  <script src="{{ asset('js/solicitacao/nova.js') }}"></script>
@endpush



@section('content')


  {{-- <table id="" class="display" style="width:100%"></table>
  <table id="" class="display" style="width:100%"></table> --}}
  <div class="col-lg-12">
      <div class="card">
          <div class="card-block">
              <h4 class="card-title">Nova Solicitação
                  {{-- <button type="button" class="btn btn-primary float-right" onclick="novaSolicitacao();">Nova Solicitacao</button> --}}
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Cadastrar produto</button>
              </h4>
              <h6 class="card-subtitle">Cadastrar Produto</h6>
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
                            {{-- <th>Criador</th> --}}
                            {{-- <th>Data Criacao</th> --}}
                            {{-- <th>Ultima Modificacao</th> --}}
                            {{-- <th>Data Modificacao</th> --}}
                            {{-- <th>Status</th> --}}
                          </tr>
                      </thead>
                  
                      <tbody>                           
                        @foreach($solicitacao->produtos as $produto)
                            <tr>      
                              <td>{{$produto->nome}}</td>
                              <td>{{$produto->quantidade}}</td>
                              <td>{{$produto->valor}}</td>
                              <td>{{$produto->valor_imposto}}</td>
                              <td>{{$produto->descricao}}</td>
                              <td>{{$produto->link_oferta}}</td>
                              {{-- <td>{{App\Usuario::find($produto->id_criador)->nome}}</td> --}}
                              {{-- <td>{{$solicitacao->data_criacao}}</td> --}}
                              {{-- <td>{{App\Usuario::find($produto->id_modificador)->nome}}</td> --}}
                              {{-- <td>{{$solicitacao->data_modificacao}}</td> --}}
                              {{-- <td>{{$solicitacao->status}}</td> --}}
                            </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                          <tr>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Valor</th>
                            <th>Valor Imposto</th>
                            <th>Descricao</th>
                            <th>Link Oferta</th>
                            {{-- <th>Criador</th> --}}
                            {{-- <th>Data Criacao</th> --}}
                            {{-- <th>Ultima Modificacao</th> --}}
                            {{-- <th>Data Modificacao</th> --}}
                          </tr>
                      </tfoot>
                  </table>
              </div>

              {{-- <h6 class="">Cadastrar Servicos</h6> --}}
             
          </div>
      </div>   
      <div class="card"> 
          <div class="card-block">
              <h4 class="card-title">Nova Solicitação
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalServico" data-whatever="@getbootstrap">Cadastrar solicitacao</button>
              </h4>
              <h6 class="card-subtitle">Cadastrar Servicos</h6>
              <div class="table-responsive">
                  <table id="" class="display" style="width:100%">
                      <thead>
                          <tr>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Valor Imposto</th>
                            <th>Descricao</th>
                          </tr>
                      </thead>
                      
                      <tbody>
                        @foreach($solicitacao->servicos as $servico)
                          <tr>
                              <td>{{$servico->nome}}</td>
                              <td>{{$servico->valor}}</td>
                              <td>{{$servico->valor_imposto}}</td>
                              <td>{{$servico->descricao}}</td>
                              
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                          <tr>
                              <th>Nome</th>
                              <th>Valor</th>
                              <th>Valor Imposto</th>
                              <th>Descricao</th>
                          </tr>
                      </tfoot>
                  </table>
              </div>
          </div>  
      </div>  
  </div>    


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
          <button id="btn-cadastro-produto" type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="exampleModalServico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Novo Solicitação de Serviço</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>itens obrigatorios (*)</p>
            <form id="cadastrar_servico" action="{{route('cadastrar_produto')}}" method="POST">
              @csrf
              <div class="form-group mb-0">
                <label for="name" class="col-form-label">Nome do Servico*</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              {{-- <div class="form-group mb-0">
                <label for="quantidade" min="1" class="col-form-label">Quantidade *</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade">
              </div> --}}
              <div class="form-group mb-0">
                <label for="valor" class="col-form-label">Valor do Serviço *</label>
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
              {{-- <div class="form-group mb-0">
                <label for="link-oferta" class="col-form-label">Link Oferta</label>
                <textarea class="form-control" type="text" id="link-oferta" name="link-oferta"></textarea>
              </div> --}}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button id="btn-cadastro-servico" type="submit" class="btn btn-primary">Cadastrar</button>
          </div>
        </div>
      </div>
    </div>
@endsection