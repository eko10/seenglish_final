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
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form action="{{ route('keuangan.laporan.data_keuangan') }}" method="POST" class="form-horizontal">
              {!! csrf_field() !!}
              {{-- <div class="form-group">
                <label>Tahun</label>
                <input type="text" class="form-control" name="tahun" id="tahun" placeholder="{{ date('Y') }}" autocomplete="off" required>
              </div> --}}
              <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="text" class="form-control" name="tanggal_awal" id="tanggal_awal" placeholder="{{ date('Y-m-d') }}" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="text" class="form-control" name="tanggal_akhir" id="tanggal_akhir" placeholder="{{ date('Y-m-d') }}" autocomplete="off" required>
              </div>
              <div class="form-group">
                <button type="submit" name="filter" class="btn btn-primary">Filter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(isset($_POST['filter']))
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title aaaa">Laporan Keuangan</h3>
        <div class="pull-right">
          <a target="_blank" href="{{ url('cetak/pdf/laporan-keuangan/' . Auth::user()->id . '/' . $_POST['tanggal_awal'] . '/' . $_POST['tanggal_akhir']) }}" class="btn btn-warning btn-md" data-toggle="tooltip" title="Cetak Laporan Keuangan"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</a>
          {{-- <a target="_blank" href="{{ url('cetak/pdf/laporan-keuangan/' . Auth::user()->id . '/' . $_POST['tahun']) }}" class="btn btn-warning btn-md" data-toggle="tooltip" title="Cetak Laporan Keuangan"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</a> --}}
        </div>
      </div>
      <div class="box-body">
        <div class="clearfix"></div>
  	    <table class="table table-hover table-condensed" id="keuangan">
  	    	<thead>
  	    		<tr>
              <th style="text-align: center">Tipe</th>
              <th>Keterangan</th>
              <th style="text-align: center">Tanggal</th>
              <th>Nominal</th>
  	    		</tr>
  	    	</thead>
          <tbody>
            @foreach($keuangan as $k)
  	    		<tr>
              <td style="text-align: center">
                @if ($k->posisi == 'M')
                  <center><span class='label label-success'>Masuk</span></center>
                @else
                  <center><span class='label label-danger'>Keluar</span></center>
                @endif
              </td>
              <td>{{ $k->keterangan }}</td>
              <td style="text-align: center">{{ $k->tanggal }}</td>
              <td>{{ number_format($k->nominal, 2, ",", ".") }}</td>
  	    		</tr>
            @endforeach
  	    	</tbody>
  	    </table>
      </div>
    </div>
  </div>
  @endif
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
    $(document).ready(function() {
      $('#keuangan').DataTable({
        responsive: true,
        lengthChange: true,
        order: [[2, "desc"]]
      });

      $('#tahun').datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose: true
      });

      $("#tanggal_awal").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
      });

      $("#tanggal_akhir").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
      });
    });
  </script>
@endpush