<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Keuangan;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use PDF;


class ApiController extends Controller
{
    // function untuk kirim notifikasi midtrans
    public function payment_handler(Request $request)
    {
        $json = json_decode($request->getContent());
        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env("MIDTRANS_SERVER_KEY"));

        if ($signature_key != $json->signature_key) {
            return abort(404);
        }

        $payment = Payment::where('order_id', $json->order_id)->where('status', '!=', 'settlement')->first();
        $payment->update(['status' => $json->transaction_status]);

        if ($json->transaction_status == 'settlement') {
            $user = User::where('email', $payment->email)->first();
            $kelas = Kelas::where('id', $user->id_kelas)->first();

            $str = $payment->email . ' - '  . $user->id_kelas;
            $token_ujian = md5($str);

            $user->status_validasi = 'Y';
            $user->status_ujian = 'Belum Mulai';
            $user->token_ujian = $token_ujian;
            $user->save();

            $keuangan = new Keuangan;
            $keuangan->posisi = 'M';
            $keuangan->keterangan = 'Pembayaran Ujian ' . $user->nama . ' (' . $user->email . ')';
            // $keuangan->sesi = $kelas->nama . ', ' . $kelas->tanggal;
            $keuangan->sesi = $user->id_kelas;
            $keuangan->tanggal = date('Y-m-d');
            $keuangan->nominal = 10000;
            $keuangan->save();

            $data["email"] = $user->email;
            $data["title"] = "Pendaftaran Berhasil";
            $data["body"] = "Pembayaran anda telah divalidasi, berikut adalah link whatsapp dan kartu ujian anda";
            $data["text"] = $kelas->link_wa;

            $pdf = PDF::loadView('pdf.kartu_ujian', ['peserta' => $user]);
            $pdf2 = PDF::loadView('pdf.tata_cara');

            Mail::send('emails.send_mail', $data, function ($message) use ($data, $pdf, $pdf2) {
                $message->to($data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "Kartu Ujian.pdf")
                    ->attachData($pdf2->output(), "Tata Cara Ujian.pdf");
            });
        } else if ($json->transaction_status == 'cancel' || $json->transaction_status == 'expire' || $json->transaction_status == 'deny') {
            $user = User::where('email', $payment->email)->first();
            $user->id_kelas = null;
            $user->payment_id = null;
            $user->status_validasi = 'N';
            $user->status_ujian = 'Tidak Terdaftar';
            $user->token_ujian = null;
            $user->save();
        }

        return 1;
    }
}
