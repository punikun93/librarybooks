<!-- Modal for Book Details -->
<div id="bookModal-{{ $book->BukuID }}" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 left-0 right-0 z-50 w-full h-full overflow-y-auto overflow-x-hidden flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="bg-white rounded-lg shadow-xl">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900 truncate pr-4">
                    {{ $book->Judul }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                    data-modal-hide="bookModal-{{ $book->BukuID }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 space-y-4">
                <!-- Flexbox container for image and details -->
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Image Section -->
                    <div class="w-full md:w-1/2 mb-4 md:mb-0">
                        <img src="{{ asset('storage/' . $book->Gambar) }}" alt="Gambar Buku"
                            class="w-full h-[50vh] md:h-[60vh] object-cover rounded-lg">
                    </div>

                    <!-- Details Section -->
                    <div class="w-full md:w-1/2 flex flex-col justify-between">
                        <div>
                            <p class="text-gray-600 mb-2">Tahun Terbit: {{ $book->TahunTerbit }}
                            </p>
                            <p class="text-gray-800 mb-2">Penulis: {{ $book->Penulis }}</p>
                            <p class="text-gray-800 mb-2">Penerbit: {{ $book->Penerbit }}</p>

                            <!-- Categories -->
                            <div class="mb-4">
                                <h4 class="font-semibold text-lg text-gray-900">Kategori:</h4>
                                <div class="flex flex-wrap mt-2">
                                    @foreach ($book->kategori as $genre)
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full mr-2 mb-2">
                                            {{ $genre->NamaKategori ?? '-' }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Borrow Form -->
                        <form action="{{ route('borrow.store', $book->BukuID) }}" method="POST"
                            class="mt-auto">
                            @csrf
                            @if (Auth::check())
                                <input type="hidden" name="UserID"
                                    value="{{ Auth::user()->UserID }}">
                                <input type="hidden" name="PetugasID" value="no">
                            @endif

                            <!-- Borrow and Return Dates -->
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label for="borrowDate-{{ $book->BukuID }}"
                                        class="block text-sm font-medium text-gray-700">Borrow
                                        Date</label>
                                    <input type="date" name="TanggalPeminjaman"
                                        id="borrowDate-{{ $book->BukuID }}"
                                        min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                                        class="mt-1 block w-full border border-gray-300 text-black rounded-md p-2">
                                </div>
                                <div>
                                    <label for="returnDate-{{ $book->BukuID }}"
                                        class="block text-sm font-medium text-gray-700">Return
                                        Date</label>
                                    <input type="date" name="TanggalPengembalian"
                                        id="returnDate-{{ $book->BukuID }}"
                                        class="mt-1 block w-full border border-gray-300 text-black rounded-md p-2">
                                </div>
                            </div>

                            <input type="hidden" name="BukuID" value="{{ $book->BukuID }}">

                            @if (Auth::check() && auth()->user()->Role === 'peminjam')
                                @if ($book->isBooked)
                                    <button type="button" disabled
                                        class="w-full text-gray-400 bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-not-allowed">
                                        Buku Sudah Dipesan
                                    </button>
                                @else
                                    <button type="submit"
                                        class="w-full text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Sewa
                                    </button>
                                @endif
                            @else
                                <button type="button" disabled
                                    class="w-full text-gray-400 bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-not-allowed">
                                    Hanya dapat diakses oleh Peminjam
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>