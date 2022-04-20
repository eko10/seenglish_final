@extends('layouts.app')
@section('title', 'Data Nilai')
@section('breadcrumb')
<h1>E-Learning</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
  <li class="active">Nilai</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  @if (Session::has('success'))
    <div class="alert alert-success">
      <i class="fa fa-check-circle"></i> {{ Session::get('success') }}
    </div>
  @endif
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Nilai</h3>
      <div class="pull-right">
        <a href="{{ route('nilai.import') }}" class="btn btn-success btn-md" data-toggle="tooltip" title="Import Excel"><i class="fa fa-file-excel-o"></i> Import Excel</a>
      </div>
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
      <table id="tabel_nilai" class="table table-hover">
        <thead>
          <tr>
            <th>Nama</th>
            <th style="text-align: left;">Sesi</th>
            <th style="text-align: center;">Nilai Reading</th>
            <th style="text-align: center;">Nilai Writing</th>
            <th style="text-align: center;">Nilai Listening</th>
            <th style="text-align: center;">Nilai Total</th>
            <th style="width: 130px; text-align: center;">Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
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
<script>
  $(document).ready(function() {
    $('.select2Class').select2();

    tabel_nilai = $('#tabel_nilai').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      lengthChange: true,
      ajax: '{{ route("elearning.data_nilai") }}',
      columns: [{
          data: 'peserta',
          name: 'peserta',
          orderable: false,
          searchable: true
        },
        {
          data: 'kelas',
          name: 'kelas',
          orderable: false,
          searchable: true
        },
        {
          data: 'nilai_reading',
          name: 'nilai_reading',
          orderable: false,
          searchable: true
        },
        {
          data: 'nilai_writing',
          name: 'nilai_writing',
          orderable: false,
          searchable: true
        },
        {
          data: 'nilai_listening',
          name: 'nilai_listening',
          orderable: false,
          searchable: true
        },
        {
          data: 'nilai_total',
          name: 'nilai_total',
          orderable: false,
          searchable: true
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ]
    });
  });
</script>
@endpush