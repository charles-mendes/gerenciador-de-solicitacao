<!DOCTYPE html>
<html lang="pt-br">
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .wrapper {
            text-align: center;
            margin-top: 40px;
        }

        .button {
            position: relative;
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration:none;   
        }
    </style>
</head>    
<body class="fix-header fix-sidebar card-no-border">

    <h3 style="text-align:center;">Solicitação esperando pela sua aprovação</h3>

    <div>
        <h3 style="text-align:center;">Foi criada uma conta para você avaliar a solicitação que esta pendente</h3>

        <table style="width: 50%;" align="center" >
            <tr>
                <td>Usuario :</td>
                <td>{{$usuario->nome}}</td>
            </tr>
            <tr>
                <td>Email: </td>
                <td>{{$usuario->email}}</td>
            </tr>
            <tr>
                <td>Senha :</td>
                <td>mudar12345</td>
            </tr>
        </table>
    </div>      

    <div>
        <h3 style="text-align:center;">Detalhe da Solicitação</h3>

        <table style="width: 50%;" align="center" >
            <tr>
                <td>Descrição :</td>
                <td>{{$solicitacao->descricao}}</td>
            </tr>
            <tr>
                <td>Criador :</td>
                <td>{{App\Usuario::find($solicitacao->id_criador)->nome}}</td>
            </tr>
            <tr>
                <td>Data Criação :</td>
                <td>{{ date( 'd/m/Y H:i:s' , strtotime($solicitacao->data_criacao))}}</td>
            </tr>
            <tr>
                <td>Status :</td>
                <td>
                    @if($solicitacao->status == 'A')
                        Ativo
                    @else
                        Inativo
                    @endif
                </td>
            </tr>
        </table>
    </div>        

    <h3 style="text-align:center;">Produtos</h3>
    @if($solicitacao->produtos->first() == [])
        <p>Não há produtos.</p>
    @else
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                    
                <tbody>
                    @if(isset($solicitacao->produtos) )
                        @foreach($solicitacao->produtos as $key => $produto)
                            <tr>
                                <td>{{$produto->nome}}</td>
                                <td>{{$produto->quantidade}}</td>
                                <td>{{$produto->descricao}}</td>                      
                            </tr>
                        @endforeach
                    @endif 
                </tbody>
            </table>
        </div>                
    @endif

    <h3 style="text-align:center;">Serviços</h3>
    @if($solicitacao->servicos->first() == [])
        <p>Não há serviços.</p>
    @else
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (isset($solicitacao->servicos))
                        @foreach($solicitacao->servicos as $key => $servico)
                            <tr>
                                <td>{{$servico->nome}}</td>
                                <td>{{$servico->descricao}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>                
    @endif
    

    <div class="wrapper">
        <a href="{{route('aprovar_solicitacao',['id'=>$solicitacao->id])}}" class="button">Avaliar solicitação</a>
    </div>

</body>

