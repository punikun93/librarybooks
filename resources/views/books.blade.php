<x-layout.app>
    <section
        class="bg-gradient-to-b from-amber-900 to-amber-700 text-white flex items-center justify-center min-h-screen m-0">
        <div class="container px-4">


            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 pb-4">
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
                                    <x-love-icon filled="true" size="w-8 h-8" color="text-red-500" />
                                @else
                                    <x-love-icon filled="true" size="w-8 h-8" color="text-gray-500" />
                                @endif
                            </div>
                        </button>
                        <!-- Bold Overlay -->
                        <button data-modal-target="bookModal-{{ $book->BukuID }}"
                            data-modal-toggle="bookModal-{{ $book->BukuID }}">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                <span
                                    class="text-white text-xl font-bold px-6 py-3 border-2 border-white rounded-lg hover:bg-white hover:text-gray-900 transition-colors duration-300">View
                                    Details</span>
                            </div>
                        </button>


                    </div>

                        @include('modalBukuDetail')
                @endforeach
            </div>
        </div>
        @include('scrollbar')
        @include('autoReturn')



    </section>

</x-layout.app>
