@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'localizacoes' =>
            [
                ['Home', route('dashboard') ]
            ]
        ]
    )
    @endcomponent
@endsection


@section('content')
<form action="{{route('nova_solicitacao')}}" method="POST">
    <button type="submit" class="btn btn-primary">Cadastrar nova solicitação</button>
</form>


@endsection