@extends('layouts.app')
@section('title', 'Detail Informasi')
@section('breadcrumb')
  <h1>Detail Informasi</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/master/informasi') }}">Informasi</a></li>
    <li class="active">Detail</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="box box-primary">
    <div class="box-body box-profile">
      @if($informasi->gambar != '')
        <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/informasi/'.$informasi->gambar) }}" alt="User profile picture" style="width: 25%">
      @else
        <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/noimage.jpg') }}" alt="User profile picture" style="width: 25%">
      @endif
      <table class="table table-condensed table-hover">
        <tr>
          <td width="150px">Judul</td>
          <td width="10px">:</td>
          <td>{{ $informasi->judul }}</td>
        </tr>
        <tr>
          <td>Isi</td>
          <td>:</td>
          <td>{{ $informasi->isi }}</td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td>:</td>
          <td>{{ $informasi->tanggal }}</td>
        </tr>
        {{-- <tr>
          <td>Gambar</td>
          <td>:</td>
          <td><img class="img-responsive img-rounded" src="{{ $informasi->gambar ? url('assets/img/informasi/'.$informasi->gambar) : url('assets/img/noimage.jpg') }}" alt="User profile picture" style="width: 25%"></td>
        </tr> --}}
        <tr>
          <td>Status</td>
          <td>:</td>
          <td>
            @if ($informasi->status == 'N')
              <span class='label label-warning'>Tidak Tampil</span>
            @else
              <span class='label label-success'>Tampil</span>
            @endif
          </td>
        </tr>
      </table>
      <hr>
      <a href="{{ url('/master/informasi') }}" class="btn btn-danger btn-block"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
    <!-- /.box-body -->
  </div>
</div>
@endsection
@push('scripts')
  <script type="text/javascript" src="{{ url('node_modules/moment/moment.js') }}"></script>
  <script>
    $(document).ready(function() {
    });
  </script>
@endpush