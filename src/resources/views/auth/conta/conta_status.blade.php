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
                                    <form method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-12">

                                            @if (isset($email_success))
                                                <h2 class="text-success">Email enviado com sucesso</h2><br/>
                                                <h4>{{$email_success}}.</h4>
                                            @else
                                                @if (isset($conta_error))
                                                    @if(isset($conta_titulo))
                                                        <h2 class="text-error">{{$conta_titulo}}</h2><br/>
                                                     @else
                                                    <h2 class="text-error">Falha ao ativar a conta</h2><br/>
                                                    @endif
                                                    <h4>{{$conta_error}}</h4>
                                                @endif
                                                  @if (isset($conta_success))
                                                        @if(isset($conta_titulo))
                                                            <h2 class="text-success">{{$conta_titulo}}</h2><br/>
                                                        @else
                                                            <h2 class="text-success">Operação realizada com sucesso!!!</h2><br/>
                                                        @endif
                                                        <h4>{{$conta_success}}.</h4>
                                                   @endif
                                                                                                  
                                            @endif
                                           
                                            </div>
                                        </div>
                                    </form>
                                    
                                        <div id="formFooterCadastro">
                                            <p><a class="underlineHover" href="{{ route('login') }}">Realizar Login</a></p>
                                        </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>