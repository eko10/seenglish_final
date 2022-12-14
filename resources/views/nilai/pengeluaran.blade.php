@extends('layouts.app')
@section('title', 'Data Pengeluaran')
@section('breadcrumb')
<h1>E-Learning</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
  <li class="active">Input Pengeluaran</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Input Pengeluaran Biaya Penerbitan Sertifikat</h3>
    </div>
    <form action="{{ route('nilai.pengeluaran.post') }}" method="POST">
      {{ csrf_field() }}
      <div class="box-body">
          <div class="form-group">
            <label class="control-label">Nama</label>
            <input type="hidden" name="id" value="{{ $nilai->id }}">
            <input type="hidden" name="id_user" value="{{ $nilai->id_user }}">
            <input type="text" class="form-control" value="{{ $nilai->peserta }}" readonly placeholder="Sesi">
          </div>
          <div class="form-group">
            <label class="control-label">Sesi</label>
            <input type="text" class="form-control" value="{{ $nilai->kelas }}" readonly placeholder="Tanggal">
          </div>
          <div class="form-group">
            <label class="control-label">Nilai Total</label>
            <input type="number" class="form-control" value="{{ $nilai->nilai_total }}" readonly placeholder="Nilai Total" required>
          </div>
          <div class="form-group">
            <label class="control-label">Nominal(Rp.)</label>
            <input type="number" class="form-control" name="nominal" placeholder="Nominal(Rupiah)" id="nominal" required>
          </div>
      </div>
      <div class="box-footer">
        <button type="button" class="btn btn-danger" onclick="self.history.back()">Batal</button>
        <button class="btn btn-success" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/select2/select2.min.css')}}">
<style type="text/css">
  .select2-container--default .select2-selection--single {
    height: 33px;
  }

  .inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
  }

  .inputfile+label {
    font-size: 1.25em;
    font-weight: 700;
    color: white;
    background-color: green;
    display: inline-block;
    padding: 10px;
  }

  .inputfile:focus+label,
  .inputfile+label:hover {
    background-color: darkgreen;
  }

  .inputfile+label {
    cursor: pointer;
  }

  .inputfile:focus+label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
  }

  .inputfile+label * {
    pointer-events: none;
  }

  .upload_url_img, .upload_url_bg {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
  }

  .upload_url_img + label, .upload_url_bg + label {
    margin-top: 5px;
    font-size: 11pt;
    font-weight: 700;
    color: white;
    background-color: #178bcc;
    display: inline-block;
    padding: 5px 10px;
    text-align: center;
    border-radius: 5px;
    cursor: pointer;
    width: 30%;
  }

  .upload_url_img:focus + label,
  .upload_url_img + label:hover,
  .upload_url_bg:focus + label,
  .upload_url_bg + label:hover {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
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
@endpush