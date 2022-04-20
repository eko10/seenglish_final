@extends('layouts.app')
@section('title', 'Data Informasi')
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
        <h3 class="box-title aaaa">Data Informasi</h3>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" id="btn-create">Buat Informasi</button>
        </div>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-informasi" method="POST" enctype="multipart/form-data" style="display: none; margin: 0 auto 20px;" class="form-horizontal well">
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">Judul</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="N">
                  <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul">
                </div>
              </div>
              <div class="form-group">
                <label for="paket" class="col-sm-2 control-label">Isi</label>
                <div class="col-sm-10">
                  <textarea name="isi" class="form-control" placeholder="Isi"></textarea>
                </div>
              </div>
              {{-- <div class="form-group">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="2022-02-28">
                </div>
              </div> --}}
              <div class="form-group">
                <label for="gambar" class="col-sm-2 control-label">Gambar</label>
                <div class="col-sm-10">
                  <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                  <div class="radio">
                    <label><input type="radio" name="status" id="a" value="A"> Tampil</label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="status" id="n" value="N"> Tidak tampil</label>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label for="save" class="col-sm-2 control-label">&nbsp</label>
                <div class="col-sm-10">
                  <div class="alert alert-danger" id="notif" style="display: none; margin: 0 auto 10px"></div>
                  <button type="button" class="btn btn-danger" id="btn-batal">Batal</button>
                  <button type="submit" class="btn btn-info" id="save">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="clearfix"></div>
  	    <table id="tabel_informasi" class="table table-hover table-condensed">
  	    	<thead>
  	    		<tr>
                    <th>Judul</th>
                    <th style="width: 250px;">Isi</th>
                    <th>Tanggal</th>
                    <th style="text-align: center;">Gambar</th>
                    <th style="text-align: center;">Status</th>
                    <th style="width: 130px; text-align: center;">Aksi</th>
  	    		</tr>
  	    	</thead>
  	    </table>
      </div>
    </div>
  </div>
@endsection
@push('css')
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
  <script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
  <script src="{{URL::asset('assets/dist/js/offline.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  <script>
    $(document).ready(function (){
      function checkconnection() {
        var status = navigator.onLine;
        if (status) {
          // alert("online");
        } else {
          // alert("offline");
        }
      }

      // $("#tanggal").datepicker({
      //   format: 'yyyy-mm-dd',
      //   autoclose: true
      // });

      tabel_informasi = $('#tabel_informasi').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: true,
        ajax:'{!! route('master.data_informasi') !!}',
        columns: [
          {data: 'judul', name: 'judul', orderable: false, searchable: true },
          {data: 'isi', name: 'isi', orderable: false, searchable: true },
          {data: 'tanggal', name: 'tanggal', orderable: true, searchable: false },
          {data: 'gambar', name: 'gambar', orderable: false },
          {data: 'status', name: 'status', orderable: false },
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "drawCallback": function(setting) {
            $('.del-informasi').on('click', function() {
                var id_informasi = $(this).attr('id');
                var $this = $(this);
                swal({
                    title: 'Yakin akan dihapus?',
                    text: "Data yang telah dihapus tidak bisa dikembalikan.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ url('crud/delete-informasi') }}",
                            data: {
                                id_informasi: id_informasi
                            },
                            success: function(data) {
                                swal(
                                    'Berhasil!',
                                    'Data informasi berhasil dihapus.',
                                    'success'
                                )
                                $this.closest('tr').hide();
                            }
                        })
                    }
                })
            });
        }
      });

      $('#btn-create').click(function() {
        $('#form-informasi').slideToggle();
      });

      $("#btn-batal").click(function() {
        $("#form-informasi").slideToggle();
      });

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
                        window.location.href = "{{ url('master/informasi') }}";
                    }else{
                        $('#notif').html(data).show();
                    }
                }
            })
      });
    });
  </script>
@endpush