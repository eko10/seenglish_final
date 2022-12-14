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
    <div id="formContent2" style="padding-top: 20px;">
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

      <div class="register-box-body" style="padding: 20px 0 30px 0;">
        <!-- <p class="login-box-msg">Silahkan daftar dahulu!</p> -->
        <form role="form" method="POST" action="{{ route('register.proses') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group has-feedback {{ $errors->has('nama') ? ' has-error' : '' }}">
            <input id="nama" type="text" class="form-control" name="nama" value="{{ old('nama') }}" autofocus placeholder="Nama Lengkap">
            @if ($errors->has('nama'))
            <span class="help-block">
              <strong>{{ $errors->first('nama') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus placeholder="Username">
            @if ($errors->has('username'))
            <span class="help-block">
              <strong>{{ $errors->first('username') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus placeholder="Email">
            @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
            @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('no_hp') ? ' has-error' : '' }}">
            <input id="no_hp" type="number" class="form-control" name="no_hp" value="{{ old('no_hp') }}" autofocus placeholder="Nomor HP(Whatsapp)">
            @if ($errors->has('no_hp'))
            <span class="help-block">
              <strong>{{ $errors->first('no_hp') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('pendidikan') ? ' has-error' : '' }}">
            <input id="pendidikan" type="text" class="form-control" name="pendidikan" value="{{ old('pendidikan') }}" autofocus placeholder="Pendidikan">
            @if ($errors->has('pendidikan'))
            <span class="help-block">
              <strong>{{ $errors->first('pendidikan') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('jk') ? ' has-error' : '' }}">
            <select name="jk" id="jk" class="form-control select2" style="width: 85%; margin: auto;">
              <option value="">Pilih Jenis Kelamin</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="form-group has-feedback {{ $errors->has('alamat') ? ' has-error' : '' }}">
            <input id="alamat" type="text" class="form-control" name="alamat" placeholder="Alamat">
            <!-- <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat"></textarea> -->
            @if ($errors->has('alamat'))
            <span class="help-block">
              <strong>{{ $errors->first('alamat') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group has-feedback {{ $errors->has('gambar') ? ' has-error' : '' }}">
            <div class="col-sm-3">
              <label for="gambar">Foto profil</label>
            </div>
            <div class="col-sm-9">
              <input id="gambar" type="file" class="form-control" name="gambar" placeholder="gambar" style="width: 85%; margin: auto;">
              @if ($errors->has('gambar'))
              <span class="help-block">
                <strong>{{ $errors->first('gambar') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-8"></div>
            <input type="submit" class="fadeIn fourth" value="Daftar">
          </div>
        </form>
        <a href="{{ route('login') }}" class="text-center">Sudah punya akun? Login sekarang!</a>
      </div>
    </div>
  </div>

  <!-- jQuery 2.2.3 -->
  <script src="{{ url('/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="{{ url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ url('/assets/plugins/iCheck/icheck.min.js') }}"></script>

</body>

</html>