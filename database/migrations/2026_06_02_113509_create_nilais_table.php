<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instruktur_id')->constrained('users')->onDelete('cascade');
            $table->integer('soft_skills')->comment('Skala 1-5');
            $table->integer('hard_skills')->comment('Skala 1-5');
            $table->integer('pengembangan')->comment('Skala 1-5');
            $table->integer('kewirausahaan')->comment('Skala 1-5');
            $table->text('catatan_tambahan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilais');
    }
};