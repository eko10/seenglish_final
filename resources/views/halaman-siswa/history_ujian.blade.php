@extends('layouts.app')
@section('title', 'History Ujian - '.Auth::user()->nama)
@section('breadcrumb')
  <h1><i class="fa fa-check-square"></i> History Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Hi, {{ Auth::user()->nama }}</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-12">
	<div class="box box-primary">
	  <div class="box-header with-border">
		<h3 class="box-title">History Ujian {{ Auth::user()->nama }}</h3>
	  </div>
	  <div class="box-body">
		<table class="table table-condensed table-hover" id="table_detail">
		  <thead>
			<tr>
			  <th>Sesi</th>
			  <th style="text-align: center;">Nilai Reading</th>
			  <th style="text-align: center;">Nilai Writing</th>
			  <th style="text-align: center;">Nilai Listening</th>
			  <th style="text-align: center;">Nilai Total</th>
			  <th style="text-align: center;">Aksi</th>
			</tr>
			</thead>
			</tbody>
			@foreach($nilai as $n)
				<tr>
					<td>{{ $n->kelas }} ({{ $n->tanggal }})</td>
					<td style="text-align: center;">
						@if ($n->nilai_reading != null)
							{{ $n->nilai_reading }}
						@else
							<div style="text-align:center">
								<center><span class='label label-danger'>Belum Terisi</span></center>
							</div>
						@endif
					</td>
					<td style="text-align: center;">
						@if ($n->nilai_writing != null)
							{{ $n->nilai_writing }}
						@else
							<div style="text-align:center">
								<center><span class='label label-danger'>Belum Terisi</span></center>
							</div>
						@endif
					</td>
					<td style="text-align: center;">
						@if ($n->nilai_listening != null)
							{{ $n->nilai_listening }}
						@else
							<div style="text-align:center">
								<center><span class='label label-danger'>Belum Terisi</span></center>
							</div>
						@endif
					</td>
					<td style="text-align: center;">
						@if ($n->nilai_total != null)
							{{ $n->nilai_total }}
						@else
							<div style="text-align:center">
								<center><span class='label label-danger'>Belum Terisi</span></center>
							</div>
						@endif
					</td>
					<td>
						@if ($n->nilai_reading != null && $n->nilai_writing != null && $n->nilai_listening != null && $n->nilai_total != null)
							@if ($n->nilai_total >= 450 && $n->status_pengeluaran == 'Y')
								<div style="text-align:center">
									<a href="cetak/pdf/sertifikat-ujian-persiswa/{{$n->id}}" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-file-pdf-o"></i> Cetak Setifikat</a>
								</div>
							@else
								<center>-</center>
							@endif
						@else
							<div style="text-align:center">
								<center>-</center>
							</div>
						@endif
					</td>
				</tr>
			@endforeach
		  </tbody>
		</table>
	  </div>
	</div>
  </div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<style>
	.bg-aqua{
		background-color: #117e98 !important;
	}
</style>
@endpush
@push('scripts')
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
	$(document).ready(function (){
	  $('#table_detail').DataTable({
		processing: true,
		responsive: true,
		lengthChange: true,
	  });
	});
</script>
@endpush