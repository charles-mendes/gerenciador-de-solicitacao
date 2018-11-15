@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
          'title' => 'Nova Solicitacao',
          'localizacoes' => [ ['Home', route('dashboard') ],['nova-solicitacao', ''] ] 
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

@php
    // session()->forget('novaSolicitacao');
    // dd(session('novaSolicitacao')->produtos);
    // dd(Auth::user());
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
                                @if(Auth::user()->tipo_conta == 'S')    
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Descricao</th>
                                    <th>Ações</th>
                                @else
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Valor</th>
                                    <th>Valor Imposto</th>
                                    <th>Descricao</th>
                                    <th>Link Oferta</th>
                                    <th>Ações</th>
                                @endif
                            </tr>
                        </thead>
                    
                        <tbody>
                            @if ( isset(session('novaSolicitacao')->produtos) )
                            @foreach(session('novaSolicitacao')->produtos as $key => $produto)
                                <tr>
                                    @if(Auth::user()->tipo_conta == 'S')    
                                        <td>{{$produto->nome}}</td>
                                        <td>{{$produto->quantidade}}</td>
                                        <td>{{$produto->descricao}}</td>
                                    @else   
                                        <td>{{$produto->nome}}</td>
                                        <td>{{$produto->quantidade}}</td>
                                        <td>{{$produto->valor}}</td>
                                        <td>{{$produto->valor_imposto}}</td>
                                        <td>{{$produto->descricao}}</td>
                                        <td>{{$produto->link_oferta}}</td> 
                                    @endif
                                        <td>
                                            <button id="btn-edit" type="button" class="btn btn-primary" data-id="{{$key}}" onclick="editarProduto(this)">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button id="btn-excluir" type="button" class="btn btn-danger" data-id="{{$key}}" onclick="excluirProduto(this)">
                                                <i class="mdi mdi-close-box-outline"></i>
                                            </button>
                                        </td>                       
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
                </h4>
                {{-- <h6 class="card-subtitle">Cadastrar Servicos</h6> --}}
                <div class="table-responsive">
                    <table id="" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    @if(Auth::user()->tipo_conta == 'S')
                                        <th>Nome</th>
                                        <th>Descricao</th>
                                        <th>Ações</th>
                                    @else
                                        <th>Nome</th>
                                        <th>Valor</th>
                                        <th>Valor Imposto</th>
                                        <th>Descricao</th>
                                        <th>Ações</th>
                                    @endif
                                </tr>
                            </thead>
                        
                        <tbody>
                            @if (isset(session('novaSolicitacao')->servicos))
                            @foreach(session('novaSolicitacao')->servicos as $key => $servico)
                                <tr>
                                    @if(Auth::user()->tipo_conta == 'S')
                                        <td>{{$servico->nome}}</td>
                                        <td>{{$servico->descricao}}</td>
                                    @else
                                        <td>{{$servico->nome}}</td>
                                        <td>{{$servico->valor}}</td>
                                        <td>{{$servico->valor_imposto}}</td>
                                        <td>{{$servico->descricao}}</td>
                                    @endif
                                        <td>
                                            <button id="btn-edit" type="button" class="btn btn-primary" data-id="{{$key}}" onclick="editarServico(this)">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button id="btn-excluir" type="button" class="btn btn-danger" data-id="{{$key}}" onclick="excluirServico(this)">
                                                <i class="mdi mdi-close-box-outline"></i>
                                            </button>
                                        </td> 
                                        
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
                        <textarea placeholder="Esta solicitação tem o objetivo de ..." required class="form-control" id="descricao" name="descricao">{{isset($id) ? session('novaSolicitacao')->produtos[$id]->descricao : ''}}</textarea>
                    </div>
                    <button  type="submit" class="btn btn-primary float-right">Salvar Solicitação</button>
                </form>
            </div>  
        </div>
    </div>  
  
    <div class="modal fade" id="cadastrar-produto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    
            </div>
        </div>
    </div>

    <div class="modal fade" id="editar-produto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    
            </div>
        </div>
    </div>   
    
    <div class="modal fade" id="excluir-produto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                    
            </div>
        </div>
    </div>  

    <div class="modal fade" id="cadastrar-servico" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    
            </div>
        </div>
    </div>   

    <div class="modal fade" id="editar-servico" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    
            </div>
        </div>
    </div>   

    <div class="modal fade" id="excluir-servico" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>  

  
@endsection