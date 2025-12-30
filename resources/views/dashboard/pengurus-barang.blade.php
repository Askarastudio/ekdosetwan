<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengurus Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Peminjaman Menunggu Approval</h3>
                    <p class="text-gray-600">Total: {{ $peminjamanMenunggu->count() }} pengajuan</p>
                    @if($peminjamanMenunggu->count() > 0)
                    <a href="{{ route('pengurus-barang.approval.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Lihat Semua Pengajuan
                    </a>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menunggu Penerbitan Surat Tugas</h3>
                    <p class="text-gray-600">Total: {{ $peminjamanDisetujui->count() }} surat belum diterbitkan</p>
                    @if($peminjamanDisetujui->count() > 0)
                    <a href="{{ route('pengurus-barang.surat-tugas.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        Kelola Surat Tugas
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
