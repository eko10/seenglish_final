<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;
// use App\Nilai;

class NilaiPerSesiExportMapping implements FromCollection, WithMapping, WithHeadings
{

    public function __construct(String $sesi = null)
    {
        $this->sesi = $sesi;
    }

    public function collection()
    {
        $nilai = DB::table('nilais')->join('users', 'users.id', '=', 'nilais.id_user')->join('kelas', 'kelas.id', '=', 'nilais.id_kelas')->select('nilais.*', 'users.nama AS peserta', 'users.email', 'kelas.nama AS kelas', 'kelas.tanggal')->where('nilais.id_kelas', $this->sesi)->get();
        return $nilai;
    }
 
    public function map($nilai) : array {
        return [
            $nilai->peserta,
            $nilai->email,
            ($nilai->nilai_reading == null) ? '' : $nilai->nilai_reading,
            ($nilai->nilai_writing == null) ? '' : $nilai->nilai_writing,
            ($nilai->nilai_listening == null) ? '' : $nilai->nilai_listening,
        ];
    }
 
    public function headings() : array {
        return [
            'NAMA',
            'EMAIL',
            'NILAI READING',
            'NILAI WRITING',
            'NILAI LISTENING'
        ];
    }
}
