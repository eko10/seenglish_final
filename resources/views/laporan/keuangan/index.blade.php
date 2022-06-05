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
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title aaaa">Laporan Keuangan</h3>
    </div>
    <div class="box-body">
      <div class="col-sm-12">
        <div class="col-sm-12">
          <form action="{{ route('keuangan.laporan.filter_keuangan') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            {{-- <div class="form-group">
                <label>Tahun</label>
                <input type="text" class="form-control" name="tahun" id="tahun" placeholder="{{ date('Y') }}" autocomplete="off" required>
        </div> --}}
        <div class="form-group">
          <!-- <label>Sesi</label>
          <input type="text" class="form-control" name="sesi" id="sesi" placeholder="Pilih sesi" autocomplete="off" required> -->
          <label>Sesi</label>
          <select name="sesi" id="sesi" class="form-control" placeholder="Pilih sesi">
            <option value="semua">Semua sesi</option>
            @foreach($kelas as $s)
            <option value="{{ $s->id }}">{{ $s->nama . ' (' . $s->tanggal . ')' }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <!-- <label>Jenis transaksi</label>
          <input type="text" class="form-control" name="posisi" id="posisi" placeholder="Pilih jenis transaksi" autocomplete="off" required> -->
          <label>Jenis transaksi</label>
          <select name="posisi" id="posisi" class="form-control" placeholder="Pilih jenis transaksi">
            <option value="semua">Semua Transaksi</option>
            <option value="M">Masuk</option>
            <option value="K">Keluar</option>
          </select>
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
        <a target="_blank" href="{{ url('cetak/pdf/filter-keuangan/' . Auth::user()->id . '/' . $_POST['posisi'] . '/' . $_POST['sesi']) }}" class="btn btn-warning btn-md" data-toggle="tooltip" title="Cetak Laporan Keuangan"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</a>
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
            <th style="text-align: center">Sesi</th>
            <th style="text-align: center">Tanggal Pembayaran</th>
            <th>Nominal</th>
          </tr>
        </thead>
        @if($keuangan->count() > 0)
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
            <td>@if ($k->sesi != null) {{ $k->getKelas->nama . ' (' . $k->getKelas->tanggal . ')' }} @else @endif</td>
            <td style="text-align: center">{{ $k->tanggal }}</td>
            <td>{{ number_format($k->nominal, 2, ",", ".") }}</td>
          </tr>
          @endforeach
        </tbody>
        @else
        <tbody>
          <tr>
            <td colspan="7" style="text-align: center;"><br>Belum ada laporan keuangan</td>
          </tr>
        </tbody>
        @endif
      </table>
      <!-- <button id="buttonPrint">Print</button> -->
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
      order: [
        [2, "desc"]
      ]
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

  // function printData() {
  //   var divToPrint = document.getElementById("keuangan");
  //   newWin = window.open("");
  //   newWin.document.write(divToPrint.outerHTML);
  //   newWin.print();
  //   newWin.close();
  // }

  // $('#buttonPrint').on('click', function() {
  //   printData();
  // })
</script>
@endpush