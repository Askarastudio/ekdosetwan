<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">
                    {{ __('Dashboard Anggota Dewan') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <div class="hidden md:flex items-center space-x-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm text-gray-600">Online</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cooldown Warning -->
            @if(!$canBorrow)
            <div class="mb-6 transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-orange-500 rounded-xl shadow-lg p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 flex-1">
                            <h3 class="text-lg font-bold text-gray-900">Periode Cooldown Aktif</h3>
                            <p class="mt-2 text-gray-700">
                                Anda dapat mengajukan peminjaman kembali pada:
                            </p>
                            <p class="mt-1 text-2xl font-bold text-orange-600">
                                {{ $nextBorrowDate->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="mb-6 transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-8 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full mr-4"></div>
                            <h3 class="text-2xl font-bold text-gray-800">Aksi Cepat</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($canBorrow)
                            <a href="{{ route('peminjaman.create') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-start space-x-4">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-bold text-white text-lg">Ajukan Peminjaman</p>
                                        <p class="text-blue-100 text-sm">Mulai pengajuan baru</p>
                                    </div>
                                </div>
                            </a>
                            @else
                            <div class="relative overflow-hidden rounded-xl bg-gray-400 p-6 opacity-60">
                                <div class="flex items-center justify-start space-x-4">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-bold text-white text-lg">Dalam Cooldown</p>
                                        <p class="text-gray-100 text-sm">Menunggu periode aktif</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <a href="{{ route('peminjaman.index') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-slate-700 to-slate-800 p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-start space-x-4">
                                    <div class="w-12 h-12 bg-white bg-opacity-10 rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-bold text-white text-lg">Riwayat Peminjaman</p>
                                        <p class="text-slate-300 text-sm">Lihat semua riwayat</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Borrowings -->
            @if($activePeminjaman->count() > 0)
            <div class="mb-6 transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-1 h-8 bg-gradient-to-b from-emerald-500 to-teal-600 rounded-full mr-4"></div>
                                <h3 class="text-2xl font-bold text-gray-800">Peminjaman Aktif</h3>
                            </div>
                            <span class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-md">
                                {{ $activePeminjaman->count() }} Aktif
                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($activePeminjaman as $peminjaman)
                            <div class="group bg-white hover:shadow-lg transition-all duration-300 rounded-xl border-2 border-gray-100 hover:border-emerald-300 p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-3">
                                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-gray-900">{{ $peminjaman->kendaraan->merk ?? 'Kendaraan belum ditentukan' }} {{ $peminjaman->kendaraan->tipe ?? '' }}</h4>
                                                <p class="text-sm text-gray-600">{{ $peminjaman->kendaraan->nomor_polisi ?? '-' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4 mt-4">
                                            <div class="flex items-start space-x-2">
                                                <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-gray-500 font-medium">Periode</p>
                                                    <p class="text-sm font-bold text-gray-900">{{ $peminjaman->tanggal_mulai->format('d M') }} - {{ $peminjaman->tanggal_selesai->format('d M Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <svg class="w-5 h-5 text-teal-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-gray-500 font-medium">Tujuan</p>
                                                    <p class="text-sm font-bold text-gray-900">{{ Str::limit($peminjaman->tujuan, 25) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="ml-4">
                                        <span class="px-4 py-2 text-sm font-bold rounded-xl shadow-md text-white
                                            @if($peminjaman->status === 'Proses') bg-gradient-to-r from-amber-500 to-orange-500
                                            @elseif($peminjaman->status === 'Diverifikasi') bg-gradient-to-r from-blue-500 to-indigo-600
                                            @elseif($peminjaman->status === 'Disetujui') bg-gradient-to-r from-emerald-500 to-teal-600
                                            @endif">
                                            {{ $peminjaman->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Borrowings -->
            <div class="transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                    <div class="bg-gradient-to-r from-violet-50 to-purple-50 p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-8 bg-gradient-to-b from-violet-500 to-purple-600 rounded-full mr-4"></div>
                            <h3 class="text-2xl font-bold text-gray-800">Riwayat Terbaru</h3>
                        </div>
                        
                        @if($myPeminjaman->count() > 0)
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kendaraan</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tujuan</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach($myPeminjaman as $peminjaman)
                                        <tr class="hover:bg-gradient-to-r hover:from-violet-50 hover:to-purple-50 transition-all duration-200 cursor-pointer"
                                            onclick="window.location='{{ route('peminjaman.show', $peminjaman) }}'">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-gray-900">{{ $peminjaman->kendaraan->merk ?? '-' }} {{ $peminjaman->kendaraan->tipe ?? '' }}</p>
                                                        <p class="text-xs text-gray-500">{{ $peminjaman->kendaraan->nomor_polisi ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm font-semibold text-gray-900">{{ $peminjaman->tanggal_mulai->format('d/m/Y') }}</p>
                                                <p class="text-xs text-gray-500">s/d {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-900 font-medium">{{ Str::limit($peminjaman->tujuan, 30) }}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-lg shadow-md text-white
                                                    @if($peminjaman->status === 'Proses') bg-gradient-to-r from-amber-500 to-yellow-600
                                                    @elseif($peminjaman->status === 'Diverifikasi') bg-gradient-to-r from-blue-500 to-indigo-600
                                                    @elseif($peminjaman->status === 'Disetujui') bg-gradient-to-r from-emerald-500 to-teal-600
                                                    @elseif($peminjaman->status === 'Selesai') bg-gradient-to-r from-slate-500 to-gray-600
                                                    @elseif($peminjaman->status === 'Ditolak') bg-gradient-to-r from-red-500 to-pink-600
                                                    @endif">
                                                    {{ $peminjaman->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-violet-100 to-purple-100 rounded-full mb-4">
                                <svg class="w-10 h-10 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Riwayat</h4>
                            <p class="text-gray-600">Anda belum pernah melakukan peminjaman</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
