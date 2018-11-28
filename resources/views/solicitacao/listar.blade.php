@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Listar Solicitações',
            'localizacoes' => [ ['Home', route('listar_solicitacao') ],['listar solicitacao', ''] ]
        ]
    )
    @endcomponent
@endsection

@push('styles')
    
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
            @if($message = Session::get('success'))
                <div class="alert alert-success">
                    {{$message}}
                </div>
            @endif

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
                        <button type="button" class="btn btn-primary float-right" onclick="novaSolicitacao();">Nova Solicitação</button>
                    </h4>
                    <h6 class="card-subtitle">Lista as solicitações cadastradas no sistema.</h6>
                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th>id</th> --}}
                                    <th>Descrição</th>
                                    <th>Criador</th>
                                    <th>Data Criação</th>
                                    <th>Ultima Modificação</th>
                                    <th>Data Modificação</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($solicitacoes as $solicitacao)
                                    <tr>
                                        {{-- <td>{{$solicitacao->id}}</td> --}}
                                        <td>{{$solicitacao->descricao}}</td>
                                        <td>{{App\Usuario::find($solicitacao->id_criador)->nome}}</td>
                                        <td>{{ date('d/m/Y H:i:s' , strtotime($solicitacao->data_criacao))}}</td>
                                        <td>{{App\Usuario::find($solicitacao->id_modificador)->nome}}</td>
                                        <td>{{ date('d/m/Y H:i:s' , strtotime($solicitacao->data_modificacao))}}</td>
                                        @if(App\Status::find($solicitacao->id_status)->tipo_status == "Inativada")
                                            <td><span class="label label-warning">{{App\Status::find($solicitacao->id_status)->tipo_status}}</span><td>

                                        @elseif(strstr(App\Status::find($solicitacao->id_status)->tipo_status, "Reprovado"))
                                            <td><span class="label label-danger">{{App\Status::find($solicitacao->id_status)->tipo_status}}</span><td>
                                        @elseif(strstr(App\Status::find($solicitacao->id_status)->tipo_status, "Aprovado")) 
                                            <td><span class="label label-megna">{{App\Status::find($solicitacao->id_status)->tipo_status}}</span><td>              
                                        @elseif(strstr(App\Status::find($solicitacao->id_status)->tipo_status, "Finalizada")) 
                                            <td><span class="label label-inverse">{{App\Status::find($solicitacao->id_status)->tipo_status}}</span><td> 
                                        @elseif(strstr(App\Status::find($solicitacao->id_status)->tipo_status, "Cotação")) 
                                            <td><span class="label label-purple">{{App\Status::find($solicitacao->id_status)->tipo_status}}</span><td>
                                        @else
                                            <td><span class="label label-success">{{App\Status::find($solicitacao->id_status)->tipo_status}}</span><td>
                                        @endif    
                                            <button type="button" class="btn btn-primary" data-id="{{$solicitacao->id}}" onclick="visualizarSoliciticoes(this);" data-toggle="tooltip" data-placement="left" title=""
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

