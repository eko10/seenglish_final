<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>Sertifikat Ujian {{ $siswa->nama }}</title>
<?php require app_path().'/functions/myconf.php'; ?>
<div style="width:92%; height:60%; padding:20px; text-align:center; border: 10px solid #787878">
	<div style="width:93%; height:90%; padding:20px; text-align:center; border: 5px solid #787878">
		   <span style="font-size:50px; font-weight:bold">Certificate of Achievement</span>
		   <br><br>
		   <span style="font-size:25px"><i>This is to certify that</i></span>
		   <br><br>
		   <span style="font-size:30px"><b>{{ $siswa->nama }}</b></span><br/><br/>
		   <span style="font-size:20px"><i>achieved the following scores on the</i></span> <br/><br/>
		   <span style="font-size:35px; font-weight:bold">TOEFL</span> <br/><br/>
		   <span style="font-size:20px"><b>{{ $nilai->nilai_total }}</b></span> <br/><br/><br/>
		   <span style="font-size:20px"><i>dated</i></span><br>
		   {{ date('D', strtotime($nilai->created_at)) }},
		   {{ date("M j Y", strtotime($nilai->created_at)) }}
	</div>
</div>