<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
  // Constructor to ensure user is authenticated


  public function index()
  {
    // Check if user is petugas
    if (Auth::user()->Role !== 'petugas') {
      return redirect()->back()->with('error', 'Unauthorized access.');
    }

    $anas_kategori = Kategori::paginate(10);
    return view('admin.books.category', compact('anas_kategori'));
  }

  public function store(Request $anas_request)
  {
    // Check if user is petugas
    if (Auth::user()->Role !== 'petugas') {
      return redirect()->back()->with('error', 'Unauthorized access.');
    }

    $anas_request->validate([
      'NamaKategori' => 'required|string|max:255',
    ]);

    try {
      $data = $anas_request->only(['NamaKategori']);
      $kategori = Kategori::create($data);

      LogAktivitas::create([
        'UserID' => Auth::user()->UserID,
        'aksi' => 'Tambah Kategori',
        'detail' => 'Tambah Kategori' . $kategori->NamaKategori,
        'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
      ]);

      return redirect()->back()->with('success', 'Category created successfully');
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Failed to create category. Please try again.');
    }
  }

  public function update(Request $anas_request, $anas_kategori)
  {
    // Check if user is petugas
    if (Auth::user()->Role !== 'petugas') {
      return redirect()->back()->with('error', 'Unauthorized access.');
    }

    $anas_request->validate([
      'NamaKategori' => 'required|string|max:255',
    ]);

    try {
      $anas_data = $anas_request->only(['NamaKategori']);
      $anas_Kategori = Kategori::findOrFail($anas_kategori);

      // Store old name for logging
      $oldName = $anas_Kategori->NamaKategori;

      // Update category
      $anas_Kategori->update($anas_data);

      // Log the deletion activity
      LogAktivitas::create([
        'UserID' => Auth::user()->UserID,
        'aksi' => 'Update Kategori',
        'detail' => 'Update Kategori' .  $oldName . ' menjadi ' . $anas_data['NamaKategori'],
        'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
      ]);

      return redirect()->back()->with('success', 'Category updated successfully');
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Failed to update category. Please try again.');
    }
  }

  public function destroy($anas_kategori)
  {
    // Check if user is petugas
    if (Auth::user()->Role !== 'petugas') {
      return redirect()->back()->with('error', 'Unauthorized access.');
    }

    try {
      $anas_kategori = Kategori::findOrFail($anas_kategori);
      $kategoriName = $anas_kategori->NamaKategori;

      $anas_kategori->delete();

      // Log the deletion activity
      LogAktivitas::create([
        'UserID' => Auth::user()->UserID,
        'aksi' => 'Hapus Kategori',
        'detail' => 'Menghapus Kategori' . $kategoriName,
        'created_at' => Carbon::now()->locale('id')->translatedFormat('Y-m-d H:i:s'),
      ]);

      return redirect()->back()->with('success', 'Category deleted successfully');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Failed to delete category. Please try again.');
    }
  }
}
