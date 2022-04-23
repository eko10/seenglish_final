<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Distribusisoal_ extends Model
{
  public function soal()
  {
  	return $this->belongsTo('App\Models\Soal', 'id_soal');
  }
  public function kelas()
  {
  	return $this->belongsTo('App\Models\Kelas', 'id_kelas');
  }
  public function jawabUser()
  {
  	return $this->belongsTo('App\Models\Jawab', 'id_soal', 'id_soal');
  }
}
