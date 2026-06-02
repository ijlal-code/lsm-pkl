<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id', 'guru_id', 'tanggal', 'permasalahan', 'solusi', 
        'catatan_instruktur', 'status_persetujuan'
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}