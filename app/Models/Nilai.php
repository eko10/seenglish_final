<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Kelas;

class Nilai extends Model
{
    protected $table = 'nilais';
    protected $guarded = [];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function getKelas()
    {
        // return $this->hasMany(Kelas::class, 'id', 'id_kelas');
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
