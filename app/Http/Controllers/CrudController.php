<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Image;
use File;
use Illuminate\Support\Str;
use App\User;
use App\Models\Distribusisoal;
use App\Models\Kelas;
use App\Models\Jawab;
use App\Models\Informasi;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class CrudController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function updateProfil(Request $request)
  {
    if ($request->nama == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama tidak boleh kosong.";
    } elseif ($request->jk == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Jenis kelamin tidak boleh kosong.";
    } elseif ($request->email == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak boleh kosong.";
    } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak valid.";
    } else {
      $cek_email = User::where('id', '!=', auth()->user()->id)->where('email', $request->email)->first();
      if ($cek_email != "") {
        return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email sudah terdaftar, silahkan ganti dengan yang lain.";
      } else {
        $query = User::where('id', $request->id)->first();
        if ($query != "") {
          $query->nama = $request->nama;
          $query->no_induk = $request->no_induk;
          $query->jk = $request->jk;
          $cek_email = User::where('email', $request->email)->where('id', '!=', $request->id)->first();
          if ($cek_email == "") {
            $query->email = $request->email;
          }
          if ($request->password != "") {
            $query->password = bcrypt($request->password);
          }
          $query->save();
        }
        return 'ok';
      }
    }
  }
  public function simpanMateri(Request $request)
  {
    // return $request->judul;
    if ($request->judul == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Judul tidak boleh kosong.";
    } elseif ($request->isi == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Isi materi tidak boleh kosong.";
    } elseif ($request->status == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Status tampil materi tidak boleh kosong.";
    } else {
      $cek = Materi::where('sesi', $request->sesi)->first();
      if ($cek == "") {
        $query = new Materi;
        $query->id_user = auth()->user()->id;
        $query->sesi = $request->sesi;
        $query->hits = 0;
      } else {
        $query = Materi::where('sesi', $request->sesi)->first();
      }
      $query->judul = $request->judul;
      $query->isi = $request->isi;
      $query->status = $request->status;
      $query->save();
      return 'ok';
    }
  }
  public function simpanGambarMateri(Request $request)
  {
    $sesi = $request->sesi_gambar;
    $uniqname = date('ymdhis') . rand(00000, 99999);
    $filename = trim(addslashes($_FILES['file']['name']));
    $filenamehapusspasi = str_replace(' ', '_', $filename);
    $savename = md5(round(microtime(true))) . '_' . $filenamehapusspasi;
    $img = Image::make($_FILES['file']['tmp_name']);
    $img->resize(720, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $img->save('assets/img/materi/' . $savename);
    $thumnews = Image::make($_FILES['file']['tmp_name']);
    $thumnews->resize(150, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $thumnews->save('assets/img/materi/thumb/' . $savename);

    $cek = Materi::where('sesi', $sesi)->first();
    if ($cek == "") {
      $query = new Materi;
      $query->id_user = auth()->user()->id;
      $query->sesi = $sesi;
      $query->status = 'N';
      $query->hits = 0;
    } else {
      if ($cek->gambar != "") {
        unlink('assets/img/materi/' . $cek->gambar);
        unlink('assets/img/materi/thumb/' . $cek->gambar);
      }
      $query = Materi::where('sesi', $sesi)->first();
    }
    $query->gambar = $savename;
    $query->save();
    return "ok";
  }
  public function terbitSoal(Request $request)
  {
    $cek = Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->first();
    if ($cek != "") {
      Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->delete();
      return 'N';
    } else {
      $query = new Distribusisoal;
      $query->id_soal = $request->id_soal;
      $query->id_kelas = $request->id_kelas;
      $query->save();
      return 'Y';
    }
  }
  public function hapusGambarMateri(Request $request)
  {
    $cek = Materi::where('id', $request->id)->first();
    if ($cek != "") {
      unlink('assets/img/materi/' . $cek->gambar);
      unlink('assets/img/materi/thumb/' . $cek->gambar);
      $cek->gambar = '';
      $cek->save();
    }
  }
  public function simpanGambarUser(Request $request)
  {
    $id = $request->id_user_gambar;
    $filename = trim(addslashes($_FILES['file']['name']));
    $filenamehapusspasi = str_replace(' ', '_', $filename);
    $savename = md5(round(microtime(true))) . '_' . $filenamehapusspasi;
    $img = Image::make($_FILES['file']['tmp_name']);
    $img->resize(350, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $img->save('assets/img/user/' . $savename);
    $cek = User::where('id', $id)->first();
    if ($cek != "") {
      if ($cek->gambar != "") {
        unlink('assets/img/user/' . $cek->gambar);
      }
      $query = User::where('id', $id)->first();
    }
    $query->gambar = $savename;
    $query->save();
    return "ok";
  }

  public function updateProfilSekolah(Request $request)
  {
    $jenis = $request->jenisInfo;
    $query = School::first();
    $query->nama = $request->nama;
    $query->alamat = $request->alamat;
    $query->motto = $request->motto;
    $query->save();
    if ($jenis == 'nama') {
      return $request->nama;
    } elseif ($jenis == 'alamat') {
      return $request->alamat;
    } elseif ($jenis == 'motto') {
      return $request->motto;
    } else {
      return 'Something hes error.';
    }
  }

  public function updateSiswa(Request $request)
  {
    if ($request->id == 'N') {
      $query = new User;
      $query->password = bcrypt(123456);
    } else {
      $query = User::where('id', $request->id)->first();
      if ($request->password != '') {
        $query->password = bcrypt($request->password);
      }
    }
    $query->id_kelas = $request->kelas;
    $query->nama = $request->nama;
    $query->username = $request->username;
    $query->pendidikan = $request->pendidikan;
    $query->jk = $request->jk;
    $query->email = $request->email;
    $query->no_hp = $request->no_hp;
    $query->alamat = $request->alamat;
    $query->save();
    return 'ok';
  }
  
  public function updateGuru(Request $request)
  {
    if ($request->id == 'N') {
      $query = new User;
      $query->password = bcrypt(123456);
    } else {
      $query = User::where('id', $request->id)->first();
      if ($request->password != '') {
        $query->password = bcrypt($request->password);
      }
    }
    $query->nama = $request->nama;
    $query->no_induk = $request->no_induk;
    $query->jk = $request->jk;
    $query->email = $request->email;
    $query->save();
    return 'ok';
  }

  public function simpanInformasi(Request $request)
  {
    if ($request->judul == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Judul tidak boleh kosong.";
    } elseif ($request->isi == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Isi tidak boleh kosong.";
    } elseif ($request->status == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Status tidak boleh kosong.";
    }

    if ($request->id == 'N') {
      $query = new Informasi;
    } else {
      $query = Informasi::find($request->id);
    }

    $dt = Carbon::now('Asia/Jakarta');
    $tanggal = $dt->toDateString();

    if($request->hasFile('gambar')){
      if($request->hasFile('gambar')){
        $imageUpload = $request->file('gambar');
        $imageName = 'GambarInfo_'.str_replace(' ', '', $request->nama).'_' . rand() . '.' . $imageUpload->getClientOriginalExtension();
        $imagePath = public_path('/assets/img/informasi/');
        $imageUpload->move($imagePath, $imageName);
      }else{
        $imageName = null;
      }
      $query->judul = $request->judul;
      $query->isi = $request->isi;
      $query->tanggal = $tanggal;
      $query->gambar = $imageName;
      $query->status = $request->status;
      $query->save();
    } else {
      $query->judul = $request->judul;
      $query->isi = $request->isi;
      $query->tanggal = $tanggal;
      $query->status = $request->status;
      $query->save();
    }
    return 1;
  }

  // functin untuk input sesi ujian  
  public function simpanKelas(Request $request)
  {
    if (!$request->nama) {
      return 'Nama sesi tidak boleh kosong';
    }elseif (!$request->tanggal) {
      return 'Tanggal tidak boleh kosong';
    }elseif (!$request->jam_mulai) {
      return 'Jam mulai tidak boleh kosong';
    }elseif (!$request->jam_selesai) {
      return 'Jam selesai tidak boleh kosong';
    }elseif (!$request->kuota) {
      return 'Kuota tidak boleh kosong';
    }elseif (!$request->link_wa) {
      return 'Link Whatsapp tidak boleh kosong';
    }
    if ($request->id == 'N') {
      $query = new Kelas;
    } else {
      $query = Kelas::find($request->id);
    }
    $query->id_wali = 1;
    $query->nama = $request->nama;
    $query->tanggal = $request->tanggal;
    $query->jam_mulai = $request->jam_mulai;
    $query->jam_selesai = $request->jam_selesai;
    $query->kuota = $request->kuota;
    $query->link_wa = $request->link_wa;
    if ($query->save()) {
      return 1;
    }
  }

  public function deleteInformasi(Request $request)
  {
    Informasi::where('id', $request->id_informasi)->delete();
    return 1;
  }

  public function deleteKelas(Request $request)
  {
    User::where('id_kelas', $request->id_kelas)->update(['id_kelas' => '']);
    Kelas::find($request->id_kelas)->delete();
    return 1;
  }

  public function deleteGuru(Request $request)
  {
    User::where('id', $request->id_guru)->delete();
    return 1;
  }

  public function deleteSiswa(Request $request)
  {
    User::where('id', $request->id_siswa)->delete();
    return 1;
  }

  public function simpanSiswa(Request $request)
  {
    if ($request->nama == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama tidak boleh kosong.";
    } elseif ($request->id_kelas == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Sesi tidak boleh kosong.";
    } elseif ($request->username == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Username tidak boleh kosong.";
    } elseif ($request->pendidikan == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Pendidikan tidak boleh kosong.";
    } elseif ($request->jk == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Jenis kelamin tidak boleh kosong.";
    } elseif ($request->email == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak boleh kosong.";
    } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak valid.";
    } elseif ($request->no_hp == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> No. HP tidak boleh kosong.";
    } elseif ($request->alamat == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Alamat tidak boleh kosong.";
    }

    $query = new User;

    if($request->hasFile('gambar') || $request->hasFile('bukti_transfer')){
      if($request->hasFile('gambar')){
        $imageUploadFoto = $request->file('gambar');
        $imageNameFoto = 'Foto_'.str_replace(' ', '', $request->nama).'_' . rand() . '.' . $imageUploadFoto->getClientOriginalExtension();
        $imagePathFoto = public_path('/assets/img/user/');
        $imageUploadFoto->move($imagePathFoto, $imageNameFoto);
      }else{
        $imageNameFoto = null;
      }

      if($request->hasFile('bukti_transfer')){
        $imageUploadBT = $request->file('bukti_transfer');
        $imageNameBT = 'BT_'.str_replace(' ', '', $request->nama).'_' . rand() . '.' . $imageUploadBT->getClientOriginalExtension();
        $imagePathBT = public_path('/assets/img/user/');
        $imageUploadBT->move($imagePathBT, $imageNameBT);
      }else{
        $imageNameBT = null;
      }

      $query->id_kelas = $request->id_kelas;
      $query->nama = $request->nama;
      $query->username = $request->username;
      $query->pendidikan = $request->pendidikan;
      $query->no_induk = 1;
      $query->nisn = 12;
      $query->jk = $request->jk;
      $query->status = 'S';
      $query->status_sekolah = 'Y';
      $query->email = $request->email;
      $query->no_hp = $request->no_hp;
      $query->alamat = $request->alamat;
      $query->gambar = $imageNameFoto;
      $query->bukti_transfer = $imageNameBT;
      $query->password = bcrypt(123456);
      $query->save();
    } else {
      $query->id_kelas = $request->id_kelas;
      $query->nama = $request->nama;
      $query->username = $request->username;
      $query->pendidikan = $request->pendidikan;
      $query->no_induk = 1;
      $query->nisn = 12;
      $query->jk = $request->jk;
      $query->status = 'S';
      $query->status_sekolah = 'Y';
      $query->email = $request->email;
      $query->no_hp = $request->no_hp;
      $query->alamat = $request->alamat;
      $query->password = bcrypt(123456);
      $query->save();
    }
    return 1;
  }

  public function updateImgSiswa(Request $request)
  {
    $file_upload_url_img = trim(addslashes($_FILES['upload_url_img']['name']));
    $ext = pathinfo($file_upload_url_img, PATHINFO_EXTENSION);
    $save_url_img = auth()->user()->id . '_' . uniqid() . '.' . $ext;
    $img_url_img = Image::make($_FILES['upload_url_img']['tmp_name']);
    $img_url_img->resize(650, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    if (!file_exists('assets/img/user/')) {
      mkdir('assets/img/user/', 0777, true);
    }
    if ($img_url_img->save('assets/img/user/' . $save_url_img)) {
      $query = User::findorfail($request->id);
      if (file_exists(app_path("assets/img/user/" . $query->gambar))) {
        unlink("assets/img/user/" . $query->gambar);
      }
      $query->gambar = $save_url_img;
      if ($query->save()) {
        return 1;
      }
    }
  }

  public function simpanSiswaViaExcel(Request $request)
  {
    if ($request->hasFile('file')) {
      $kesalahan = '';
      $baris = 1;
      $sukses = 0;
      $gagal = 0;
      $jumlah = 0;
      FacadesExcel::load($request->file('file'), function ($reader) use ($kesalahan, $baris, $sukses, $gagal, $jumlah) {
        $results = $reader->get();
        $jumlah = count($results);
        foreach ($results as $value) {
          if (!$value->nama_lengkap) {
            $kesalahan .= '<br>- Nama Siswa kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
          }
          if (!$value->no_induk) {
            $kesalahan .= '<br>- No Induk/NIS kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
          }
          if (!$value->jenis_kelamin) {
            $kesalahan .= '<br>- Jenis kelamin siswa kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
          }
          $cek_user = User::where('no_induk', $value['no_induk'])->first();
          if (!$cek_user) {
            $query = new User;
            $query->id_kelas = $value['id_kelas'];
            $query->nama = addslashes($value['nama_lengkap']);
            $query->no_induk = $value['no_induk'];
            $query->nisn = $value['nisn'];
            $query->jk = $value['jenis_kelamin'];
            $query->status = 'S';
            $query->status_sekolah = 'Y';
            $query->email = trim(strtolower($value['no_induk'])) . '@ayosinau.com';
            $query->password = bcrypt(123456);
            if ($query->save()) {
              $sukses = $sukses + 1;
            }
          }
        }
        $aktifitas = new Aktifitas;
        $aktifitas->id_user = auth()->user()->id;
        $aktifitas->nama = 'Mengupload data siswa via Excel. Jumlah data ' . $jumlah . ', sukses diupload sebanyak: ' . $sukses . ' dan gagal diupload sebanyak: ' . $gagal;
        $aktifitas->save();
      });
      return view('siswa.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
    } else {
      return redirect()->route('siswa');
    }
  }

  public function resetUjian(Request $request)
  {
    $jawab = Jawab::findorfail($request->id_ujian);
    Jawab::where('id_soal', $jawab->id_soal)
      ->where('id_user', $jawab->id_user)
      ->where('id_kelas', $jawab->id_kelas)
      ->delete();
    $siswa = User::findorfail($jawab->id_user);
    $aktifitas = new Aktifitas;
    $aktifitas->id_user = auth()->user()->id;
    $aktifitas->nama = 'Mereset data nilai siswa atas nama: ' . $siswa->nama;
    $aktifitas->save();
  }
}
