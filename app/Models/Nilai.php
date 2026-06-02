<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'instruktur_id', 'soft_skills', 'hard_skills', 'pengembangan', 'kewirausahaan', 'catatan_tambahan'];

    public function siswa() { return $this->belongsTo(User::class, 'siswa_id'); }
}