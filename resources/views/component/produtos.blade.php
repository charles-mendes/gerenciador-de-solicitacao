 <thead>
    <tr>
        @if(Auth::user()->tipo_conta == 'S')    
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Descricao</th>
            @if(isset($acao) && $acao == true)
                <th>Ações</th>
            @endif
        @else
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th>Descricao</th>
            @if(isset($acao) && $acao == true)
                <th>Ações</th>
            @endif
        @endif
    </tr>
</thead>

<tbody>
    @if ( isset($solicitacao->produtos) )
        @foreach($solicitacao->produtos as $key => $produto)
            <tr>
                @if(Auth::user()->tipo_conta == 'S')    
                    <td>{{$produto->nome}}</td>
                    <td>{{$produto->quantidade}}</td>
                    <td>{{$produto->descricao}}</td>
                @else   
                    <td>{{$produto->nome}}</td>
                    <td>{{$produto->quantidade}}</td>
                    <td>{{$produto->valor}}</td>
                    <td>{{$produto->descricao}}</td>
                @endif
                @if(isset($acao) && $acao == true)
                    <td>
                        <button id="btn-edit" type="button" class="btn btn-primary" data-id="{{$key}}" onclick="editarProduto(this)">
                            <i class="ti-pencil"></i>
                        </button>
                        <button id="btn-excluir" type="button" class="btn btn-danger" data-id="{{$key}}" onclick="excluirProduto(this)">
                            <i class="mdi mdi-close-box-outline"></i>
                        </button>
                    </td>   
                @endif                        
            </tr>
        @endforeach
    @endif 
</tbody>