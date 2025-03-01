<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function favorites()
    {
        return $this->belongsToMany(Buku::class, 'koleksipribadi', 'UserID', 'BukuID');
    }

    public function log()
    {
        return $this->hasMany(LogAktivitas::class, 'UserID', 'UserID');
    }

    protected $primaryKey = 'UserID';
    protected $fillable = [
        'Username',
        'password',
        'email',
        'NamaLengkap',
        'Alamat',
        'Role',
        'Status',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
