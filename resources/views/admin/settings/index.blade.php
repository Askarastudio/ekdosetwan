<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <!-- Batas Maksimal Pinjam -->
                            <div>
                                <label for="batas_maksimal_pinjam" class="block text-sm font-medium text-gray-700">
                                    Batas Maksimal Peminjaman (Hari)
                                </label>
                                <div class="mt-1">
                                    <input type="number" name="batas_maksimal_pinjam" id="batas_maksimal_pinjam" 
                                        value="{{ old('batas_maksimal_pinjam', $settings->get('batas_maksimal_pinjam')->value ?? 3) }}" 
                                        min="1" max="30" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Maksimal hari yang dapat dipinjam oleh Anggota Dewan dalam satu pengajuan.
                                </p>
                                @error('batas_maksimal_pinjam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Filter Hari -->
                            <div>
                                <label for="filter_hari" class="block text-sm font-medium text-gray-700">
                                    Filter Hari Peminjaman
                                </label>
                                <div class="mt-1">
                                    <select name="filter_hari" id="filter_hari" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="semua" {{ old('filter_hari', $settings->get('filter_hari')->value ?? 'semua') == 'semua' ? 'selected' : '' }}>
                                            Semua Hari
                                        </option>
                                        <option value="hari_libur" {{ old('filter_hari', $settings->get('filter_hari')->value ?? 'semua') == 'hari_libur' ? 'selected' : '' }}>
                                            Hanya Hari Libur
                                        </option>
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Tentukan apakah peminjaman dapat dilakukan pada semua hari atau hanya hari libur.
                                </p>
                                @error('filter_hari')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cooldown Period -->
                            <div>
                                <label for="cooldown_period" class="block text-sm font-medium text-gray-700">
                                    Periode Cooldown (Hari)
                                </label>
                                <div class="mt-1">
                                    <input type="number" name="cooldown_period" id="cooldown_period" 
                                        value="{{ old('cooldown_period', $settings->get('cooldown_period')->value ?? 14) }}" 
                                        min="1" max="90" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Jumlah hari yang harus ditunggu setelah peminjaman selesai sebelum dapat meminjam kembali.
                                </p>
                                @error('cooldown_period')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Info Box -->
                            <div class="rounded-md bg-blue-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1 md:flex md:justify-between">
                                        <p class="text-sm text-blue-700">
                                            Pengaturan ini bersifat dinamis dan dapat diubah sesuai dengan kebijakan pimpinan. 
                                            Perubahan akan berlaku segera setelah disimpan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Settings Summary -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Saat Ini</h3>
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Batas Maksimal Pinjam</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $settings->get('batas_maksimal_pinjam')->value ?? 3 }} Hari</dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Filter Hari</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                {{ $settings->get('filter_hari')->value == 'semua' ? 'Semua Hari' : 'Hari Libur' }}
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Cooldown Period</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $settings->get('cooldown_period')->value ?? 14 }} Hari</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
