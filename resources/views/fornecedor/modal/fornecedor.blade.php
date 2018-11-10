<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{!isset($fornecedor) ? 'Novo Fornecedor' : 'Editar Fornecedor' }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p>itens obrigatorios (*)</p>
    <form id="cria-edita-fornecedor" action="{{route( !isset($fornecedor) ? 'cadastrar_fornecedor' : 'salvar_fornecedor')}}" method="POST">
        @csrf
        <div class="form-group mb-0">
            <label for="name" class="col-form-label">Nome do Fornecedor *</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{isset($fornecedor) ? $fornecedor->nome : ''}}">
        </div>
        <div class="form-group mb-2 mt-3">
            <input type="checkbox" id="check_identificacao" name="check_identificacao" />
            <label for="check_identificacao">Possui CPF/CNPJ ?</label>
        </div>
        <div  id="field_identificacao" class="form-group mb-0" style="display:none">
            <label for="identificacao" class="col-form-label">CPF/CNPJ *</label>
            <input type="number" class="form-control" id="identificacao" name="identificacao" value="{{isset($fornecedor) ? $fornecedor->cnpj : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="telefone" class="col-form-label">Telefone *</label>
            <input type="number" class="form-control" id="telefone" name="telefone" value="{{isset($fornecedor) ? $fornecedor->telefone : ''}}">
        </div>
        <div class="form-group mb-0">
            <label for="email" class="col-form-label">Email *</label>
            <input type="mail" class="form-control" id="email" name="email" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">
        </div>
        <div class="form-group mb-0">
                <label for="descricao" class="col-form-label">Descricao do fornecedor :</label>
                <input type="mail" class="form-control" id="descricao" name="descricao" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">
            </div>
        <div class="form-group mb-2 mt-3">
            <input type="checkbox" id="check_endereco" name="check_endereco" />
            <label for="check_endereco">Possui endereço ?</label>
        </div>
        <div id="fields_endereco" class="form-group mb-0" style="display:none" >
            <label for="endereco" class="col-form-label">Endereco</label>
            <input type="text" class="form-control verify-required" id="endereco" name="endereco" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

            <label for="bairro" class="col-form-label">Bairro</label>
            <input type="text" class="form-control verify-required" id="bairro" name="bairro" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

            <label for="cidade" class="col-form-label">Cidade</label>
            <input type="text" class="form-control verify-required" id="cidade" name="cidade" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

            <label for="estado" class="col-form-label">Estado</label>
            <input type="text" class="form-control verify-required" id="estado" name="estado" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

            <label for="numero" class="col-form-label">numero</label>
            <input type="text" class="form-control verify-required" id="numero" name="numero" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

            <label for="cep" class="col-form-label">CEP</label>
            <input type="text" class="form-control verify-required" id="cep" name="cep" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

            <label for="pais" class="col-form-label">Pais</label>
            <input type="text" class="form-control verify-required" id="pais" name="pais" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">
        </div>

        <div class="form-group mb-2 mt-3">
            <input type="checkbox" id="check_contrato" name="check_contrato" />
            <label for="check_contrato">Possui contrato ?</label>
        </div>

        <div  id="fields_contrato" class="form-group mb-0" style="display:none">
                <label for="numero_contrato" class="col-form-label">Numero do Contrato</label>
                <input type="text" class="form-control verify-required-contrato" id="numero_contrato" name="numero_contrato" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

                <label for="descricao_contrato" class="col-form-label">Descricao Contrato</label>
                <input type="text" class="form-control verify-required-contrato" id="descricao_contrato" name="descricao_contrato" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">

                <label for="data_vencimento" class="col-form-label">Data Vencimento</label>
                <input type="date" class="form-control verify-required-contrato" id="data_vencimento" name="data_vencimento" value="{{isset($fornecedor) ? $fornecedor->email : ''}}">


                {{-- <div class="form-group mb-2 mt-3">
                    <input type="checkbox" id="check_anexo" name="check_anexo" />
                    <label for="check_anexo">Possui anexo ?</label>
                </div> --}}

        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    <button id="btn-cadastro-fornecedor" onclick="$('#cria-edita-fornecedor').submit();" type="submit" class="btn btn-primary">{{isset($fornecedor) ? 'Salvar' : 'Cadastrar'}}</button>
</div>
</div>