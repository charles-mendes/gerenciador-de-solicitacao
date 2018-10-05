@extends('layouts.principal')

@section('breadcrumb')
    @component(
        'layouts.component.breadcrumb',
        [
            'localizacoes' =>
            [
                ['Home', route('dashboard') ],
                ['nova-solicitacao', '']
            ]
        ]
    )
    @endcomponent
@endsection



@section('content')

        
@endsection