
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Excluir Produto</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p class="text-center">Tem certeza que deseja excluir o produto <strong>{{ $produto->nome }}</strong> ?</p>
    <form method="POST" id="form-excluir-produto" action="{{route('excluir_produto_fornecedor')}}">
        @csrf
        <input type="hidden" name="id_produto" value="{{$produto->id}}"">
    </form>
</div>    
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
    <button type="button" class="btn btn-danger" onclick="$('#form-excluir-produto').submit();">Sim</button>
</div>

