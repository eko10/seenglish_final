<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SE English | Daftar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/assets/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="{{ url('/') }}"><b>SE</b>English</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Silahkan daftar dahulu!</p>
      <form role="form" method="POST" action="{{ route('register.proses') }}">
        {{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('nama') ? ' has-error' : '' }}">
          <input id="nama" type="text" class="form-control" name="nama" value="{{ old('nama') }}" required autofocus placeholder="Nama Lengkap">
          @if ($errors->has('nama'))
          <span class="help-block">
            <strong>{{ $errors->first('nama') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
          <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">
          @if ($errors->has('username'))
          <span class="help-block">
            <strong>{{ $errors->first('username') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
          @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
          <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('no_hp') ? ' has-error' : '' }}">
          <input id="no_hp" type="number" class="form-control" name="no_hp" value="{{ old('no_hp') }}" required autofocus placeholder="No. HP">
          @if ($errors->has('no_hp'))
          <span class="help-block">
            <strong>{{ $errors->first('no_hp') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('pendidikan') ? ' has-error' : '' }}">
          <input id="pendidikan" type="text" class="form-control" name="pendidikan" value="{{ old('pendidikan') }}" required autofocus placeholder="Pendidikan">
          @if ($errors->has('pendidikan'))
          <span class="help-block">
            <strong>{{ $errors->first('pendidikan') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('jk') ? ' has-error' : '' }}">
          <select name="jk" id="jk" class="form-control select2">
            <option value="">Pilih Jenis Kelamin</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>
        <div class="form-group has-feedback {{ $errors->has('alamat') ? ' has-error' : '' }}">
          {{-- <input id="alamat" type="text" class="form-control" name="alamat" required placeholder="Alamat"> --}}
          <textarea name="alamat" id="alamat" class="form-control" required placeholder="Alamat"></textarea>
          @if ($errors->has('alamat'))
          <span class="help-block">
            <strong>{{ $errors->first('alamat') }}</strong>
          </span>
          @endif
        </div>
        <div class="row">
          <div class="col-xs-8"></div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Daftar</button>
          </div>
        </div>
      </form>
      <a href="{{ route('login') }}" class="text-center">Sudah punya akun? Login sekarang!</a>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

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