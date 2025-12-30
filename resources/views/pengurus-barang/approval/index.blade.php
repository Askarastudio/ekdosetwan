<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval Peminjaman') }}
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengajuan Menunggu Approval</h3>
                    
                    @if($peminjamanMenunggu->count() > 0)
                        <div class="space-y-6">
                            @foreach($peminjamanMenunggu as $peminjaman)
                            <div class="border border-gray-200 rounded-lg p-6" x-data="{ showApprove: false, showReject: false }">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            Pengajuan #{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}
                                        </h4>
                                        <p class="text-sm text-gray-600">Oleh: {{ $peminjaman->user->name }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $peminjaman->status }}
                                    </span>
                                </div>

                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Periode</dt>
                                        <dd class="text-sm text-gray-900">
                                            {{ $peminjaman->tanggal_mulai->format('d/m/Y') }} - {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Kendaraan</dt>
                                        <dd class="text-sm text-gray-900">
                                            {{ $peminjaman->kendaraan->merk }} {{ $peminjaman->kendaraan->tipe }}<br>
                                            <span class="text-gray-500">{{ $peminjaman->kendaraan->nomor_polisi }}</span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Supir</dt>
                                        <dd class="text-sm text-gray-900">
                                            {{ $peminjaman->supir->nama }}<br>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $peminjaman->supir->nomor_hp) }}" target="_blank" class="text-green-600 hover:text-green-900 inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Hubungi Supir
                                            </a>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Diverifikasi oleh</dt>
                                        <dd class="text-sm text-gray-900">{{ $peminjaman->verifiedBy->name ?? '-' }}</dd>
                                    </div>
                                    @if($peminjaman->catatan_verifikator)
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Catatan P3B</dt>
                                        <dd class="text-sm text-gray-900">{{ $peminjaman->catatan_verifikator }}</dd>
                                    </div>
                                    @endif
                                </dl>

                                <div class="flex space-x-2">
                                    <button @click="showApprove = !showApprove" title="Setujui" class="inline-flex items-center justify-center h-9 w-9 rounded bg-green-600 text-white hover:bg-green-700 transition">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
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

                                <!-- Approval Form -->
                                <div x-show="showApprove" x-transition class="mt-6 border-t pt-6">
                                    <form action="{{ route('pengurus-barang.approval.approve', $peminjaman) }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="catatan_pengurus_barang_{{ $peminjaman->id }}" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                            <textarea name="catatan_pengurus_barang" id="catatan_pengurus_barang_{{ $peminjaman->id }}" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Catatan untuk penugasan..."></textarea>
                                        </div>

                                        <div class="mt-4 flex justify-end space-x-2">
                                            <button type="button" @click="showApprove = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                                Setujui Peminjaman
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Rejection Form -->
                                <div x-show="showReject" x-transition class="mt-6 border-t pt-6">
                                    <form action="{{ route('pengurus-barang.approval.reject', $peminjaman) }}" method="POST">
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
                                                Tolak Peminjaman
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengajuan menunggu approval</h3>
                            <p class="mt-1 text-sm text-gray-500">Semua pengajuan sudah diproses.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
