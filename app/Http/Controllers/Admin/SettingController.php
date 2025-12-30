<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'batas_maksimal_pinjam' => 'required|integer|min:1|max:30',
            'filter_hari' => 'required|in:semua,hari_libur',
            'cooldown_period' => 'required|integer|min:1|max:90',
        ]);

        Setting::set('batas_maksimal_pinjam', $request->batas_maksimal_pinjam, 'integer');
        Setting::set('filter_hari', $request->filter_hari, 'string');
        Setting::set('cooldown_period', $request->cooldown_period, 'integer');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
