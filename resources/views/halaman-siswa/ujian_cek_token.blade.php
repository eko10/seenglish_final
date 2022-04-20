@extends('layouts.app')
@section('title', 'Cek Token Ujian - '.Auth::user()->nama)
@section('breadcrumb')
  <h1><i class="fa fa-check-square"></i> Cek Token Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Hi, {{ Auth::user()->nama }}</li>
  </ol>
@endsection
@section('content')
	<div class="col-md-12">
	  <div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Masukkan token yang dikirim admin.</h3>
		</div>
		<form action="{{ route('siswa.cek-token-ujian') }}" method="POST">
			{{ csrf_field() }}
			<div class="box-body">
				@if($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<i class="fa fa-times"></i> {{ $error }}<br>
						@endforeach
					</div>
				@endif
				<input type="hidden" name="id" value="{{ Auth::user()->id }}">
				<input type="hidden" name="email" value="{{ Auth::user()->email }}">
				<input type="hidden" name="id_kelas" value="{{ Auth::user()->id_kelas }}">
				<div class="form-group">
					<label for="token">Token</label>
					<input type="text" class="form-control" id="token" name="token" placeholder="Masukan Token Anda" required>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-success"> Submit</button>
			</div>
		</form>
	  </div>

  	</div>
@endsection
@push('css')
<style>
	.bg-aqua{
		background-color: #117e98 !important;
	}
</style>
@endpush