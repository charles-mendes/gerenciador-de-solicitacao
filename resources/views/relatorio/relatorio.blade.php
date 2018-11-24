@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'title' => 'Relatório',
            'localizacoes' => [ ['Home', route('listar_solicitacao') ],['Relatório de solicitações', ''] ]
        ]
    )
    @endcomponent
@endsection


@push('styles')
    <link href="{{ asset('css/switch.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/relatorio/listar.js?t='.time()) }}"></script>
@endpush

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
                    <h4 class="card-title">Relatório das Solicitações 
                        {{-- <button type="button" class="btn btn-primary float-right" onclick="novaSolicitacao();">Nova Solicitacao</button> --}}
                    </h4>
                    <h6 class="card-subtitle">Lista os solicitações cadastrados no sistema.</h6>
                    <div class="table-responsive">
                        <table  id="example" width="100%">
                            <thead>
                                <th>Solicitacao</th>
                                <th>Item</th>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                                <th>Descricao</th>
                                <th>Criador</th>
                                <th>Data Criação</th>
                                <th>Modificador</th>
                                <th>Data Modificação</th>
                            </thead>
                            <tbody>
                                
                                @foreach ($solicitacoes as $solicitacao)
                                    @foreach ($solicitacao->produtos as $item)
                                        <tr>    
                                            <td class="text-center">Solicitacao {{$solicitacao->id}}</td>   
                                            <td class="text-center">Produto</td>   
                                            <td class="text-center">{{$item->nome}}</td>   
                                            <td class="text-right">{{$item->quantidade}}</td>   
                                            <td class="text-right">{{$item->valor}}</td>   
                                            <td class="text-center">{{$item->descricao}}</td>   
                                            <td class="text-center">{{App\Usuario::find($item->id_criador)->nome}}</td>
                                            <td class="text-right">{{ date('d/m/Y' , strtotime($item->data_criacao))}}</td>
                                            <td class="text-center">{{App\Usuario::find($item->id_modificador)->nome}}</td>
                                            <td class="text-right">{{ date('d/m/Y' , strtotime($item->data_modificacao))}}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($solicitacao->servicos as $item)
                                        <tr>    
                                            <td class="text-center">Solicitacao {{$solicitacao->id}}</td>   
                                            <td class="text-center">Servico</td>   
                                            <td class="text-right">{{$item->nome}}</td>   
                                            <td></td>   
                                            <td class="text-right">{{$item->valor}}</td>   
                                            <td class="text-center">{{$item->descricao}}</td>   
                                            <td class="text-center">{{App\Usuario::find($item->id_criador)->nome}}</td>
                                            <td class="text-right">{{ date('d/m/Y' , strtotime($item->data_criacao))}}</td>
                                            <td class="text-center">{{App\Usuario::find($item->id_modificador)->nome}}</td>
                                            <td class="text-right">{{ date('d/m/Y' , strtotime($item->data_modificacao))}}</td>
                                        </tr>
                                    @endforeach
                                    
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
        
@endsection

