<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SE English | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="{{ url('/assets/dist/css/AdminLTE.min.css') }}"> -->
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/iCheck/square/blue.css') }}">

  <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
  <link href="{{ asset('/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page">

  <div class="wrapper fadeInDown">
    <div id="formContent" style="padding-top: 20px;">
      <!-- Tabs Titles -->

      <!-- Icon -->
      <div class="fadeIn first" id="logo">
        <!-- <i class="fa-light fa-user"></i> -->
        <a href="{{ url('/') }}">
          <h3><b>SE</b>English</h3>
        </a>
      </div>

      <div class="login-box-body">
        {{-- @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>    
          <strong>{{ $message }}</strong>
      </div>
      @endif --}}
      @if (Session::has('success'))
      <div class="alert alert-success">
        <i class="fa fa-check-circle"></i> {{ Session::get('success') }}
      </div>
      @endif

      <!-- Login Form -->
      <form role="form" method="POST" action="{{ route('login') }}" style="padding-bottom: -10px;">
        {{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
          <input type="email" id="email" class="fadeIn second form-control" name="email" value="{{ old('email') }}" placeholder="email" required autofocus>
          <span class="form-control-feedback"></span>
          @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
          <input type="password" id="password" class="fadeIn third form-control" name="password" placeholder="password" required>
          <span class="form-control-feedback"></span>
          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
        <input type="submit" class="fadeIn fourth" value="Log In">
      </form>

      <!-- Remember Akun -->
      <div id="formFooter">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
          </label>
        </div>
        <!-- <a class="underlineHover" href="#">Forgot Password?</a> -->
        <a href="{{ route('register') }}" class="text-center">Belum punya akun? Daftar sekarang!</a>
      </div>

    </div>
  </div>

  <!-- jQuery 2.2.3 -->
  <script src="{{ url('/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="{{ url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ url('/assets/plugins/iCheck/icheck.min.js') }}"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '10%' // optional
      });
    });
  </script>
</body>

</html>