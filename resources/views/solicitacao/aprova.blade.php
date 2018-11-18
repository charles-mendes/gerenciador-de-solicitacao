@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Aprova Solicitaçao',
            'localizacoes' => [ ['Home', route('dashboard') ],['aprova solicitacao', ''] ]
        ]
    )
    @endcomponent
@endsection

@push('styles')
    <link href="{{ asset('css/switch.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/solicitacao/aprova.js?t='.time()) }}"></script>
@endpush

@section('content')
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title text-center">Aprova Solicitação</h4>
                    <h4 class="card-title text-center">Tem certeza que deseja aprovar está solicitação ?</h4>

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
                        <div class="col-4 offset-4 text-center pt-3">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-danger" data-id="{{$id}}" onclick="justificarMotivo(this);">Não</button>
                                </div>
                                <div class="col-6"> 
                                    <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="aprovarSolicitacao(this);">Sim</button>
                                </div>
                            </div>
                        </div>
                    </div>


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
        
        <div class="modal fade" id="excluir-solicitacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>  
@endsection

