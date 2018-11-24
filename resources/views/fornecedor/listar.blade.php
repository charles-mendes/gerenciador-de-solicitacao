@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Listar Fornecedores',
            'localizacoes' => [ ['Home', route('listar_solicitacao') ],['listar fornecedores', ''] ]
        ]
    )
    @endcomponent
@endsection

@push('styles')
    <link href="{{ asset('css/switch.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {{-- <script src="{{ asset('js/mask.js?t='.time()) }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="{{ asset('js/fornecedor/listar.js?t='.time()) }}"></script>
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
                                    <th>Descrição</th>
                                    <th>Produto/Servico</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($fornecedores as $fornecedor)
                                    <tr>
                                        <td>{{$fornecedor->nome}}</td>
                                        <td>{{$fornecedor->cnpj}}</td>
                                        <td>
                                            @if($fornecedor->status == 'A')
                                                <span class="label label-success">Ativo</span>
                                            @endif
                                            @if($fornecedor->status == 'I')
                                                <span class="label label-danger">Inativo</span>
                                            @endif
                                        </td>
                                        <td>{{$fornecedor->telefone}}</td>
                                        <td>{{$fornecedor->email}}</td>
                                        <td>{{$fornecedor->descricao}}</td>
                                        <td class="text-center">
                                            @if( !($fornecedor->produtos->first()) && !($fornecedor->servicos->first()) )
                                                <button type="button" class="btn btn-primary" data-id="{{$fornecedor->id}}" onclick="cadastrar(this);" data-toggle="tooltip" data-placement="right" title=""
                                                    data-original-title="Cadastrar produtos/servicos">
                                                        Adicionar
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-primary" data-id="{{$fornecedor->id}}" onclick="cadastrar(this);" data-toggle="tooltip" data-placement="right" title=""
                                                    data-original-title="Cadastrar produtos/servicos">
                                                        Editar 
                                                </button>

                                            @endif

                                        </td>
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
                                                    <a class="dropdown-item" data-id="{{$fornecedor->id}}" onclick="editarFornecedor(this);">Editar</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" data-id="{{$fornecedor->id}}" onclick="excluirFornecedor(this);">Inativar</a>
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

