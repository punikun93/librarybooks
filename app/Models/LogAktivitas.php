<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'logAktivitas';
    protected $primaryKey = 'LogID';
    protected $keyType = 'string';


    protected $fillable = [
        'UserID',
        'aksi',
        'detail',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}
