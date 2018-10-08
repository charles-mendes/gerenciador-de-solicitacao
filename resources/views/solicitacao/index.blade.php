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


@endsection