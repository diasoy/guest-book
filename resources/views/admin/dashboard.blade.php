<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Visitors -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900">
                                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Total Pengunjung</h3>
                                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($totalVisitors) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visitors This Month -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="h-8 w-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Pengunjung Bulan Ini</h3>
                                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($visitorsThisMonth) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visitors Today -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                                <svg class="h-8 w-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Pengunjung Hari Ini</h3>
                                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($visitorsToday) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
            <div id="successMessage" class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-100 p-4 mb-4 mt-6 rounded-md shadow">
                <div class="flex justify-between items-center">
                    <p class="text-sm">{{ session('success') }}</p>
                    <button onclick="document.getElementById('successMessage').style.display='none'" class="text-green-700 dark:text-green-100 hover:text-green-900 dark:hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-100 p-4 mb-4 mx-6 mt-6 rounded-md shadow">
                <p class="font-bold text-sm">Terdapat kesalahan pada input:</p>
                <ul class="list-disc ml-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Data Table Section -->
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Data Pengunjung</h3>

                    <!-- Filters -->
                    <div class="flex flex-col md:flex-row justify-between mb-4 space-y-3 md:space-y-0">
                        <div class="flex flex-col md:flex-row gap-3">
                            <!-- Time Period Filter -->
                            <div>
                                <label for="filter-period" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periode</label>
                                <select id="filter-period" name="filter-period" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                                </select>
                            </div>

                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" name="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nama pengunjung..." value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Per Page Filter -->
                        <div>
                            <label for="per-page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tampilkan</label>
                            <select id="per-page" name="per-page" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Foto</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Instansi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($visitors as $index => $visitor)
                                <tr class="{{ $index % 2 == 0 ? '' : 'bg-gray-50 dark:bg-gray-700' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ ($visitors->currentPage() - 1) * $visitors->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($visitor->image_url)
                                        <img src="{{ Storage::url($visitor->image_url) }}" alt="Foto {{ $visitor->nama }}" class="h-12 w-12 rounded-full object-cover">
                                        @else
                                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $visitor->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $visitor->instansi ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $visitor->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 flex gap-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        <a href="{{ route('admin.tamu.show', $visitor) }}" class="hover:text-indigo-700 text-indigo-600 dark:hover:text-indigo-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            Lihat

                                        </a>
                                        <a href="{{ route('admin.tamu.edit', $visitor) }}" class="hover:text-green-700 text-green-600 dark:hover:text-green-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tamu.destroy', $visitor) }}" method="POST" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                        Tidak ada data pengunjung
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $visitors->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Visitor Details -->
    <div id="visitorDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 50;">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle">Detail Pengunjung</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal()">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4" id="visitorDetails">
                    <!-- Details will be loaded here -->
                    <div class="flex justify-center">
                        <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for filters and modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodFilter = document.getElementById('filter-period');
            const perPageFilter = document.getElementById('per-page');
            const searchInput = document.getElementById('search');

            // Handle filter changes
            function applyFilters() {
                const period = periodFilter.value;
                const perPage = perPageFilter.value;
                const search = searchInput.value;

                let url = new URL(window.location.href);
                url.searchParams.set('period', period);
                url.searchParams.set('perPage', perPage);

                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }

                window.location.href = url.toString();
            }

            // Add event listeners
            periodFilter.addEventListener('change', applyFilters);
            perPageFilter.addEventListener('change', applyFilters);

            // Add debounce for search
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });
        });

        // Visitor details modal functions
        function showVisitorDetails(id) {
            document.getElementById('visitorDetailModal').classList.remove('hidden');

            // Fetch visitor details via AJAX
            fetch(`/visitor-details/${id}`)
                .then(response => response.json())
                .then(data => {
                    let html = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="text-center">
                                ${data.image_url
                                    ? `<img src="${data.image_url}" alt="Foto ${data.nama}" class="mx-auto h-48 w-48 rounded-lg object-cover">`
                                    : `<div class="mx-auto h-48 w-48 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                      </div>`
                                }
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Foto Pengunjung</p>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</h4>
                                    <p class="mt-1 text-base text-gray-900 dark:text-white">${data.nama}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Instansi</h4>
                                    <p class="mt-1 text-base text-gray-900 dark:text-white">${data.instansi || '-'}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kontak</h4>
                                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                                        ${data.telepon ? `Tel: ${data.telepon}<br>` : ''}
                                        ${data.email ? `Email: ${data.email}` : '-'}
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kunjungan</h4>
                                    <p class="mt-1 text-base text-gray-900 dark:text-white">${data.created_at}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Keperluan</h4>
                            <p class="mt-1 text-base text-gray-900 dark:text-white whitespace-pre-line">${data.keperluan}</p>
                        </div>
                    `;

                    document.getElementById('visitorDetails').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching visitor details:', error);
                    document.getElementById('visitorDetails').innerHTML = `
                        <div class="text-center text-red-500">
                            Terjadi kesalahan saat memuat data pengunjung. Silakan coba lagi.
                        </div>
                    `;
                });
        }

        function closeModal() {
            document.getElementById('visitorDetailModal').classList.add('hidden');
        }

        // Close modal when clicking outside the content
        window.onclick = function(event) {
            const modal = document.getElementById('visitorDetailModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</x-app-layout>