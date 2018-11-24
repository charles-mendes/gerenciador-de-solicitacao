@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
          'title' => 'Novo Cadastro Produto/Servico',
          'localizacoes' => [ ['Home', route('listar_solicitacao') ],['nova-cadastro', ''] ] 
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
                  <button type="button" onclick="cadastrarProduto()" class="btn btn-primary">Cadastrar produto</button>
              </h4>
              <div class="table-responsive">
                <table id="" class="display" style="width:100%">
                    @component('component.produtos', ['item' => $fornecedor,'acao' => true,'flag'=>true])@endcomponent
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
                        @component('component.servicos', ['item' => $fornecedor,'acao' => true, 'flag'=>true])@endcomponent
                  </table>
              </div>
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
        <div class="modal-dialog modal-lg" role="document">
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    
            </div>
        </div>
    </div>    

  
@endsection