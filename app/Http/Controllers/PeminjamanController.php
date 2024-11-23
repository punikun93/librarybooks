<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\LogAktivitas;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PeminjamanController extends Controller
{

    public function return(Request $request)
    {

        $anas_peminjaman = Peminjaman::findOrFail($request->PeminjamanID);
        $anas_pengembalian = Pengembalian::where('PeminjamanID', $anas_peminjaman->PeminjamanID);
        try {

            $anas_pengembalian->update([
                'Status' => 'done',
            ]);
            // Log activity if the user is a 'petugas'
            if (Auth::user()->Role == 'petugas') {
                LogAktivitas::create([
                    'UserID' => Auth::user()->UserID,
                    'aksi' => 'Verifikasi Pengembalian',
                    'detail' => 'Pengembalian dengan Peminjaman ID: ' . $anas_peminjaman->PeminjamanID . 'dengan buku' . $anas_peminjaman->buku->Judul,
                    'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
                ]);
            }

            return redirect()->back()->with('success', 'borrow updated return successfully');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'borrow updated return failed');
        }
    }
    public function index()
    {
        $anas_kategori = Kategori::all();

        // Ambil user ID yang telah meminjam 3 kali atau lebih
        $anas_excludedUserIDs = Peminjaman::select('UserID')->groupBy('UserID')->havingRaw('COUNT(*) >= 3')->pluck('UserID');

        // Ambil semua user dengan role 'peminjam'
        $anas_users = User::where('Role', 'peminjam')->get();

        // Filter user yang sudah meminjam 3 kali atau lebih
        $anas_fullUsers = $anas_users->filter(function ($user) use ($anas_excludedUserIDs) {
            return $anas_excludedUserIDs->contains($user->UserID);
        });

        // Filter user yang belum meminjam 3 kali
        $anas_bebasUsers = $anas_users->filter(function ($user) use ($anas_excludedUserIDs) {
            return !$anas_excludedUserIDs->contains($user->UserID);
        });

        // Ambil buku yang tidak sedang dipinjam
        $anas_excludedBookIDs = Peminjaman::pluck('BukuID');
        $anas_books = Buku::whereNotIn('BukuID', $anas_excludedBookIDs)->get();

        // Tentukan status berdasarkan route yang diakses
        $anas_status = Route::is('borrow.history') || Route::is('borrow.return') ? 'done' : (Route::is('borrow.confirmed') ? 'proses' : 'booked');

        $anas_peminjaman = Peminjaman::with('user', 'buku')->where('Status', $anas_status);

        // Tambahkan logika untuk status 'done'
        if ($anas_status == 'done') {
            if (Route::is('borrow.return')) {
                // Tampilkan pengembalian dengan status 'proses'
                $anas_peminjaman = $anas_peminjaman->whereHas('pengembalian', function ($query) {
                    $query->where('Status', 'proses');
                });
            } elseif (Route::is('borrow.history')) {
                // Tampilkan pengembalian dengan status 'selesai'
                $anas_peminjaman = $anas_peminjaman->whereHas('pengembalian', function ($query) {
                    $query->where('Status', 'done');
                });
            }
        }

        // Paginasi hasil peminjaman
        $anas_peminjaman = $anas_peminjaman->paginate(10);
        try {
            return view('admin.borrow.index', compact('anas_peminjaman', 'anas_books', 'anas_kategori', 'anas_fullUsers', 'anas_bebasUsers'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function store(Request $anas_request)
    {
        try {
            $anas_data = $anas_request->validate([
                'UserID' => 'required|integer',
                'BukuID' => 'required|integer',
                'TanggalPeminjaman' => 'required|date',
                'TanggalPengembalian' => 'required|date',
                'PetugasID' => 'nullable',
            ]);
            $anas_peminjaman = new Peminjaman();
            $anas_peminjaman->UserID = $anas_data['PetugasID'] ? $anas_data['UserID'] : Auth::user()->UserID;
            $anas_peminjaman->BukuID = $anas_data['BukuID'];
            $anas_peminjaman->TanggalPeminjaman = $anas_data['TanggalPeminjaman'];
            $anas_peminjaman->TanggalPengembalian = $anas_data['TanggalPengembalian'];

            if ($anas_data['PetugasID'] == 'yes') {
                $anas_peminjaman->Status = 'booked';
            } elseif (Auth::user()->Role == 'peminjam') {
                $anas_peminjaman->Status = 'proses';
            }

            $anas_peminjaman->save();

            // Log activity if the user is a 'petugas'
            if (Auth::user()->Role == 'petugas') {
                LogAktivitas::create([
                    'UserID' => Auth::user()->UserID,
                    'aksi' => 'Tambah Pinjam Buku',
                    'detail' => 'Tamabh Peminjaman dengan ID: ' . $anas_peminjaman->PeminjamanID . 'dengan buku' . $anas_peminjaman->buku->Judul,
                    'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
                ]);
            }
            return redirect()->back()->with('success', 'borrow created successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create borrow. Please try again.');
        }
    }

    public function update($anas_peminjaman)
    {
        $anas_Peminjaman = Peminjaman::findOrFail($anas_peminjaman);
        if ($anas_Peminjaman->Status === 'proses') {
            $anas_Peminjaman->Status = 'booked';
        } elseif ($anas_Peminjaman->Status === 'booked') {
            $anas_Peminjaman->Status = 'done';
        } else {
            return redirect()->back()->with('error', 'Invalid status transition.');
        }
        $anas_Peminjaman->save();
        // Log activity if the user is a 'petugas'
        if (Auth::user()->Role == 'petugas') {
            LogAktivitas::create([
                'UserID' => Auth::user()->UserID,
                'aksi' => 'Update Status Peminjaman',
                'detail' => 'Update Status Peminjaman dengan ID: ' . $anas_Peminjaman->PeminjamanID  . 'Status menjadi' . $anas_Peminjaman->Status,
                'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
            ]);
        }
        return redirect()->back()->with('success', 'borrow updated successfully');
    }
    public function destroy($anas_peminjaman)
    {
        $anas_peminjaman = Peminjaman::findOrFail($anas_peminjaman);
        $bukuJudul = $anas_peminjaman->buku->Judul;

        $anas_peminjaman->delete();
        // Log activity if the user is a 'petugas'
        if (Auth::user()->Role == 'petugas') {
            LogAktivitas::create([
                'UserID' => Auth::user()->UserID,
                'aksi' => 'Tolak Peminjaman',
                'detail' => 'Tolak Peminjaman dengan ID: ' . $anas_peminjaman->PeminjamanID . 'dengan buku' . $bukuJudul,
                'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->back()->with('success', 'borrow deleted successfully');
    }

    public function back(Request $anas_request)
    {
        $anas_request->validate([
            'PeminjamanID' => 'required|integer',
            'BukuID' => 'required|integer',
        ]);

        $anas_pengembalian = new Pengembalian();
        $anas_pengembalian->PeminjamanId = $anas_request->PeminjamanID;
        $anas_pengembalian->BukuID = $anas_request->BukuID;
        $anas_pengembalian->Status = 'proses';
        $anas_pengembalian->TanggalPengembalian = Carbon::now();
        $anas_pengembalian->save();

        $anas_peminjaman = Peminjaman::where('PeminjamanID', $anas_request->PeminjamanID);
        $anas_peminjaman->update([
            'Status' => 'done',
        ]);

        return redirect()->back()->with('success', 'borrow updated successfully');
    }
}
