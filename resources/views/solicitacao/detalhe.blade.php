{{-- <div class="modal-content"> --}}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalhe da Solicitação</h5>
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
                <p>{{ date('d/m/Y H:i:s' , strtotime($solicitacao->data_criacao))}}</p>
            </div>

            <div class="form-group mb-3">
                <label class="col-form-label">Modificou</label>
                <p>{{App\Usuario::find($solicitacao->id_modificador)->nome}}</p>
            </div>

            <div class="form-group mb-3">
                <label class="col-form-label">Ultima Modificacao</label>
                <p>{{date('d/m/Y H:i:s' , strtotime($solicitacao->data_modificacao))}}</p>
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
                <p>Não há produtos.</p>
            @else
                <div class="table-responsive">
                    <table id="table-produto-detalhe" class="display" style="width:100%">
                        @component('component.produtos', ['item' => $solicitacao])@endcomponent
                    </table>
                </div>                

            @endif

            <h3>Serviços</h3>
            @if($solicitacao->servicos->first() == [])
                <p>Não há serviços.</p>
            @else
            <div class="table-responsive">
                <table id="table-servico-detalhe" class="display" style="width:100%">
                    @component('component.servicos', ['item' => $solicitacao])@endcomponent
                </table>
            </div>                
            @endif
        <div class="row">
            <div class="col-12 text-center pt-3">
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-success" data-id="{{$id}}" onclick="editarSolicitacao(this);">Editar solicitação</button>
                    </div>
                    <div class="col-6"> 
                        <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="avaliaSolicitacao(this);">Avaliar solicitação</button>
                    </div>
                </div>
            </div>
        </div>
            
          
        </form>
    </div>
{{-- </div> --}}