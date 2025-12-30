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
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Nomor</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Pemohon</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Kendaraan</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Supir</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Periode</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($peminjamanMenunggu->take(5) as $peminjaman)
                                <tr>
                                    <td class="px-4 py-2 font-semibold text-gray-900">#{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $peminjaman->user->name }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ optional($peminjaman->kendaraan)->nomor_polisi ?? '-' }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ optional($peminjaman->supir)->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $peminjaman->tanggal_mulai->format('d/m/Y') }} - {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('peminjaman.show', $peminjaman) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($peminjamanMenunggu->count() > 5)
                        <p class="text-xs text-gray-500 mt-2">Menampilkan 5 pengajuan terbaru.</p>
                        @endif
                    </div>
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
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Nomor</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Pemohon</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Kendaraan</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Supir</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Periode</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($peminjamanDisetujui->take(5) as $peminjaman)
                                <tr>
                                    <td class="px-4 py-2 font-semibold text-gray-900">#{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $peminjaman->user->name }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ optional($peminjaman->kendaraan)->nomor_polisi ?? '-' }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ optional($peminjaman->supir)->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $peminjaman->tanggal_mulai->format('d/m/Y') }} - {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('peminjaman.show', $peminjaman) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($peminjamanDisetujui->count() > 5)
                        <p class="text-xs text-gray-500 mt-2">Menampilkan 5 peminjaman terbaru.</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
