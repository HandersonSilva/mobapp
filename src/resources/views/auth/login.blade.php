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

    <div id="container">
      @if (Route::has('register'))
          <div class="w-100 text-center text-md-right register-text pr-md-5 pt-md-2 pr-0"><a href="{{ route('register') }}" class="">Registrar-se</a></div>
      @endif
     
      <div class="wrapper fadeInDown">
          <div id="formContent">
            <!-- Tabs Titles -->
        
            <!-- Icon -->
            <div class="fadeIn first my-3">
              <i class="fas fa-user-circle"></i>
            </div>
        
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <input type="text" id="email" class="fadeIn second  {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus placeholder="login">
              @if ($errors->has('email'))
                  <div class=" alert-danger" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </div>
              @endif
             
              <input type="password" id="password" class="fadeIn third {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="password">
  
              @if ($errors->has('password'))
                <div class="alert-danger" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
  
              @if (Session::has('invalid'))
                <div class="alert-danger" role="alert">
                    <strong>{{Session::get('invalid') }}</strong>
                </div>
              @endif
  
              <!-- função lembrar senha
               <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> -->
  
              <input type="submit" class="fadeIn fourth" value="Log In">
          </form>
        
            <!-- Remind Passowrd -->
            <div id="formFooter">
              <a class="underlineHover" href="{{ route('reset_senha_view') }}">Esqueceu sua senha?</a>
            </div>
            
          </div>
        </div>
    </div>
      

      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
