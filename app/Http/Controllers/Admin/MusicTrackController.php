<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MusicTrack;
use Illuminate\Http\Request;

class MusicTrackController extends Controller
{
    public function index()
    {
        $tracks = MusicTrack::orderBy('sort_order')->get();
        return view('admin.music-tracks.index', compact('tracks'));
    }

    public function create()
    {
        return view('admin.music-tracks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'url'        => 'required|string|max:500',
            'sort_order' => 'integer',
            'is_active'  => 'boolean',
        ]);

        MusicTrack::create([
            'title'      => $request->title,
            'url'        => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.music-tracks.index')
            ->with('success', 'Pista creada correctamente.');
    }

    public function edit(MusicTrack $musicTrack)
    {
        return view('admin.music-tracks.edit', compact('musicTrack'));
    }

    public function update(Request $request, MusicTrack $musicTrack)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'url'        => 'required|string|max:500',
            'sort_order' => 'integer',
            'is_active'  => 'boolean',
        ]);

        $musicTrack->update([
            'title'      => $request->title,
            'url'        => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.music-tracks.index')
            ->with('success', 'Pista actualizada correctamente.');
    }

    public function destroy(MusicTrack $musicTrack)
    {
        $musicTrack->delete();
        return redirect()->route('admin.music-tracks.index')
            ->with('success', 'Pista eliminada correctamente.');
    }
}
