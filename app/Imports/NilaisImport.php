<?php

namespace App\Imports;

use DB;
use App\User;
use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Mail;

class NilaisImport implements ToModel, WithHeadingRow
{
    public function __construct(String $sesi = null)
    {
        $this->sesi = $sesi;
    }

    public function model(array $row)
    {
        $user_by_email = User::where('email', $row['email'])->first();          
        $id_user = $user_by_email->id;
        $sesi = $this->sesi;
        $cek = Nilai::where('id_user', $id_user)->where('id_kelas', $sesi)->count();
        if($cek == 0) {
            $nilai = new Nilai();
            $nilai->id_kelas = $sesi;
            $nilai->id_user = $id_user;
            $nilai->nilai_reading = $row['nilai_reading'];
            $nilai->nilai_writing = $row['nilai_writing'];
            $nilai->nilai_listening = $row['nilai_listening'];
            $nilai->nilai_total = (($row['nilai_reading'] + $row['nilai_writing'] + $row['nilai_listening']) / 3) * 10;
            $nilai->save();
            $user = User::find($id_user);
            $user->id_kelas = null;
            $user->payment_id = null;
            $user->status_validasi = 'N';
            $user->status_ujian = 'Tidak Terdaftar';
            $user->token_ujian = null;
            $user->save();

            $data["email"] = $user->email;
            $data["title"] = "Penilaian Selesai";
            $data["body"] = "Nilai ujian anda telah diinput, silahkan cek pada website";
            $data["text"] = "";

            Mail::send('emails.send_mail', $data, function ($message) use ($data) {
                $message->to($data["email"])
                ->subject($data["title"]);
            });
        }
    }

}
