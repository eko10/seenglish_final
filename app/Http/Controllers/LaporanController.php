<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Excel;
use PDF;
use DataTables;

use App\User;
use App\Models\Jawab;
use App\Models\Soal;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Detailsoal;
use App\Models\DetailSoalEssay;
use App\Models\JawabEsay;
use App\Models\Keuangan;

class LaporanController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $kelas = Kelas::orderBy('nama', 'ASC')->paginate(20);
      return view('laporan.index', compact('user', 'kelas'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function keuanganIndex()
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $keuangan = Keuangan::all();
      return view('laporan.keuangan.index', compact('user', 'keuangan'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function detailKelas(Request $request)
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $kelas = Kelas::where('id', $request->id)->first();
      return view('laporan.detailKelas', compact('user', 'kelas'));
    } else {
      return redirect()->route('home.index');
    }
  }
  public function data_paket_soal(Request $request)
  {
    $hasils = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
      ->select('soals.paket', 'jawabs.*')
      ->where('jawabs.id_kelas', $request->id_kelas)->groupBy('jawabs.id_soal')->get();
    return Datatables::of($hasils)
      ->addColumn('action', function ($hasils) {
        return '<div style="text-align:center"><a href="' . $hasils->id_kelas . '/paket-soal/' . $hasils->id_soal . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->make(true);
  }
  public function detailPaketSoalPerKelas(Request $request)
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $kelas = Kelas::where('id', $request->id_kelas)->first();
      $soal = Soal::where('id', $request->id_soal)->first();
      return view('laporan.detailKelasPaket', compact('user', 'kelas', 'soal'));
    } else {
      return redirect()->route('home.index');
    }
  }
  public function dataKelasPaketSoal(Request $request)
  {
    $jawabs = Jawab::select('jawabs.*', DB::raw('sum(score) as jumlah_nilai'))
      ->where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->groupBy('id_user');
    return Datatables::of($jawabs)
      ->addColumn('nama', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->nama;
        } else {
          return 'no name';
        }
      })
      ->addColumn('nis', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->no_induk;
        } else {
          return 'no nis';
        }
      })
      ->addColumn('nisn', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->nisn;
        } else {
          return 'no nisn';
        }
      })
      ->addColumn('email', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->email;
        } else {
          return 'no email';
        }
      })
      ->addColumn('no_hp', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->no_hp;
        } else {
          return 'no nomor hp';
        }
      })
      ->addColumn('jumlah_nilai', function ($jawabs) {
        return $jawabs->jumlah_nilai;
      })
      ->addColumn('action', function ($jawabs) {
        return '<div style="text-align:center"><a href="../../../' . $jawabs->id_soal . '/' . $jawabs->id_user . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->make(true);
  }
  public function dataSiswa(Request $request)
  {
    $jawabs = Jawab::select('jawabs.*', DB::raw('sum(score) as jumlah_nilai'))
      ->where('id_user', $request->id_user)
      ->groupBy('id_soal')
      ->get();
    return Datatables::of($jawabs)
      ->addColumn('kelas', function ($jawabs) {
        if ($jawabs->kelas) {
          return $jawabs->kelas->nama;
        } else {
          return 'no sesi';
        }
      })
      ->addColumn('soal', function ($jawabs) {
        if ($jawabs->soal) {
          return $jawabs->soal->paket;
        } else {
          return 'no paket';
        }
      })
      ->addColumn('nama', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->nama;
        } else {
          return 'no name';
        }
      })
      ->addColumn('email', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->email;
        } else {
          return 'no email';
        }
      })
      ->addColumn('no_hp', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->no_hp;
        } else {
          return 'no nomor hp';
        }
      })
      ->addColumn('jumlah_nilai', function ($jawabs) {
        return $jawabs->jumlah_nilai;
      })
      ->addColumn('action', function ($jawabs) {
        $id = $jawabs->user->id;
        $nama = $jawabs->user->nama;
        $kelas = $jawabs->kelas->nama;
        if($jawabs->jumlah_nilai > 0){
          return "<center><a target='_blank' href='cetak/pdf/sertifikat-ujian-persiswa/$id/$jawabs->id_soal' class='btn btn-warning btn-md' data-toggle='tooltip' title='Cetak sertifikat untuk peserta an. $nama - $kelas '><i class='fa fa-file-pdf-o'></i> Cetak Sertifikat</a></center>";
        }else{
          return "<center>-</center>";
        }
      })
      ->make(true);
  }
  public function laporanKeuangan(Request $request)
  {
    $keuangan = Keuangan::latest()->get();
    return Datatables::of($keuangan)
      ->addColumn('posisi', function ($keuangan) {
        if ($keuangan->posisi) {
          if ($keuangan->posisi == 'M') {
            return "<center><span class='label label-success'>Masuk</span></center>";
          } else {
            return "<center><span class='label label-danger'>Keluar</span></center>";
          }
        } else {
          return 'no posisi';
        }
      })
      ->addColumn('keterangan', function ($keuangan) {
        if ($keuangan->keterangan) {
          return $keuangan->keterangan;
        } else {
          return 'no keterangan';
        }
      })
      ->addColumn('tanggal', function ($keuangan) {
        if ($keuangan->tanggal) {
          return '<center>'. $keuangan->tanggal .'<center>';
        } else {
          return 'no tanggal';
        }
      })
      ->addColumn('nominal', function ($keuangan) {
        return number_format($keuangan->nominal, 2, ",", ".");
      })
      ->rawColumns(['posisi', 'tanggal'])
      ->make(true);
  }
  public function detailLaporanSiswa(Request $request)
  {
    if (auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $siswa = User::where('id', $request->id_user)->first();
      $soal = Soal::select('paket', 'id')->where('id', $request->id_soal)->first();
      $hasil_ujian = Jawab::select(DB::raw('SUM(jawabs.score) as jumlah_nilai'), 'jawabs.created_at', 'jawabs.status')
        ->where('jawabs.id_user', $request->id_user)
        ->where('jawabs.id_soal', $request->id_soal)
        ->first();
      $soal_essay = DetailSoalEssay::where('id_soal', $request->id_soal)->get();
      $nilai_essay = 0;
      if ($soal_essay->count() > 0) {
        foreach ($soal_essay as $essay) {
          $nilai_essay = $nilai_essay + ($essay->getJawab->score ?? 0);
        }
      }

      return view('laporan.detailSiswa', compact('user', 'siswa', 'hasil_ujian', 'soal', 'soal_essay', 'nilai_essay'));
    } else {
      return redirect()->route('home.index');
    }
  }
  public function hasilSiswa(Request $request)
  {
    $jawabs = Jawab::where('jawabs.id_user', $request->id_user);
    return Datatables::of($jawabs)
      ->addColumn('empty_space', function () {
        return '&nbsp;';
      })
      ->addColumn('dataSoal', function ($jawabs) {
        if ($jawabs->detailSoal) {
          return $jawabs->detailSoal->soal;
        } else {
          return 'No have question';
        }
      })
      ->addColumn('kunci', function ($jawabs) {
        if ($jawabs->detailSoal) {
          return $jawabs->detailSoal->kunci;
        } else {
          return 'No have question';
        }
      })
      ->rawColumns(['dataSoal'])
      ->make(true);
  }
  public function excelHasilUjianPerkelas(Request $request)
  {
    $kelas = Kelas::where('id', $request->kelas)->first();
    $soal = Soal::where('id', $request->soal)->first();
    $detailSoal = Detailsoal::where('id_soal', $request->soal)->get();
    $jawabs = Jawab::where('id_soal', $request->soal)->where('id_kelas', $request->kelas)
      ->groupBy('id_user')->get();
    $soal_essay = DetailSoalEssay::where('id_soal', $request->soal)->get();
    Excel::create('Nilai Kelas ' . $kelas->nama, function ($excel) use ($jawabs, $soal, $kelas, $detailSoal, $soal_essay) {
      $excel->sheet('New sheet', function ($sheet) use ($jawabs, $soal, $kelas, $detailSoal, $soal_essay) {
        $sheet->setStyle(array(
          'font' => array(
            'size' =>  12,
          )
        ));
        $sheet->loadView('laporan.excel.excel_hasil_ujian_perkelas', compact('jawabs', 'soal', 'kelas', 'detailSoal', 'soal_essay'));
      });
    })->download('xlsx');
  }
  public function pdfHasilUjianPersiswa(Request $request)
  {
    $siswa = User::where('id', $request->siswa)->first();
    $jumlah_soal = Detailsoal::where('id_soal', $request->soal)->count();
    $soals = Detailsoal::where('id_soal', $request->soal)->where('status', 1)->get();
    $jawabs = Jawab::where('id_soal', $request->soal)->where('id_user', $request->siswa)->where('status', 1)->get();
    $jawabBenar = Jawab::where('id_soal', $request->soal)->where('id_user', $request->siswa)->where('status', 1)->where('score', '!=', '0')->get();
    $jawab_first = Jawab::where('id_soal', $request->soal)
      ->where('id_user', $request->siswa)
      ->where('status', 1)->first();
    $jumlah_jawaban_benar = Jawab::where('id_soal', $request->soal)
      ->where('id_user', $request->siswa)
      ->where('status', 1)
      ->select(DB::raw('sum(jawabs.score) as jumlahNilai'))
      ->first();
    $pdf = PDF::loadView('laporan.pdf.hasil_ujian', compact('jawabs', 'siswa', 'soals', 'jawabBenar', 'jumlah_jawaban_benar', 'jawab_first', 'jumlah_soal'));
    return $pdf->setPaper('legal')->stream('hasil ujian.pdf');
  }
  public function pdfSertifikatUjianPersiswaLama(Request $request)
  {
    $siswa = User::where('id', $request->siswa)->first();
    $jawab_first = Jawab::where('id_soal', $request->soal)
      ->where('id_user', $request->siswa)
      ->where('status', 1)->first();
    $jumlah_jawaban_benar = Jawab::where('id_soal', $request->soal)
      ->where('id_user', $request->siswa)
      ->where('status', 1)
      ->select(DB::raw('sum(jawabs.score) as jumlahNilai'))
      ->first();
    $pdf = PDF::loadView('laporan.pdf.sertifikat_ujian', compact('siswa', 'jumlah_jawaban_benar', 'jawab_first'));
    return $pdf->setPaper('legal')->stream('sertifikat ujian.pdf');
  }
  public function pdfSertifikatUjianPersiswa($id)
  {
    $siswa = User::where('id', auth()->user()->id)->first();
    $nilai = Nilai::where('id', $id)->first();
    $pdf = PDF::loadView('laporan.pdf.sertifikat_ujian', compact('siswa', 'nilai'));
    return $pdf->setPaper('legal')->stream('Sertifikat Ujian - '.$siswa->nama.'.pdf');
  }
  public function pdfLaporanKeuangan(Request $request)
  {
    $user = User::where('id', $request->user)->first();
    $keuangan = Keuangan::all();
    $keuangan_masuk = Keuangan::where('posisi', 'M')->sum('nominal');
    $keuangan_keluar = Keuangan::where('posisi', 'K')->sum('nominal');
    $pdf = PDF::loadView('laporan.pdf.laporan_keuangan', compact('user', 'keuangan', 'keuangan_masuk', 'keuangan_keluar'));
    return $pdf->setPaper('legal')->stream('Laporan Keuangan.pdf');
  }

}
