<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\User;
use App\Models\Soal;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Aktifitas;
use App\Models\Detailsoal;
use App\Models\School;
use App\Models\Informasi;
use Carbon\Carbon;

Carbon::setLocale('id');

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $siswas = User::where('status', 'S')->count();
    $pakets = Soal::where('jenis', 1)->count();
    $soals = Detailsoal::count();
    $sesi = Kelas::where('tanggal', '>', Carbon::today()->toDateString())->count();
    $informasi = Informasi::latest()->first();
    return view('home', compact('siswas', 'pakets', 'soals', 'informasi', 'sesi'));
  }

  public function pengaturan()
  {
    $user = User::findorfail(Auth::user()->id);
    // $sekolah = School::first();
    return view('pengaturan.index', compact('user'));
  }

  public function activity()
  {
    return view('errors.404');
  }
}
