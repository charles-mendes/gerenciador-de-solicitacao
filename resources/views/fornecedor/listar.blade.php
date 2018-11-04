@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Listar Fornecedores',
            'localizacoes' => [ ['Home', route('dashboard') ],['listar fornecedores', ''] ]
        ]
    )
    @endcomponent
@endsection

@push('styles')
    <link href="{{ asset('css/switch.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/fornecedor/listar.js?t='.time()) }}"></script>
@endpush


@section('content')
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Listar Fornecedores 
                        <button type="button" class="btn btn-primary float-right" onclick="novoFornecedor();">Novo Fornecedor</button>
                    </h4>
                    <h6 class="card-subtitle">Lista os fornecedores cadastrados no sistema.</h6>
                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>                                    
                                    <th>Nome</th>
                                    <th>CPNJ</th>
                                    <th>Status Contrato</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Categoria</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($fornecedores as $fornecedor)
                                    <tr>
                                        <td>{{$fornecedor->nome}}</td>
                                        <td>{{$fornecedor->cnpj}}</td>
                                        <td>{{$fornecedor->status_contato_forn}}</td>
                                        <td>{{$fornecedor->telefone}}</td>
                                        <td>{{$fornecedor->email}}</td>
                                        {{-- <td>
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
                                                <span class="label label-alert">excluido</span>
                                            @endif
                                        </td>                                         --}}
                                        <td>{{$fornecedor->categoria}}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-id="{{$fornecedor->id}}" onclick="visualizarFornecedor(this);" data-toggle="tooltip" data-placement="right" title=""
                                                data-original-title="Clique aqui para visualizar os detalhes deste fornecedor">
                                                    <i class="ti-eye"></i>
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start">
                                                    <a class="dropdown-item" data-id="{{$fornecedor->id}}" onclick="alterarStatus(this);">Inativar</a>
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
        <div class="modal fade" id="fornecedor" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>
        <div class="modal fade" id="detalhe-fornecedor" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        
                </div>
            </div>
        </div>       
@endsection

