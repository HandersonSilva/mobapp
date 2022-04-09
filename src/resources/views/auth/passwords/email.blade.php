<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://kit.fontawesome.com/2d1991b65b.js"></script>

</head>
<body class="body_reset">

<div id="container_reset" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card cadastro-empresa reset-senha">
                <div><h3>Redefinição de Senha</h3></div>

                <div class="card-body">
                    @if (session('email_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('email_status') }}
                        </div>
                    @endif
                    @if(session('email_status_error'))
                          <div class="alert  alert-danger" role="alert">
                            {{session('email_status_error')}}
                        </div>
                    @endif
                   @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                 
                    @if (session('email_user'))
                        <form method="POST" action="{{ route('save_senha') }}">
                    @else
                        <form method="POST" action="{{ route('reset_senha') }}">
                    @endif
                        @csrf
                      
                    @if (session('email_user'))
                      <div class="form-group row">
                            <div class="col-md-12">
                                <input  type="text" placeholder="Codigo" class="in-email" name="code" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="password" placeholder="Nova senha" class="in-email" name="password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirme a Senha"  >
                                 <input type="hidden" class="form-control" name="email_user" value="{{session('email_user')}}" >
                            </div>
                        </div>
                    @else
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="Email" class=" in-email" name="email"  value="{{ old('email') }}" required>
                            </div>
                        </div>
                    @endif
                        <div class="form-group div-btn-redefinir row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-submit-redefinir">
                                    {{ __('Redefinir') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="formFooterCadastro">
                        <p><a class="underlineHover" href="{{ route('login') }}">Lembrou a senha? Realize Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
