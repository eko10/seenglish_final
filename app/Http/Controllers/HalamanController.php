<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Models\Kelas;
use Carbon\Carbon;
use DataTables;

Carbon::setLocale('id');

class HalamanController extends Controller
{

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('halaman', [
      'sesi' => Kelas::latest()->where('tanggal', '>', Carbon::today()->toDateString())->get(),
      'iter' => 1
    ]);
  }
}
