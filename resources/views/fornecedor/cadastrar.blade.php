@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
          'title' => 'Novo Cadastro Produto/Servico',
          'localizacoes' => [ ['Home', route('dashboard') ],['nova-cadastro', ''] ] 
        ]
    )
    @endcomponent
@endsection


@push('scripts')
  <script src="{{ asset('js/fornecedor/cadastrar.js') }}"></script>
@endpush

@php
    // dd($fornecedor->produtos);
@endphp


@section('content')
  <div class="col-lg-12">
      <div class="card">
          <div class="card-block">
              <h4 class="card-title">
                  Cadastrar Produto
                  <button type="button" onclick="cadastrarProduto()" class="btn btn-primary">Cadastrar produto</button>
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
                          @foreach($fornecedor->produtos as $key => $produto)
                              <tr>      
                                <td>{{$produto->nome}}</td>
                                <td>{{$produto->quantidade}}</td>
                                <td>{{$produto->valor}}</td>
                                <td>{{$produto->valor_imposto}}</td>
                                <td>{{$produto->descricao}}</td>
                                <td>{{$produto->link_oferta}}</td> 
                                <th>
                                  <button id="btn-edit" type="button" class="btn btn-primary" data-id="{{$key}}" 
                                    onclick="editarProduto(this)"><i class="ti-pencil"></i></button>
                                </th>                          
                              </tr>
                          @endforeach
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
                        @if ( isset(session('novoCadastroFornecedor')->servicos) )
                          @foreach(session('novoCadastroFornecedor')->servicos as $key => $servico)
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