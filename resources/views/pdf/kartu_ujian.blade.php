<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<title>Kartu Ujian {{ $peserta->nama }}</title>

<body>
	<h1 style="text-align: center">Kartu Ujian</h1>
	<hr>
	<table width="100%">
		<tr>
			<td style="width: 83%">
				@if($peserta->gambar != "")
				<img src="{{ public_path('/assets/img/user/'.$peserta->gambar) }}" width="100" height="100">
				@else
				<img src="{{ public_path('/assets/dist/img/user2-160x160.jpg') }}" width="100" height="100">
				@endif
			</td>
			<td style="width: 15%"></td>
			<td style="width: 2%"></td>
		</tr>
		<tr>
			<td style="width: 15%">Nama</td>
			<td style="width: 2%">:</td>
			<td style="width: 83%">{{ $peserta->nama }} </td>
		</tr>
		<tr>
			<td style="width: 15%">Email</td>
			<td style="width: 2%">:</td>
			<td style="width: 83%">{{ $peserta->email }} </td>
		</tr>
		<tr>
			<td style="width: 15%">No. Handphone</td>
			<td style="width: 2%">:</td>
			<td style="width: 83%">{{ $peserta->no_hp }} </td>
		</tr>
		<tr>
			<td style="width: 15%">Token Ujian</td>
			<td style="width: 2%">:</td>
			<td style="width: 83%">{{ $peserta->token_ujian }} </td>
		</tr>
		<tr>
			<td style="width: 15%">Link Whatsapp</td>
			<td style="width: 2%">:</td>
			<td style="width: 83%">{{ $peserta->getKelas->link_wa }} </td>
		</tr>
	</table>
	<br>
	<table width="100%">
		<tr>
			<th class="garis" width="45%" style="text-align: left">Sesi</th>
			<th class="garis" width="20%" style="text-align: center">Tanggal</th>
			<th class="garis" width="35%" style="text-align: center">Jam</th>
		</tr>
		<tr>
			<td class="garis" width="45%" style="text-align: left">{{ $peserta->getKelas->nama }}</td>
			<td class="garis" width="20%" style="text-align: center">{{ $peserta->getKelas->tanggal }}</td>
			<td class="garis" width="35%" style="text-align: center">{{ $peserta->getKelas->jam_mulai }} - {{ $peserta->getKelas->jam_selesai }}</td>
		</tr>
	</table>
</body>