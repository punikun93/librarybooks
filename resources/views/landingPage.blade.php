<x-layout.app>
    <section
        class="bg-gradient-to-b from-amber-900 to-amber-700 text-white  flex items-center justify-center relative  h-screen">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center relative  flex flex-col justify-center items-center ">
                <!-- Title and Description -->
                <h1 class="text-4xl md:text-6xl font-bold mb-6 relative z-10">Unlock a World of Knowledge</h1>
                <p class="text-xl mb-8 relative z-10">Access millions of books, articles, and resources at your
                    fingertips.
                    Your journey to wisdom starts here.</p>
                <style>
                    /* Button Container */
                    .Btn-Container {
                        display: flex;
                        width: 170px;
                        height: fit-content;
                        background: linear-gradient(to right, #f59e0b, #d97706);
                        /* Gradien amber */
                        border-radius: 40px;
                        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
                        justify-content: space-between;
                        align-items: center;
                        margin-top: 8px;
                        border: none;
                        cursor: pointer;
                        transition: all 0.3s ease;
                    }

                    .Btn-Container:hover {
                        transform: scale(1.05);
                        /* Zoom-in efek */
                    }

                    .icon-Container {
                        width: 45px;
                        height: 45px;
                        background-color: #1f2937;
                        /* Dark grey */
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 50%;
                        border: 3px solid #f59e0b;
                    }

                    .text {
                        width: calc(170px - 45px);
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        /* Tetap putih untuk kontras */
                        font-size: 1.1em;
                        letter-spacing: 1.2px;
                    }

                    .icon-Container svg {
                        transition-duration: 1.5s;
                        fill: #fbbf24;
                        /* Warna kuning kontras */
                    }

                    .Btn-Container:hover .icon-Container svg {
                        animation: arrow 1s linear infinite;
                        fill: #fde68a;
                        /* Ikon lebih terang saat hover */
                    }

                    @keyframes arrow {
                        0% {
                        opacity: 0;
                            margin-left: 0px;
                        }

                        100% {
                            opacity: 1;
                            margin-left: 10px;
                        }
                    }
                </style>
                @if (Auth::check() && Auth::user()->Role == 'peminjam')
                    <a href="{{ route('books.data') }}">
                        <button class="Btn-Container">
                            <span class="text">Explode</span>
                            <span class="icon-Container">
                                <svg width="16" height="19" viewBox="0 0 16 19"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="1.61321" cy="1.61321" r="1.5" fill="currentColor"></circle>
                                    <circle cx="5.73583" cy="1.61321" r="1.5" fill="currentColor"></circle>
                                    <circle cx="5.73583" cy="5.5566" r="1.5" fill="currentColor"></circle>
                                    <circle cx="9.85851" cy="5.5566" r="1.5" fill="currentColor"></circle>
                                    <circle cx="9.85851" cy="9.5" r="1.5" fill="currentColor"></circle>
                                    <circle cx="13.9811" cy="9.5" r="1.5" fill="currentColor"></circle>
                                    <circle cx="5.73583" cy="13.4434" r="1.5" fill="currentColor"></circle>
                                    <circle cx="9.85851" cy="13.4434" r="1.5" fill="currentColor"></circle>
                                    <circle cx="1.61321" cy="17.3868" r="1.5" fill="currentColor"></circle>
                                    <circle cx="5.73583" cy="17.3868" r="1.5" fill="currentColor"></circle>
                                </svg>
                            </span>
                        </button>
                    </a>
                @endif



                <!-- Book shadow elements -->
                <div
                    class="absolute top-0 left-0 right-0 flex space-x-6 justify-center translate-y-0 sm:-translate-y-1/2 z-0  md:h-72">
                    <!-- Buku 1, miring ke kiri -->
                    <div
                        class="best sm:w-2/4 w-1/4  shadow-xl rounded-lg transform  rotate-[-15deg] opacity-30  transition-opacity duration-300">
                        <img src="{{ asset('images/balik.jpg') }}" class="object-cover border-l-8 pl-1" alt="">
                    </div>
                    <!-- Buku 2, tetap tegak -->
                    <div
                        class="best sm:w-2/4 w-1/4  shadow-xl rounded-lg transform  opacity-30  transition-opacity duration-300">
                        <img src="{{ asset('images/php.jpg') }}" class="object-cover pb-1" alt="">
                    </div>
                    <!-- Buku 3, miring ke kanan -->
                    <div
                        class="best sm:w-2/4 w-1/4  shadow-xl rounded-lg transform  opacity-30 rotate-[15deg]  transition-opacity duration-300">
                        <img src="{{ asset('images/sejarah.jpg') }}" class="object-cover border-r-8 pr-1"
                            alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>
    {{-- <section
class="bg-gradient-to-b from-amber-900 to-amber-700 text-white  flex items-center justify-center relative  h-screen">
<div class="container mx-auto px-4">
    <div class="max-w-3xl mx-auto text-center ">
        <!-- Title and Description -->
        <h1 class="text-4xl md:text-6xl font-bold mb-6 relative z-10">Unlock a World of Knowledge</h1>
        <p class="text-xl mb-8 relative z-10">Access millions of books, articles, and resources at your
            fingertips.
            Your journey to wisdom starts here.</p>

        <!-- Book shadow elements -->
        <div
            class="absolute top-0 left-0 right-0 flex space-x-6 justify-center z-0  md:h-72">
            <!-- Buku 1, miring ke kiri -->
            <div
                class="best w-1/4 bg-white  shadow-xl rounded-lg transform  rotate-[-15deg] opacity-30  transition-opacity duration-300">
                <img src="{{ asset('images/balik.jpg') }}" class="object-cover"
                    alt="">
            </div>
            <!-- Buku 2, tetap tegak -->
            <div
                class="best w-1/4 bg-white  shadow-xl rounded-lg transform  opacity-30 z-10  transition-opacity duration-300">
                <img src="{{ asset('images/php.jpg') }}" class="object-cover" alt="">
            </div>
            <!-- Buku 3, miring ke kanan -->
            <div
                class="best w-1/4 bg-white  shadow-xl rounded-lg transform  opacity-30 rotate-[15deg]  transition-opacity duration-300">
                <img src="{{ asset('images/sunyi.webp') }}" class="object-cover" alt="">
            </div>
        </div>

    </div>
</div>
</section> --}}
    <section
        class="bg-gradient-to-b from-amber-900 to-amber-700 text-white flex items-center justify-center min-h-screen m-0">
        <div class="container px-4">
            <!-- Title Section -->
            <div class="text-center mb-6">
                <h1 class="text-4xl font-bold text-white">
                    Best Books by Rating 📚⭐
                </h1>
            </div>

            <!-- Book Cards Container -->
            <div class="flex gap-x-4 pb-2 overflow-x-auto p-0 scrollbar-custom pl-0 ml-0">
                @foreach ($anas_books as $book)
                    <!-- Book Card -->
                    <div class="best bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col w-[35vh] flex-shrink-0 snap-start group relative overflow-y-hidden overflow-x-hidden"
                        style="height: 50vh;">

                        <!-- Book Cover (Modal Trigger) -->

                        <button data-modal-target="bookModal-{{ $book->BukuID }}"
                            data-modal-toggle="bookModal-{{ $book->BukuID }}"
                            class="h-full bg-gray-100 rounded-t-lg flex items-center justify-center overflow-hidden cursor-pointer group-hover:scale-105 transform transition-all duration-300 ease-in-out">
                            <img src="{{ asset('storage/' . $book->Gambar) }}" alt="Gambar Buku"
                                class="w-full h-full object-cover rounded-t-lg">
                        </button>

                        <!-- Book Card Hover Effect: Book Details -->
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
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
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
                                                            class="mt-1 block w-full border border-gray-300 text-black rounded-md p-2"
                                                            readonly>
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

                    <script>
                        (function() {
                            const calculateReturnDate = (date) => {
                                const result = new Date(date);
                                result.setDate(result.getDate() + 7);
                                return result.toISOString().split('T')[0];
                            };

                            const getLocalDate = () => {
                                const now = new Date();
                                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                                return now.toISOString().split('T')[0];
                            };

                            const initializeDateInputs = () => {
                                const modals = document.querySelectorAll('[id^="bookModal-"]');
                                modals.forEach(modal => {
                                    const borrowInput = modal.querySelector('input[name="TanggalPeminjaman"]');
                                    const returnInput = modal.querySelector('input[name="TanggalPengembalian"]');

                                    if (!borrowInput || !returnInput) return;

                                    const today = getLocalDate();
                                    borrowInput.value = borrowInput.min = today;
                                    returnInput.value = returnInput.min = calculateReturnDate(today);

                                    borrowInput.addEventListener('change', () => {
                                        const newDate = calculateReturnDate(borrowInput.value);
                                        returnInput.value = returnInput.min = newDate;
                                    });
                                });
                            };

                            document.readyState === 'loading' ?
                                document.addEventListener('DOMContentLoaded', initializeDateInputs) :
                                initializeDateInputs();
                        })();
                    </script>
                @endforeach
            </div>
        </div>
        @include('scrollbar')

    </section>






    <section id="features" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Why Choose DigiLib?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-amber-100 rounded-lg p-6 shadow-lg transform hover:scale-105 transition duration-300">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-12 h-12 text-amber-700 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Vast Collection</h3>
                    <p>Explore our extensive library with millions of titles across various genres and subjects.
                    </p>
                </div>
                <div class="bg-amber-100 rounded-lg p-6 shadow-lg transform hover:scale-105 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-12 h-12 text-amber-700 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Personalized Experience</h3>
                    <p>Get tailored book recommendations based on your reading preferences and history.</p>
                </div>
                <div class="bg-amber-100 rounded-lg p-6 shadow-lg transform hover:scale-105 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-12 h-12 text-amber-700 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Unlock Knowledge</h3>
                    <p>Get tailored book recommendations based on your reading preferences and history</p>
                </div>
            </div>
        </div>
    </section>

    @if (!Auth::check())

        <section id="collections" class="py-20 bg-amber-100">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Explore Our Books by Category</h2>
                <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
                    <!-- Left Section -->
                    <div class="w-full md:w-1/2 bg-amber-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-white text-xl font-semibold mb-2">Description Categories</h3>
                        <p class="text-white text-sm">...</p>
                    </div>
                    <!-- Right Section (Category Items Grid) -->
                    <div
                        class="w-full md:w-1/2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 cursor-pointer text-center items-center">
                        @foreach ($anas_kategori as $item)
                            <div
                                class="bg-white rounded-lg p-4 overflow-hidden shadow-lg transform hover:bg-amber-300 transition duration-300 ease-in-out">
                                <h3 class="text-md font-semibold">{{ $item->NamaKategori }}</h3>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif


    @if (!Auth::check())
        <section id="cta" class="py-20 bg-amber-700 text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Start Your Reading Journey Today</h2>
                <p class="text-xl mb-8">Join thousands of satisfied readers and unlock unlimited access to our
                    vast
                    library.</p>
                <a href="{{ route('register') }}"
                    class="bg-white text-amber-900 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-amber-100 transition duration-300">Sign
                    Up Now</a>
            </div>
        </section>
    @endif
</x-layout.app>
