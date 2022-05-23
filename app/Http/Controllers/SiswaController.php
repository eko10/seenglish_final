<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDF;
use Hash;
use Auth;
use DataTables;
use App\User;
use App\Models\Soal;
use App\Models\Payment;
use App\Models\Keuangan;
use App\Models\Nilai;
use App\Models\Jawab;
use App\Models\Kelas;
use App\Models\Distribusisoal;
use App\Models\Detailsoal;
use App\Models\DetailSoalEssay;
use App\Models\JawabEsay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SiswaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $kelas = Kelas::get();
      $peserta = User::where('status', 'S')->orderBy('nama', 'asc')->get();

      return view('siswa.index', compact('user', 'kelas', 'peserta'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function editSiswa(Request $request)
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $siswa = User::where('id', $request->id)->first();
      $kelas = Kelas::select('id', 'nama')->get();
      return view('siswa.form.ubah', compact('user', 'siswa', 'kelas'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function dataSiswa()
  {
    $siswas = User::select('users.*', 'payments.status AS status_payment')->join('payments', 'payments.id', '=', 'users.payment_id')->where('users.status', 'S')->latest()->get();
    if (auth()->user()->status == 'G') {
      return Datatables::of($siswas)
        ->addColumn('kelas', function ($siswas) {
          return 'ini kelas';
        })
        ->editColumn('jk', function ($siswas) {
          if ($siswas->jk == 'L') {
            return 'Laki-laki';
          } else {
            return 'Perempuan';
          }
        })
        ->addColumn('kelas', function ($siswas) {
          if ($siswas->getKelas) {
            return $siswas->getKelas->nama;
          } else {
            return "-";
          }
        })
        ->addColumn('action', function ($siswas) {
          return '<div style="text-align:center"><a href="siswa/detail/' . $siswas->id . '" class="btn btn-xs btn-success">Detail</a></div>';
        })
        ->make(true);
    } elseif (auth()->user()->status == 'A') {
      return Datatables::of($siswas)
        ->addColumn('kelas', function ($siswas) {
          return 'ini kelas';
        })
        ->editColumn('jk', function ($siswas) {
          if ($siswas->jk == 'L') {
            return 'Laki-laki';
          } else {
            return 'Perempuan';
          }
        })
        ->addColumn('kelas', function ($siswas) {
          if ($siswas->getKelas) {
            return $siswas->getKelas->nama;
          } else {
            return "-";
          }
        })
        ->editColumn('status_validasi', function ($siswas) {
          if ($siswas->status_validasi != 'Y') {
            return "<center><span class='label label-warning'>Belum Divalidasi</span></center>";
          } else {
            return "<center><span class='label label-success'>Sudah Divalidasi</span></center>";
          }
        })
        ->editColumn('status_pembayaran', function ($siswas) {
          if ($siswas->status_payment == 'settlement') {
            return "<center><span class='label label-success'>Paid</span></center>";
          } else if ($siswas->status_payment == 'pending') {
            return "<center><span class='label label-warning'>Pending</span></center>";
          } else {
            return "<center><span class='label label-danger'>" . $siswas->status_payment . "</span></center>";
          }
        })
        ->addColumn('action', function ($siswas) {
          return '<div style="text-align:center">
                    <a href="siswa/detail/' . $siswas->id . '" class="btn btn-xs btn-success">Detail</a>
                  </div>';
        })
        ->rawColumns(['status_validasi', 'status_pembayaran', 'action'])
        ->make(true);
    }
  }

  public function detailSiswa(Request $request)
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      // $siswa = User::select('users.*', 'payments.status AS status_payment')->join('payments', 'payments.id', '=', 'users.payment_id')->where('users.id', $request->id)->first();
      $siswa = User::find($request->id);

      return view('siswa.detail', compact('user', 'siswa'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function validasi(Request $request)
  {
    if (auth()->user()->status == 'A') {
      $query = User::where('id', $request->id)->first();
      $kelas = Kelas::where('id', $query->id_kelas)->first();

      $data["email"] = $query->email;
      $data["title"] = "Pendaftaran Berhasil";
      $data["body"] = "Pembayaran anda telah divalidasi, berikut adalah link whatsapp dan kartu ujian anda";
      $data["text"] = $kelas->link_wa;

      $pdf = PDF::loadView('pdf.kartu_ujian', ['peserta' => $query]);
      $pdf2 = PDF::loadView('pdf.tata_cara');
    
      Mail::send('emails.send_mail', $data, function($message) use ($data, $pdf, $pdf2) {
          $message->to($data["email"])
                  ->subject($data["title"])
                  ->attachData($pdf->output(), "Kartu Ujian.pdf")
                  ->attachData($pdf2->output(), "Tata Cara Ujian.pdf");
      });
      return redirect('master/siswa/detail/' . $request->id)->withSuccess('Data berhasil divalidasi');
    } else {
      return redirect()->route('home.index');
    }
  }

  // function untuk daftar ujian
  public function daftarUjian()
  {
    if (auth()->user()->status == 'S') {
      $dt = Carbon::now('Asia/Jakarta');
      $sekarang = $dt->toTimeString();
      $datetime_sekarang = $dt->toDateTimeString();
      $user = User::where('id', auth()->user()->id)->first();
      $kelas = Kelas::select('kelas.*')->where('kelas.tanggal', '>', $dt->toDateString())->get();
      if ($user->payment_id != null) {
        $payment = Payment::where('id', $user->payment_id)->first();
        if($datetime_sekarang > $payment->payment_until){
          $user->id_kelas = null;
          $user->payment_id = null;
          $user->status_validasi = 'N';
          $user->status_ujian = 'Tidak Terdaftar';
          $user->token_ujian = null;
          $user->save();
        }
        $payment_status = $payment->status;
        $payment_until = $payment->payment_until;
      } else {
        $payment_status = null;
        $payment_until = null;
      }
      return view('halaman-siswa.daftar_ujian', ['user' => $user, 'kelas' => $kelas, 'payment' => $payment_status, 'tgl_sekarang' => $dt->toDateString(), 'jam_sekarang' => $sekarang, 'batas' => $payment_until]);
    } else {
      return redirect()->route('home.index');
    }
  }

  public function payment(Request $request)
  {
    if (auth()->user()->status == 'S') {
      $user = User::where('id', '=', $request->id)->first();
      $kelas = Kelas::where('id', '=', $request->kelas)->first();

      // set nominal pembayaran pendaftaran ujian
      $nominal = 10000;

      $peserta = User::where('status', 'S')->where('id_kelas', $kelas->id)->count();
      $sisa_kuota = $kelas->kuota - $peserta;
      if ($sisa_kuota <= 0) {
        return redirect(url('siswa/daftar-ujian'))->with('alert-failed', 'Kuota pada sesi yang anda pilih telah penuh, silahkan pilih sesi yang lain.');
      } else {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        // \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $params = array(
          'transaction_details' => array(
            'order_id' => rand(),
            'gross_amount' => $nominal,
          ),
          'item_details' => array(
            [
              'id' => $kelas->id . '-' . $user->id,
              'price' => $nominal,
              'quantity' => 1,
              'name' => "Pembayaran Ujian Sesi " . $kelas->nama
            ]
          ),
          'customer_details' => array(
            'first_name' => $user->nama,
            'email' => $user->email,
            'phone' => $user->no_hp,
          ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('halaman-siswa.pembayaran_ujian', ['user' => $user, 'kelas' => $kelas, 'nominal' => $nominal, 'snap_token' => $snapToken]);
      }
    } else {
      return redirect()->route('home.index');
    }
  }

  public function paymentPost(Request $request)
  {
    $json = json_decode($request->get('json'));
    $kelas = Kelas::where('id', '=', $request->get('kelas'))->first();
    $peserta = User::where('status', 'S')->where('id_kelas', $kelas->id)->count();
    $sisa_kuota = $kelas->kuota - $peserta;
    $dt = Carbon::now('Asia/Jakarta');
    $sekarang = $dt->toTimeString();
    $payment_until = $dt->add(1, 'day');
    if ($sisa_kuota <= 0) {
      return redirect(url('siswa/daftar-ujian'))->with('alert-failed', 'Kuota pada sesi yang anda pilih telah penuh, silahkan pilih sesi yang lain.');
    } else {
      $payment = new Payment();
      $payment->status = $json->transaction_status;
      $payment->uname = $request->get('uname');
      $payment->email = $request->get('email');
      $payment->number = $request->get('number');
      $payment->transaction_id = $json->transaction_id;
      $payment->order_id = $json->order_id;
      $payment->gross_amount = $json->gross_amount;
      $payment->payment_type = $json->payment_type;
      $payment->payment_code = isset($json->payment_code) ? $json->payment_code : null;
      $payment->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
      $payment->payment_until = $payment_until;
      $payment->save();

      $user = User::where('email', '=', Auth::user()->email)->first();
      $user->id_kelas = $request->get('kelas');
      $user->status_ujian = 'Tidak Terdaftar';
      $user->payment_id = $payment->id;

      return $user->save() ? redirect(url('siswa/daftar-ujian')) : redirect(url('siswa/daftar-ujian'))->with('alert-failed', 'Terjadi kesalahan');
    }
  }
  public function kirimEmailMin1Jam(Request $request)
  {
    $data["email"] = $request->email;
    $data["title"] = "Pembayaran belum selesai";
    $data["body"] = "";
    $data["text"] = "Pembayaran ujian anda pada ". $request->sesi ." (". $request->tanggal .") belum selesai, mohon untuk segera melakukan pembayaran";

    Mail::send('emails.send_mail', $data, function($message) use ($data) {
      $message->to($data["email"])->subject($data["title"]);
    });

    return redirect(url('siswa/daftar-ujian'));
  }

  public function resetPendaftaranUjian(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    $user->id_kelas = null;
    $user->payment_id = null;
    $user->status_validasi = 'N';
    $user->status_ujian = 'Tidak Terdaftar';
    $user->token_ujian = null;
    $user->save();

    return redirect(url('siswa/daftar-ujian'));
  }

  public function historyUjianLama()
  {
    $user = User::where('id', auth()->user()->id)->first();
    $pakets = Distribusisoal::where('id_kelas', auth()->user()->id_kelas)->get();
    return view('halaman-siswa.history_ujian', compact('user', 'pakets'));
  }

  public function historyUjian()
  {
    $user = User::where('id', auth()->user()->id)->first();
    $nilai = DB::table('nilais')->join('users', 'users.id', '=', 'nilais.id_user')->join('kelas', 'kelas.id', '=', 'nilais.id_kelas')->select('nilais.*', 'kelas.nama AS kelas', 'kelas.tanggal')->where('nilais.id_user', auth()->user()->id)->get();
    return view('halaman-siswa.history_ujian', compact('user', 'nilai'));
  }

  public function ujian()
  {
    $user = User::where('id', auth()->user()->id)->first();
    return view('halaman-siswa.ujian_cek_token', compact('user'));
  }

  public function cekTokenUjian(Request $request)
  {
    if (auth()->user()->status == 'S') {
      $token = auth()->user()->email . ' - ' . auth()->user()->id_kelas;
      if (md5($token) == $request->token) {
        $sesi = Kelas::where('id', auth()->user()->id_kelas)->first();
        $user = User::where('id', auth()->user()->id)->first();
        $pakets = Distribusisoal::where('id_kelas', auth()->user()->id_kelas)->get();
        $dt = Carbon::now('Asia/Jakarta');
        $sekarang = $dt->toTimeString();
        $jam_mulai = $sesi->jam_mulai;
        $jam_selesai = $sesi->jam_selesai;
        if ($sesi->tanggal == $dt->toDateString() && $sekarang > $jam_mulai && $sekarang < $jam_selesai) {
          return view('halaman-siswa.ujian', compact('user', 'pakets'));
        } else {
          return view('halaman-siswa.belum_mulai', compact('user', 'pakets', 'sesi'));
        }
      } else {
        return redirect()->back()->withErrors('Token tidak valid')->withInput();
      }
    } else {
      return redirect()->route('home.index');
    }
  }

  public function detailUjian($id)
  {
    $check_soal = Distribusisoal::where('id_soal', $id)->where('id_kelas', auth()->user()->id_kelas)->first();
    if ($check_soal) {
      $soal = Soal::with('detail_soal_essays')->where('id', $id)->first();
      $soals = Detailsoal::where('id_soal', $id)->where('status', 'Y')->get();
      return view('halaman-siswa.detail_ujian', compact('soal', 'soals'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function getSoal($id)
  {
    $soal = Detailsoal::find($id);
    return view('halaman-siswa.get_soal', compact('soal'));
  }

  public function jawab(Request $request)
  {
    $get_jawab = explode('/', $request->get_jawab);
    $pilihan = $get_jawab[0];
    $id_detail_soal = $get_jawab[1];
    $id_siswa = $get_jawab[2];
    $detail_soal = Detailsoal::find($id_detail_soal);

    $jawab = Jawab::where('no_soal_id', $id_detail_soal)->where('id_user', auth()->user()->id)->first();
    if (!$jawab) {
      $jawab = new Jawab;
      $jawab->revisi = 0;
    } else {
      $jawab->revisi = $jawab->revisi + 1;
    }

    $jawab->no_soal_id = $id_detail_soal;
    $jawab->id_soal = $detail_soal->id_soal;
    $jawab->id_user = auth()->user()->id;
    $jawab->id_kelas = auth()->user()->id_kelas;
    $jawab->nama = auth()->user()->nama;
    $jawab->pilihan = $pilihan;

    $check_jawaban = Detailsoal::where('id', $id_detail_soal)->where('kunci', $pilihan)->first();
    if ($check_jawaban) {
      $jawab->score = $detail_soal->score;
    } else {
      $jawab->score = 0;
    }
    $jawab->status = 0;
    $jawab->save();
    return 1;
  }

  public function kirimJawaban(Request $request)
  {
    Jawab::where('id_soal', $request->id_soal)->where('id_user', auth()->user()->id)->update(['status' => 1]);
    $query = User::where('id', auth()->user()->id)->first();
    $query->status_ujian = 'Tidak Terdaftar';
  }

  public function finishUjian($id)
  {
    $soal = Soal::find($id);
    $nilai = Jawab::where('id_soal', $id)->where('id_user', auth()->user()->id)->sum('score');
    return view('halaman-siswa.finish', compact('soal', 'nilai'));
  }

  public function delete()
  {
    return view('siswa.delete');
  }

  public function getBtnDelete($password)
  {
    $validate_admin = User::where('email', auth()->user()->email)->first();
    if ($validate_admin && Hash::check($password, $validate_admin->password)) {
      $cocok = 'Y';
    } else {
      $cocok = 'N';
    }
    return view('siswa.tombol_hapus', compact('cocok'));
  }

  public function deleteAll()
  {
    $users = User::where('status', 'S')->get();
    foreach ($users as $key => $value) {
      $jawab = Jawab::where('id_user', $value->id)->first();
      if ($jawab) {
        $jawab->delete();
      }
    }
    User::where('status', 'S')->delete();
  }

  public function getDetailEssay(Request $request)
  {
    $soal_essay = DetailSoalEssay::with('userJawab')->find($request->id_soal_esay);
    return view('halaman-siswa.get_soal_essay', compact('soal_essay'));
  }

  public function simpanJawabanEssay(Request $request)
  {
    if ($request->jawab_essay == '' || $request->jawab_essay == null) {
      return '';
    }
    $check_jawaban = JawabEsay::where('id_user', auth()->user()->id)->where('id_detail_soal_esay', $request->id_soal_esay)->first();
    if (!$check_jawaban) {
      $save = new JawabEsay;
      $save->id_detail_soal_esay = $request->id_soal_esay;
      $save->id_user = auth()->user()->id;
    } else {
      $save = $check_jawaban;
    }
    $save->jawab = $request->jawab_essay;
    if ($save->save()) {
      return 1;
    }
  }

  //filter nilai berdasarkan sesi
  public function filterSiswaSesi(Request $request)
  {
    if (auth()->user()->status == 'A') {

      $user = User::where('id', auth()->user()->id)->first();
      $kelas = Kelas::get();

      if ($request->sesi == 'semua') {
        $peserta = User::where('status', 'S')->orderBy('nama', 'asc')->get();

        return view('siswa.index', compact('user', 'peserta', 'kelas'));
      } else {
        $peserta = User::where('id_kelas', $request->sesi)->orderBy('id', 'ASC')->get();

        return view('siswa.index', compact('user', 'peserta', 'kelas'));
        // if ($peserta) {
        //   return view('siswa.index', compact('user', 'peserta', 'kelas'));
        // } else {
        //   $peserta = User::where('status', 'S')->orderBy('nama', 'asc')->get();
        //   return view('siswa.index', compact('user', 'kelas', 'peserta'));
        // }
      }
    } else {
      return redirect()->route('home.index');
    }
  }
}
