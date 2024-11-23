<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'BukuID';

    protected $fillable = [
        'BukuID',
        'Judul',
        'Penulis',
        'Penerbit',
        'TahunTerbit',
        'Status',
        'Gambar'
    ];

    public function kategori()
    {
        return $this->belongsToMany(
            Kategori::class,           // The related model (Kategori)
            'kategoribuku_relasi',     // The pivot table name
            'BukuID',                  // The foreign key for the Buku model in the pivot table
            'KategoriID',              // The foreign key for the Kategori model in the pivot table
            'BukuID',                  // The primary key for the Buku model
            'KategoriID'               // The primary key for the Kategori model
        );
    }
    public function favorit()
    {
        return $this->belongsToMany(
            Kategori::class,           // The related model (Kategori)
            'koleksipribadi',     // The pivot table name
            'BukuID',                  // The foreign key for the Buku model in the pivot table
            'KoleksiID',
            'BukuID',                  // The primary key for the Buku model
            'KoleksiID'
        );
    }
    public function usersWhoFavorited()
    {
        return $this->belongsToMany(User::class, 'koleksipribadi', 'BukuID', 'UserID');
    }

    public function ulasanBuku()
    {
        return $this->hasMany(UlasanBuku::class, 'BukuID');
    }
}
