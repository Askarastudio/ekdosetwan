<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Surat Tugas') }}
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

            <!-- Peminjaman yang perlu Surat Tugas -->
            @if($peminjamanDisetujui->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menunggu Penerbitan Surat Tugas</h3>
                    
                    <div class="space-y-4">
                        @foreach($peminjamanDisetujui as $peminjaman)
                        <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">#{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }} - {{ $peminjaman->user->name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $peminjaman->kendaraan->merk }} {{ $peminjaman->kendaraan->tipe }} ({{ $peminjaman->kendaraan->nomor_polisi }})<br>
                                    Supir: {{ $peminjaman->supir->nama }}<br>
                                    Periode: {{ $peminjaman->tanggal_mulai->format('d/m/Y') }} - {{ $peminjaman->tanggal_selesai->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="{{ route('pengurus-barang.surat-tugas.generate', $peminjaman) }}" 
                                    onclick="return confirm('Terbitkan Surat Tugas untuk pengajuan ini?')"
                                    title="Terbitkan Surat Tugas"
                                    class="inline-flex items-center justify-center h-9 w-9 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Surat Tugas yang sudah diterbitkan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Surat Tugas Terbaru</h3>
                    
                    @if($suratTugasTerbaru->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($suratTugasTerbaru as $surat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $surat->nomor_surat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $surat->tanggal_surat->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $surat->peminjaman->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $surat->peminjaman->kendaraan->merk }} {{ $surat->peminjaman->kendaraan->tipe }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('pengurus-barang.surat-tugas.download', $surat) }}" 
                                            title="Download PDF"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded text-red-600 hover:bg-red-50 transition">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('pengurus-barang.peminjaman.export-word', $surat->peminjaman) }}" 
                                            title="Export Word (Editable)"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded text-blue-600 hover:bg-blue-50 transition">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm">Belum ada Surat Tugas yang diterbitkan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
