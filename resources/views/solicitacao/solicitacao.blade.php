@extends('layouts.principal')

@php
    // dd($status);
@endphp
{{-- @section('breadcrumb')
    @component('layouts.component.breadcrumb',[
          'title' => ($status == 'criando') ? 'Nova Solicitacao' : 'Editando Solicitacao',
          'localizacoes' => [ ['Home', route('listar_solicitacao') ],[($status == 'criando') ? 'Nova Solicitacao' : 'Editando Solicitacao', ''] ] 
        ]
    )
    @endcomponent
@endsection --}}

@push('scripts')
  {{-- <script src="{{ asset('js/solicitacao/nova.js?t={{time()}}') }}"></script> --}}
  <script src="{{ asset('js/solicitacao/nova.js?t='.time()) }}"></script>
@endpush

@section('content')
    <div class="col-lg-12">
        @if(count($errors)>0)
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">
                    Cadastrar Produto
                    <button type="button" onclick="cadastrarProduto()" class="btn btn-primary">+</button>
                </h4>
                <div class="table-responsive">
                    <table id="" class="display" style="width:100%">
                        @component('component.produtos', ['item' => session('novaSolicitacao'),'acao' => true])@endcomponent
                    </table>
                </div>
                
            </div>
        </div>   
        <div class="card"> 
            <div class="card-block">
                <h4 class="card-title">
                    Cadastrar Servicos
                    <button type="button" onclick="cadastrarServico()" class="btn btn-primary">+</button>
                </h4>
                <div class="table-responsive">
                    <table id="" class="display" style="width:100%">
                        @component('component.servicos', ['item' => session('novaSolicitacao'),'acao' => true])@endcomponent
                    </table>
                </div>
            </div>  
        </div>  
        <div class="card"> 
            <div class="card-block">
                <form id="cadastra_solicitacao" action="{{route(($status == 'criando') ? 'cadastrar_solicitacao' : 'salvar_solicitacao')}}" method="POST">
                    @csrf
                    <div class="form-group mb-0">
                        <label for="descricao" class="col-form-label">Descricao da solicitação</label>
                        <textarea id="descricao" name="descricao" class="form-control" placeholder="Esta solicitação tem o objetivo de ..." required >{{isset(session('novaSolicitacao')->descricao)? session('novaSolicitacao')->descricao : ''}}</textarea>
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