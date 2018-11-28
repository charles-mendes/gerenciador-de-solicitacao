@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Listar Usuarios',
            'localizacoes' => [ ['Home', route('listar_solicitacao') ],['listar usuarios', ''] ]
        ]
    )
    @endcomponent
@endsection

@push('styles')
    <link href="{{ asset('css/switch.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/usuario/listar.js?t='.time()) }}"></script>
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
                    <h4 class="card-title">Listar Usuarios
                        <button id="btn-novoUsuario" type="button" class="btn btn-primary float-right" onclick="novoUsuario();">Novo Usuario</button>
                    </h4>
                    <h6 class="card-subtitle">Lista os usuarios cadastrados no sistema.</h6>
                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>email</th>
                                    <th>Situação</th>
                                    <th>Tipo de Conta</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($usuarios as $usuario)
                                    <tr>
                                        {{-- <td>{{$solicitacao->id}}</td> --}}
                                        <td>{{$usuario->nome}}</td>
                                        <td>{{$usuario->email}}</td>
                                        <td>
                                            @if($usuario->situacao == 'A')
                                                <span class="label label-success">Ativo</span>
                                            @endif
                                            @if($usuario->situacao == 'I')
                                                <span class="label label-danger">Inativo</span>
                                            @endif                                            
                                        </td>     
                                        <td>
                                            @if($usuario->tipo_conta == 'A')
                                                <span class="label label-custom">Aprovador</span>
                                            @endif
                                            @if($usuario->tipo_conta == 'C')
                                                <span class="label label-warning">Comprador</span>
                                            @endif
                                            @if($usuario->tipo_conta == 'AD')
                                                <span class="label label-danger">Administrador</span>
                                            @endif
                                            @if($usuario->tipo_conta == 'S')
                                                <span class="label label-danger">Solicitante</span>
                                            @endif
                                        </td>                                   
                                        <td>
                                            <button type="button" class="btn btn-primary" data-id="{{$usuario->id}}" onclick="editaUsuario(this)" data-toggle="tooltip" data-placement="left" title=""
                                                data-original-title="Clique aqui para editar usuário">
                                                    <i class="ti-pencil"></i>
                                            </button>
                                            @if($usuario->situacao == 'A')
                                            <button type="button" class="btn btn-success btn-situacao" data-id="{{$usuario->id}}" onclick="mudarSituacao(this)" data-toggle="tooltip" data-placement="left" title=""
                                                data-original-title="Clique para desabilitar usuário">
                                                <i class="mdi mdi-checkbox-marked-outline"></i>
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-danger btn-situacao" data-id="{{$usuario->id}}" onclick="mudarSituacao(this)" data-toggle="tooltip" data-placement="left" title=""
                                                data-original-title="Clique para habilitar usuário">
                                                <i class="mdi mdi-close-box-outline"></i>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
        <div class="modal fade" id="usuario" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>    

        <div class="modal fade" id="situacao" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>    
@endsection

