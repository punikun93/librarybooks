<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('users')->insert([
            [
                'UserID' => 1,
                'Username' => 'user123',
                'password' => Hash::make('password123'),
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'NamaLengkap' => 'User One',
                'Alamat' => '123 User St.',
                'Role' => 'peminjam',
                'Status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'UserID' => 2,
                'Username' => 'petugas123',
                'password' => Hash::make('password123'),
                'email' => 'petugas@gmail.com',
                'email_verified_at' => now(),
                'NamaLengkap' => 'Petugas One',
                'Alamat' => '456 Petugas Ave.',
                'Role' => 'petugas',
                'Status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'UserID' => 3,
                'Username' => 'admin123',
                'password' => Hash::make('password123'),
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'NamaLengkap' => 'Admin One',
                'Alamat' => '789 Admin Blvd.',
                'Role' => 'administrator',
                'Status' => 'Confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
