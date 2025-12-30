<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
                                <input type="text" name="merk" id="merk" value="{{ old('merk') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('merk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
                                <input type="text" name="tipe" id="tipe" value="{{ old('tipe') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('tipe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nomor_polisi" class="block text-sm font-medium text-gray-700">Nomor Polisi</label>
                                <input type="text" name="nomor_polisi" id="nomor_polisi" value="{{ old('nomor_polisi') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('nomor_polisi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status_kondisi" class="block text-sm font-medium text-gray-700">Status Kondisi</label>
                                <select name="status_kondisi" id="status_kondisi" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Sangat Baik" {{ old('status_kondisi') == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                                    <option value="Perbaikan" {{ old('status_kondisi') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                    <option value="Rusak" {{ old('status_kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                                @error('status_kondisi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="galeri_foto" class="block text-sm font-medium text-gray-700">Galeri Foto</label>
                                <input type="file" name="galeri_foto[]" id="galeri_foto" multiple accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100">
                                <p class="mt-1 text-sm text-gray-500">Upload foto interior/eksterior kendaraan (max 2MB per file)</p>
                                @error('galeri_foto.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-4">
                            <a href="{{ route('admin.kendaraan.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
