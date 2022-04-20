<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DataTables;

use App\User;
use App\Models\Informasi;

class InformasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->status == 'A') {
            $user = User::where('id', Auth::user()->id)->first();
            $informasi = Informasi::latest()->get();
            return view('informasi.index', compact('user', 'informasi'));
        } else {
            return redirect()->route('home.index');
        }
    }
    public function dataInformasi()
    {
        $informasi = Informasi::latest()->get();
        return Datatables::of($informasi)
            ->addColumn('action', function ($informasi) {
            return '<div style="text-align:center">
                        <a href="informasi/ubah/' . $informasi->id . '" class="btn btn-xs btn-primary">Ubah</a>
                        <button type="button" class="btn btn-xs btn-danger del-informasi" id=' . $informasi->id . '>Hapus</button>
                        <a href="informasi/detail/' . $informasi->id . '" class="btn btn-xs btn-success">Detail</a>
                    </div>';
            })
            ->editColumn('gambar', function ($informasi) {
                if($informasi->gambar){
                    return '<center><img class="profile-user-img img-responsive img-rounded" src="'.url('/assets/img/informasi/'.$informasi->gambar).'" style="width: 50%"></center>';
                } else{
                    return '<center><b>-</b></center>';
                }
            })
            ->editColumn('status', function ($informasi) {
                if ($informasi->status == 'A') {
                    return "<center><span class='label label-success'>Tampil</span></center>";
                } elseif ($informasi->status == 'N') {
                    return "<center><span class='label label-danger'>Tidak Tampil</span></center>";
                } else {
                    return '<center>-</center>';
                }
            })
            ->rawColumns(['action', 'gambar', 'status'])
            ->make(true);
    }
    public function detailInformasi(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $informasi = Informasi::where('id', $request->id)->first();
        return view('informasi.detail', compact('user', 'informasi'));
    }
    public function ubahInformasi($id)
    {
        if (Auth::user()->status == 'A') {
            $user = User::where('id', Auth::user()->id)->first();
            $informasi = Informasi::where('id', $id)->first();
            return view('informasi.form.ubah', compact('user', 'informasi'));
        } else {
            return redirect()->route('home.index');
        }
    }
}
