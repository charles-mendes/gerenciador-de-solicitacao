@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/login.js') }}" defer></script>
@endpush

@section('content')
<div class="container">

    <section id="wrapper">
    <!-- <div class="login-register" style="background-image:url(http://cetelemnegocie.com.br/images/background/credit-card-payment.jpg);"> -->
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material m-4" method="POST" id="loginform" action="{{ route('login') }}">
                    @csrf
                    <h3 class="box-title m-b-20">Login</h3>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" id="email" name="email" required="" autofocus="" value="" placeholder="E-Mail">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" id="password" name="password" type="password" required="" placeholder="Password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    
                     <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-5">
                                <!-- <button type="submit" class="btn btn-primary">
                                    {{-- __('Login') --}}
                                </button> -->

                                <a id="recuperar-password" class="btn btn-link" href="javascript:void(0);">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="card-repassword" class="login-box card" style="display: none;">
            <div class="card-body">
                
                <form class="form-horizontal form-material m-4" method="POST" action="{{ route('password.request') }}" aria-label="Reset Password">
                    @csrf
                    <h2 id="close-repassword" class="text-center col-xs-12 offset-11">&#215;</h2>
                    <h3 class="box-title m-b-20">Recuperação de senha</h3>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" id="email" name="email" required="" autofocus="" value="" placeholder="E-Mail">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>  

                    <div class="form-group">  
                        <div class="col-xs-12 offset-9">
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
            
        
    </section>



</div>


@endsection
