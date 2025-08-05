<?php

use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\StatusPerkawinan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('no_kk');
            $table->foreignIdFor(User::class)->constrained();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin',['L','P']);
            $table->string('gol_darah',5);
            $table->string('no_rumah',5);
            $table->string('rt',5);
            $table->string('rw',5);
            $table->string('no_hp',25);
            $table->foreignIdFor(Agama::class)->constrained();
            $table->foreignIdFor(StatusPerkawinan::class)->constrained();
            $table->foreignIdFor(Pekerjaan::class)->constrained();
            $table->enum('status_warga',['Hidup','Mati','Pindah']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
