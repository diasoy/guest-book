<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Data Tamu</h2>
                <a href="{{ url()->previous() }}"
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
                    <form action="{{ route('admin.tamu.update', $tamu) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Lengkap</label>
                                <input type="text" name="nama" id="nama"
                                    value="{{ old('nama', $tamu->nama) }}"
                                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                            </div>

                            <div>
                                <label for="instansi"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instansi</label>
                                <input type="text" name="instansi" id="instansi"
                                    value="{{ old('instansi', $tamu->instansi) }}"
                                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="telepon"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                    Telepon</label>
                                <input type="text" name="telepon" id="telepon"
                                    value="{{ old('telepon', $tamu->telepon) }}"
                                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $tamu->email) }}"
                                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="md:col-span-2">
                                <label for="keperluan"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keperluan</label>
                                <textarea name="keperluan" id="keperluan" rows="4"
                                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">{{ old('keperluan', $tamu->keperluan) }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="photoData"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto tamu</label>
                                <input type="file" name="photo_data" id="photoData"
                                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 dark:hover:file:bg-gray-600">
                                @if ($tamu->image_url)
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Foto saat ini:</p>
                                    <img src="{{ Storage::url($tamu->image_url) }}"
                                        class="mt-2 h-32 w-32 object-cover rounded-md shadow-md"
                                        alt="Foto {{ $tamu->nama }}">
                                @endif
                            </div>
                        </div>

                        <div class="pt-6 border-t dark:border-gray-700 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
