<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'status',
        'prediction',
        'anomaly',
        'recommendation',
    ];

    public function statusLogs()
    {
        return $this->hasMany(BarangStatusLog::class);
    }
}
