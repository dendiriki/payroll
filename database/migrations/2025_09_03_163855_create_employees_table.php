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
    Schema::create('employees', function (Blueprint $table) {
                $table->id();
                
                // Relasi ke users (nullable, kalau user dihapus maka user_id jadi null)
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->string('nama_lengkap');
                $table->string('tempat_lahir');
                $table->date('tanggal_lahir');
                $table->enum('jenis_kelamin', ['L', 'P']);
                $table->string('jabatan');
                $table->enum('status', ['Tetap', 'Kontrak', 'HL']);
                $table->date('join_date'); 
                $table->decimal('gaji_pokok', 15, 2);
                $table->decimal('tunjangan', 15, 2)->default(0);
                $table->boolean('bpjs')->default(false);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
