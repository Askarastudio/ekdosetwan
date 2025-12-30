<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600 bg-clip-text text-transparent animate-gradient">
                    @if(auth()->user()->hasAnyRole(['P3B', 'Pengurus Barang']))
                        {{ __('Daftar Semua Peminjaman') }}
                    @else
                        {{ __('Riwayat Peminjaman Saya') }}
                    @endif
                </h2>
                <p class="text-sm text-gray-600 mt-1">Kelola dan pantau peminjaman kendaraan</p>
            </div>
            @if(auth()->user()->canBorrow())
            <a href="{{ route('peminjaman.create') }}" class="group relative overflow-hidden inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-purple-700 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <svg class="h-5 w-5 mr-2 relative z-10 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="relative z-10">Ajukan Peminjaman Baru</span>
            </a>
            @endif
        </div>
    </x-slot>

    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
    </style>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-6 transform hover:scale-[1.02] transition-all duration-300">
                <div class="rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 p-[2px]">
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-4 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 transform hover:scale-[1.02] transition-all duration-300">
                <div class="rounded-xl bg-gradient-to-r from-red-500 to-pink-500 p-[2px]">
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-4 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-2xl sm:rounded-2xl border border-white/20">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-slate-50 to-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <span>No. Pengajuan</span>
                                        </div>
                                    </th>
                                    @if(auth()->user()->hasAnyRole(['P3B', 'Pengurus Barang']))
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pemohon</th>
                                    @endif
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kendaraan</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tujuan</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($peminjamans as $peminjaman)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-200">
                                                <span class="text-xs font-bold text-white">#{{ substr(str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT), -2) }}</span>
                                            </div>
                                            <span class="text-sm font-bold text-gray-900">#{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </td>
                                    @if(auth()->user()->hasAnyRole(['P3B', 'Pengurus Barang']))
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-bold text-white">{{ substr($peminjaman->user->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">{{ $peminjaman->user->name ?? 'Pengguna' }}</span>
                                        </div>
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center shadow-md">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">
                                                    {{ $peminjaman->kendaraan->merk ?? 'Belum ditentukan' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $peminjaman->kendaraan->nomor_polisi ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $peminjaman->tanggal_mulai->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            s/d {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-900 font-medium">
                                            {{ Str::limit($peminjaman->tujuan, 40) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-lg shadow-md
                                            @if($peminjaman->status === 'Proses') bg-gradient-to-r from-amber-400 to-yellow-500 text-white
                                            @elseif($peminjaman->status === 'Diverifikasi') bg-gradient-to-r from-blue-400 to-indigo-500 text-white
                                            @elseif($peminjaman->status === 'Disetujui') bg-gradient-to-r from-emerald-400 to-teal-500 text-white
                                            @elseif($peminjaman->status === 'Selesai') bg-gradient-to-r from-slate-400 to-gray-500 text-white
                                            @elseif($peminjaman->status === 'Ditolak') bg-gradient-to-r from-red-400 to-pink-500 text-white
                                            @endif">
                                            {{ $peminjaman->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('peminjaman.show', $peminjaman) }}" title="Detail" class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white hover:shadow-lg hover:scale-110 transition-all duration-200">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        @if(auth()->user()->hasRole('Pengurus Barang') && $peminjaman->status === 'Disetujui' && $peminjaman->suratTugas)
                                            <a href="{{ route('pengurus-barang.peminjaman.export-pdf', $peminjaman) }}" title="Export PDF" class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-red-500 to-pink-600 text-white hover:shadow-lg hover:scale-110 transition-all duration-200">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </a>
                                            
                                            <a href="{{ route('pengurus-barang.peminjaman.export-word', $peminjaman) }}" title="Export Word (Editable)" class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-sky-500 to-blue-600 text-white hover:shadow-lg hover:scale-110 transition-all duration-200">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mb-4">
                                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Riwayat</h4>
                                        <p class="text-gray-500">Belum ada riwayat peminjaman</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($peminjamans->hasPages())
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        {{ $peminjamans->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
