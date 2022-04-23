@extends('layouts.app')
@section('title', 'Pembayaran Ujian - ' . Auth::user()->nama)
@section('breadcrumb')
<h1><i class="fa fa-check-square"></i> Pembayaran Ujian</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
	<li class="active">Hi, {{ Auth::user()->nama }}</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Rincian Pembayaran Ujian</h3>
		</div>
		<div class="box-body">
			<form action="{{ route('siswa.payment-post') }}" id="submit_form" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="json" id="json_callback">
				<input type="hidden" name="uname" value="{{Auth::user()->username}}">
				<input type="hidden" name="email" value="{{Auth::user()->email}}">
				<input type="hidden" name="number" value="{{Auth::user()->no_hp}}">
				<input type="hidden" name="kelas" value="{{$kelas->id}}">
			</form>
			<form>
				<div class="box-body">
					<div class="form-group">
						<label class="control-label">Sesi</label>
						<input type="text" class="form-control" value="{{ $kelas->nama }}" readonly placeholder="Sesi">
					</div>
					<div class="form-group">
						<label class="control-label">Tanggal</label>
						<input type="text" class="form-control" value="{{ $kelas->tanggal }}" readonly placeholder="Tanggal">
					</div>
					<div class="form-group">
						<label class="control-label">Jam</label>
						<input type="text" class="form-control" value="{{ $kelas->jam_mulai }} - {{ $kelas->jam_selesai }}" readonly placeholder="Jam">
					</div>
					<div class="form-group">
						<label class="control-label">Nominal</label>
						<input type="text" class="form-control" value="{{ number_format($nominal, 2, ",", ".") }}" readonly placeholder="Nominal">
					</div>
					<div class="form-group" style="margin-top: 20px">
						<div class="col-sm-offset-3 col-sm-9">
							<div id="notif" style="display: none;"></div>
							<img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading">
						</div>
					</div>
				</div>
			</form>
			<div class="box-footer">
				<button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
				<button class="btn btn-success" id="pay-button">Bayar</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/select2/select2.min.css')}}">
<style>
	.bg-aqua {
		background-color: #117e98 !important;
	}

	.select2-container--default .select2-selection--single {
		height: 33px;
	}
</style>
@endpush
@push('scripts')
{{-- <script type="text/javascript" src="//app.midtrans.com/snap/snap.js" data-client-key="Mid-client-jMHwvlbzh74Rm4Q9"></script> --}}
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-9HDvcpxtiGA-Od8y"></script>
<!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
<script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
<script src="{{URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script type="text/javascript">
	// For example trigger on button clicked, or any time you need
	var payButton = document.getElementById('pay-button');
	payButton.addEventListener('click', function() {
		// Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
		window.snap.pay('{{$snap_token}}', {
			onSuccess: function(result) {
				/* You may add your own implementation here */
				console.log(result);
				//   window.location.href = "{{ route('siswa.daftar-ujian') }}";
				send_response_to_form(result);
			},
			onPending: function(result) {
				/* You may add your own implementation here */
				console.log(result);
				//   window.location.href = "{{ route('siswa.daftar-ujian') }}";
				send_response_to_form(result);
			},
			onError: function(result) {
				/* You may add your own implementation here */
				console.log(result);
				//   window.location.href = "{{ route('siswa.daftar-ujian') }}";
				send_response_to_form(result);
			},
			onClose: function() {
				/* You may add your own implementation here */
				alert('you closed the popup without finishing the payment');
				window.location.href = "{{ route('siswa.daftar-ujian') }}";
			}
		})
	});

	function send_response_to_form(result) {
		document.getElementById('json_callback').value = JSON.stringify(result);
		console.log(result);
		$('#submit_form').submit();
	}
</script>
@endpush