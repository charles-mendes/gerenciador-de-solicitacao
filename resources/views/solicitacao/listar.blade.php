@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Listar Solicitações',
            'localizacoes' => [ ['Home', route('dashboard') ],['listar solicitacao', ''] ]
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

@php
    // dd($solicitacoes);
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
                    <h4 class="card-title">Listar Solicitações 
                        <button type="button" class="btn btn-primary float-right" onclick="novaSolicitacao();">Nova Solicitacao</button>
                    </h4>
                    <h6 class="card-subtitle">Lista os solicitações cadastrados no sistema.</h6>
                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th>id</th> --}}
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
                                        {{-- <td>{{$solicitacao->id}}</td> --}}
                                        <td>{{$solicitacao->descricao}}</td>
                                        <td>{{App\Usuario::find($solicitacao->id_criador)->nome}}</td>
                                        <td>{{ date( 'd/m/Y H:i:s' , strtotime($solicitacao->data_criacao))}}</td>
                                        <td>{{App\Usuario::find($solicitacao->id_modificador)->nome}}</td>
                                        <td>{{ date( 'd/m/Y H:i:s' , strtotime($solicitacao->data_modificacao))}}</td>
                                        <td>
                                            @if($solicitacao->status == 'A')
                                                <span class="label label-success">aprovado</span>
                                            @endif
                                            @if($solicitacao->status == 'P')
                                                <span class="label label-success">pendente</span>
                                            @endif
                                            @if($solicitacao->status == 'R')
                                                <span class="label label-success">reprovado</span>
                                            @endif
                                            @if($solicitacao->status == 'E')
                                                <span class="label label-danger">excluido</span>
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
                                                    <a class="dropdown-item" data-id="{{$solicitacao->id}}" onclick="editarSolicitacao(this);">Editar</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" data-id="{{$solicitacao->id}}" onclick="excluirSolicitacao(this);">Inativar</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
        
        <div class="modal fade" id="excluir-solicitacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>  
@endsection

