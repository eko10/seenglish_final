<?php

use Carbon\Carbon; ?>
@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb')
<h1>Dashboard</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
  <li class="active">Selamat datang</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
@if(Auth::user()->status == 'A')
<div class="row">
  <div class="col-md-6 col-sm-4 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="ion ion-person-stalker"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Jumlah Peserta</span>
        <span class="info-box-number">{{ number_format($siswas) }} <small>orang</small></span>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-4 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="ion ion-ios-list-outline"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Jumlah Sesi Aktif</span>
        <span class="info-box-number">{{ number_format($sesi) }} <small>Sesi</small></span>
      </div>
    </div>
  </div>
</div>
@endif
<div class="row">
  <div class="col-md-12">
    @if(!empty($informasi))
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-info-circle"></i> Informasi</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
            <i class="fa fa-times"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <h1 class="mt-4">{{ $informasi->judul }}</h1>
        <p style="font-size: 16px">
          by
          <a href="#">Admin</a>
        </p>
        <hr>
        <p style="font-size: 12px">Posted on {{ $informasi->tanggal }} | {{ $informasi->created_at->diffForHumans() }}</p>
        <hr>
        <img class="img-fluid rounded col-lg-12" src="{{ ($informasi->gambar != null && file_exists('assets/img/informasi/'.$informasi->gambar)) ? asset('assets/img/informasi/'.$informasi->gambar) : asset('assets/img/informasi/noimage.jpg') }}" alt="{{ $informasi->judul }}">
        <hr>
        <p style="font-size: 18px">{{ $informasi->isi }}</p>
      </div>
      <div class="box-footer"></div>
      @endif

    </div>

  </div>
</div>
@endsection
@push('css')
@endpush
@push('scripts')
<script>
  $(document).ready(function() {
    $('.carousel').carousel({
      interval: 1500
    });
  });
</script>
@endpush