<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PayrollController;



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware(['auth', 'role:supervisor,staff'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/', [KaryawanController::class, 'index'])->name('index');
    Route::get('/create', [KaryawanController::class, 'create'])->name('create');
    Route::post('/', [KaryawanController::class, 'store'])->name('store');
    Route::get('/{id}', [KaryawanController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [KaryawanController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KaryawanController::class, 'update'])->name('update');
    Route::delete('/{id}', [KaryawanController::class, 'destroy'])->name('destroy');
});

// --- Payroll ---
Route::middleware(['auth','role:supervisor,staff,karyawan'])
    ->prefix('payroll')
    ->name('payroll.')
    ->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('index');
        Route::get('/{id}', [PayrollController::class, 'show'])->name('show');
        Route::delete('/{id}', [PayrollController::class, 'destroy'])->name('destroy');

        // ✅ Generate Payroll (POST)
        Route::post('/generate', [PayrollController::class, 'generate'])->name('generate');
        Route::post('/pdf/all', [PayrollController::class, 'pdfAll'])->name('pdfAll');
        // ✅ Tambahkan ini untuk slip per karyawan (PDF)
        Route::get('/{id}/pdf', [PayrollController::class, 'pdf'])->name('pdf');
        // ✅ Approve Payroll (khusus supervisor)
        Route::put('/{id}/approve', [PayrollController::class, 'approve'])
            ->name('approve')
            ->middleware('role:supervisor');
    });

    // Hanya karyawan yang bisa akses slip gaji
    Route::middleware(['auth'])->group(function () {
        Route::get('/slip-gaji', [App\Http\Controllers\PayrollController::class, 'mySlip'])
            ->name('payroll.myslip');
    });


