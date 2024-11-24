<x-layout.admin>
    <div class="p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">
                @if (Route::is('borrow.confirmed'))
                    Confirmed
                @elseif(Route::is('borrow.history'))
                    History
                @elseif(Route::is('borrow.return'))
                    Return
                @else
                    Data
                @endif
                Borrows
            </h1>
            <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                @if (Route::is('borrow.confirmed') || Route::is('borrow.history') || Route::is('borrow.return'))
                @else
                    <button
                        class="inline-block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:relative"
                        data-modal-target="createborrowModal" data-modal-toggle="createborrowModal">
                        Create Borrowing
                    </button>
            </span>
            @endif
        </div>

        <!-- borrows Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Full Name</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Book Title</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Borrow Date</th>
                        @if (!Route::is('borrow.history') )
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Return Date</th>
                        @endif
                        @if (Route::is('borrow.history') || Route::is('borrow.return'))
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">User Return</th>
                        @endif
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status Borrowing</th>
                        @if (!Route::is('borrow.history') && !Route::is('borrow'))
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Action</th>
                        @endif
                    </tr>
                </thead> 
                <tbody>
                    @forelse ($anas_peminjaman as $peminjaman)
            
                        
                    <tr class="border-t @if ($peminjaman->Status === 'over') bg-red-400 text-white @endif">
                        <td class="px-4 py-2 text-sm ">
                                {{ $peminjaman->user->NamaLengkap ?? 'Unknown User' }}
                            </td>
                            <td class="px-4 py-2 text-sm ">
                                {{ $peminjaman->buku->Judul ?? 'Unknown Book' }}
                            </td>
                            <td class="px-4 py-2 text-sm ">
                                {{ $peminjaman->TanggalPeminjaman ? \Carbon\Carbon::parse($peminjaman->TanggalPeminjaman)->format('d M Y') : '-' }}
                            </td>
                            @if (!Route::is('borrow.history') )
                            <td class="px-4 py-2 text-sm ">
                                {{ $peminjaman->TanggalPengembalian ? \Carbon\Carbon::parse($peminjaman->TanggalPengembalian)->format('d M Y') : '-' }}
                            </td>
                            @endif

                            @if (Route::is('borrow.history') || Route::is('borrow.return'))
                            <td class="px-4 py-2 text-sm ">
                                {{ $peminjaman->pengembalian->created_at ? \Carbon\Carbon::parse($peminjaman->pengembalian->created_at)->format('d M Y') : '-' }}
                            </td>
                            @endif

                            <td class="px-4 py-2 text-sm  capitalize">
                                {{ ucfirst($peminjaman->Status) }}
                            </td>

                            <td class="flex justify-center space-x-2 py-4 text-sm ">
                                @if (Route::is('borrow.confirmed'))
                                    <form action="{{ route('borrow.update', $peminjaman->PeminjamanID) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="text-Blue-600 hover:text-white hover:bg-blue-600  border p-2 bg-white shadow-sm rounded-md">
                                            <x-done-icon />
                                        </button>
                                    </form>
                                @endif
                                @if (Route::is('borrow.return'))
                                    <form action="{{ route('return.confirm') }}"
                                        method="POST">
                                        @csrf
                                            <input type="hidden" name="PeminjamanID" value="{{ $peminjaman->PeminjamanID }}">
                                        <button type="submit"
                                            class="text-Blue-600 hover:text-white hover:bg-green-600  border p-2 bg-white shadow-sm rounded-md">
                                            <x-done-icon />
                                        </button>
                                    </form>
                                @endif
                                @if (Route::is('borrow.confirmed'))
                                    <form action="{{ route('borrow.destroy', $peminjaman->PeminjamanID) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-Blue-600 hover:text-white hover:bg-red-600  border p-2 bg-white shadow-sm rounded-md">
                                            <x-delete-icon />
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-sm ">
                                No borrows found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $anas_peminjaman->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Create borrow Modal -->
    <div id="createborrowModal" aria-hidden="true" tabindex="-1"
        class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Create borrow</h2>
            <form action="{{ route('borrow.store') }}" method="POST">
                @csrf
                <input type="hidden" name="PetugasID" value="yes">
                <!-- Pilih Users -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Users</label>
                    <select name="UserID" id="userSelect"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                        <option value="" disabled selected> Select user</option>
                        [
                        @foreach ($anas_bebasUsers as $user)
                            <option value="{{ $user->UserID }}">{{ $user->NamaLengkap }}</option>
                        @endforeach

                        @foreach ($anas_fullUsers as $user)
                            <option value="{{ $user->UserID }}" class="bg-red-500 text-white" disabled readonly>
                                {{ $user->NamaLengkap }} (Full - 3 Book borrows)
                            </option>
                        @endforeach]
                    </select>
                </div>

                <!-- Pilih Buku -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Books</label>
                    <select name="BukuID" id="bookSelect"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                        <option value="" disabled selected> Select book</option>
                        @foreach ($anas_books as $book)
                            <option value="{{ $book->BukuID }}">{{ $book->Judul }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Borrow Date -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Borrow Date</label>
                    <input type="date" name="TanggalPeminjaman" min="{{ date('Y-m-d') }}" id="borrowDate"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                </div>

                <!-- Return Date -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Return Date</label>
                    <input type="date" name="TanggalPengembalian" id="returnDate"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" required >
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2">
                    <button type="button" class="px-4 py-2 bg-gray-300 rounded"
                        data-modal-hide="createborrowModal">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Create</button>
                </div>
            </form>
        </div>
    </div>



    <div id="editBookModal" class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Edit borrow</h2>
            <form id="editBookForm" method="POST">
                @csrf
                @method('PUT')
                <p id="editBookTitle" class="mb-4 text-sm text-gray-700"></p>
                <!-- Add form fields -->
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                <button type="button" class="px-4 py-2 bg-gray-300 rounded"
                    onclick="toggleModal('editBookModal')">Cancel</button>
            </form>
        </div>
    </div>

    <div id="deleteBookModal" class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Delete borrow</h2>
            <p id="deleteMessage" class="mb-4 text-sm text-gray-700"></p>
            <form id="deleteBookForm" method="POST">
                @csrf
                @method('DELETE')
                <!-- Add form fields -->


                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Delete</button>
                <button type="button" class="px-4 py-2 bg-gray-300 rounded"
                    onclick="toggleModal('deleteBookModal')">Cancel</button>
            </form>
        </div>
    </div>
    @include('autoReturn')

</x-layout.admin>
