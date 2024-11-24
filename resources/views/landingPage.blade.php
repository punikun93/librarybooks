<x-layout.app>
    <section
        class="bg-gradient-to-b from-amber-900 to-amber-700 text-white  flex items-center justify-center   h-screen">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center relative  flex flex-col justify-center items-center ">
                <!-- Title and Description -->
                <h1 class="text-4xl md:text-6xl font-bold mb-6 relative z-10">Unlock a World of Knowledge</h1>
                <p class="text-xl mb-8 relative z-10">Access millions of books, articles, and resources at your
                    fingertips.
                    Your journey to wisdom starts here.</p>
            
                @if (Auth::check() && Auth::user()->Role == 'peminjam')
                    <a href="{{ route('books.data') }}">
                        @include('btnExplode')
                    </a>
                @endif
                <!-- Book shadow elements -->
                <div class="absolute top-0 left-0 right-0 flex space-x-6 justify-center translate-y-0 sm:-translate-y-1/2 z-0  md:h-72">
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
            <div class="flex justify-center gap-x-4 pb-2 overflow-x-auto p-0 scrollbar-custom pl-0 ml-0">
                @foreach ($anas_books as $book)
                    <!-- Style 2: Rich & Bold -->
                    <div class=" best bg-amber-900 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col w-[35vh] flex-shrink-0 snap-start group relative overflow-hidden border-2 border-gray-800"
                        style="height: 50vh;">
                        <!-- Rating Badge -->
                        <div class="absolute bottom-0 w-full bg-amber-500 text-gray-300 py-2 px-4  z-20 flex items-center justify-center " >
                            <div class="px-4 py-2  bg-gray-900 text-whute rounded-full font-semibold">

                                {{ $loop->iteration }}
                            </div>
                        </div>
                        <div
                            class="absolute top-3 right-3 bg-amber-500 text-gray-900 px-4 py-2 rounded-lg z-10 flex items-center gap-2 shadow-lg font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span>{{ number_format($book->average_rating, 1) }}</span>
                        </div>

                        <!-- Review Count -->
                        <div
                            class="absolute top-3 left-3 bg-gray-800 text-white px-4 py-2 rounded-lg z-10 text-sm font-bold">
                            {{ $book->ulasanBuku->count() }} reviews
                        </div>

                            <button data-modal-target="bookModal-{{ $book->BukuID }}"
                                data-modal-toggle="bookModal-{{ $book->BukuID }}"
                                class="h-full bg-gray-800 flex items-center justify-center overflow-hidden group-hover:scale-110 transform transition-all duration-500 ease-out">
                                <img src="{{ asset('storage/' . $book->Gambar) }}" alt="Gambar Buku"
                                    class="w-full h-full object-cover opacity-90 group-hover:opacity-100">
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
    @include('autoReturn')

</x-layout.app>
