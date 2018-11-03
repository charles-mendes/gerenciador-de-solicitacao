    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alterar Situação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form id="form-mudar-situacao" action="{{route('salvar_situacao')}}" method="POST">
            @csrf
            <input type="hidden" name="id_usuario" value="{{$usuario->id}}">
            {{-- <div class="form-group mb-0"> --}}
                <h4>Você deseja {{$usuario->situacao == 'A' ? 'Inativar' : 'Ativar'}} o usuario {{$usuario->nome}} ?</h4>
            {{-- </div> --}}
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button id="btn-cadastro-produto" onclick="$('#form-mudar-situacao').submit();" type="submit" class="btn {{($usuario->situacao == 'A') ? 'btn-danger' : 'btn-primary'}}">{{($usuario->situacao == 'A') ?'Inativar': 'Ativar'}}</button>
    </div>
{{-- </div> --}}