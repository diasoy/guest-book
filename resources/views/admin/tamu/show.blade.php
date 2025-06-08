<x-app-layout>
  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Detail Pengunjung</h2>
        <a href="{{ route('dashboard') }}"
          class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Kembali
        </a>
      </div>

      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Visitor Photo -->
            <div class="text-center">
              <div class="mb-4">
                @if ($tamu->image_url)
                <img src="{{ Storage::url($tamu->image_url) }}" alt="Foto {{ $tamu->nama }}"
                  class="mx-auto h-64 w-64 object-cover rounded-lg shadow-md">
                @else
                <div
                  class="mx-auto h-64 w-64 rounded-lg bg-gray-200 flex items-center justify-center shadow-md">
                  <svg class="h-32 w-32 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                    </path>
                  </svg>
                </div>
                @endif
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Foto Pengunjung</p>
              </div>
            </div>

            <!-- Visitor Information -->
            <div class="md:col-span-2 space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Informasi
                    Pengunjung</h3>

                  <div class="space-y-4">
                    <div>
                      <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama
                        Lengkap</h4>
                      <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $tamu->nama }}
                      </p>
                    </div>

                    <div>
                      <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Instansi
                      </h4>
                      <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $tamu->instansi ?: '-' }}
                      </p>
                    </div>
                  </div>
                </div>

                <div>
                  <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Kontak</h3>

                  <div class="space-y-4">
                    <div>
                      <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor
                        Telepon</h4>
                      <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $tamu->telepon ?: '-' }}
                      </p>
                    </div>

                    <div>
                      <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</h4>
                      <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $tamu->email ?: '-' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Kunjungan</h3>

                <div class="space-y-4">
                  <div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal & Waktu
                    </h4>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                      {{ $tamu->created_at->format('d F Y, H:i') }} WIB
                    </p>
                  </div>

                  <div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-100">Keperluan</h4>
                    <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-700 rounded-md dark:text-gray-200">
                      {{ $tamu->keperluan }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="mt-8 border-t pt-6 dark:border-gray-700 flex justify-end space-x-3">
            <a href="{{ route('admin.tamu.show', ['tamu' => $tamu->id, 'print' => true]) }}" target="_blank"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                </path>
              </svg>
              Cetak
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if (request('print'))
  <script>
    window.onload = function() {
      window.print();
    }
  </script>
  <style>
    @media print {

      header,
      nav,
      footer,
      .no-print {
        display: none !important;
      }

      body {
        padding: 0;
        margin: 0;
      }

      .py-6 {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
      }
    }
  </style>
  @endif
</x-app-layout>