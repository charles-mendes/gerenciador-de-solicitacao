@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Avalia Solicitaçao',
            'localizacoes' => [ ['Home', route('listar_solicitacao') ],['avalia solicitacao', ''] ]
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
                    @if($status == 'Pendente')    
                        <h4 class="card-title text-center">Avaliar Solicitação</h4>
                        <h4 class="card-title text-center">Você deseja aprovar está solicitação ?</h4>
                    @endif
                    @if($status == 'Iniciou Cotação')    
                        <h4 class="card-title text-center">Finalize a Cotação</h4>
                        <h4 class="card-title text-center">Você deseja finalizar o preenchimento da cotação ?</h4>
                    @endif
                    @if($status == 'Em processo de execução')
                        <h4 class="card-title text-center">Finalize o processo da Solicitação</h4>
                        <h4 class="card-title text-center">Você deseja finalizar o processo da solicitação ?</h4>
                    @endif    
                    @if($status == 'Finalizada')    
                        <h4 class="card-title text-center">Solicitação Finalizada</h4>
                        {{-- <h4 class="card-title text-center">Você deseja finalizar o processo da solicitação ?</h4> --}}
                    @endif
                    @if($status == 'Aprovado pelo Administrador')    
                        <h4 class="card-title text-center">Solicitação Aprovada pelo Administrador</h4>
                        {{-- <h4 class="card-title text-center">Você deseja finalizar o processo da solicitação ?</h4> --}}    
                    @endif
                    
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
                    @if($status == 'Iniciou Cotação')
                        @if($total > 5000 && $falta_preencher == false)
                            {{-- enviar email para Diretoria --}}
                            <div class="row">
                                <div class="col-4 offset-4 text-center pt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger" data-id="{{$id}}" onclick="editarSolicitacao(this);">Editar Cotação</button>
                                        </div>
                                        <div class="col-6"> 
                                            <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="enviarEmailDiretoria(this);">Finalizar Cotação</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($falta_preencher == true)
                            {{-- Aparecer modal falando que tem que preencher todos os valores da solicitacao --}}
                            <div class="row">
                                <div class="col-4 offset-4 text-center pt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger" data-id="{{$id}}" onclick="editarSolicitacao(this);">Editar Cotação</button>
                                        </div>
                                        <div class="col-6"> 
                                            <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="faltaPreencher(this);">Finalizar Cotação</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($total < 5000 && $falta_preencher == false)
                            {{-- caso ideial apenas finaliza a cotacao --}}
                            <div class="row">
                                <div class="col-4 offset-4 text-center pt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger" data-id="{{$id}}" onclick="editarSolicitacao(this);">Editar Cotação</button>
                                        </div>
                                        <div class="col-6"> 
                                            <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="finalizarCotacao(this);">Finalizar Cotação</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif    
                    @endif
                    @if($status == 'Em processo de execução')
                        <div class="row">
                            <div class="col-4 offset-4 text-center pt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger" data-id="{{$id}}" onclick="justificarMotivo(this);">Justificar motivo</button>
                                    </div>
                                    <div class="col-6"> 
                                        <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="finalizarProcesso(this);">Finalizar Solicitação</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($status == 'Finalizada' || $status == 'Aprovado pelo Administrador')
                        <div class="row">
                            <div class="col-4 offset-4 text-center pt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <a type="button" href="{{route('listar_solicitacao')}}" class="btn btn-primary">Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($status == 'Pendente')
                        <div class="row">
                            <div class="col-12 text-center pt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger" data-id="{{$id}}" onclick="justificarMotivo(this);">Não Aprovar</button>
                                    </div>
                                    <div class="col-6"> 
                                        <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="aprovarSolicitacao();">Aprovar</button>
                                    </div>
                                </div>
                            </div>
                            <form id="cadastrar_aprovacao" action="{{route('cadastrar_aprovacao')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id_solicitacao" value="{{isset($id) ? $id :''}}">
                            </form>
                        </div>
                    @endif
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

