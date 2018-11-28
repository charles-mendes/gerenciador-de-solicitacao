@php
    // dd($solicitacao->id,Auth::user()->id);
    // dd( );
@endphp
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
                <label class="col-form-label">Última Modificação</label>
                <p>{{date('d/m/Y H:i:s' , strtotime($solicitacao->data_modificacao))}}</p>
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
        
        @if(Auth::user()->tipo_conta == 'S' || Auth::user()->tipo_conta == 'AD' || Auth::user()->tipo_conta == 'C' &&  App\Status::find($solicitacao->id_status)->tipo_status == 'Esperando Aprovação da diretoria')
            <div class="row">
                <div class="col-12 text-center pt-5">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-success" data-id="{{$id}}" onclick="editarSolicitacao(this);">Editar solicitação</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            
            @if( Auth::user()->tipo_conta == 'A' && App\Status::find($solicitacao->id_status)->tipo_status == 'Aprovado pelo Aprovador'  &&  $aprovou == true)
                <div class="row">
                    <div class="col-12 text-center pt-5">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-success" data-id="{{$id}}" onclick="editarSolicitacao(this);">Editar solicitação</button>
                            </div>
                            <div class="col-6"> 
                                <button type="button" class="btn btn-primary" data-id="{{$id}}" onclick="avaliaSolicitacao(this);">Reprovar solicitação</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12 text-center pt-5">
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
            @endif    
            

        @endif
        {{-- verifica se foi ele quem aprovou se for da para reprovar --}}
        {{-- se for outro aprovador tem que aparecer que ja foi aprovada por outro  --}}
        
        
          
        </form>
    </div>
{{-- </div> --}}