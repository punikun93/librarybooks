<x-layout.app>
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-2 select-none">Riwayat Peminjaman Buku</h1>
                <p class="text-gray-600 select-none">Kelola dan pantau aktivitas peminjaman buku Anda</p>
            </div>

            <!-- Review Modal -->


            <!-- Main Content -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 select-none">
                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">Total Peminjaman</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ count($anas_peminjaman->whereIn('Status',['booked' , 'done'])) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">Sedang Dipinjam</h3>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $anas_peminjaman->where('Status','booked')->count()}}
                        </p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">Dikembalikan</h3>
                        <p class="text-2xl font-bold text-green-600">   
                            {{ $anas_pengembalian }}
                        </p>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="select-none px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Informasi Buku
                                </th>
                                <th scope="col"
                                    class="select-none px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status Peminjaman
                                </th>
                                <th scope="col"
                                    class="select-none px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Pengembalian
                                </th>
                                <th scope="col"
                                    class="select-none px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ulasan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($anas_peminjaman as $peminjaman)

                                <tr class="hover:bg-gray-50 transition-all duration-300">
                                    <td class="px-6 py-4 select-none">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 h-14 w-14">
                                                <img class="h-14 w-14 rounded-lg object-cover shadow-sm"
                                                    src="{{ asset('storage/' . $peminjaman->buku->Gambar) }}"
                                                    alt="Cover {{ $peminjaman->buku->Judul }}">
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $peminjaman->buku->Judul }}</h4>
                                                <p class="text-xs text-gray-500">Penulis:
                                                    {{ $peminjaman->buku->Penulis }}</p>
                                                <p class="text-xs text-gray-500">Penerbit:
                                                    {{ $peminjaman->buku->Penerbit }}</p>
                                                <p class="text-xs text-gray-500">Tahun Terbit:
                                                    {{ $peminjaman->buku->TahunTerbit }}</p>
                                                <span class="inline-block mt-1 text-xs text-gray-400">
                                                    Dipinjam pada: {{ $peminjaman->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 select-none">
                                        @if ($peminjaman->buku->isBooked)
                                            @if ($peminjaman->Status === 'proses')
                                                <span
                                                    class="px-3 py-1 inline-flex items-center space-x-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                    <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                                                    <span>Menunggu Konfirmasi</span>
                                                </span>
                                            @elseif ($peminjaman->Status === 'done')
                                                <span
                                                    class="px-3 py-1 inline-flex items-center space-x-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                                    <span>Selesai Dipinjam</span>
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex items-center space-x-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                                    <span>Sedang Dipinjam</span>
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex items-center space-x-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                                <span>Selesai</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 select-none">
                                        @if ($peminjaman->buku->isBooked)
                                            @if ($peminjaman->Status === 'proses')
                                                <span class="text-sm text-gray-400">Belum dapat dikembalikan</span>
                                            @elseif ($peminjaman->Status === 'booked')
                                                <button data-modal-toggle="kembalikan{{ $peminjaman->PeminjamanID }}"
                                                    data-modal-target="kembalikan{{ $peminjaman->PeminjamanID }}"
                                                    class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Kembalikan
                                                </button>
                                            @elseif ($peminjaman->Status === 'done')
                                                @if ($peminjaman->pengembalian->Status === 'proses')
                                                    <span
                                                        class="px-3 py-1 inline-flex items-center space-x-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                        <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                                        <span>Menunggu Verifikasi </span>
                                                    </span>
                                                @elseif ($peminjaman->pengembalian->Status === 'done')
                                                    <span class="text-sm text-gray-400">Sudah dikembalikan</span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 select-none">
                                        @if ($peminjaman->pengembalian->Status??'' === 'done')
                                            @if ($peminjaman->ulasan)
                                                <div class="space-y-2">
                                                    <div class="flex items-center space-x-1">
                                                        @for ($i = 0; $i < $peminjaman->ulasan->Rating; $i++)
                                                          ⭐
                                                        @endfor
                                                    </div>
                                                    <p class="text-sm text-gray-600">{{ $peminjaman->ulasan->Ulasan }}</p>
                                                </div>
                                            @else
                                                <button data-modal-toggle="ulasanModal{{ $peminjaman->PeminjamanID }}"
                                                    data-modal-target="ulasanModal{{ $peminjaman->PeminjamanID }}"
                                                    class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Beri Ulasan
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-sm text-gray-400">Belum dapat diulas</span>
                                        @endif
                                    </td>
                                    
                                </tr>
                                <div id="ulasanModal{{ $peminjaman->PeminjamanID }}" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full backdrop-blur">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                        <form action="{{ route('ulasan.store') }}" method="POST">
                                            @csrf
                                            <div class="relative bg-white rounded-lg shadow">
                                                <!-- Modal Header -->
                                                <div class="flex justify-between items-center p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-medium text-gray-900">
                                                        Ulasan untuk {{ $peminjaman->buku->Judul }}
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                                        data-modal-hide="ulasanModal{{ $peminjaman->PeminjamanID }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="p-6 space-y-4">
                                                    <label for="rating"
                                                        class="block text-sm font-medium text-gray-700">Rating</label>
                                                    <div id="ratingContainer{{ $peminjaman->PeminjamanID }}"
                                                        class="flex items-center">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <button type="button" data-rating="{{ $i }}"
                                                                class="rating-star text-gray-400 hover:text-yellow-500">
                                                                <svg class="w-6 h-6" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            </button>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="Rating"
                                                        id="ratingInput{{ $peminjaman->PeminjamanID }}">
                                                    <input type="hidden" name="BukuID"
                                                        value="{{ $peminjaman->BukuID }}">
                                                    <input type="hidden" name="PeminjamanID"
                                                        value="{{ $peminjaman->PeminjamanID }}">
                                                    <label for="review"
                                                        class="block text-sm font-medium text-gray-700 mt-4">Ulasan</label>
                                                    <textarea id="review" rows="4" name="Ulasan"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Bagikan pendapat Anda..."></textarea>
                                                </div>
                                                <!-- Modal Footer -->
                                                <div class="flex items-center justify-end p-6 space-x-2 border-t">
                                                    <button
                                                        data-modal-hide="ulasanModal{{ $peminjaman->PeminjamanID }}"
                                                        type="button"
                                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5">Batal</button>
                                                    <button type="Submit"
                                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5">Kirim</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        document.querySelectorAll("[id^='ratingContainer']").forEach(container => {
                                            const stars = container.querySelectorAll(".rating-star");
                                            const ratingInput = document.querySelector(
                                                `#ratingInput${container.id.replace("ratingContainer", "")}`);
                                            stars.forEach(star => {
                                                star.addEventListener("click", () => {
                                                    const rating = star.getAttribute("data-rating");
                                                    // Update input value
                                                    ratingInput.value = rating;
                                                    // Update star colors
                                                    stars.forEach(s => {
                                                        if (s.getAttribute("data-rating") <= rating) {
                                                            s.classList.add("text-yellow-500");
                                                            s.classList.remove("text-gray-400");
                                                        } else {
                                                            s.classList.remove("text-yellow-500");
                                                            s.classList.add("text-gray-400");
                                                        }
                                                    });
                                                });
                                            });
                                        });
                                    });
                                </script>
                                <div id="kembalikan{{ $peminjaman->PeminjamanID }}" tabindex="-1"
                                    aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full backdrop-blur">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                        <form action="{{ route('pengembalian.store') }}" method="POST">
                                            @csrf
                                            <div class="relative bg-white rounded-lg shadow">
                                                <!-- Modal Header -->
                                                <div class="flex justify-between items-center p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-medium text-gray-900">
                                                        Kembalikan Buku {{ $peminjaman->buku->Judul }}
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                                        data-modal-hide="kembalikan{{ $peminjaman->PeminjamanID }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="p-6 space-y-4">
                                                    <label for="yakin"
                                                        class="block text-sm font-medium text-gray-700">Apakah Anda
                                                        yakin
                                                        ingin mengembalikan buku ini?</label>

                                                </div>
                                                <input type="hidden" name="PeminjamanID"
                                                    value="{{ $peminjaman->PeminjamanID }}">
                                                <input type="hidden" name="BukuID"
                                                    value="{{ $peminjaman->BukuID }}">
                                                <!-- Modal Footer -->
                                                <div class="flex items-center justify-end p-6 space-x-2 border-t">
                                                    <button
                                                        data-modal-hide="kembalikan{{ $peminjaman->PeminjamanID }}"
                                                        type="button"
                                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5">Batal</button>
                                                    <button type="submit"
                                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5">Kembalikan</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <p class="mt-4 text-gray-500">Belum ada riwayat peminjaman</p>
                                            <a href="#"
                                                class="mt-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                Pinjam buku sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function submitReview() {
                // You'll need to implement the AJAX call to submit the review
                fetch('/submit-review', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            book: this.selectedBook,
                            rating: this.rating,
                            review: this.review
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close modal and reset form
                            this.showModal = false;
                            this.rating = 0;
                            this.review = '';
                            this.selectedBook = null;

                            // Optionally refresh the page or update the UI
                            window.location.reload();
                        } else {
                            alert('Terjadi kesalahan saat menyimpan ulasan. Silakan coba lagi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan ulasan. Silakan coba lagi.');
                    });
            }
        </script>
    @endpush

</x-layout.app>
