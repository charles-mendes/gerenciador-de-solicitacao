<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="TCC">
    <meta name="author" content="Charles e Rafael">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <title>TCC</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{ asset('plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="{{ asset('plugins/c3-master/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <!-- Datatables-->
    {{-- <link href="{{ asset('plugins/datatables/media/css/dataTables.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('plugins/datatables/media/css/jquery.dataTables_themeroller.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="https://fonts.gstatic.com"> -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @stack('styles')
    
</head>
@php
    // dd(session()->all());
@endphp
<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="/dashboard">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            
                            <!-- Light Logo icon -->
                            <img src="{{ asset('images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         
                         <!-- Light Logo text -->    
                         <img src="{{ asset('images/logo-light-text.png ') }}" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -- >
                        <!-- ============================================================== -->
                        <button type="button" class="btn btn-default" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form> 
                        <li></li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        {{-- @php dd(session('menu'))@endphp --}}
                        @if(session()->has('menu'))
                            @foreach (session('menu') as $key => $item)
                                <li> <a class="waves-effect waves-dark" href="{{$item['link']}}" aria-expanded="false"><i class="{{$item['icone']}}"></i><span class="hide-menu">{{$key}}</span></a>        
                            @endforeach
                        @endif
                        {{-- <li> <a class="waves-effect waves-dark" href="/dashboard" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="/solicitacoes" aria-expanded="false"><i class="mdi mdi-account-check"></i><span class="hide-menu">Solicitação</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="/usuarios" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Usuarios</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="/fornecedores" aria-expanded="false"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Fornecedor</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="/relatorios" aria-expanded="false"><i class="mdi mdi-earth"></i><span class="hide-menu">Relatorios</span></a>
                        </li> --}}
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
           
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        @yield('breadcrumb')
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                @yield('content')
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>    
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> 2018 - TCC rafael e charles </footer>
            <!-- ================================================git ============== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('plugins/bootstrap/js/tether.min.js') }}"></script>
    
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    
    <!--Custom JavaScript -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- chartist chart -->
    <script src="{{ asset('plugins/chartist-js/dist/chartist.min.js') }}"></script>
    <!-- <script src="{{-- asset('plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') --}}"></script> -->
    <!--c3 JavaScript -->
    <script src="{{ asset('plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('plugins/c3-master/c3.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('js/dashboard1.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    

    @stack('scripts')
</body>
</html>
