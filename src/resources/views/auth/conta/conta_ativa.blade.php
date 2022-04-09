<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body>
        <div id="fluid-container">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                          
                            <div class="card cadastro-empresa conta-ativa reset-senha">
                                <div class="card-body">
                                   
                                    <form method="POST" action="{{ route('conta_send_link') }}">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                            <h3>Conta Inativa</h3><br/>
                                            @if (isset($email_error))
                                             <h3>{{$email_error}}.</h3>

                                            @else
                                                 <h4>Por favor verifique seu email ou click em reenviar o link de ativação.</h4>
                                            @endif
                                             @if (Session::has('conta_invalida'))
                                                    <input type="hidden"  name="email" value="{{Session::get('conta_invalida') }}">                     
                                            @endif
                                            
                                            </div>
                                        </div>
                                        @if (Session::has('conta_invalida'))
                                            <div class="form-group div-btn-redefinir row mb-0">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-submit-redefinir">
                                                        {{ __('Reenviar link de ativação') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </form>
                                    @if (Session::has('conta_invalida'))
                                        <div id="formFooterCadastro">
                                            <p><a class="underlineHover" href="{{ route('login') }}">Encontrou o email de ativação? Realize Login</a></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>