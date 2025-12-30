<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600">Sistem E-Peminjaman Kendaraan Dinas Operasional</p>
                </div>
            </div>

            @role('User')
            @php
                $activePeminjaman = auth()->user()->peminjamans()
                    ->whereIn('status', ['Proses', 'Diverifikasi', 'Disetujui'])
                    ->first();
                $canBorrow = auth()->user()->canBorrow();
                $nextBorrowDate = auth()->user()->nextBorrowDate();
            @endphp

            <!-- Active Peminjaman Warning -->
            @if($activePeminjaman)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Anda memiliki peminjaman aktif!</strong><br>
                            Nomor Pengajuan: <span class="font-mono font-semibold">#{{ str_pad($activePeminjaman->id, 5, '0', STR_PAD_LEFT) }}</span><br>
                            Status: <span class="font-semibold">{{ $activePeminjaman->status }}</span><br>
                            Anda tidak dapat mengajukan peminjaman baru hingga peminjaman ini selesai.
                        </p>
                        <a href="{{ route('peminjaman.show', $activePeminjaman) }}" class="mt-2 inline-flex items-center text-sm font-medium text-yellow-700 hover:text-yellow-600">
                            Lihat Detail
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Cooldown Period Warning -->
            @if(!$canBorrow && !$activePeminjaman)
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <strong>Periode Cooldown Aktif</strong><br>
                            Anda dapat mengajukan peminjaman kembali pada: <span class="font-semibold">{{ $nextBorrowDate->format('d F Y') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Can Borrow - Show Quick Action -->
            @if($canBorrow && !$activePeminjaman)
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                <strong>Anda dapat mengajukan peminjaman kendaraan!</strong>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        Ajukan Peminjaman
                    </a>
                </div>
            </div>
            @endif
            @endrole

            <!-- Quick Links -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @role('User')
                        <a href="{{ route('peminjaman.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Riwayat Peminjaman</p>
                                <p class="text-sm text-gray-600">Lihat semua peminjaman</p>
                            </div>
                        </a>
                        @endrole

                        @role('Admin')
                        <a href="{{ route('admin.kendaraan.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Kelola Kendaraan</p>
                                <p class="text-sm text-gray-600">Manage kendaraan dinas</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.supir.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Kelola Supir</p>
                                <p class="text-sm text-gray-600">Manage supir</p>
                            </div>
                        </a>
                        @endrole

                        @role('P3B')
                        <a href="{{ route('p3b.verifikasi.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Verifikasi Peminjaman</p>
                                <p class="text-sm text-gray-600">Review & assign</p>
                            </div>
                        </a>
                        @endrole

                        @role('Pengurus Barang')
                        <a href="{{ route('pengurus-barang.approval.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Approval Peminjaman</p>
                                <p class="text-sm text-gray-600">Setujui & cetak surat</p>
                            </div>
                        </a>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
