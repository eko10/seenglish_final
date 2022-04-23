@extends('layouts.app')
@section('title', 'Daftar Ujian - '.Auth::user()->nama)
@section('breadcrumb')
  <h1><i class="fa fa-check-square"></i> Daftar Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Hi, {{ Auth::user()->nama }}</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
  @if($payment == 'settlement' && Auth::user()->status_ujian == 'Belum Mulai' && Auth::user()->getKelas->tanggal > $tgl_sekarang)
  <div class="col-md-12">
  	<div class="alert alert-danger">
		<i class="fa fa-info-circle"></i> Anda telah terdaftar ujian pada sesi <b>{{ Auth::user()->getKelas->nama }} ({{ Auth::user()->getKelas->tanggal }}).<br>
	</div>
  </div>
  @elseif($payment == 'pending' && $tgl_sekarang < Auth::user()->getKelas->tanggal)
  <div class="col-md-12">
  	<div class="alert alert-warning">
		<i class="fa fa-info-circle"></i> Mohon segera lakukan pembayaran pendaftaran ujian anda pada sesi <b>{{ Auth::user()->getKelas->nama }} ({{ Auth::user()->getKelas->tanggal }}),</b> rincian pembayaran telah dikirim ke email anda.<br>
	</div>
  </div>
  <div class="col-md-12">
  	<div class="alert alert-danger">
		<i class="fa fa-clock-o"></i> Batas waktu pembayaran : <b><span id="demo"></span></b><br>
	</div>
  </div>
  <form action="{{ route('siswa.pembayaran.email') }}" id="submit-form" method="POST">
	{{ csrf_field() }}
	<input type="hidden" name="email" value="{{ Auth::user()->email }}">
	<input type="hidden" name="sesi" value="{{ Auth::user()->getKelas->nama}}">
	<input type="hidden" name="tanggal" value="{{ Auth::user()->getKelas->tanggal}}">
  </form>
  <form action="{{ route('siswa.pembayaran.reset') }}" id="submit-form-reset" method="POST">
	{{ csrf_field() }}
	<input type="hidden" name="email" value="{{ Auth::user()->email }}">
  </form>
  @else
  <div class="col-md-12">
	<div class="box box-primary">
	  <div class="box-header with-border">
		<h3 class="box-title">Daftar Ujian</h3>
	  </div>
	  <div class="box-body">
		@if(session('alert-success'))
		  <div class="alert alert-success">
			<i class="fa fa-check-square-o"></i> {{session('alert-success')}}
		  </div>
		@elseif(session('alert-failed'))
		  <div class="alert alert-danger">
			<i class="fa fa-times"></i> {{session('alert-failed')}}
		  </div>
		@endif
		<form action="{{ route('siswa.payment') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="box-body">
			  <input type="hidden" name="id" value="{{ Auth::user()->id }}">
			  <input type="hidden" name="nama" value="{{ Auth::user()->nama }}">
			  <input type="hidden" name="email" value="{{ $user->email }}">
			  <input type="hidden" name="username" value="{{ Auth::user()->username }}">
			  <input type="hidden" name="pendidikan" value="{{ Auth::user()->pendidikan }}">
			  <input type="hidden" name="jk" value="{{ Auth::user()->jk }}">
			  <input type="hidden" name="no_hp" value="{{ Auth::user()->no_hp }}">
			  <input type="hidden" name="alamat" value="{{ Auth::user()->alamat }}">
			  <input type="hidden" name="password" value="">
			  <div class="form-group">
				<label for="id_kelas" class="control-label">Sesi</label>
				<select name="kelas" id="id_kelas" class="form-control select2Class" style="width: 100%" required>
				  <option></option>
				  @forelse($kelas as $data_kelas)
					@php
						$peserta = \App\User::where('status', 'S')->where('status_validasi', 'Y')->where('id_kelas', $data_kelas->id)->count();
						$sisa_kuota = $data_kelas->kuota - $peserta;
					@endphp
						<option value="{{ $data_kelas->id }}">{{ $data_kelas->nama }} ({{ $data_kelas->tanggal }}) - Sisa Kuota <b>({{ $sisa_kuota }})</b></option>
				  @empty
				  @endforelse
				</select>
			  </div>
			</div>
			<div class="box-footer">
			  <div id="wrap-btn">
				<button type="submit" class="btn btn-success">Daftar</button>
			  </div>
			</div>
		</form>
	  </div>
	</div>
  </div>
  @endif
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/select2/select2.min.css')}}">
<style>
	.bg-aqua{
		background-color: #117e98 !important;
	}

	.select2-container--default .select2-selection--single {
		height: 33px;
	}
</style>
@endpush
@push('scripts')
<script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
<script src="{{URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
	$(document).ready(function (){
		$('.select2Class').select2({
			placeholder: "Pilih Sesi",
    		allowClear: true
		});
	});
</script>
<script>
// Set the date we're counting down to
var countDownDate = new Date("{{ $batas }}").getTime();
var proses1 = document.getElementById('submit-form');
var proses2 = document.getElementById('submit-form-reset');

// Update the count down every 1 second
var x = setInterval(function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  document.getElementById("demo").innerHTML = days + " Hari " + hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
  if (days == 0 && hours == 00 && minutes == 59 && seconds == 59) {
    clearInterval(x);
	proses1.submit();
  }else if (days == 0 && hours == 00 && minutes == 00 && seconds == 00) {
    clearInterval(x);
	proses2.submit();
  }
}, 1000);
</script>
@endpush