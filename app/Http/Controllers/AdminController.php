<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        return view('admin.dashboard', compact('anas_peminjaman', 'anas_pengembalian', 'anas_most_borrowed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
