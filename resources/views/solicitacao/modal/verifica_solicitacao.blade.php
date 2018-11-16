<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Inativar Solicitacao</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p class="text-center">Tem certeza que deseja inativar a solicitacao  ?</p>
    <form method="POST" id="form-excluir-produto" action="{{route('excluir_solicitacao')}}">
        @csrf
        <input type="hidden" name="id_solicitacao" value="{{$solicitacao->id}}"">
    </form>
    <p class="text-center">Itens que ela possui :</p>
    <h3>Produtos</h3>
    @if($solicitacao->produtos->first() == [])
        <p>Não há produtos.</p>
    @else
    <div class="table-responsive">
        <table id="table-produto" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                    <th>Valor Imposto</th>
                    <th>Descricao</th>
                    <th>Link Oferta</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($solicitacao->produtos as $produto)
                    <tr>
                        <td>{{$produto->nome}}</td>
                        <td>{{$produto->quantidade}}</td>
                        <td>{{$produto->valor}}</td>
                        <td>{{$produto->valor_imposto}}</td>
                        <td>{{$produto->descricao}}</td>
                        <td>{{$produto->link_oferta}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>                
    @endif

    <h3>Serviços</h3>
    @if($solicitacao->servicos->first() == [])
        <p>Não há serviços.</p>
    @else
    <div class="table-responsive">
        <table id="table-servico" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Valor Imposto</th>
                    <th>Descricao</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($solicitacao->servicos as $servico)
                    <tr>
                        <td>{{$servico->nome}}</td>
                        <td>{{$servico->valor}}</td>
                        <td>{{$servico->valor_imposto}}</td>
                        <td>{{$servico->descricao}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>                
    @endif
</div>    
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
    <button type="button" class="btn btn-danger" onclick="$('#form-excluir-produto').submit();">Sim</button>
</div>

