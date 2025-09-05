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
        Schema::create('payrolls', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('employee_id');
        $table->string('periode'); // contoh: 2025-08
        $table->decimal('gaji_pokok', 15, 2);
        $table->decimal('tunjangan_tetap', 15, 2);
        $table->decimal('insentif', 15, 2)->default(0);
        $table->integer('lembur_jam')->default(0);
        $table->decimal('lembur_upah', 15, 2)->default(0);
        $table->decimal('nwnp_potongan', 15, 2)->default(0);
        $table->decimal('bpjs_potongan', 15, 2)->default(0);
        $table->decimal('total_gaji', 15, 2);
        $table->enum('status', ['draft', 'approved'])->default('draft');
        $table->timestamps();

        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
