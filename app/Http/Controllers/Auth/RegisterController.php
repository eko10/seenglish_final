<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // $validator = $request->validate([
        //     'nama' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        // ]);

        // dd($validator->fails());

        // if($validator->fails()){
        //     return Redirect::back()->withErrors($validator)->withInput($request->all());
        // }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    public function registerProses(Request $request)
    {
        $data = $request->all();
        $check = $this->create($data);
        return redirect('login')->withSuccess('Pendaftaran berhasil, silahkan login.');
    }

    public function create(array $data)
    {
        return User::create([
            'nama' => $data['nama'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'no_hp' => $data['no_hp'],
            'pendidikan' => $data['pendidikan'],
            'jk' => $data['jk'],
            'alamat' => $data['alamat'],
            'status' => 'S',
            'status_ujian' => 'Tidak Terdaftar',
            'status_validasi' => 'N',
            'status_sekolah' => 'Y',
        ]);
    }
}
