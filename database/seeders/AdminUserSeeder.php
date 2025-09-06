<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // ✅ Tambahkan ini
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Cek dulu apakah admin sudah ada
        if (!User::where('email', 'admin@payroll.com')->exists()) {
            User::create([
                'name' => 'Admin Payroll',
                'email' => 'admin@payroll.com',
                'role' => 'supervisor',
                'password' => Hash::make('password123'), // ganti dengan password yang lebih aman
            ]);
        }
    }
}
