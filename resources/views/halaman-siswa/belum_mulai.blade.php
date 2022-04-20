@extends('layouts.app')
@section('title', 'Cek Ujian - '.Auth::user()->nama)
@section('breadcrumb')
  <h1>Cek Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/siswa/ujian') }}">Ujian</a></li>
    <li class="active">Cek Ujian</li>
  </ol>
@endsection
@section('content')
	<div class="col-md-12">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title"><i class="fa fa-info"></i> Informasi</h3>
	    </div>
	    <div class="box-body">
	    	<center>
	    		<i class="fa fa-sad-o" aria-hidden="true" style="font-size: 50pt; color: #18b10f;"></i>
	    		<p style="color: #848483; font-size: 14pt; margin: 0">Maaf, ujian akan dimulai pada tanggal <b>{{ $sesi->tanggal }}</b> mulai pukul <b>{{ $sesi->jam_mulai }}</b> sampai <b>{{ $sesi->jam_selesai }}</b></p>
	    	</center>
	    </div>
	  </div>
	</div>
@endsection