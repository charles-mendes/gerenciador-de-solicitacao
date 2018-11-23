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
@php
   //  dd($solicitacoes->produtos);
@endphp

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
    <link href="{{ asset('plugins/TableExport/dist/css/tableexport.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/relatorio/listar.js?t='.time()) }}"></script>
    <script src="{{ asset('plugins/TableExport/dist/js/tableexport.js?t='.time()) }}"></script>
    <script src="{{ asset('plugins/FileSaver/dist/FileSaver.js?t='.time()) }}"></script>
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
                        <button type="button" class="btn btn-primary float-right" onclick="novaSolicitacao();">Nova Solicitacao</button>
                    </h4>
                    <h6 class="card-subtitle">Lista os solicitações cadastrados no sistema.</h6>
                    <div class="table-responsive">
                        {{-- <table id="example" class="display" style="width:100%">
                                <thead>
                                        <tr>    
                                            <th>Solicitacao</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                </thead>
                                <tbody>
                                    <tr>    
                                        <td>Solicitacao</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                        </table> --}}

                        
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                 </tr>
                                </thead>
                                 @foreach($solicitacoes as $solicitacao)
                                 <tr>
                                    <td>Solicitacao {{$solicitacao->id}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                 </tr>
                                <tr>
                                    <th><strong>Descrição</strong></th>
                                    <th><strong>Criador</strong></th>
                                    <th><strong>Data Criacao</strong></th>
                                    <th><strong>Ultima Modificacao</strong></th>
                                    <th><strong>Data Modificacao</strong></th>
                                    <th><strong>Status</strong></th>
                                </tr>

                                 <tr>
                                    <td>{{$solicitacao->descricao}}</td>
                                    <td>{{App\Usuario::find($solicitacao->id_criador)->nome}}</td>
                                    <td>{{ date('d/m/Y H:i:s' , strtotime($solicitacao->data_criacao))}}</td>
                                    <td>{{App\Usuario::find($solicitacao->id_modificador)->nome}}</td>
                                    <td>{{ date('d/m/Y H:i:s' , strtotime($solicitacao->data_modificacao))}}</td>
                                    <td><span class="label label-success">{{App\Status::find($solicitacao->id_status)->tipo_status}}</span></td>
                                 </tr>
                                    @if(isset($solicitacao->produtos) && $solicitacao->produtos->first() !== null )
                                       <tr>
                                          <td>Produtos</td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <tr>
                                          <th></th>
                                          <th></th>
                                          <th><strong>Nome</strong></th>
                                          <th><strong>Quantidade</strong></th>
                                          <th><strong>Valor</strong></th>
                                          <th><strong>descricao</strong></th>
                                       </tr>   
                                       @foreach ($solicitacao->produtos as $item)
                                          <tr>
                                             <td></td>
                                             <td></td>
                                             <td>{{$item->nome}}</td>
                                             <td>{{$item->quantidade}}</td>
                                             <td>{{$item->valor}}</td>
                                             <td>{{$item->descricao}}</td>
                                          </tr>  
                                       @endforeach
                                    @endif
                                    
                                    @if(isset($solicitacao->servicos) && $solicitacao->servicos->first() !== null)
                                       <tr>
                                          <td>Servico</td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <tr>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th><strong>Nome</strong></th>
                                          <th><strong>Valor</strong></th>
                                          <th><strong>descricao</strong></th>
                                       </tr>   
                                       @foreach ($solicitacao->servicos as $item)
                                          <tr>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td>{{$item->nome}}</td>
                                             <td>{{$item->valor}}</td>
                                             <td>{{$item->descricao}}</td>
                                          </tr>  
                                       @endforeach
                                    @endif
                                @endforeach
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

