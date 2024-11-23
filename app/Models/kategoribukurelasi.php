<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategoribukurelasi extends Model
{
    protected $table = 'kategoribuku_relasi';
    protected $primaryKey = 'KategoriBukuID';
    protected $fillable = [
        'KategoriID',
        'BukuID',
    ];
}
