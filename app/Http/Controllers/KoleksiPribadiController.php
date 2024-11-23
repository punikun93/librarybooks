<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Models\KoleksiPribadi;
use Illuminate\Support\Facades\Auth;

class KoleksiPribadiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $anas_user = Auth::user()->UserID;
        $anas_koleksi = KoleksiPribadi::with('buku')->where('UserID', $anas_user)->get();
        return view('collections', compact('anas_koleksi'));
    }


    public function toggleFavorite(Request $request)
    {
        try {
            $book = Buku::findOrFail($request->book_id);
            $user = Auth::user();

            if ($user->favorites->contains($book->BukuID)) {
                $user->favorites()->detach($book->BukuID);
                $isFavorited = false;
            } else {
                $user->favorites()->attach($book->BukuID);
                $isFavorited = true;
            }

            return response()->json([
                'success' => true,
                'isFavorited' => $isFavorited,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
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
    public function show(KoleksiPribadi $koleksiPribadi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KoleksiPribadi $koleksiPribadi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KoleksiPribadi $koleksiPribadi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KoleksiPribadi $koleksiPribadi)
    {
        //
    }
}
