@extends('layouts.app')
@section('title', 'Data Sesi')
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
        <h3 class="box-title aaaa">Data Sesi</h3>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" id="btn-create">Buat Sesi</button>
        </div>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-kelas" style="display: none; margin: 0 auto 20px;" class="form-horizontal well">
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">Nama Sesi</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="N">
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Sesi">
                </div>
              </div>
              
              <div class="form-group">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="2022-02-28" autocomplete="off">
                </div>
              </div><div class="form-group">
                <label for="jam_mulai" class="col-sm-2 control-label">Jam Mulai</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="jam_mulai" id="jam_mulai" placeholder="09:00" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="jam_selesai" class="col-sm-2 control-label">Jam Selesai</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="jam_selesai" id="jam_selesai" placeholder="11:00" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="kuota" class="col-sm-2 control-label">Kuota Peserta</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="kuota" id="kuota" placeholder="Kuota Peserta" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="link_wa" class="col-sm-2 control-label">Link Whatsapp</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="link_wa" id="link_wa" placeholder="Link Whatsapp" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="save" class="col-sm-2 control-label">&nbsp</label>
                <div class="col-sm-10">
                  <div class="alert alert-danger" id="notif" style="display: none; margin: 0 auto 10px"></div>
                  <button type="button" class="btn btn-danger" id="btn-batal">Batal</button>
                  <button type="button" class="btn btn-info" id="save">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="clearfix"></div>
  	    <table id="tabel_kelas" class="table table-hover table-condensed">
  	    	<thead>
  	    		<tr>
              <th>ID Sesi</th>
  	    			<th>Nama Sesi</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <th style="text-align: center;">Jumlah Peserta</th>
              <th style="text-align: center;">Kuota Peserta</th>
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
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/timepicker/bootstrap-timepicker.css')}}">
@endpush
@push('scripts')
  <script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
  <script src="{{URL::asset('assets/dist/js/offline.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
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

    	tabel_kelas = $('#tabel_kelas').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: true,
        ajax:'{!! route('master.data_kelas') !!}',
        columns: [
          {data: 'id', name: 'id', orderable: true, searchable: true },
          {data: 'nama', name: 'nama', orderable: true, searchable: true },
          {data: 'tanggal', name: 'tanggal', orderable: false, searchable: false },
          {
            data: 'jam_mulai',
            name: 'jam_mulai', 
            orderable: false, 
            searchable: false,
          },
          {data: 'siswa', name: 'siswa', orderable: false, searchable: false },
          {data: 'kuota', name: 'kuota', orderable: false, searchable: false },
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "drawCallback": function (setting) {
          $('.del-kelas').on('click', function() {
            var id_kelas = $(this).attr('id');
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
                  url: "{{ url('crud/delete-kelas') }}",
                  data: {id_kelas:id_kelas},
                  success: function(data) {
                    swal(
                      'Berhasil!',
                      'Data sesi berhasil dihapus.',
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
        $('#form-kelas').slideToggle();
      });

      $("#btn-batal").click(function() {
        $("#form-kelas").slideToggle();
      })

      $('#save').click(function() {
        $('#notif').hide();
        var formData = $('#form-kelas').serialize();
        $.ajax({
          type: 'POST',
          url: "{{ url('crud/simpan-kelas') }}",
          data: formData,
          success: function(data) {
            if (data == 1) {
              window.location.href = "{{ url('master/kelas') }}";
            }else{
              $('#notif').html(data).show();
            }
          }
        })
      });
    });
  </script>
@endpush