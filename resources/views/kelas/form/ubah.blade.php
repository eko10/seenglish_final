@extends('layouts.app')
@section('title', 'Ubah Sesi')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Sesi</li>
  </ol>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Ubah Sesi</h3>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-kelas" style="" class="form-horizontal">
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">Nama Sesi</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="{{ $kelas->id }}">
                  <input type="hidden" name="id_wali" value="1">
                  <input type="text" class="form-control" name="nama" id="nama" value="{{ $kelas->nama }}" placeholder="Nama Sesi">
                </div>
              </div>
              <div class="form-group">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{ $kelas->tanggal }}" placeholder="2022-02-28" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="jam_mulai" class="col-sm-2 control-label">Jam Mulai</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="jam_mulai" id="jam_mulai" value="{{ $kelas->jam_mulai }}" placeholder="09:00" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="jam_selesai" class="col-sm-2 control-label">Jam Selesai</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="jam_selesai" id="jam_selesai" value="{{ $kelas->jam_selesai }}" placeholder="11:00" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="kuota" class="col-sm-2 control-label">Kuota Peserta</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="kuota" id="kuota" value="{{ $kelas->kuota }}" placeholder="Kuota Peserta" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="link_wa" class="col-sm-2 control-label">Link Whatsapp</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="link_wa" id="link_wa" value="{{ $kelas->link_wa }}" placeholder="Link Whatsapp" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="save" class="col-sm-2 control-label">&nbsp</label>
                <div class="col-sm-10">
                  <div class="alert alert-danger" id="notif" style="display: none; margin: 0 auto 10px"></div>
                  <button type="button" class="btn btn-primary" id="save">Simpan</button>
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
@push('css')
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/timepicker/bootstrap-timepicker.css')}}">
@endpush
@push('scripts')
  <script src="{{URL::asset('assets/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
  <script>
    $(document).ready(function (){
      $("#tanggal").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
      });
      $('#jam_mulai').timepicker({
        showMeridian: false,
        showInputs: false
      });
      $('#jam_selesai').timepicker({
        showMeridian: false,
        showInputs: false
      });
      $('#save').click(function() {
        $('#notif').hide();
        var formData = $('#form-kelas').serialize();
        $.ajax({
          type: 'POST',
          url: "{{ url('crud/simpan-kelas') }}",
          data: formData,
          success: function(data) {
            if (data == 1) {
              window.location.href = "{{ url('master/kelas/detail/'.$kelas->id) }}";
            }else{
              $('#notif').html(data).show();
            }
          }
        })
      });
    });
  </script>
@endpush