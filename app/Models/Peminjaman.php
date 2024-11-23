<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $primaryKey = 'PeminjamanID';
    protected $table = 'peminjaman';

    protected $fillable = [
        'UserID',
        'BukuID',
        'TanggalPeminjaman',
        'TanggalPengembalian',
        'Status',
    ];
    protected $dates = ['TanggalPeminjaman', 'TanggalPengembalian'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'PeminjamanID');
    }
    public function ulasan()
    {
        return $this->hasOne(UlasanBuku::class, 'PeminjamanID');
    }
    public function ulasanBuku()
    {
        return $this->hasMany(UlasanBuku::class, 'BukuID');
    }
}
