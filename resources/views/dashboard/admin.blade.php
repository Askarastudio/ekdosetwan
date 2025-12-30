<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="relative overflow-hidden rounded-2xl bg-white text-gray-900 p-6 md:p-8 card-animate" style="background: linear-gradient(135deg, #f6f9ff 0%, #eef2ff 28%, #ebfff7 100%);">
                <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(circle at 20% 20%, rgba(99,102,241,0.45), transparent 28%), radial-gradient(circle at 80% 10%, rgba(34,197,94,0.35), transparent 25%);"></div>
                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="space-y-3 slide-up">
                        <p class="text-sm uppercase tracking-widest font-semibold bg-gradient-to-r from-blue-500 via-indigo-500 to-emerald-500 bg-clip-text text-transparent">Ringkasan Sistem</p>
                        <h1 class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-indigo-600 via-blue-600 to-emerald-500 bg-clip-text text-transparent drop-shadow-lg">Halo, {{ auth()->user()->name }}</h1>
                        <p class="max-w-2xl text-gray-700">Pantau kendaraan, supir, dan aktivitas peminjaman secara real-time. Semua aksi penting ada di sini.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 w-full lg:w-auto slide-up" style="animation-delay:0.12s;">
                        <div class="glass-panel rounded-xl px-4 py-3 text-center">
                            <p class="text-sm text-gray-700">Kendaraan</p>
                            <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $totalKendaraan }}</p>
                        </div>
                        <div class="glass-panel rounded-xl px-4 py-3 text-center">
                            <p class="text-sm text-gray-700">Supir</p>
                            <p class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent">{{ $totalSupir }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 stagger">
                <div class="bg-white overflow-hidden rounded-xl card-animate p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500/10 text-blue-600 rounded-xl p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm font-medium">Total Kendaraan</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalKendaraan }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden rounded-xl card-animate p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-emerald-500/10 text-emerald-600 rounded-xl p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm font-medium">Total Supir</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalSupir }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden rounded-xl card-animate p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-amber-500/10 text-amber-600 rounded-xl p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm font-medium">Menunggu Verifikasi</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ $peminjamanProses }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden rounded-xl card-animate p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500/10 text-purple-600 rounded-xl p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm font-medium">Sedang Berlangsung</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ $peminjamanBerlangsung }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden rounded-xl card-animate mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @can('create-kendaraan')
                        <a href="{{ route('admin.kendaraan.index') }}" class="flex items-center p-4 rounded-lg bg-blue-50 hover:bg-blue-100 transition card-animate" style="box-shadow:none;">
                            <svg class="h-8 w-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Kelola Kendaraan</h4>
                                <p class="text-sm text-gray-600">Tambah & edit kendaraan</p>
                            </div>
                        </a>
                        @endcan

                        @can('create-supir')
                        <a href="{{ route('admin.supir.index') }}" class="flex items-center p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition card-animate" style="box-shadow:none;">
                            <svg class="h-8 w-8 text-emerald-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Kelola Supir</h4>
                                <p class="text-sm text-gray-600">Tambah & edit supir</p>
                            </div>
                        </a>
                        @endcan

                        @can('edit-settings')
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center p-4 rounded-lg bg-purple-50 hover:bg-purple-100 transition card-animate" style="box-shadow:none;">
                            <svg class="h-8 w-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Pengaturan</h4>
                                <p class="text-sm text-gray-600">Konfigurasi sistem</p>
                            </div>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            @can('view-audit-log')
            <div class="bg-white overflow-hidden rounded-xl card-animate">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                        <span class="badge-soft bg-indigo-100 text-indigo-700">Log terakhir</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 table-animate">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentAuditLogs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $log->user->name ?? 'System' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="badge-soft bg-blue-50 text-blue-700">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $log->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada aktivitas
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>
