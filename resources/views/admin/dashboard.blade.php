<x-layout.admin>
    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100">
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">

            <p class="text-3xl font-bold text-gray-900 mt-4">{{ count($anas_peminjaman) }}</p>
            <p class="text-sm text-gray-400 mt-1">Semua data peminjaman</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">

            <p class="text-3xl font-bold text-blue-600 mt-4">{{ $anas_peminjaman->where('Status', 'booked')->count() }}
            </p>
            <p class="text-sm text-gray-400 mt-1">Proses peminjaman aktif</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">

            <p class="text-3xl font-bold text-green-600 mt-4">{{ $anas_pengembalian }}</p>
            <p class="text-sm text-gray-400 mt-1">Peminjaman selesai</p>
        </div>
    </div>
</x-layout.admin>