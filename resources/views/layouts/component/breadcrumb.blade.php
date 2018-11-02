<h3 class="text-themecolor m-b-0 m-t-0">{{$title}}</h3>
<ol class="breadcrumb">
    @forelse($localizacoes as $local)
        <li class="breadcrumb-item {{ empty($local[1]) ? 'active' : '' }}">
           @if(!empty($local[1])) <a href="{{$local[1]}}"> @endif
                    {{$local[0]}}
                @if(!empty($local[1])) </a> @endif
        </li>
    @empty
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
    @endforelse
</ol>
