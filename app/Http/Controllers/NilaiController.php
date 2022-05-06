<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Excel;
use DataTables;

use Illuminate\Http\Request;
use App\User;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Keuangan;
use App\Exports\NilaiPerSesiExportMapping;
use App\Imports\NilaisImport;

class NilaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->status == 'A') {
        $user = User::where('id', auth()->user()->id)->first();
        $nilai = Nilai::get();
            return view('nilai.index', compact('user', 'nilai'));
        } else {
            return redirect()->route('home.index');
        }
    }

    public function dataNilai()
    {
        $nilai = DB::table('nilais')->join('users', 'users.id', '=', 'nilais.id_user')->join('kelas', 'kelas.id', '=', 'nilais.id_kelas')->select('nilais.*', 'users.nama AS peserta', 'kelas.nama AS kelas', 'kelas.tanggal')->get();
        return Datatables::of($nilai)
            ->addColumn('peserta', function ($nilai) {
                return $nilai->peserta;
            })
            ->addColumn('kelas', function ($nilai) {
                return $nilai->kelas." (".$nilai->tanggal.")";
            })
            ->editColumn('nilai_reading', function ($nilai) {
                if ($nilai->nilai_reading == null) {
                    return "<center><span class='label label-danger'>Belum Terisi</span></center>";
                } else {
                    return "<center>".$nilai->nilai_reading."</center>";
                }
            })
            ->editColumn('nilai_writing', function ($nilai) {
                if ($nilai->nilai_writing == null) {
                    return "<center><span class='label label-danger'>Belum Terisi</span></center>";
                } else {
                    return "<center>".$nilai->nilai_writing."</center>";
                }
            })
            ->editColumn('nilai_listening', function ($nilai) {
                if ($nilai->nilai_listening == null) {
                    return "<center><span class='label label-danger'>Belum Terisi</span></center>";
                } else {
                    return "<center>".$nilai->nilai_listening."</center>";
                }
            })
            ->editColumn('nilai_total', function ($nilai) {
                if ($nilai->nilai_total == null) {
                    return "<center><span class='label label-danger'>Belum Terisi</span></center>";
                } else {
                    return "<center>".$nilai->nilai_total."</center>";
                }
            })
            ->addColumn('action', function ($nilai) {
                if ($nilai->nilai_reading != null && $nilai->nilai_writing != null && $nilai->nilai_listening != null && $nilai->nilai_total != null) {
                    if ($nilai->nilai_total >= 450) {
                        if ($nilai->status_pengeluaran == 'N') {
                            return '<div style="text-align:center">
                                        <a href="nilai/pengeluaran/' . $nilai->id . '" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Biaya Penerbitan Sertifikat</a>
                                    </div>';
                        } else {
                            return '<div style="text-align:center">
                                        <a href="nilai/cetak/pdf/sertifikat/'. $nilai->id_user .'/'. $nilai->id_kelas .'" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-file-pdf-o"></i> Cetak Setifikat</a>
                                    </div>';
                        }
                    } else {
                        return '<center>-</center>';
                    }
                } else {
                    return '<div style="text-align:center">
                                <a href="nilai/input/' . $nilai->id . '" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Input Nilai</a>
                            </div>';
                }
            })
            ->rawColumns(['kelas', 'nilai_reading', 'nilai_writing', 'nilai_listening', 'nilai_total', 'action'])
            ->make(true);
        
    }

    public function inputNilai($id)
    {
        if (auth()->user()->status == 'A') {
            $nilai = DB::table('nilais')->join('users', 'users.id', '=', 'nilais.id_user')->join('kelas', 'kelas.id', '=', 'nilais.id_kelas')->select('nilais.*', 'users.nama AS peserta', 'kelas.nama AS kelas')->where('nilais.id', $id)->first();
            return view('nilai.input', compact('nilai'));
        } else {
            return redirect()->route('home.index');
        }
    }

    // function proses import excel nilai peserta tes
    public function inputNilaiPost(Request $request)
    {
        if (auth()->user()->status == 'A') {
            $user = User::where('id', $request->id_user)->first();
            $nilai = Nilai::where('id', $request->id)->first();
            $nilai->nilai_reading = $request->nilai_reading;
            $nilai->nilai_writing = $request->nilai_writing;
            $nilai->nilai_listening = $request->nilai_listening;
            $nilai->nilai_total = (($nilai->nilai_reading + $nilai->nilai_writing + $nilai->nilai_listening) / 3) * 10;
            $nilai->save();

            $user->id_kelas = null;
            $user->payment_id = null;
            $user->status_validasi = 'N';
            $user->status_ujian = 'Tidak Terdaftar';
            $user->token_ujian = null;
            $user->save();

            return redirect()->route('nilai')->with(['alert-success' => 'Data berhasil diinput'])->with(['alert-failed' => 'Terjadi kesalahan']);
        } else {
            return redirect()->route('home.index');
        }
    }

    public function pengeluaran($id)
    {
        if (auth()->user()->status == 'A') {
            $nilai = DB::table('nilais')->join('users', 'users.id', '=', 'nilais.id_user')->join('kelas', 'kelas.id', '=', 'nilais.id_kelas')->select('nilais.*', 'users.nama AS peserta', 'kelas.nama AS kelas')->where('nilais.id', $id)->first();
            return view('nilai.pengeluaran', compact('nilai'));
        } else {
            return redirect()->route('home.index');
        }
    }

    // function untuk proses tambah pengeluaran
    public function pengeluaranPost(Request $request)
    {
        if (auth()->user()->status == 'A') {
            $user = User::where('id', $request->id_user)->first();
            $nilai = Nilai::where('id', $request->id)->first();
            $nilai->status_pengeluaran = 'Y';
            $nilai->save();

            $keuangan = new Keuangan;
            $keuangan->posisi = 'K';
            $keuangan->keterangan = 'Pembayaran Penerbitan Sertifikat Ujian '. $user->nama .' ('. $user->email .')';
            $keuangan->tanggal = date('Y-m-d');
            $keuangan->nominal = $request->nominal;
            $keuangan->save();

            return redirect()->route('nilai')->with(['alert-success' => 'Sertifikat a/n '.$user->nama.' berhasil diterbitkan'])->with(['alert-failed' => 'Terjadi kesalahan']);
        } else {
            return redirect()->route('home.index');
        }
    }

    public function pdfSertifikatUjian($user, $kelas)
    {
        $siswa = User::where('id', $user)->first();
        $nilai = Nilai::where('id_user', $user)->where('id_kelas', $kelas)->first();
        $pdf = PDF::loadView('laporan.pdf.sertifikat_ujian', compact('siswa', 'nilai'));
        return $pdf->setPaper('legal')->stream('Sertifikat Ujian - '.$siswa->nama.'.pdf');
    }

    public function import()
    {
        if (auth()->user()->status == 'A') {
            $user = User::where('id', auth()->user()->id)->first();
            $sesi = Kelas::get();
            return view('nilai.import', compact('user', 'sesi'));
        } else {
            return redirect()->route('home.index');
        }
    }

    // function untuk proses import nilai dengan excel
    public function importProses(Request $request)
    {
        if (auth()->user()->status == 'A') {
            Excel::toCollection(new NilaisImport(), $request->file('file_excel'));
            Excel::import(new NilaisImport($request->sesi), $request->file('file_excel'));
            return redirect()->route('nilai')->withSuccess('Data excel berhasil diimport.');
        } else {
            return redirect()->route('home.index');
        }
    }
    
}
