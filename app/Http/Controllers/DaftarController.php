<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DaftarController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function register(Request $request){
        $error = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'no_hp' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong !',
            'email.required' => 'Email tidak boleh kosong !',
            'email.email' => 'Email tidak valid !',
            'email.unique' => 'Email tidak boleh sama !',
            'username.required' => 'Username tidak boleh kosong !',
            'username.unique' => 'Username tidak boleh sama !',
            'password.required' => 'Password tidak boleh kosong !',
            'password.min' => 'Password minimal 6 karakter !',
            'no_hp.required' => 'No. Handphone tidak boleh kosong !',
        ]);

        if($error->fails()) {
            return redirect()->back()->withErrors($error)->withInput();
        } 

        $user = new \App\User;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username = $request->username;
        $user->no_hp = $request->no_hp;
        $user->pendidikan = $request->pendidikan;
        $user->jk = $request->jk;
        $user->alamat = $request->alamat;
        $user->status = 'S';
        $user->status_ujian = 'Tidak Terdaftar';
        $user->status_validasi = 'N';
        $user->status_sekolah = 'Y';
        $user->remember_token = Str::random(60);
        $user->save();
        return redirect('/login')->with(['success' => 'Pendaftaran akun berhasil.']);
    }
}
