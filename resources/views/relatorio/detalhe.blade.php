{{-- <div class="modal-content"> --}}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Download</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>            
          
            
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
                        <button type="button" class="btn btn-success" data-id="{{$id}}" onclick="editarSolicitacao(this);">Excel</button>
                    </div>
                    <div class="col-6"> 
                        <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="avaliaSolicitacao(this);">PDF</button>
                    </div>
                </div>
            </div>
        </div>
            
          
        </form>
    </div>
{{-- </div> --}}