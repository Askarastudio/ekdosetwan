<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengajuan Menunggu Verifikasi</h3>
                    
                    @if($peminjamanMenunggu->count() > 0)
                        <div class="space-y-6">
                            @foreach($peminjamanMenunggu as $peminjaman)
                            <div class="border border-gray-200 rounded-lg p-6" x-data="{ showForm: false, showReject: false }">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            Pengajuan #{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}
                                        </h4>
                                        <p class="text-sm text-gray-600">Oleh: {{ $peminjaman->user->name }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $peminjaman->status }}
                                    </span>
                                </div>

                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Periode</dt>
                                        <dd class="text-sm text-gray-900">
                                            {{ $peminjaman->tanggal_mulai->format('d/m/Y') }} - {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}
                                            ({{ $peminjaman->tanggal_mulai->diffInDays($peminjaman->tanggal_selesai) + 1 }} hari)
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nomor HP PIC</dt>
                                        <dd class="text-sm text-gray-900">{{ $peminjaman->nomor_hp_pic }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tujuan</dt>
                                        <dd class="text-sm text-gray-900">{{ $peminjaman->tujuan }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Diajukan</dt>
                                        <dd class="text-sm text-gray-900">{{ $peminjaman->created_at->diffForHumans() }}</dd>
                                    </div>
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Kebutuhan</dt>
                                        <dd class="text-sm text-gray-900">{{ $peminjaman->kebutuhan }}</dd>
                                    </div>
                                </dl>

                                <div class="flex space-x-2">
                                    <button @click="showForm = !showForm" title="Verifikasi & Tugaskan" class="inline-flex items-center justify-center h-9 w-9 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button @click="showReject = !showReject" title="Tolak" class="inline-flex items-center justify-center h-9 w-9 rounded bg-red-600 text-white hover:bg-red-700 transition">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('peminjaman.show', $peminjaman) }}" title="Detail" class="inline-flex items-center justify-center h-9 w-9 rounded bg-gray-600 text-white hover:bg-gray-700 transition">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>

                                <!-- Verification Form -->
                                <div x-show="showForm" x-transition class="mt-6 border-t pt-6">
                                    <form action="{{ route('p3b.verifikasi.verify', $peminjaman) }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="bg-gray-50 rounded-md p-4 border border-dashed border-gray-200">
                                                <p class="text-sm font-semibold text-gray-700 mb-2">Kendaraan yang diajukan</p>
                                                @if($peminjaman->kendaraan)
                                                    <p class="text-base font-semibold text-gray-900">{{ $peminjaman->kendaraan->merk }} {{ $peminjaman->kendaraan->tipe }}</p>
                                                    <p class="text-sm text-gray-700">Nomor Polisi: {{ $peminjaman->kendaraan->nomor_polisi }}</p>
                                                    <p class="text-sm text-gray-500 mt-1">Dipilih oleh pemohon saat pengajuan.</p>
                                                @else
                                                    <p class="text-sm text-red-600">Belum ada kendaraan dipilih oleh pemohon. Mohon hubungi pemohon.</p>
                                                @endif
                                            </div>

                                            <div>
                                                <label for="supir_id_{{ $peminjaman->id }}" class="block text-sm font-medium text-gray-700">Pilih Supir *</label>
                                                <select name="supir_id" id="supir_id_{{ $peminjaman->id }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <option value="">-- Pilih Supir --</option>
                                                    @foreach($supirs as $supir)
                                                    <option value="{{ $supir->id }}">
                                                        {{ $supir->nama }} - {{ $supir->nomor_hp }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label for="catatan_verifikator_{{ $peminjaman->id }}" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                                <textarea name="catatan_verifikator" id="catatan_verifikator_{{ $peminjaman->id }}" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex justify-end space-x-2">
                                            <button type="button" @click="showForm = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                                Batal
                                            </button>
                                            <button type="submit" @if(!$peminjaman->kendaraan) disabled class="px-4 py-2 text-sm font-medium text-white bg-blue-300 border border-transparent rounded-md cursor-not-allowed" @else class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700" @endif>
                                                Verifikasi
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Rejection Form -->
                                <div x-show="showReject" x-transition class="mt-6 border-t pt-6">
                                    <form action="{{ route('p3b.verifikasi.reject', $peminjaman) }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="alasan_penolakan_{{ $peminjaman->id }}" class="block text-sm font-medium text-gray-700">Alasan Penolakan *</label>
                                            <textarea name="alasan_penolakan" id="alasan_penolakan_{{ $peminjaman->id }}" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jelaskan alasan penolakan..."></textarea>
                                        </div>

                                        <div class="mt-4 flex justify-end space-x-2">
                                            <button type="button" @click="showReject = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                                                Tolak Pengajuan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengajuan menunggu verifikasi</h3>
                            <p class="mt-1 text-sm text-gray-500">Semua pengajuan sudah diproses.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
