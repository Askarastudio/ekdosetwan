<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('peminjaman.store') }}" method="POST" id="peminjamanForm">
                        @csrf

                        <div class="space-y-6">
                            <!-- Kendaraan -->
                            <div>
                                <label for="kendaraan_id" class="block text-sm font-medium text-gray-700">
                                    Pilih Kendaraan <span class="text-red-500">*</span>
                                </label>
                                <select name="kendaraan_id" id="kendaraan_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Kendaraan --</option>
                                    @foreach($kendaraans as $kendaraan)
                                    <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                        {{ $kendaraan->merk }} {{ $kendaraan->tipe }} - {{ $kendaraan->nomor_polisi }} 
                                        ({{ $kendaraan->status_kondisi }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('kendaraan_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date Range -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">
                                        Tanggal Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                        value="{{ old('tanggal_mulai') }}" 
                                        min="{{ date('Y-m-d') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('tanggal_mulai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">
                                        Tanggal Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                                        value="{{ old('tanggal_selesai') }}" 
                                        min="{{ date('Y-m-d') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('tanggal_selesai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duration Warning -->
                            <div id="durationWarning" class="hidden rounded-md bg-yellow-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700" id="durationWarningText"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tujuan -->
                            <div>
                                <label for="tujuan" class="block text-sm font-medium text-gray-700">
                                    Tujuan Perjalanan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tujuan" id="tujuan" 
                                    value="{{ old('tujuan') }}" required
                                    placeholder="Contoh: Jakarta - Bandung"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('tujuan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kebutuhan -->
                            <div>
                                <label for="kebutuhan" class="block text-sm font-medium text-gray-700">
                                    Detail Kebutuhan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="kebutuhan" id="kebutuhan" rows="4" required
                                    placeholder="Jelaskan detail kebutuhan dan keperluan peminjaman kendaraan..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('kebutuhan') }}</textarea>
                                @error('kebutuhan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor HP PIC -->
                            <div>
                                <label for="nomor_hp_pic" class="block text-sm font-medium text-gray-700">
                                    Nomor HP Penanggung Jawab <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_hp_pic" id="nomor_hp_pic" 
                                    value="{{ old('nomor_hp_pic', auth()->user()->phone) }}" required
                                    placeholder="08123456789"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Nomor yang dapat dihubungi selama masa peminjaman</p>
                                @error('nomor_hp_pic')
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
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Batas maksimal peminjaman: {{ $maxDays }} hari.</strong><br>
                                            Pengajuan akan diverifikasi oleh P3B dan memerlukan persetujuan dari Pengurus Barang sebelum kendaraan dapat digunakan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-4">
                            <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
                            <button type="submit" id="submitBtn" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Submit Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const maxDays = {{ $maxDays }};
        const startDateInput = document.getElementById('tanggal_mulai');
        const endDateInput = document.getElementById('tanggal_selesai');
        const warningDiv = document.getElementById('durationWarning');
        const warningText = document.getElementById('durationWarningText');
        const submitBtn = document.getElementById('submitBtn');

        function checkDuration() {
            if (startDateInput.value && endDateInput.value) {
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                if (diffDays > maxDays) {
                    warningDiv.classList.remove('hidden');
                    warningText.textContent = `Durasi peminjaman (${diffDays} hari) melebihi batas maksimal ${maxDays} hari. Silakan sesuaikan tanggal.`;
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    warningDiv.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
            checkDuration();
        });

        endDateInput.addEventListener('change', checkDuration);
    </script>
    @endpush
</x-app-layout>
