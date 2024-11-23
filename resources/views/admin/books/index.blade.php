<x-layout.admin>
    <div class="p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">Books</h1>
            <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                <button class="inline-block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:relative"
                    data-modal-target="createBookModal" data-modal-toggle="createBookModal">
                    Create Book
                </button>
            </span>
        </div>

        <!-- New Books Grid Display -->
        <div class="mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($anas_books as $book)
                    <div
                        class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <!-- Book Cover -->
                        <div class="h-48 bg-gray-100 rounded-t-lg flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/' . $book->Gambar) }}" alt="Gambar Buku"
                                class="w-full h-full object-cover">
                        </div>

                        <!-- Book Info -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <!-- Title and Year -->
                            <div>
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-gray-800 truncate">{{ $book->Judul }}</h3>
                                    <span class="text-sm text-gray-500">{{ $book->TahunTerbit }}</span>
                                </div>

                                <!-- Author -->
                                <div class="flex items-center text-sm text-gray-600 mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 9.75a3 3 0 11-6 0 3 3 0 016 0zM17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975M17.982 18.725a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275" />
                                    </svg>
                                    {{ $book->Penulis }}
                                </div>

                                <!-- Publisher -->
                                <div class="flex items-center text-sm text-gray-600 mt-2">
                                    Penerbit: {{ $book->Penerbit }}
                                </div>

                                <!-- Categories -->
                                <div class="mt-3">
                                    <h4 class="text-sm font-semibold text-gray-700">Kategori:</h4>
                                    <ul class="flex flex-wrap mt-1">
                                        @foreach ($book->kategori as $genre)
                                            <li
                                                class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full mr-2 mb-2 shadow-sm">
                                                {{ $genre->NamaKategori ?? '-' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 flex justify-end space-x-2">
                                <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">

                                    <button data-modal-target="editBookModal{{ $book->BukuID }}"
                                        data-modal-toggle="editBookModal{{ $book->BukuID }}"
                                        class="inline-block border-e p-3 text-gray-700 hover:bg-gray-50 focus:relative">
                                        <x-edit-icon class="w-4 h-4" />
                                    </button>
                                    <button data-modal-target="deleteBookModal{{ $book->BukuID }}"
                                        data-modal-toggle="deleteBookModal{{ $book->BukuID }}"
                                        class="inline-block border-e p-3 text-gray-700 hover:bg-gray-50 focus:relative">
                                        <x-delete-icon class="w-4 h-4" />
                                    </button>

                                </span>

                            </div>
                        </div>
                    </div>

                    <div id="editBookModal{{ $book->BukuID }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden backdrop-blur z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 sm:p-6">
                            <h2 class="text-xl sm:text-2xl font-semibold mb-4">Edit Book</h2>
                            <form action="{{ route('books.update', $book->BukuID) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                    
                                <!-- Input: Judul -->
                                <div class="mb-3">
                                    <label for="editBookTitle{{ $book->BukuID }}" class="block text-sm font-medium text-gray-700">Judul</label>
                                    <input type="text" name="Judul" id="editBookTitle{{ $book->BukuID }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" value="{{ $book->Judul }}" required>
                                </div>
                    
                                <!-- Input: Penulis -->
                                <div class="mb-3">
                                    <label for="editBookAuthor{{ $book->BukuID }}" class="block text-sm font-medium text-gray-700">Penulis</label>
                                    <input type="text" name="Penulis" id="editBookAuthor{{ $book->BukuID }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" value="{{ $book->Penulis }}" required>
                                </div>
                    
                                <!-- Input: Penerbit -->
                                <div class="mb-3">
                                    <label for="editBookPublisher{{ $book->BukuID }}" class="block text-sm font-medium text-gray-700">Penerbit</label>
                                    <input type="text" name="Penerbit" id="editBookPublisher{{ $book->BukuID }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" value="{{ $book->Penerbit }}" required>
                                </div>
                    
                                <!-- Input: Tahun Terbit -->
                                <div class="mb-3">
                                    <label for="editBookYear{{ $book->BukuID }}" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                                    <input type="number" name="TahunTerbit" id="editBookYear{{ $book->BukuID }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" value="{{ $book->TahunTerbit }}" required min="1800" max="{{ date('Y') }}">
                                </div>
                    
                                <!-- Input: Kategori -->
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                                        @foreach ($anas_kategori as $kategori)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="KategoriID[]" value="{{ $kategori->KategoriID }}"
                                                    id="kategori{{ $kategori->KategoriID }}"
                                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                    @if ($book->kategori->contains('KategoriID', $kategori->KategoriID)) checked @endif>
                                                <label for="kategori{{ $kategori->KategoriID }}" class="ml-2 text-xs text-gray-700">
                                                    {{ $kategori->NamaKategori }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                    
                                <!-- Input: Gambar Buku -->
                                <div class="mb-3">
                                    <label for="editBookCover{{ $book->BukuID }}" class="block text-sm font-medium text-gray-700">Gambar Buku</label>
                                    <input type="file" name="cover" id="editBookCover{{ $book->BukuID }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm">
                                </div>
                    
                                <!-- Buttons -->
                                <div class="flex justify-end space-x-2">
                                    <button type="button" data-modal-hide="editBookModal{{ $book->BukuID }}"
                                        class="px-3 py-2 mr-2 text-sm text-gray-700 bg-gray-200 rounded-md">Cancel</button>
                                    <button type="submit" class="px-3 py-2 text-sm text-white bg-blue-600 rounded-md">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    



                    <!-- Delete Book Modal -->
                    <div id="deleteBookModal{{ $book->BukuID }}"
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden backdrop-blur z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                            <h2 class="text-2xl font-semibold mb-4">Delete Book</h2>
                            <p class="mb-4">Are you sure you want to delete <span class="font-semibold underline"
                                    id="deleteMessage"></span> ?</p>
                            <form id="deleteBookForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('books.destroy', $book->BukuID) }}">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end">
                                    <button type="button" data-modal-hide="deleteBookModal{{ $book->BukuID }}"
                                        class="px-4 py-2 mr-2 text-sm text-gray-700 bg-gray-200 rounded-md">Cancel</button>
                                    <button type="submit"
                                        class="px-4 py-2 text-sm text-white bg-red-600 rounded-md">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    
        <!-- Create Book Modal -->
        <div id="createBookModal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden backdrop-blur z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 sm:p-6">
                <h2 class="text-xl sm:text-2xl font-semibold mb-4">Create Book</h2>
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Input: Judul -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="Judul"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                    </div>

                    <!-- Input: Penulis -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Penulis</label>
                        <input type="text" name="Penulis"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                    </div>

                    <!-- Input: Penerbit -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Penerbit</label>
                        <input type="text" name="Penerbit"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                    </div>

                    <!-- Input: Tahun Terbit -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                        <input type="number" name="TahunTerbit"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required
                            min="1800" max="{{ date('Y') }}" placeholder="Enter publication year">
                    </div>

                    <!-- Input: Kategori -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                            @foreach ($anas_kategori as $kategori)
                                <div class="flex items-center">
                                    <input type="checkbox" name="KategoriID[]" value="{{ $kategori->KategoriID }}"
                                        id="kategori{{ $kategori->KategoriID }}"
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="kategori{{ $kategori->KategoriID }}"
                                        class="ml-2 text-xs text-gray-700">
                                        {{ $kategori->NamaKategori }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Input: Gambar Buku -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Gambar Buku</label>
                        <input type="file" name="cover"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="button" data-modal-hide="createBookModal"
                            class="px-3 py-2 mr-2 text-sm text-gray-700 bg-gray-200 rounded-md">Cancel</button>
                        <button type="submit"
                            class="px-3 py-2 text-sm text-white bg-blue-600 rounded-md">Create</button>
                    </div>
                </form>
            </div>
        </div>



</x-layout.admin>
