@extends('layouts.app')
@section('title', 'Detail Peserta')
@section('breadcrumb')
<h1>Detail Peserta</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
  <li><a href="{{ url('/master/siswa') }}">Peserta</a></li>
  <li class="active">Detail</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  @if (Session::has('success'))
  <div class="alert alert-success">
    <i class="fa fa-check-circle"></i> {{ Session::get('success') }}
  </div>
  @endif
  <div class="box box-primary">
    <div class="box-body box-profile">
      @if($siswa->gambar != '')
      <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/user/'.$siswa->gambar) }}" alt="User profile picture" style="width: 25%">
      @else
      <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/noimage.jpg') }}" alt="User profile picture" style="width: 25%">
      @endif
      {{-- <p class="text-muted text-center">
        @if($siswa->status == 'G')
          Guru
        @elseif($siswa->status == 'A')
          Admin
        @endif
      </p> --}}

      <table class="table table-condensed table-hover">
        <tr>
          <td width="150px">Nama</td>
          <td width="10px">:</td>
          <td>{{ $siswa->nama }}</td>
        </tr>
        <tr>
          <td>Username</td>
          <td>:</td>
          <td>{{ $siswa->username }}</td>
        </tr>
        <tr>
          <td>Pendidikan</td>
          <td>:</td>
          <td>{{ $siswa->pendidikan }}</td>
        </tr>
        <tr>
          <td>Sesi</td>
          <td>:</td>
          <td>@if ($siswa->id_kelas != null) {{ $siswa->getKelas->nama }} @else Belum terdaftar sesi @endif</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>:</td>
          <td>{{ $siswa->email }}</td>
        </tr>
        <tr>
          <td>No. HP</td>
          <td>:</td>
          <td>{{ $siswa->no_hp }}</td>
        </tr>
        <tr>
          <td>Jenis Kelamin</td>
          <td>:</td>
          <td>
            @if($siswa->jk == 'L')
            Laki-laki
            @else
            Perempuan
            @endif
          </td>
        </tr>
        <tr>
          <td>Alamat</td>
          <td>:</td>
          <td>{{ $siswa->alamat }}</td>
        </tr>
        <tr>
          <td>Status Validasi</td>
          <td>:</td>
          <td>
            @if ($siswa->status_validasi != 'Y')
            <span class='label label-warning'>Belum Divalidasi</span>
            @else
            <span class='label label-success'>Sudah Divalidasi</span>
            @endif
          </td>
        </tr>
        <tr>
          <td>Status Pembayaran</td>
          <td>:</td>
          <td>
            @if ($siswa->status_payment == 'settlement')
            <span class='label label-success'>Paid</span>
            @else
            <span class='label label-warning'>{{ ucfirst($siswa->status_payment) }}</span>
            @endif
          </td>
        </tr>
        <tr>
          <td>Token Ujian</td>
          <td>:</td>
          <td>
            @if ($siswa->token_ujian == null or $siswa->status_validasi != 'Y' or $siswa->status_payment != 'settlement')
            <b>-</b>
            @else
            <b>{{ $siswa->token_ujian }}</b>
            @endif
          </td>
        </tr>
      </table>
      <hr>
      {{-- @if($siswa->status_validasi != 'Y' or $siswa->status_payment != 'settlement')
      <form action="{{ route('validasi') }}" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{ $siswa->id }}">
      <input type="hidden" name="validasi" value="Y">
      <button type="submit" class="btn btn-primary btn-block" id="simpan"><i class="fa fa-edit"></i> Validasi</button>
      <a href="{{ url('/master/siswa') }}" class="btn btn-danger btn-block"><i class="fa fa-arrow-left"></i> Kembali</a>
      </form>
      @else --}}
      <a href="{{ url('/master/siswa') }}" class="btn btn-danger btn-block"><i class="fa fa-arrow-left"></i> Kembali</a>
      {{-- @endif --}}
    </div>
    <!-- /.box-body -->
  </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ url('node_modules/moment/moment.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#btn-reset').on('click', function() {
      var id_ujian = $(this).attr('data-id');
      var $this = $(this);
      swal({
        title: 'Yakin akan direset?',
        text: "Data yang telah direset tidak bisa dikembalikan.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset!'
      }).then(function() {
        $.ajax({
          type: 'POST',
          url: "{{ url('crud/reset-ujian') }}",
          data: {
            id_ujian: id_ujian
          },
          success: function(data) {
            console.log(data);
            swal(
              'Berhasil!',
              'Data ujian berhasil direset.',
              'success'
            )
          }
        })
      })
    });
  });
</script>
@endpush