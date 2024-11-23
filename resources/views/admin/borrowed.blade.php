<x-layout.admin>
    <div class="container mx-auto p-6">
        <div class="mb-6">
            <!-- Tombol Print -->
            <div class="mb-4 no-print">
                <button onclick="window.print()" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    Cetak Tabel
                </button>
            </div>

            <style>
                @media print {
                    /* Sembunyikan semua elemen kecuali tabel */
                    body * {
                        visibility: hidden;
                    }
                    .container, .container * {
                        visibility: visible;
                    }
                    .no-print {
                        display: none;
                    }
                    /* Reset style untuk print */
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #000;
                        padding: 8px;
                        text-align: left;
                    }
                    /* Posisikan tabel di kiri atas saat print */
                    .container {
                        position: absolute;
                        left: 0;
                        top: 0;
                    }
                    /* Tambahan style untuk header print */
                    thead {
                        background-color: #f3f4f6 !important;
                        -webkit-print-color-adjust: exact;
                    }
                }
            </style>
  <h1 class="text-2xl font-bold mb-8 text-center print:text-xl">Books Borrow (Top Borrow)</h1>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-left border-b">
                        <th class="py-3 px-6 text-sm font-medium text-gray-700">#</th>
                        <th class="py-3 px-6 text-sm font-medium text-gray-700">Buku</th>
                        <th class="py-3 px-6 text-sm font-medium text-gray-700">Total Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anas_most_borrowed as $index => $buku)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4 px-6 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 text-sm text-gray-900 font-medium">
                                {{ $buku->buku->Judul ?? 'Tidak tersedia' }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-700">
                                {{ $buku->total_peminjaman }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center text-gray-500">
                                Tidak ada data peminjaman ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout.admin>