<?php

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
        Schema::create('pelaporans', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('waktu');
            $table->string('tempat');
            $table->string('deskripsi');
            $table->string('bukti');
            $table->bigInteger('id_m');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporans');
    }
};
