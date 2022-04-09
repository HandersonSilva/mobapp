<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    
    <title>Cadastro</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://kit.fontawesome.com/2d1991b65b.js"></script>

</head>
<body>

        <div id="fluid-container">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 fadeIn">
                            <div class="title">
                                <h2>Bem Vindo ao Pida Delivery</h2>
                            </div>
                            <div class="card cadastro-empresa">
                                <div class="card-body">
                                    @if (session('hasConta'))
                                    <span class="alert-cadastro" role="alert">
                                        <strong> {{ session('hasConta') }}</strong>
                                    </span> @endif
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                
                                        <div class="form-group row">
                                            <!--  <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>-->
                
                                            <div class="col-12 text-center">
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('nome') }}" placeholder="Nome" autofocus> 
                                                @if ($errors->has('name'))
                                                <span class="alert-cadastro " role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                                            <!--  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->
                
                                            <div class="col-12 text-center">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email"  > 
                                                @if ($errors->has('email'))
                                                <span class="alert-cadastro " role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                
                                            <div class="col-12">
                                                <select id="tipo-regime">
                                                    <option value="0">Pessoa Física</option>
                                                    <option value="1">Pessoa Jurídica</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                
                                            <div class="col-12 text-center">
                                                <input id="cpf" type="text" class="form-control"  minlength="11" maxlength="18" name="cpf" value="{{ old('cpf') }}" placeholder="CNPJ/CPF">
                                                @if ($errors->has('cpf'))
                                                <span class="alert-cadastro " role="alert">
                                                    <strong>{{ $errors->first('cpf') }}</strong>
                                                </span> 
                                                @endif
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                
                                            <div class="col-12 text-center">
                                                <input id="telefone" type="text" class="form-control" name="telefone" value="{{ old('telefone') }}" placeholder="Telefone"  >
                                                @if ($errors->has('telefone'))
                                                <span class="alert-cadastro " role="alert">
                                                    <strong>{{ $errors->first('telefone') }}</strong>
                                                </span> @endif
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                                            <!--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>-->
                
                                            <div class="col-12 text-center">
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Senha" name="password"  > @if ($errors->has('senha'))
                                                <span class="alert-cadastro " role="alert">
                                                        <strong>{{ $errors->first('senha') }}</strong>
                                                </span> 
                                            @endif
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                                            <!--<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>-->
                
                                            <div class="col-12">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirme a Senha"  >
                                            </div>
                                        </div>
                
                                        <div class="form-group row mb-0">
                                            <div class="col-12 offset-md-4">
                
                                                <!--</button>-->
                                            </div>
                                        </div>
                                        <input type="submit" class="fadeIn fourth" value="Registrar">
                                    </form>
                                    <!-- Remind Passowrd -->
                                    <div id="formFooterCadastro">
                                        <p><a class="underlineHover" href="{{ route('login') }}">Já possui conta? Realize Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script src="{{ asset('js/vanillaMasker/vanilla-masker.js') }}"></script>
    <script src="{{ asset('js/cadastro_empresa.js') }}"></script>

</body>
</html>