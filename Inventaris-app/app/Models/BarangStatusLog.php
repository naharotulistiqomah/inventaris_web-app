<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangStatusLog extends Model
{
    protected $fillable = [
        'barang_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
        'old_jumlah',
        'new_jumlah',
        'note',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
