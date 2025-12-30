<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cooldown Warning -->
            @if(!$canBorrow)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Anda baru dapat meminjam kembali pada tanggal <strong>{{ $nextBorrowDate->format('d F Y') }}</strong>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="flex space-x-4">
                        @if($canBorrow)
                        <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Ajukan Peminjaman
                        </a>
                        @else
                        <button disabled class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Ajukan Peminjaman (Dalam Cooldown)
                        </button>
                        @endif
                        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Riwayat Peminjaman
                        </a>
                    </div>
                </div>
            </div>

            <!-- Active Borrowings -->
            @if($activePeminjaman->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Peminjaman Aktif</h3>
                    <div class="space-y-4">
                        @foreach($activePeminjaman as $peminjaman)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $peminjaman->kendaraan->merk ?? 'Kendaraan belum ditentukan' }} {{ $peminjaman->kendaraan->tipe ?? '' }}</h4>
                                    <p class="text-sm text-gray-600">{{ $peminjaman->tanggal_mulai->format('d M Y') }} - {{ $peminjaman->tanggal_selesai->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-600">Tujuan: {{ $peminjaman->tujuan }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($peminjaman->status === 'Proses') bg-yellow-100 text-yellow-800
                                    @elseif($peminjaman->status === 'Diverifikasi') bg-blue-100 text-blue-800
                                    @elseif($peminjaman->status === 'Disetujui') bg-green-100 text-green-800
                                    @endif">
                                    {{ $peminjaman->status }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Borrowings -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Terbaru</h3>
                    @if($myPeminjaman->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kendaraan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($myPeminjaman as $peminjaman)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $peminjaman->kendaraan->merk ?? '-' }} {{ $peminjaman->kendaraan->tipe ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $peminjaman->tanggal_mulai->format('d/m/Y') }} - {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ Str::limit($peminjaman->tujuan, 30) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($peminjaman->status === 'Proses') bg-yellow-100 text-yellow-800
                                            @elseif($peminjaman->status === 'Diverifikasi') bg-blue-100 text-blue-800
                                            @elseif($peminjaman->status === 'Disetujui') bg-green-100 text-green-800
                                            @elseif($peminjaman->status === 'Selesai') bg-gray-100 text-gray-800
                                            @elseif($peminjaman->status === 'Ditolak') bg-red-100 text-red-800
                                            @endif">
                                            {{ $peminjaman->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">Belum ada riwayat peminjaman</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
