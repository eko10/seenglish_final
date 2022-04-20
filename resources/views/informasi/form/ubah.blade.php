@extends('layouts.app')
@section('title', 'Ubah Informasi')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Informasi</li>
  </ol>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-edit" aria-hidden="true"></i> Ubah Informasi</h3>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-informasi" method="POST" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">Judul</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="{{ $informasi->id }}">
                  <input type="text" class="form-control" name="judul" id="judul" value="{{ $informasi->judul }}" placeholder="Judul">
                </div>
              </div>
              <div class="form-group">
                <label for="paket" class="col-sm-2 control-label">Isi</label>
                <div class="col-sm-10">
                  <textarea name="isi" class="form-control" placeholder="Isi">{{ $informasi->isi }}</textarea>
                </div>
              </div>
              {{-- <div class="form-group">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{ $informasi->tanggal }}" placeholder="2022-02-28">
                </div>
              </div> --}}
              <div class="form-group">
                <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                <div class="col-sm-10">
                  @if($informasi->gambar != '')
                    <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/informasi/'.$informasi->gambar) }}" alt="User profile picture" style="width: 20%">
                  @else
                    <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/noimage.jpg') }}" alt="User profile picture" style="width: 20%">
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="gambar" class="col-sm-2 control-label">Ubah Gambar</label>
                <div class="col-sm-10">
                  <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                  <div class="radio">
                    <label><input type="radio" name="status" id="a" value="A" @if($informasi->status == 'A') checked @else @endif> Tampil</label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="status" id="n" value="N" @if($informasi->status == 'N') checked @else @endif> Tidak tampil</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="save" class="col-sm-2 control-label">&nbsp</label>
                <div class="col-sm-10">
                  <div class="alert alert-danger" id="notif" style="display: none; margin: 0 auto 10px"></div>
                  <button type="submit" class="btn btn-primary" id="save">Simpan</button>
                  <button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function (){

      // $("#tanggal").datepicker({
      //   format: 'yyyy-mm-dd',
      //   autoclose: true
      // });

      $("#form-informasi").submit(function(e) {
        e.preventDefault();
        $('#notif').hide();  
        let formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ url('/crud/simpan-informasi') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
              if (data == 1) {
                window.location.href = "{{ url('master/informasi/detail/'.$informasi->id) }}";
              }else{
                $('#notif').html(data).show();
              }
            }
        })
      });
    });
  </script>
@endpush