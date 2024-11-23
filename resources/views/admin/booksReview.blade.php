<x-layout.admin>
    <div class="container mx-auto p-6">
        <!-- Tombol Print -->
        <div class="mb-4 no-print">
            <button onclick="window.print()" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                Cetak Daftar Rating
            </button>
        </div>

        <!-- Tampilan normal dan print -->
        <h1 class="text-2xl font-bold mb-8 text-center print:text-xl">Books Review (Top Rated)</h1>
        <table class="w-full border-collapse border border-gray-200 text-sm shadow-md print:shadow-none">
            <thead class="bg-gray-100 print:bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border text-left">Peringkat</th>
                    <th class="px-4 py-2 border text-left">Judul Buku</th>
                    <th class="px-4 py-2 border text-left">Rating</th>
                    <th class="px-4 py-2 border text-left">Jumlah Ulasan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anas_ulasan as $index => $ulasan)
                    <tr class="@if($index % 2 == 0) bg-white @else bg-gray-50 @endif hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $ulasan->buku->Judul ?? 'Tidak tersedia' }}</td>
                        <td class="px-4 py-2 border text-yellow-500 font-semibold">{{ number_format($ulasan->average_rating, 2) }}</td>
                        <td class="px-4 py-2 border text-gray-700">{{ $ulasan->total_reviews }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 border text-center text-gray-500">
                            Tidak ada ulasan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
        <style>
            @media print {
                /* Sembunyikan elemen yang tidak perlu dicetak */
                .no-print {
                    display: none !important;
                }

                /* Buat semua elemen terlihat kecuali yang di-hide */
                body * {
                    visibility: hidden;
                }
                .container, .container * {
                    visibility: visible;
                }

                /* Atur ukuran font untuk mode print */
                body {
                    font-size: 12pt;
                }

                /* Tabel */
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }

                th, td {
                    padding: 8px;
                    border: 1px solid #000;
                    text-align: left;
                }

                /* Header tabel */
                thead {
                    background-color: #f3f4f6 !important;
                    -webkit-print-color-adjust: exact;
                    display: table-header-group;
                }

                /* Hindari pemotongan tabel di antar halaman */
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }

                /* Tampilan header halaman saat print */
                h1 {
                    text-align: center;
                    font-size: 18pt;
                    margin-bottom: 15px;
                }

                /* Posisi container di kiri atas */
                .container {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                }
            }
        </style>
    </x-layout.admin>
