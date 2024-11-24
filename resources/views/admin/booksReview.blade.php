<x-layout.admin>
    <div class="container mx-auto p-6">
        <!-- Filter and Print Controls -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 no-print">
            <div class="flex flex-wrap gap-4">
                <!-- Sort Controls -->
                <select id="sortBy" onchange="updateSort()"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="rating">Sort by Rating</option>
                    <option value="reviews">Sort by Number of Reviews</option>
                </select>

                <!-- Order Controls -->
                <select id="orderBy" onchange="updateSort()"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="desc">Highest to Lowest</option>
                    <option value="asc">Lowest to Highest</option>
                </select>

                <!-- Rating Filter -->
                <select id="ratingFilter" onchange="updateSort()"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Ratings</option>
                    <option value="4">4+ Stars</option>
                    <option value="3">3+ Stars</option>
                    <option value="2">2+ Stars</option>
                    <option value="1">1+ Star</option>
                </select>
            </div>

            <button onclick="window.print()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                Cetak Daftar Rating
            </button>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold mb-8 text-center print:text-xl">Books Review (Top Rated)</h1>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200 text-sm shadow-md print:shadow-none">
                <thead class="bg-gray-100 print:bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border text-left">Peringkat</th>
                        <th class="px-4 py-2 border text-left">Judul Buku</th>
                        <th class="px-4 py-2 border text-left">Rating</th>
                        <th class="px-4 py-2 border text-left">Jumlah Ulasan</th>
                    </tr>
                </thead>
                <tbody id="reviewTableBody">
                    @forelse($anas_ulasan as $index => $ulasan)
                        <tr class="@if ($index % 2 == 0) bg-white @else bg-gray-50 @endif hover:bg-gray-100"
                            data-rating="{{ $ulasan->average_rating }}" data-reviews="{{ $ulasan->total_reviews }}">
                            <td class="px-4 py-2 border ranking">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $ulasan->buku->Judul ?? 'Tidak tersedia' }}</td>
                            <td class="px-4 py-2 border">
                                <div class="flex items-center gap-1">
                                    <span
                                        class="text-yellow-500 font-semibold">{{ number_format($ulasan->average_rating, 2) }}</span>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </td>
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
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body * {
                visibility: hidden;
            }

            .container,
            .container * {
                visibility: visible;
            }

            body {
                font-size: 12pt;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th,
            td {
                padding: 8px;
                border: 1px solid #000;
                text-align: left;
            }

            thead {
                background-color: #f3f4f6 !important;
                -webkit-print-color-adjust: exact;
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            h1 {
                text-align: center;
                font-size: 18pt;
                margin-bottom: 15px;
            }

            .container {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }
    </style>

    <script>
        function updateSort() {
            const sortBy = document.getElementById('sortBy').value;
            const orderBy = document.getElementById('orderBy').value;
            const ratingFilter = document.getElementById('ratingFilter').value;

            const tbody = document.getElementById('reviewTableBody');
            const rows = Array.from(tbody.getElementsByTagName('tr'));

            // Show/hide rows based on rating filter
            rows.forEach(row => {
                const rating = parseFloat(row.getAttribute('data-rating'));
                if (ratingFilter === 'all' || rating >= parseFloat(ratingFilter)) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none'; 
                }
            });

            // Filter visible rows for sorting
            const visibleRows = rows.filter(row => row.style.display !== 'none');

            // Sort rows
            visibleRows.sort((a, b) => {
                const aValue = parseFloat(a.getAttribute(`data-${sortBy === 'rating' ? 'rating' : 'reviews'}`));
                const bValue = parseFloat(b.getAttribute(`data-${sortBy === 'rating' ? 'rating' : 'reviews'}`));
                return orderBy === 'desc' ? bValue - aValue : aValue - bValue;
            });

            // Reorder rows in the table
            visibleRows.forEach((row, index) => {
                row.querySelector('.ranking').textContent = index + 1; // Update ranking
                tbody.appendChild(row);
            });

            // Show/hide empty state
            const emptyState = document.querySelector('tr td[colspan="4"]')?.parentElement;
            if (emptyState) {
                emptyState.style.display = visibleRows.length === 0 ? '' : 'none';
            }
        }

        // Initialize sorting
        document.addEventListener('DOMContentLoaded', updateSort);
    </script>
</x-layout.admin>
