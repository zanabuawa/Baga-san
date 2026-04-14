<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $links = SocialLink::all()->keyBy('platform');
        return view('admin.social-links.index', compact('links'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'links.*.url'       => 'nullable|url',
            'links.*.is_active' => 'boolean',
        ]);

        $platforms = ['x', 'instagram', 'discord', 'paypal', 'whatsapp'];

        foreach ($platforms as $platform) {
            SocialLink::updateOrCreate(
                ['platform' => $platform],
                [
                    'url'       => $request->input("links.{$platform}.url"),
                    'is_active' => $request->boolean("links.{$platform}.is_active"),
                ]
            );
        }

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Links sociales actualizados correctamente.');
    }
}