<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
       protected $fillable = [
        'employee_id',
        'periode',
        'gaji_pokok',
        'tunjangan_tetap',
        'insentif',
        'lembur_jam',
        'lembur_upah',
        'nwnp_potongan',
        'bpjs_potongan',
        'total_gaji',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
