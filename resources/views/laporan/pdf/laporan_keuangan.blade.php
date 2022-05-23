<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
	input[type="radio"] {
		margin-top: 3px;
	}
	table {
		border-collapse: collapse;
	}
	.garis {
		border: solid thin #333;
		padding: 6px;
	}
	.well {
		background: #f2f6fc;
		padding: 15px;
		border: solid thin #d7dee8;
		color: #3a4149;
	}
	.benar {
		background: #e5f9e9;
		color: #1d231e;
		padding: 10px 15px 0 15px;
	}
	.salah {
		background: #f9f1ed;
		color: #1d231e;
	}
</style>
<title>Laporan Keuangan</title>
<?php require app_path().'/functions/myconf.php'; ?>
<h1 style="text-align: center">Laporan Keuangan</h1>
<hr style="margin-bottom: 4px">
<div style="height: 5px"></div>
<table width="100%">
	<tr>
		<td class="garis" style="text-align: center" width="10%">Tipe</td>
        <td class="garis" style="text-align: left" width="40%">Keterangan</td>
        <td class="garis" style="text-align: center" width="20%">Tanggal</td>
        <td class="garis" style="text-align: center" width="30%">Nominal</td>
	</tr>
    @foreach ($keuangan as $k)
	<tr>
		<td class="garis" style="text-align: center">
			{{ ($k->posisi == 'M') ? 'Masuk' : 'Keluar' }}
		</td>
		<td class="garis" style="text-align: left">{{ $k->keterangan }}</td>
		<td class="garis" style="text-align: left">@if ($k->sesi != null) {{ $k->getKelas->nama . ' (' . $k->getKelas->tanggal . ')' }} @else @endif</td>
		<td class="garis" style="text-align: center">{{ $k->tanggal }}</td>
		<td class="garis" style="text-align: center">{{ ($k->posisi == 'M') ? number_format($k->nominal, 2, ',', '.') : "-". number_format($k->nominal, 2, ',', '.') }}</td>
		<!-- <td class="garis" style="text-align: center">@if ($k->posisi == 'M' || $k->posisi == 'semua' ) {{ $keuangan_masuk }} else {{ $keuangan_keluar }} @endif</td> -->
	</tr>
	@endforeach
	<tr>
		<td class="garis" style="text-align: center" colspan="4">Total Keuangan</td>
		<td class="garis" style="text-align: center">@if ($posisi == 'semua') {{ number_format($keuangan_masuk - $keuangan_keluar, 2, ',', '.') }} @elseif ($posisi == 'M') {{ number_format($keuangan_masuk, 2, ',', '.') }} @else -{{ number_format($keuangan_keluar, 2, ',', '.') }} @endif</td>
	</tr>
</table>