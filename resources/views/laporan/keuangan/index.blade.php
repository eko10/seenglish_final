@extends('layouts.app')
@section('title', 'Laporan Keuangan')
@section('breadcrumb')
  <h1>Laporan</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Keuangan</a></li>
    <li class="active">Laporan</li>
  </ol>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title aaaa">Laporan Keuangan</h3>
        <div class="pull-right">
          {{-- <button type="button" class="btn btn-primary" id="btn-create">Cetak Laporan</button> --}}
          <a target="_blank" href="{{ url('cetak/pdf/laporan-keuangan/'.Auth::user()->id) }}" class="btn btn-warning btn-md" data-toggle="tooltip" title="Cetak Laporan Keuangan"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</a>
        </div>
      </div>
      <div class="box-body">
        <div class="clearfix"></div>
  	    <table id="tabel_keuangan" class="table table-hover table-condensed">
  	    	<thead>
  	    		<tr>
              <th style="text-align: center">Tipe</th>
              <th>Keterangan</th>
              <th style="text-align: center">Tanggal</th>
              <th>Nominal</th>
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
@endpush
@push('scripts')
  <script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
  <script src="{{URL::asset('assets/dist/js/offline.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  <script>
    $(document).ready(function (){
    	tabel_keuangan = $('#tabel_keuangan').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: true,
        ajax:'{!! route('keuangan.laporan.data_keuangan') !!}',
        columns: [
          {data: 'posisi', name: 'posisi', orderable: true, searchable: true },
          {data: 'keterangan', name: 'keterangan', orderable: true, searchable: true },
          {data: 'tanggal', name: 'tanggal', orderable: true, searchable: false },
          {
            data: 'nominal',
            name: 'nominal', 
            orderable: false, 
            searchable: false,
          },
        ],
      });

    });
  </script>
@endpush