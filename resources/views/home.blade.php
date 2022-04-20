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
        <!-- <span><b>{{ number_format($soals) }}</b> <small>soal</small></span> -->
      </div>
    </div>
  </div>
</div>
@endif
{{-- </div class="row">
    <div class="col-md-12 col-sm-4 col-xs-12">
      <div class="info-box">
        @if(count($informasi) >= 1)
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              @foreach($informasi->take(3) as $p)
                <li data-target="#myCarousel" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
@endforeach
</ol>
<div class="carousel-inner">
  @foreach($informasi->take(3) as $p)
  <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
    <img class="first-slide" width="100%" height="300px" src="{{ ($p->gambar == null) ? asset('assets/img/noimage.jpg') : asset('assets/img/informasi/'.$p->gambar) }}" alt="{{ $p->judul }}">
    <div class="container">
      <div class="carousel-caption text-center">
        <h3 style="color: black">{{ $p->judul }}</h3>
        <p><a class="btn btn-sm btn-warning" href="{{ url('master/informasi/detail/'. $p->id) }}" role="button"><i class="fa fa-eye"></i> Lihat detail</a></p>
      </div>
    </div>
  </div>
  @endforeach
</div>
<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
  <span class="carousel-control-next-icon" aria-hidden="true"></span>
  <span class="sr-only">Next</span>
</a>
</div>
@else
<p class="text-center" style="font-style: italic">Tidak Ada Informasi</p>
@endif
</div>
</div>
</div> --}}
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