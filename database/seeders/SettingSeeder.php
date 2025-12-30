<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'batas_maksimal_pinjam',
            'value' => '3',
            'type' => 'integer',
            'description' => 'Batas maksimal hari peminjaman KDO',
        ]);

        Setting::create([
            'key' => 'filter_hari',
            'value' => 'semua',
            'type' => 'string',
            'description' => 'Filter hari peminjaman: semua, hari_libur',
        ]);

        Setting::create([
            'key' => 'cooldown_period',
            'value' => '14',
            'type' => 'integer',
            'description' => 'Cooldown period dalam hari setelah peminjaman selesai',
        ]);

        Setting::create([
            'key' => 'app_name',
            'value' => 'E-Peminjaman KDO',
            'type' => 'string',
            'description' => 'Nama aplikasi',
        ]);

        Setting::create([
            'key' => 'organization_name',
            'value' => 'Sekretariat DPRD Provinsi DKI Jakarta',
            'type' => 'string',
            'description' => 'Nama organisasi',
        ]);
    }
}
