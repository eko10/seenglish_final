<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangans';

    protected $guarded = [];

    public function getKelas()
    {
        return $this->belongsTo(Kelas::class, 'sesi');
    }
}
