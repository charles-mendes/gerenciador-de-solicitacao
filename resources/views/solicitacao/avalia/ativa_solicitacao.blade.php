@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Ativa Solicitaçao',
            'localizacoes' => [ ['Home', route('listar_solicitacao') ],['Ativa solicitacao', ''] ]
        ]
    )
    @endcomponent
@endsection
@php
    // dd($justificativa);
@endphp
@push('styles')
    <link href="{{ asset('css/switch.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/solicitacao/aprova.js?t='.time()) }}"></script>
@endpush



@section('content')
        <div class="col-lg-12">
            @if($justificativa !== null)
                <div class="alert alert-danger">
                    <p>Solicitação em estado de reprovação</p>
                    <p>Status : {{App\Status::find($solicitacao->id_status)->tipo_status}}</p>
                    <p>Criador : {{App\Usuario::find($justificativa->id_criador)->nome}}</p>
                    <p>Justificativa : {{$justificativa->justificativa}}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-block">
                        <h4 class="card-title text-center">Ativar Solicitação</h4>
                        <h4 class="card-title text-center">Você deseja ativar novamente está solicitação ?</h4>

                    <h3 class="pt-4 text-center">Produtos</h3>
                    @if($solicitacao->produtos->first() == [])
                        <p>Não há produtos.</p>
                    @else
                        <div class="table-responsive">
                            <table id="table-produto-detalhe" class="display" style="width:100%">
                                @component('component.produtos', ['item' => $solicitacao])@endcomponent
                            </table>
                        </div>                
                    @endif

                    <h3 class="pt-4 text-center">Serviços</h3>
                    @if($solicitacao->servicos->first() == [])
                        <p>Não há serviços.</p>
                    @else
                        <div class="table-responsive">
                            <table id="table-servico-detalhe" class="display" style="width:100%">
                                @component('component.servicos', ['item' => $solicitacao])@endcomponent
                            </table>
                        </div>                
                    @endif 

                    <div class="row">
                        <div class="col-12 text-center pt-3">
                            <div class="row">
                                <div class="col-12"> 
                                    <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="$('#ativar_solicitacao').submit();">Ativar solicitação</button>
                                </div>
                            </div>
                        </div>
                        <form id="ativar_solicitacao" action="{{route('cadastrar_ativacao')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id_solicitacao" value="{{isset($id) ? $id :''}}">
                        </form>
                    </div>
            </div>
        </div>    
        <div class="modal fade" id="detalhe-solicitacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>   

        <div class="modal fade" id="justificativa" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>   
        <div class="modal fade" id="falta_preencher" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>   
        <div class="modal fade" id="finaliza_cotacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>
        <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>   
        
        
        <div class="modal fade" id="excluir-solicitacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>  
@endsection

