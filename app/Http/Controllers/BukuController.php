<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Support\Str;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\kategoribukurelasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $anas_kategori = Kategori::all();
        $excludedBookIDs = Peminjaman::whereIn('Status', ['proses', 'booked'])->pluck('BukuID');
        $anas_books = Buku::all();

        // Tandai buku yang sedang dipinjam
        foreach ($anas_books as $book) {
            $book->isBooked = $excludedBookIDs->contains($book->BukuID);
        }

        // Pisahkan buku yang bisa dipinjam dan yang tidak
        $booksAvailable = $anas_books->filter(fn($book) => !$book->isBooked);
        $booksUnavailable = $anas_books->filter(fn($book) => $book->isBooked);

        // Urutkan berdasarkan TahunTerbit (desc)
        $booksAvailable = $booksAvailable->sortByDesc('TahunTerbit');
        $booksUnavailable = $booksUnavailable->sortByDesc('TahunTerbit');

        // Gabungkan kembali
        $anas_books = $booksAvailable->concat($booksUnavailable);



        if (Auth::user()->Role == 'peminjam') {
            $userID = Auth::user()->UserID;
            $isFullUser = Peminjaman::where('UserID', $userID)
                ->whereIn('Status', ['proses', 'booked'])
                ->selectRaw('COUNT(*) as total')
                ->groupBy('UserID')
                ->havingRaw('total >= 3')
                ->exists();


            return view('books', compact('anas_books', 'anas_kategori', 'isFullUser'));
        }
        return view('admin.books.index', compact('anas_books', 'anas_kategori'));
    }

    public function store(Request $anas_request)
    {
        try {
            // Validasi input
            $validatedData = $anas_request->validate([
                'Judul' => 'required|string|max:255',
                'Penulis' => 'required|string|max:255',
                'Penerbit' => 'required|string|max:255',
                'TahunTerbit' => 'required|integer',
                'cover' => 'nullable|image',
                'KategoriID' => 'required|array',
            ]);
            // Inisialisasi model Buku
            $anas_buku = new Buku();
            $anas_buku->Judul = $validatedData['Judul'];
            $anas_buku->Penulis = $validatedData['Penulis'];
            $anas_buku->Penerbit = $validatedData['Penerbit'];
            $anas_buku->TahunTerbit = $validatedData['TahunTerbit'];

            // Proses unggah file jika ada
            if ($anas_request->hasFile('cover')) {
                $foto = $anas_request->file('cover');
                $fileName = $validatedData['Judul'] . '-' . time() . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('Gambar_buku', $fileName, 'public');
                $anas_buku->Gambar = $path;
            }
            $anasJudul = $anas_buku->Judul; // Simpan judul sebelum menghapus data

            // Simpan data buku     
            $anas_buku->save();

            foreach ($anas_request->input('KategoriID') as $kategoriID) {
                kategoribukurelasi::create([
                    'BukuID' => $anas_buku->BukuID,
                    'KategoriID' => $kategoriID,
                ]);
            }

            if (Auth::user()->Role == 'petugas') {
                LogAktivitas::create([
                    'UserID' => Auth::user()->UserID,
                    'aksi' => 'Tambah Buku',
                    'detail' => 'Tambah Buku dengan Judul ' . $anasJudul,
                    'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
                ]);
            };


            return redirect()->back()->with('success', 'Data buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Menampilkan error jika terjadi kesalahan
            return redirect()
                ->back()
                ->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $anas_request, $anas_buku)
    {
        try {
            // Validasi data
            $anas_validatedData = $anas_request->validate([
                'Judul' => 'required|string|max:255',
                'Penulis' => 'required|string|max:255',
                'Penerbit' => 'required|string|max:255',
                'TahunTerbit' => 'required|integer',
                'cover' => 'nullable|image',
                'KategoriID' => 'required|array',
            ]);
            $anas_Buku = Buku::findOrFail($anas_buku);

            // Proses unggah file Gambar baru jika ada
            if ($anas_request->hasFile('cover')) {
                // Hapus Gambar lama jika ada
                if ($anas_Buku->Gambar && Storage::disk('public')->exists($anas_Buku->Gambar)) {
                    Storage::disk('public')->delete($anas_Buku->Gambar);
                }

                // Simpan Gambar baru dengan nama file dari dua kata pertama judul dan waktu unik
                $anas_file = $anas_request->file('cover');
                $anas_fileName = Str::slug(Str::words($anas_validatedData['Judul'], 2, '')) . '-' . time() . '.' . $anas_file->getClientOriginalExtension();
                $anas_validatedData['cover'] = $anas_file->storeAs('Gambar_buku', $anas_fileName, 'public');
                $anas_Buku->Gambar = $anas_validatedData['cover'];
            }
            $anasJudul = $anas_Buku->Judul; // Simpan judul sebelum menghapus data

            // Perbarui data buku
            $anas_Buku->update($anas_validatedData);
            // Handle categories:
            // First, delete the old categories associated with the book
            $anas_Buku->kategori()->detach();

            // Now, add the new categories
            foreach ($anas_request->input('KategoriID') as $kategoriID) {
                $anas_Buku->kategori()->attach($kategoriID);
            }

            // Log activity if the user is a 'petugas'
            if (Auth::user()->Role == 'petugas') {
                LogAktivitas::create([
                    'UserID' => Auth::user()->UserID,
                    'aksi' => 'Update Buku',
                    'detail' => 'Update Buku ' . $anasJudul,
                    'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
                ]);
            }
            return redirect()->back()->with('success', 'Data buku berhasil diperbarui!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()
                ->back()
                ->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($anas_buku)
    {
        try {
            $anas_Buku = Buku::find($anas_buku);
            $anasJudul = $anas_Buku->Judul; // Simpan judul sebelum menghapus data

            $anas_Buku->delete();

            // Log activity if the user is a 'petugas'
            if (Auth::user()->Role == 'petugas') {
                LogAktivitas::create([
                    'UserID' => Auth::user()->UserID,
                    'aksi' => 'Hapus Buku',
                    'detail' => 'Hapus Buku' . $anasJudul,
                    'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
