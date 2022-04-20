@extends('layouts.app')
@section('title', 'Laporan')
@section('breadcrumb')
<h1>Laporan</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
	<li class="active">Laporan</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-8">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Laporan per-Sesi</h3>
		</div>
		<div class="box-body">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="text-center" style="width: 25px">#</th>
						<th>Nama Sesi</th>
						<th class="text-center">Jumlah Peserta</th>
						<th class="text-center" style="width: 50px">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@if($kelas->count())
					<?php $no = $kelas->firstItem(); ?>
					@foreach($kelas as $data_kelas)
					<tr>
						<td class="text-center">{{ $no++ }}</td>
						<td>{{ ucwords(strtolower($data_kelas->nama)) }}</td>
						<td class="text-center">{{ number_format($data_kelas->siswa->count(),0,'.','.').' orang' }}</td>
						<td align="center"><a href="{{ url('/elearning/laporan/detail-kelas/'.$data_kelas->id) }}" class="btn btn-success btn-xs">Detail</a></td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="3" class="alert alert-danger">Data sesi kosong.</td>
					</tr>
					@endif
				</tbody>
			</table>
			{!! $kelas->render() !!}
		</div>
	</div>
</div>
<div class="col-md-4">
	@if($user->status == 'G' or $user->status == 'A')
	<div class="box box-danger">
		<div class="box-body">
			<p><i class="fa fa-question-circle" style="color: indianred"></i> Daftar sesi berisi data paket soal yang dikerjakan oleh peserta. Klik tombol detail untuk masuk kedalam sesi.</p>
			<p>Apabila terdapat sesi yang belum terdaftar, silahkan hubungi administrator untuk menambahkan data sesi.</p>
		</div>
	</div>
	@endif
</div>
@endsection