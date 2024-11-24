<?php

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\PetugasMiddleware;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UlasanBukuController;
use App\Http\Controllers\KoleksiPribadiController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users/confirmed', [UserController::class, 'index'])->name('users.confirmed');
    Route::post('/users/{user}', [UserController::class, 'confirm'])->name('confirmed');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.data');

    Route::post('/category', [KategoriController::class, 'store'])->name('category.store');
    Route::delete('/category/{kategori}', [KategoriController::class, 'destroy'])->name('category.destroy');
    Route::put('/category/{kategori}', [KategoriController::class, 'update'])->name('category.update');
    Route::get('/books/category', [KategoriController::class, 'index'])->name('books.category');

    Route::get('/books', [BukuController::class, 'index'])->name('books.data');
    Route::post('/books/store', [BukuController::class, 'store'])->name('books.store');
    Route::put('/books/{buku}', [BukuController::class, 'update'])->name('books.update');
    Route::delete('/books/{buku}', [BukuController::class, 'destroy'])->name('books.destroy');
});

Route::get('/borrowed', [UlasanBukuController::class, 'borrowed'])->name('report.borrow');
Route::get('/books/review', [UlasanBukuController::class, 'review'])->name('report.review');


Route::middleware(PetugasMiddleware::class)->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::post('/category', [KategoriController::class, 'store'])->name('category.store');
    Route::delete('/category/{kategori}', [KategoriController::class, 'destroy'])->name('category.destroy');
    Route::put('/category/{kategori}', [KategoriController::class, 'update'])->name('category.update');
    Route::get('/books/category', [KategoriController::class, 'index'])->name('books.category');

    Route::get('/books', [BukuController::class, 'index'])->name('books.data');
    Route::post('/books/store', [BukuController::class, 'store'])->name('books.store');
    Route::put('/books/{buku}', [BukuController::class, 'update'])->name('books.update');
    Route::delete('/books/{buku}', [BukuController::class, 'destroy'])->name('books.destroy');

    Route::get('/borrow', [PeminjamanController::class, 'index'])->name('borrow');
    Route::get('/borrow/confirmed', [PeminjamanController::class, 'index'])->name('borrow.confirmed');
    Route::get('/borrow/return', [PeminjamanController::class, 'index'])->name('borrow.return');
    Route::get('/borrow/history', [PeminjamanController::class, 'index'])->name('borrow.history');
    Route::delete('/borrow/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('borrow.destroy');
    Route::post('/borrow/store', [PeminjamanController::class, 'store'])->name('borrow.store');
    Route::put('/borrow/{update}', [PeminjamanController::class, 'update'])->name('borrow.update');
    Route::post('/borrow/return', [PeminjamanController::class, 'return'])->name('return.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('/books', [BukuController::class, 'index'])->name('books.data');
    Route::post('/borrow/store', [PeminjamanController::class, 'store'])->name('borrow.store');
    Route::get('/collections', [KoleksiPribadiController::class, 'index'])->name('collections');
    Route::post('/toggle-favorite', [KoleksiPribadiController::class, 'toggleFavorite'])->name('favorite');
    Route::get('/borrowing', [UlasanBukuController::class, 'index'])->name('ulasan');
    Route::post('/borrowing/store', [UlasanBukuController::class, 'store'])->name('ulasan.store');
    Route::post('/borrowing/back', [PeminjamanController::class, 'back'])->name('pengembalian.store');
});
Route::get('/', function () {
    // Ambil ID buku yang sedang dipinjam dengan status 'booked'
    $excludedBookIDs = Peminjaman::where('Status', 'booked')->pluck('BukuID');

    // Ambil 3 buku dengan rating terbaik
    $anas_books = Buku::with('ulasanBuku')
        ->withCount(['ulasanBuku as average_rating' => function ($query) {
            $query->select(DB::raw('AVG(Rating)'));
        }])
        ->orderByDesc('average_rating') // Urutkan berdasarkan rating tertinggi
        ->take(3) // Batasi hanya 3 buku
        ->get();

    // Ambil semua kategori
    $anas_kategori = Kategori::all();

    foreach ($anas_books as $book) {
        $book->isBooked = $excludedBookIDs->contains($book->BukuID);
    }
    return view('landingPage', compact('anas_kategori', 'anas_books'));
})->name('landingPage');
