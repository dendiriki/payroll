<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'jabatan',
        'status',
        'join_date',
        'gaji_pokok',
        'tunjangan',
        'bpjs',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'join_date' => 'date',
        'bpjs' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }


    public function getInsentifAttribute()
    {
        if ($this->status !== 'Tetap' || !$this->join_date) {
            return 0;
        }

        $years = now()->diffInYears(\Carbon\Carbon::parse($this->join_date));

        return 1000000 + ($years * 100000);
    }

}