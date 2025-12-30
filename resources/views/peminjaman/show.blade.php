<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Peminjaman #') }}{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Peminjaman</h3>
                            
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Pemohon</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->user->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nomor HP PIC</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->nomor_hp_pic }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Mulai</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->tanggal_mulai->format('d F Y') }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Selesai</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->tanggal_selesai->format('d F Y') }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $peminjaman->tanggal_mulai->diffInDays($peminjaman->tanggal_selesai) + 1 }} hari
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($peminjaman->status === 'Proses') bg-yellow-100 text-yellow-800
                                            @elseif($peminjaman->status === 'Diverifikasi') bg-blue-100 text-blue-800
                                            @elseif($peminjaman->status === 'Disetujui') bg-green-100 text-green-800
                                            @elseif($peminjaman->status === 'Selesai') bg-gray-100 text-gray-800
                                            @elseif($peminjaman->status === 'Ditolak') bg-red-100 text-red-800
                                            @endif">
                                            {{ $peminjaman->status }}
                                        </span>
                                    </dd>
                                </div>

                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Tujuan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->tujuan }}</dd>
                                </div>

                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Kebutuhan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->kebutuhan }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Kendaraan & Supir Info -->
                    @if($peminjaman->kendaraan_id || $peminjaman->supir_id)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kendaraan & Supir</h3>
                            
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                @if($peminjaman->kendaraan)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kendaraan</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $peminjaman->kendaraan->merk }} {{ $peminjaman->kendaraan->tipe }}<br>
                                        <span class="text-gray-500">{{ $peminjaman->kendaraan->nomor_polisi }}</span>
                                    </dd>
                                </div>
                                @endif

                                @if($peminjaman->supir)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Supir</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $peminjaman->supir->nama }}<br>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $peminjaman->supir->nomor_hp) }}" target="_blank" class="text-green-600 hover:text-green-900">
                                            {{ $peminjaman->supir->nomor_hp }}
                                        </a>
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan -->
                    @if($peminjaman->catatan_verifikator || $peminjaman->catatan_pengurus_barang || $peminjaman->alasan_penolakan)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                            
                            @if($peminjaman->catatan_verifikator)
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500">Catatan P3B</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->catatan_verifikator }}</dd>
                            </div>
                            @endif

                            @if($peminjaman->catatan_pengurus_barang)
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500">Catatan Pengurus Barang</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $peminjaman->catatan_pengurus_barang }}</dd>
                            </div>
                            @endif

                            @if($peminjaman->alasan_penolakan)
                            <div class="rounded-md bg-red-50 p-4">
                                <dt class="text-sm font-medium text-red-800">Alasan Penolakan</dt>
                                <dd class="mt-1 text-sm text-red-700">{{ $peminjaman->alasan_penolakan }}</dd>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Timeline Sidebar -->
                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                            
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900">Diajukan</p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                        <time>{{ $peminjaman->created_at->format('d/m/y H:i') }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    @if($peminjaman->verified_at)
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900">Diverifikasi oleh P3B</p>
                                                        <p class="text-xs text-gray-500">{{ $peminjaman->verifiedBy->name ?? '' }}</p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                        <time>{{ $peminjaman->verified_at->format('d/m/y H:i') }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif

                                    @if($peminjaman->approved_at)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$peminjaman->completed_at)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900">Disetujui</p>
                                                        <p class="text-xs text-gray-500">{{ $peminjaman->approvedBy->name ?? '' }}</p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                        <time>{{ $peminjaman->approved_at->format('d/m/y H:i') }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif

                                    @if($peminjaman->completed_at)
                                    <li>
                                        <div class="relative pb-8">
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-gray-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900">Selesai</p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                        <time>{{ $peminjaman->completed_at->format('d/m/y H:i') }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Surat Tugas -->
                    @if($peminjaman->suratTugas)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Surat Tugas</h3>
                            <div class="text-sm text-gray-600 mb-4">
                                <p>Nomor: {{ $peminjaman->suratTugas->nomor_surat }}</p>
                                <p>Tanggal: {{ $peminjaman->suratTugas->tanggal_surat->format('d F Y') }}</p>
                            </div>
                            <a href="{{ route('pengurus-barang.surat-tugas.download', $peminjaman->suratTugas) }}" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
