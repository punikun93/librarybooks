<?php

namespace App\Models;

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
}
