<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\UlasanBuku;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UlasanBukuController extends Controller
{
    public function review()
    {
        // Menghitung rata-rata rating per buku dan jumlah ulasan
        $anas_ulasan = UlasanBuku::select(
                'BukuID',
                DB::raw('AVG(Rating) as average_rating'),
                DB::raw('COUNT(Rating) as total_reviews') // Menambahkan total ulasan
            )
            ->groupBy('BukuID')
            ->orderBy('average_rating', 'desc') // Urutkan berdasarkan rata-rata tertinggi
            ->with('buku') // Sertakan relasi buku
            ->get();
    
        return view('admin.booksReview', compact('anas_ulasan'));
    }
    


    public function borrowed()
    {
        // Ambil data peminjaman dengan status booked atau done
        $anas_peminjaman = Peminjaman::with(['buku', 'pengembalian'])
            ->whereIn('Status', ['booked', 'done']) // Filter status
            ->get();

        // Hitung jumlah peminjaman per buku
        $anas_most_borrowed = Peminjaman::select('BukuID', DB::raw('COUNT(*) as total_peminjaman'))
            ->whereIn('Status', ['booked', 'done']) // Filter status
            ->groupBy('BukuID') // Kelompokkan berdasarkan BukuID
            ->orderBy('total_peminjaman', 'desc') // Urutkan dari yang terbanyak
            ->with('buku') // Sertakan relasi buku
            ->get();

        // Total pengembalian
        $anas_pengembalian = Pengembalian::count();

        return view('admin.borrowed', compact('anas_peminjaman', 'anas_pengembalian', 'anas_most_borrowed'));
    }

    public function index()
    {
        // Ambil UserID dari user yang sedang login
        $anas_user = Auth::user()->UserID;

        // Ambil data peminjaman berdasarkan UserID
        $anas_peminjaman = Peminjaman::with(['buku', 'pengembalian']) // Pastikan ada relasi pengembalian
            ->where('UserID', $anas_user)
            ->get();

        // Tandai status isBooked langsung pada data buku
        $anas_peminjaman->each(function ($peminjaman_anas) {
            // Cek apakah ada di tabel pengembalian
            if ($peminjaman_anas->pengembalian) {
                // Jika ada pengembalian, cek status di tabel pengembalian
                $statusPengembalian = $peminjaman_anas->pengembalian->Status;

                // Tambahkan logika berdasarkan status pengembalian
                if ($statusPengembalian === 'proses') {
                    $peminjaman_anas->buku->isBooked = 'Menunggu Verifikasi';
                } elseif ($statusPengembalian === 'selesai') {
                    $peminjaman_anas->buku->isBooked = 'Pengembalian Selesai';
                } else {
                    $peminjaman_anas->buku->isBooked = 'Dalam Pengembalian';
                }
            } else {
                // Jika tidak ada di pengembalian, gunakan status default
                $peminjaman_anas->buku->isBooked = in_array($peminjaman_anas->Status, ['proses', 'booked']);
            }
        });
        $anas_pengembalian = Pengembalian::count();
        // Return ke view dengan hanya satu variabel
        return view('history', compact('anas_peminjaman', 'anas_pengembalian'));
    }

    public function store(Request $anas_request)
    {
        try {
            $anas_request->validate([
                'BukuID' => 'required|integer',
                'Ulasan' => 'required|string',
                'Rating' => 'required|integer',
                'PeminjamanID' => 'required|integer',
            ]);

            UlasanBuku::create([
                'UserID' => Auth::user()->UserID,
                'BukuID' => $anas_request->BukuID,
                'Ulasan' => $anas_request->Ulasan,
                'Rating' => $anas_request->Rating,
                'PeminjamanID' => $anas_request->PeminjamanID,
            ]);
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
