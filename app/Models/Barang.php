<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'nama_barang',
        'type',
        'kode_barang',
        'kondisi',
        'foto',
        'status'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
