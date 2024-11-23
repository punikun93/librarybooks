<x-layout.app>
    <section
        class="bg-gradient-to-b from-amber-900 to-amber-700 text-white flex items-center justify-center min-h-screen m-0">
        <div class="container px-4">
            <!-- Categories Section -->
            <div class="mb-6 overflow-x-auto scrollbar-custom">
                <div class="flex gap-2 min-w-max px-2">
                    <button
                        class="category-button active px-6 py-2 rounded-full bg-amber-600 text-white transition-all duration-300 hover:bg-amber-700"
                        data-category="all">
                        All Books
                    </button>
                    @foreach ($anas_kategori as $category)
                        <button
                            class="category-button px-6 py-2 rounded-full text-white bg-amber-800/50 hover:bg-amber-600 transition-all duration-300"
                            data-category="{{ $category->id }}">
                            {{ $category->NamaKategori }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2 pb-4">
                @foreach ($anas_books as $book)
                    <!-- Book Card -->
                    <div class="best bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col w-[35vh] flex-shrink-0 snap-start group relative overflow-y-hidden overflow-x-hidden"
                        style="height: 50vh;">


                        <button data-modal-target="bookModal-{{ $book->BukuID }}"
                            data-modal-toggle="bookModal-{{ $book->BukuID }}"
                            class="h-full bg-gray-950 rounded-t-lg flex items-center justify-center overflow-hidden cursor-pointer  transform transition-all duration-300 ease-in-out">
                            <img src="{{ asset('storage/' . $book->Gambar) }}" alt="Gambar Buku"
                                class="w-full h-full object-cover rounded-t-lg 
                                     @if ($book->isBooked) grayscale opacity-70 @endif">
                        </button>

                        {{-- Make sure to include CSRF token in your layout --}}
                        @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const csrfToken = '{{ csrf_token() }}';

                                    // Hapus event listener lama sebelum menambahkan yang baru
                                    document.querySelectorAll('.favorite-btn').forEach(button => {
                                        // Gunakan event delegation untuk menghindari multiple listeners
                                        button.onclick = function(e) {
                                            e.preventDefault();
                                            const bookId = this.getAttribute('data-book-id');
                                            const userId = this.getAttribute('data-user-id');
                                            const currentButton = this; // Simpan referensi ke button yang diklik

                                            console.log('Clicked button:', bookId, userId); // Debug info

                                            fetch('/toggle-favorite', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': csrfToken
                                                    },
                                                    body: JSON.stringify({
                                                        book_id: bookId,
                                                        user_id: userId,
                                                    }),
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        if (data.isFavorited) {
                                                            currentButton.innerHTML =
                                                                `<div class="bg p-1 bg-white rounded-full"><x-love-icon filled="true" size="w-8 h-8" color="text-red-500" /> </div`;
                                                        } else {
                                                            currentButton.innerHTML =
                                                                `<div class="bg p-1 bg-white rounded-full"><x-love-icon filled="true" size="w-8 h-8" color="text-gray-500" /> </div`;
                                                        }
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                });
                                        };
                                    });
                                });
                            </script>
                        @endpush

                        {{-- Favorite button component --}}
                        <button id="favorite-btn-{{ $book->BukuID }}"
                            class="favorite-btn p-2  absolute z-30 top-2 right-2 group-hover:scale-110 transition-all duration-300 ease-in-out"
                            data-book-id="{{ $book->BukuID }}" data-user-id="{{ auth()->user()->UserID }}">
                            <div class="bg p-1 bg-white rounded-full">
                                @if (auth()->user()->favorites->contains($book->BukuID))
                                    {{-- Filled Heart Icon --}}

                                    <x-love-icon filled="true" size="w-8 h-8" color="text-red-500" />
                                @else
                                    <x-love-icon filled="true" size="w-8 h-8" color="text-gray-500" />
                                @endif
                            </div>
                        </button>

                        <button data-modal-target="bookModal-{{ $book->BukuID }}"
                            data-modal-toggle="bookModal-{{ $book->BukuID }}">
                            <div
                                class="absolute w-full inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-white text-lg font-semibold">View Details</span>
                            </div>
                        </button>


                    </div>

                    <!-- Modal for Book Details -->
                    <div id="bookModal-{{ $book->BukuID }}" tabindex="-1" aria-hidden="true"
                        class="hidden fixed top-0 left-0 z-50 w-full h-full justify-center items-center bg-black/50">
                        <div class="w-full max-w-xl h-auto ">
                            <!-- Modal content -->
                            <div class="w-full h-auto bg-white rounded-lg shadow">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        {{ $book->Judul }}
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
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
                                <div class="p-4 md:p-5 flex flex-col md:flex-row gap-4">
                                    <!-- Image Section -->
                                    <div class="w-full md:w-1/2 h-px[30vh]">
                                        <img src="{{ asset('storage/' . $book->Gambar) }}" alt="Gambar Buku"
                                            class="object-cover w-full h-full rounded-lg">
                                    </div>

                                    <!-- Details Section -->
                                    <div class="w-full md:w-1/2 flex flex-col justify-between">
                                        <div>
                                            <p class="text-gray-600 mb-4">Tahun Terbit:
                                                {{ $book->TahunTerbit }}</p>
                                            <p class="text-gray-800 mb-4">Penulis: {{ $book->Penulis }}</p>
                                            <p class="text-gray-800 mb-4">Penerbit: {{ $book->Penerbit }}</p>

                                            <!-- Categories -->
                                            <div class="mb-4">
                                                <h4 class="font-semibold text-lg text-gray-900">Kategori:</h4>
                                                <ul class="flex flex-wrap mt-2">
                                                    @foreach ($book->kategori as $genre)
                                                        <li
                                                            class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full mr-2 mb-2 shadow-sm">
                                                            {{ $genre->NamaKategori ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>


                                        </div>

                                        <form action="{{ route('borrow.store') }}" method="POST" class="mt-4">
                                            @csrf

                                            @if (Auth::check() && Auth::user()->Role == 'peminjam')
                                                <!-- Input Hidden untuk User -->
                                                <input type="hidden" name="UserID"
                                                    value="{{ Auth::user()->UserID }}">
                                                <input type="hidden" name="PetugasID" value="no">
                                                <input type="hidden" name="BukuID" value="{{ $book->BukuID }}">
                                                <!-- Buku Tersedia untuk Disewa -->
                                                @if (!$isFullUser)
                                                    @if ($book->isBooked)
                                                        <!-- Show nothing if the book is already booked -->
                                                    @else
                                                        <div class="mb-4">
                                                            <label for="borrowDate"
                                                                class="block text-sm font-medium text-gray-700">Tanggal
                                                                Peminjaman</label>
                                                            <input type="date" name="TanggalPeminjaman"
                                                                id="borrowDate" min="{{ date('Y-m-d') }}"
                                                                value="{{ date('Y-m-d') }}"
                                                                class="mt-1 block w-full border border-gray-300 text-black rounded-md p-2 focus:ring-amber-500 focus:border-amber-500"
                                                                required>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label for="returnDate"
                                                                class="block text-sm font-medium text-gray-700">Tanggal
                                                                Pengembalian</label>
                                                            <input type="date" name="TanggalPengembalian"
                                                                id="returnDate"
                                                                class="mt-1 block w-full border border-gray-300 text-black rounded-md p-2 focus:ring-amber-500 focus:border-amber-500"
                                                                required >
                                                        </div>
                                                    @endif
                                                @endif

                                                @if ($isFullUser)
                                                    @if ($book->isBooked)
                                                        <!-- Buku sudah dipesan oleh pengguna lain -->
                                                        <button type="button" disabled
                                                            class="text-gray-400 bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full cursor-not-allowed">
                                                            Buku Sudah Dipesan
                                                        </button>
                                                    @else
                                                        <!-- User mencapai batas 3 buku -->
                                                        <p class="text-red-500 font-medium mb-2">Anda sudah meminjam
                                                            sampai batas 3 buku.</p>
                                                    @endif
                                                @else
                                                    <!-- Buku tersedia untuk dipinjam -->
                                                    @if ($book->isBooked)
                                                        <!-- Buku sudah dipesan oleh pengguna lain -->
                                                        <button type="button" disabled
                                                            class="text-gray-400 bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full cursor-not-allowed">
                                                            Buku Sudah Dipesan
                                                        </button>
                                                    @else
                                                        <!-- Tombol Sewa Aktif -->
                                                        <button type="submit"
                                                            class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full">
                                                            Sewa
                                                        </button>
                                                    @endif
                                                @endif
                                            @else
                                                <!-- Hanya untuk pengguna dengan role 'peminjam' -->
                                                <button type="button" disabled
                                                    class="text-gray-400 bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full cursor-not-allowed">
                                                    Hanya dapat diakses oleh Peminjam
                                                </button>
                                            @endif
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('scrollbar')
        <script>
            (function () {
                // Calculate return date max (7 days from borrow date)
                const calculateMaxReturnDate = (date) => {
                    const result = new Date(date);
                    result.setDate(result.getDate() + 7);
                    return result.toISOString().split('T')[0];
                };
        
                // Initialize date inputs
                const initializeDateInputs = () => {
                    document.querySelectorAll('input[name="TanggalPeminjaman"]').forEach((borrowInput, index) => {
                        const returnInput = document.querySelectorAll('input[name="TanggalPengembalian"]')[index];
                        if (!returnInput) return;
        
                        // Update return date on borrow date change
                        borrowInput.addEventListener('change', () => {
                            const borrowDate = borrowInput.value;
        
                            if (!borrowDate) {
                                returnInput.value = "";
                                returnInput.removeAttribute("min");
                                returnInput.removeAttribute("max");
                                return;
                            }
        
                            const maxDate = calculateMaxReturnDate(borrowDate);
        
                            returnInput.setAttribute("min", borrowDate); // Minimal pengembalian sama dengan tanggal peminjaman
                            returnInput.setAttribute("max", maxDate);   // Maksimal pengembalian 7 hari setelah peminjaman
        
                            // Jika nilai saat ini di luar batas, sesuaikan
                            if (returnInput.value < borrowDate || returnInput.value > maxDate) {
                                returnInput.value = borrowDate;
                            }
                        });
        
                        // Set default values when initialized
                        borrowInput.dispatchEvent(new Event("change"));
                    });
                };
        
                // Initialize when DOM is ready
                document.readyState === "loading"
                    ? document.addEventListener("DOMContentLoaded", initializeDateInputs)
                    : initializeDateInputs();
            })();
        </script>
        
        

    </section>

</x-layout.app>
