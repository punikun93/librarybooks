<x-layout.app>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($anas_koleksi->count() > 0)
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Koleksi Pribadi</h1>
                <p class="text-gray-600">Buku-buku favorit yang telah Anda simpan</p>
            </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($anas_koleksi as $koleksi)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="relative pb-[60%]">
                                @if($koleksi->buku->Gambar)
                                    <img src="{{ asset('storage/' . $koleksi->buku->Gambar) }}" 
                                         alt="{{ $koleksi->buku->Judul }}"
                                         class="absolute h-full w-full object-cover">
                                @else
                                    <div class="absolute h-full w-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Favorite Button --}}
                                <button id="favorite-btn-{{ $koleksi->buku->BukuID }}"
                                    class="favorite-btn p-2 absolute z-30 top-2 right-2 group-hover:scale-110 transition-all duration-300 ease-in-out"
                                    data-book-id="{{ $koleksi->buku->BukuID }}" 
                                    data-user-id="{{ auth()->user()->UserID }}">
                                    <div class="bg p-1 bg-white rounded-full">
                                        <x-love-icon filled="true" size="w-8 h-8" color="text-red-500" />
                                    </div>
                                </button>
                            </div>
                            
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $koleksi->buku->Judul }}
                                </h2>
                                <p class="text-sm text-gray-600 mb-2">
                                    {{ $koleksi->buku->Penulis }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">
                                        {{ $koleksi->buku->TahunTerbit }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
            <div class="text-center py-12 flex flex-col max-w-3xl mx-auto rounded-2xl justify-center items-center h-screen bg-amber-100">
                <!-- Ikon dengan animasi -->
                <svg class="mx-auto h-24 w-24 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                
                <!-- Judul dengan gaya lebih kreatif -->
                <h3 class="mt-6 text-3xl font-semibold text-amber-800">Ups, Koleksi Kosong!</h3>
                <p class="mt-4 text-lg text-gray-700">Sepertinya Anda belum menambahkan buku ke koleksi pribadi Anda.</p>
                <p class="mt-4 text-sm text-gray-500">Mulai tambahkan buku agar koleksi Anda terlihat di sini.</p>
                
                <!-- Tombol Aksi dengan animasi hover -->
                <div class="mt-8">
                    <a href="{{ route('books.data') }}" class="relative inline-flex items-center px-8 py-3 font-medium text-white bg-amber-600 rounded-lg shadow-lg group hover:bg-amber-700 focus:outline-none focus:ring-4 focus:ring-amber-300 transition duration-300 ease-in-out transform hover:scale-105">
                        <span class="absolute left-0 w-0  bg-amber-700 group-hover:w-full  group-hover:h-full transition-all duration-300 ease-in-out rounded-lg"></span>
                        <span class="relative z-10">Perpustakaan</span>
                    </a>
                </div>
            </div> 
            @endif
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = '{{ csrf_token() }}';
    
            document.querySelectorAll('.favorite-btn').forEach(button => {
                button.onclick = function(e) {
                    e.preventDefault();
                    const bookId = this.getAttribute('data-book-id');
                    const userId = this.getAttribute('data-user-id');
                    const currentButton = this;
                    const cardElement = currentButton.closest('.bg-white'); // Get the parent card element
    
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
                            if (!data.isFavorited) {
                                // Animate and remove the card
                                cardElement.style.transition = 'all 0.5s ease';
                                cardElement.style.transform = 'scale(0.8)';
                                cardElement.style.opacity = '0';
                                
                                setTimeout(() => {
                                    cardElement.remove();
                                    // Check if there are no more cards
                                    const remainingCards = document.querySelectorAll('.bg-white').length;
                                    if (remainingCards === 0) {
                                        location.reload(); // Reload to show empty state
                                    }
                                }, 500);
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
    </x-layout.app>