// --- API Presensi (dummy pakai file json) ---
Route::prefix('api')->group(function () {
    // Endpoint untuk isi dummy JSON
    Route::post('/presensi-dummy', function () {
        $data = [
        [
            "karyawan_id" => 1,
            "periode"     => "2025-09",
            "presensi"    => [
                [ "tanggal" => "2025-09-01", "jam_masuk" => "08:05", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-02", "jam_masuk" => "08:15", "jam_keluar" => "17:30" ],
                [ "tanggal" => "2025-09-03", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-04", "jam_masuk" => "08:00", "jam_keluar" => "20:00" ],
                [ "tanggal" => "2025-09-05", "jam_masuk" => "08:10", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-06", "jam_masuk" => "08:20", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-07", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-08", "jam_masuk" => "07:55", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-09", "jam_masuk" => "08:05", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-10", "jam_masuk" => "08:00", "jam_keluar" => "21:00" ],
                [ "tanggal" => "2025-09-11", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-12", "jam_masuk" => "08:12", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-13", "jam_masuk" => "08:25", "jam_keluar" => "17:40" ],
                [ "tanggal" => "2025-09-14", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-15", "jam_masuk" => "07:50", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-16", "jam_masuk" => "08:05", "jam_keluar" => "20:30" ],
                [ "tanggal" => "2025-09-17", "jam_masuk" => "08:10", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-18", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-19", "jam_masuk" => "08:30", "jam_keluar" => "17:45" ],
                [ "tanggal" => "2025-09-20", "jam_masuk" => "08:40", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-21", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-22", "jam_masuk" => "08:05", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-23", "jam_masuk" => "08:15", "jam_keluar" => "20:00" ],
                [ "tanggal" => "2025-09-24", "jam_masuk" => "08:00", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-25", "jam_masuk" => "08:05", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-26", "jam_masuk" => "08:25", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-27", "jam_masuk" => "08:30", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-28", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-29", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-30", "jam_masuk" => "08:10", "jam_keluar" => "20:30" ]
            ],
        ],
        [
            "karyawan_id" => 2,
            "periode"     => "2025-09",
            "presensi"    => [
                [ "tanggal" => "2025-09-01", "jam_masuk" => "08:10", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-02", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-03", "jam_masuk" => "08:20", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-04", "jam_masuk" => "08:00", "jam_keluar" => "19:30" ],
                [ "tanggal" => "2025-09-05", "jam_masuk" => "08:05", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-06", "jam_masuk" => "08:25", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-07", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-08", "jam_masuk" => "07:55", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-09", "jam_masuk" => "08:15", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-10", "jam_masuk" => "08:00", "jam_keluar" => "21:00" ],
                [ "tanggal" => "2025-09-11", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-12", "jam_masuk" => "08:12", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-13", "jam_masuk" => "08:25", "jam_keluar" => "17:40" ],
                [ "tanggal" => "2025-09-14", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-15", "jam_masuk" => "07:50", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-16", "jam_masuk" => "08:05", "jam_keluar" => "20:30" ],
                [ "tanggal" => "2025-09-17", "jam_masuk" => "08:10", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-18", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-19", "jam_masuk" => "08:30", "jam_keluar" => "17:45" ],
                [ "tanggal" => "2025-09-20", "jam_masuk" => "08:40", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-21", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-22", "jam_masuk" => "08:05", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-23", "jam_masuk" => "08:15", "jam_keluar" => "20:00" ],
                [ "tanggal" => "2025-09-24", "jam_masuk" => "08:00", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-25", "jam_masuk" => "08:05", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-26", "jam_masuk" => "08:25", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-27", "jam_masuk" => "08:30", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-28", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-29", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-30", "jam_masuk" => "08:10", "jam_keluar" => "20:30" ]
            ],
        ],
        [
            "karyawan_id" => 4,
            "periode"     => "2025-09",
            "presensi"    => [
                [ "tanggal" => "2025-09-01", "jam_masuk" => "07:50", "jam_keluar" => "16:45" ],
                [ "tanggal" => "2025-09-02", "jam_masuk" => "08:00", "jam_keluar" => "20:00" ],
                [ "tanggal" => "2025-09-03", "jam_masuk" => "08:20", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-04", "jam_masuk" => "08:15", "jam_keluar" => "17:25" ],
                [ "tanggal" => "2025-09-05", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-06", "jam_masuk" => "08:25", "jam_keluar" => "17:35" ],
                [ "tanggal" => "2025-09-07", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-08", "jam_masuk" => "08:00", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-09", "jam_masuk" => "08:05", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-10", "jam_masuk" => "08:00", "jam_keluar" => "21:10" ],
                [ "tanggal" => "2025-09-11", "jam_masuk" => "08:10", "jam_keluar" => "17:30" ],
                [ "tanggal" => "2025-09-12", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-13", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-14", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-15", "jam_masuk" => "07:55", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-16", "jam_masuk" => "08:05", "jam_keluar" => "20:45" ],
                [ "tanggal" => "2025-09-17", "jam_masuk" => "08:20", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-18", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-19", "jam_masuk" => "08:15", "jam_keluar" => "17:40" ],
                [ "tanggal" => "2025-09-20", "jam_masuk" => "08:35", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-21", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-22", "jam_masuk" => "08:05", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-23", "jam_masuk" => "08:10", "jam_keluar" => "20:10" ],
                [ "tanggal" => "2025-09-24", "jam_masuk" => "08:00", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-25", "jam_masuk" => "08:20", "jam_keluar" => "17:25" ],
                [ "tanggal" => "2025-09-26", "jam_masuk" => "08:25", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-27", "jam_masuk" => "08:40", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-28", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-29", "jam_masuk" => "08:05", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-30", "jam_masuk" => "08:15", "jam_keluar" => "20:15" ]
            ],
        ],
            [
                "karyawan_id" => 5,
                "periode"     => "2025-09",
                "presensi"    => [
                        [ "tanggal" => "2025-09-01", "jam_masuk" => "08:10", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-02", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-03", "jam_masuk" => "08:20", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-04", "jam_masuk" => "08:00", "jam_keluar" => "19:30" ],
                [ "tanggal" => "2025-09-05", "jam_masuk" => "08:05", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-06", "jam_masuk" => "08:25", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-07", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-08", "jam_masuk" => "07:55", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-09", "jam_masuk" => "08:15", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-10", "jam_masuk" => "08:00", "jam_keluar" => "21:00" ],
                [ "tanggal" => "2025-09-11", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-12", "jam_masuk" => "08:12", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-13", "jam_masuk" => "08:25", "jam_keluar" => "17:40" ],
                [ "tanggal" => "2025-09-14", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-15", "jam_masuk" => "07:50", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-16", "jam_masuk" => "08:05", "jam_keluar" => "20:30" ],
                [ "tanggal" => "2025-09-17", "jam_masuk" => "08:10", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-18", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-19", "jam_masuk" => "08:30", "jam_keluar" => "17:45" ],
                [ "tanggal" => "2025-09-20", "jam_masuk" => "08:40", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-21", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-22", "jam_masuk" => "08:05", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-23", "jam_masuk" => "08:15", "jam_keluar" => "20:00" ],
                [ "tanggal" => "2025-09-24", "jam_masuk" => "08:00", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-25", "jam_masuk" => "08:05", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-26", "jam_masuk" => "08:25", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-27", "jam_masuk" => "08:30", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-28", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-29", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-30", "jam_masuk" => "08:10", "jam_keluar" => "20:30" ]
                ],
            ],
                [
                "karyawan_id" => 6,
                "periode"     => "2025-09",
                "presensi"    => [
                        [ "tanggal" => "2025-09-01", "jam_masuk" => "08:10", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-02", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-03", "jam_masuk" => "08:20", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-04", "jam_masuk" => "08:00", "jam_keluar" => "19:30" ],
                [ "tanggal" => "2025-09-05", "jam_masuk" => "08:05", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-06", "jam_masuk" => "08:25", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-07", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-08", "jam_masuk" => "07:55", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-09", "jam_masuk" => "08:15", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-10", "jam_masuk" => "08:00", "jam_keluar" => "21:00" ],
                [ "tanggal" => "2025-09-11", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-12", "jam_masuk" => "08:12", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-13", "jam_masuk" => "08:25", "jam_keluar" => "17:40" ],
                [ "tanggal" => "2025-09-14", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-15", "jam_masuk" => "07:50", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-16", "jam_masuk" => "08:05", "jam_keluar" => "20:30" ],
                [ "tanggal" => "2025-09-17", "jam_masuk" => "08:10", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-18", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-19", "jam_masuk" => "08:30", "jam_keluar" => "17:45" ],
                [ "tanggal" => "2025-09-20", "jam_masuk" => "08:40", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-21", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-22", "jam_masuk" => "08:05", "jam_keluar" => "17:10" ],
                [ "tanggal" => "2025-09-23", "jam_masuk" => "08:15", "jam_keluar" => "20:00" ],
                [ "tanggal" => "2025-09-24", "jam_masuk" => "08:00", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-25", "jam_masuk" => "08:05", "jam_keluar" => "17:05" ],
                [ "tanggal" => "2025-09-26", "jam_masuk" => "08:25", "jam_keluar" => "17:20" ],
                [ "tanggal" => "2025-09-27", "jam_masuk" => "08:30", "jam_keluar" => "17:00" ],
                [ "tanggal" => "2025-09-28", "jam_masuk" => null,    "jam_keluar" => null ],
                [ "tanggal" => "2025-09-29", "jam_masuk" => "08:00", "jam_keluar" => "17:15" ],
                [ "tanggal" => "2025-09-30", "jam_masuk" => "08:10", "jam_keluar" => "20:30" ]
                ],
            ],
        ];

        // Simpan ke file JSON
        Storage::disk('public')->put('presensi.json', json_encode($data, JSON_PRETTY_PRINT));

        return response()->json([
            "message" => "Dummy presensi berhasil dibuat",
            "path"    => "storage/app/public/presensi.json",
            "sample"  => $data
        ]);
    });
});

