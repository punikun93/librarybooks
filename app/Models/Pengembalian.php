<?php

namespace App\Models;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $primaryKey = 'PengembalianID';

    protected $fillable = [
        'PengembalianID',
        'PeminjamanID',
        'BukuID',
        'TanggalPengembalian',
    ];

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman::class, 'PeminjamanID');
    }
}
