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
@endpush

@push('scripts')
    <script src="{{ asset('js/solicitacao/listar.js') }}"></script>
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
                                    <th></th>
                                    <th>Descrição</th>
                                    <th>Criador</th>
                                    <th>Data Criacao</th>
                                    <th>Ultima Modificacao</th>
                                    <th>Data Modificacao</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($solicitacoes as $solicitacao)
                                    <tr>
                                        @if($solicitacao->produtos->first() !== null || $solicitacao->servicos->first() !== null)
                                            <td>Tem</td>
                                        @else
                                            <td>N</td>
                                        @endif
                                        <td>{{$solicitacao->descricao}}</td>
                                        <td>{{$solicitacao->id_criador}}</td>
                                        <td>{{$solicitacao->data_criacao}}</td>
                                        <td>{{$solicitacao->id_modificador}}</td>
                                        <td>{{$solicitacao->data_modificacao}}</td>
                                        <td>{{$solicitacao->status}}</td>
                                    </tr>

                                    {{-- @if($solicitacao->produtos->first() !== null)
                                        <tr>
                                            <table id="example1" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <td>Produtos</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <table id="example2" class="display" style="width:100%">
                                                        <tr>
                                                            <thead>
                                                                <tr>
                                                                    <th>Nome</th>
                                                                    <th>Quantidade</th>
                                                                    <th>Valor</th>
                                                                    <th>Total Imposto</th>
                                                                    <th>Descricao</th>
                                                                    <th>link</th>
                                                                </tr>
                                                            </thead>
                                                            @foreach($solicitacao->produtos as $produto)
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{$produto->nome}}</td>
                                                                    <td>{{$produto->quantidade}}</td>
                                                                    <td>{{$produto->valor}}</td>
                                                                    <td>{{$produto->valor_imposto}}</td>
                                                                    <td>{{$produto->descricao}}</td>
                                                                    <td>{{$produto->link_oferta}}</td>
                                                                </tr>
                                                            </tbody>
                                                            @endforeach
                                                        </tr> 
                                                    </table>      
                                                </tbody>    
                                            </table>    
                                        </tr>
                                    @endif
                                    @if($solicitacao->servicos->first() !== null)
                                        <tr>
                                            <table id="example3" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <td></td>
                                                            <td>Servicos</td>
                                                        </tr>
                                                    </thead>
                    
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Quantidade</th>
                                                            <th>Valor</th>
                                                            <th>Total Imposto</th>
                                                            <th>Descricao</th>
                                                            <th>link</th>
                                                        </tr>
                                                    </thead>
                                                @foreach($solicitacao->servicos as $servico)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{$servico->nome}}</td>
                                                        <td>{{$servico->quantidade}}</td>
                                                        <td>{{$servico->valor}}</td>
                                                        <td>{{$servico->valor_imposto}}</td>
                                                        <td>{{$servico->descricao}}</td>
                                                        <td>{{$servico->link_oferta}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>    
                                        </tr>
                                    @endif --}}
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Descrição</th>
                                    <th>Criador</th>
                                    <th>Data Criacao</th>
                                    <th>Ultima Modificacao</th>
                                    <th>Data Modificacao</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>    
        </div>    
@endsection

