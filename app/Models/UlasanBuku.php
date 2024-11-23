<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    protected $table = 'ulasanbuku';
    protected $primaryKey = 'UlasanID';

    protected $fillable = [
        'UserID',
        'BukuID',
        'Ulasan',
        'Rating',
        'PeminjamanID',

    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }
}
