@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'localizacoes' =>
            [
                ['Home', route('dashboard') ],
                ['listar solicitacao', '']
            ]
        ]
    )
    @endcomponent
@endsection

@push('styles')
    {{-- <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
    </style> --}}
    <link href="{{ asset('css/switch.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/solicitacao/listar.js?t='.time()) }}"></script>
@endpush



@section('content')
    {{-- <div class="row">     --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Listar Solicitações 
                        {{-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Nova Solicitacao</button> --}}
                        <button type="button" class="btn btn-primary float-right" onclick="novaSolicitacao();">Nova Solicitacao</button>
                    </h4>
                    <h6 class="card-subtitle">Lista os solicitações cadastrados no sistema.</h6>
                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Descrição</th>
                                    <th>Criador</th>
                                    <th>Data Criacao</th>
                                    <th>Ultima Modificacao</th>
                                    <th>Data Modificacao</th>
                                    <th>Situação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($solicitacoes as $solicitacao)
                                    <tr>
                                        {{-- @if($solicitacao->produtos->first() !== null || $solicitacao->servicos->first() !== null)
                                            <td>Tem</td>
                                        @else
                                            <td>N</td>
                                        @endif --}}
                                        <td>{{$solicitacao->id}}</td>
                                        <td>{{$solicitacao->descricao}}</td>
                                        <td>{{App\Usuario::find($solicitacao->id_criador)->nome}}</td>
                                        <td>{{$solicitacao->data_criacao}}</td>
                                        <td>{{App\Usuario::find($solicitacao->id_modificador)->nome}}</td>
                                        <td>{{$solicitacao->data_modificacao}}</td>
                                        <td>
                                            @if($solicitacao->status == 'A')
                                                <span class="label label-success">ativo</span>
                                            @else
                                                <span class="label label-success">Inativo</span>
                                            @endif
                                        </td>                                        
                                        <td>
                                            <button type="button" class="btn btn-primary" data-id="{{$solicitacao->id}}" onclick="visualizarSoliciticoes(this);" data-toggle="tooltip" data-placement="right" title=""
                                                data-original-title="Clique aqui para visualizar os detalhes deste usuário">
                                                    <i class="ti-eye"></i>
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start">
                                                    <a class="dropdown-item" data-id="{{$solicitacao->id}}" onclick="alterarStatus(this);">Inativar</a>
                                                </div>
                                            </div>
                                                  
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Descrição</th>
                                    <th>Criador</th>
                                    <th>Data Criacao</th>
                                    <th>Ultima Modificacao</th>
                                    <th>Data Modificacao</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot> --}}
                        </table>
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
@endsection

