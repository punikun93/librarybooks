<x-layout.admin>
    @if (Auth::user()->Role == 'petugas')

    <!-- Stats Summary remains the same -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100">
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <p class="text-3xl font-bold text-gray-900 mt-4">{{ count($anas_peminjaman) }}</p>
            <p class="text-sm text-gray-400 mt-1">Semua data peminjaman</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <p class="text-3xl font-bold text-blue-600 mt-4">{{ $anas_peminjaman->where('Status', 'booked')->count() }}</p>
            <p class="text-sm text-gray-400 mt-1">Proses peminjaman aktif</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <p class="text-3xl font-bold text-green-600 mt-4">{{ $anas_pengembalian }}</p>
            <p class="text-sm text-gray-400 mt-1">Peminjaman selesai</p>
        </div>
    </div>
        
    @endif
    @if (Auth::user()->Role == 'administrator')

    <!-- Activity Log Section -->
    <section class="p-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Activity Log</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($anas_log as $aktivitas)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                          
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $aktivitas->user->NamaLengkap }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $actionText = strtolower($aktivitas->aksi);
                                    $badgeClass = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full ';
                                    
                                    // Determine badge color based on action
                                    if (str_contains($actionText, 'hapus') || str_contains($actionText, 'tolak') || str_contains($actionText, 'logout')) {
                                        $badgeClass .= 'bg-red-100 text-red-800';
                                    } elseif (str_contains($actionText, 'login')) {
                                        $badgeClass .= 'bg-blue-100 text-blue-800';
                                    } elseif (str_contains($actionText, 'update')) {
                                        $badgeClass .= 'bg-yellow-100 text-yellow-800';
                                    } elseif (str_contains($actionText, 'tambah')) {
                                        $badgeClass .= 'bg-green-100 text-green-800';
                                    } else {
                                        $badgeClass .= 'bg-gray-100 text-gray-800';
                                    }
                                @endphp
                                <span class="{{ $badgeClass }}">
                                    {{ $aktivitas->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs overflow-hidden overflow-ellipsis">
                                    {{ $aktivitas->detail }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $aktivitas->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $anas_log->links() }}
        </div>
    </section>

    @endif
</x-layout.admin>