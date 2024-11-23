<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'KategoriID';

    protected $fillable = [
        'NamaKategori',
    ];
    
    public function buku()
    {
        return $this->belongsToMany(
            Buku::class,
            'kategoribuku_relasi', // Nama pivot table
            'KategoriID',          // Foreign key di pivot table untuk model ini
            'BukuID',              // Foreign key di pivot table untuk model terkait
            'KategoriID',          // Primary key model ini
            'BukuID'               // Primary key model terkait
        );
    }
}
