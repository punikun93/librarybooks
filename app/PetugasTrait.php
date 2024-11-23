<?php

namespace App;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

trait PetugasTrait
{
    protected function logActivity($aksi, $detail)
    {
        LogAktivitas::create([
            'UserID' => Auth::user()->UserID,
            'aksi' => $aksi,
            'detail' => $detail
        ]);
    }
}
