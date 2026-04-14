<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'happy_clients'      => 'nullable|integer|min:0',
            'years_experience'   => 'nullable|integer|min:0',
            'default_theme'      => 'nullable|in:dark,light,red,gold,blue,purple',
            'logo_hero'    => 'nullable|image|mimes:png,jpg,jpeg,gif,svg,webp|max:2048',
            'logo_navbar'  => 'nullable|image|mimes:png,jpg,jpeg,gif,svg,webp|max:2048',
            'logo_favicon' => 'nullable|mimes:png,jpg,jpeg,gif,svg,webp,ico|max:2048',
        ]);

        // Manejar subida / borrado de cada logo
        foreach (['logo_hero', 'logo_navbar', 'logo_favicon'] as $field) {
            $removeKey = 'remove_' . $field;
            if ($request->boolean($removeKey)) {
                $old = PageSetting::where('key', $field)->value('value');
                if ($old) Storage::disk('public')->delete($old);
                PageSetting::updateOrCreate(['key' => $field], ['value' => null]);
            } elseif ($request->hasFile($field) && $request->file($field)->isValid()) {
                $old = PageSetting::where('key', $field)->value('value');
                if ($old) Storage::disk('public')->delete($old);
                $path = $request->file($field)->store('logos', 'public');
                PageSetting::updateOrCreate(['key' => $field], ['value' => $path]);
            }
        }

        $settings = [
            'artist_name',
            'hero_title',
            'hero_subtitle',
            'bio',
            'commissions_status',
            'delivery_time',
            'contact_email',
            'commission_slots',
            'happy_clients',
            'years_experience',
            'default_theme',
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