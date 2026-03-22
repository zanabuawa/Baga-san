<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = PageSetting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'artist_name'        => 'required|string|max:255',
            'hero_title'         => 'required|string|max:255',
            'hero_subtitle'      => 'required|string',
            'bio'                => 'required|string',
            'commissions_open'   => 'boolean',
            'commissions_status' => 'required|string|max:255',
            'delivery_time'      => 'required|string|max:255',
            'contact_email'      => 'nullable|email',
            'commission_slots'   => 'required|integer|min:1|max:20',
        ]);

        $settings = [
            'artist_name',
            'hero_title',
            'hero_subtitle',
            'bio',
            'commissions_status',
            'delivery_time',
            'contact_email',
            'commission_slots',

        ];

        foreach ($settings as $key) {
            PageSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->$key]
            );
        }

        PageSetting::updateOrCreate(
            ['key' => 'commissions_open'],
            ['value' => $request->boolean('commissions_open') ? 'true' : 'false']
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Configuración guardada correctamente.');
    }
}