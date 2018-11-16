{{-- <div class="modal-content"> --}}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalhe da Solicitacao</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>            
            <div class="form-group mb-3">
                <label for="name" class="col-form-label">Descrição</label>
                <p>{{$solicitacao->descricao}}</p>
            </div>
            <div class="form-group mb-3">
                <label class="col-form-label">Criador</label>
                <p>{{App\Usuario::find($solicitacao->id_criador)->nome}}</p>
            </div>

            <div class="form-group mb-3">
                <label class="col-form-label">Data Criação</label>
                <p>{{$solicitacao->data_criacao}}</p>
            </div>

            <div class="form-group mb-3">
                <label class="col-form-label">Modificou</label>
                <p>{{App\Usuario::find($solicitacao->id_modificador)->nome}}</p>
            </div>

            <div class="form-group mb-3">
                <label class="col-form-label">Ultima Modificacao</label>
                <p>{{$solicitacao->data_modificacao}}</p>
            </div>

            <div class="form-group mb-3">
                <label class="col-form-label">Status</label>
                @if($solicitacao->status == 'A')
                    <span class="label label-success">Ativo</span>
                @else
                    <span class="label label-success">Inativo</span>
                @endif
            </div>
            <h3>Produtos</h3>
            @if($solicitacao->produtos->first() == [])
                <p>Nãao há produtos.</p>
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
                                <th>Ações</th>
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
                                    <td>
                                        <button type="button" class="btn btn-primary" data-id="{{$produto->id}}" onclick="#" data-toggle="tooltip" data-placement="right" title=""
                                                data-original-title="Clique aqui para visualizar os detalhes deste usuário">
                                                    <i class="ti-pencil"></i>
                                        </button>
                                    </td>
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
                            <th>Ações</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($solicitacao->servicos as $servico)
                            <tr>
                                <td>{{$servico->nome}}</td>
                                <td>{{$servico->valor}}</td>
                                <td>{{$servico->valor_imposto}}</td>
                                <td>{{$servico->descricao}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-id="{{$servico->id}}" onclick="#" data-toggle="tooltip" data-placement="right" title=""
                                            data-original-title="Clique aqui para visualizar os detalhes deste usuário">
                                                <i class="ti-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>                

        @endif
        <div class="row">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="editarSolicitacao(this);">Editar solicitação</button>
            </div>
        </div>
            
          
        </form>
    </div>
{{-- </div> --}}