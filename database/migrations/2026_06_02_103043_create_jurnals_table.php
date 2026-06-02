<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            // Menghubungkan jurnal dengan siswa yang mengisi
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            
            // Kolom-kolom isi formulir berdasarkan dokumen HKI
            $table->date('hari_tanggal'); 
            $table->string('unit_kerja'); 
            $table->text('deskripsi_pekerjaan'); 
            $table->string('dokumentasi')->nullable(); // Menyimpan nama file foto jika ada
            
            // Kolom dari sisi instruktur industri
            $table->text('catatan_instruktur')->nullable(); 
            $table->enum('status_persetujuan', ['pending', 'disetujui', 'revisi'])->default('pending');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users'); 

            // TAMBAHAN: Kolom untuk menyimpan feedback/catatan dari Guru Pembimbing
            $table->text('feedback_guru')->nullable(); 

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jurnals');
    }
};