<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MusicTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        Log::info('=== MUSIC STORE: inicio ===');
        Log::info('POST data', $request->except(['_token']));
        Log::info('FILES raw', $_FILES ?? []);
        Log::info('CONTENT_LENGTH', [$request->server('CONTENT_LENGTH')]);
        Log::info('hasFile(audio_file)', [$request->hasFile('audio_file')]);
        Log::info('upload_max_filesize', [ini_get('upload_max_filesize')]);
        Log::info('post_max_size', [ini_get('post_max_size')]);

        if ($request->hasFile('audio_file')) {
            $f = $request->file('audio_file');
            Log::info('Archivo recibido', [
                'name'      => $f->getClientOriginalName(),
                'size'      => $f->getSize(),
                'mime'      => $f->getMimeType(),
                'extension' => $f->getClientOriginalExtension(),
                'isValid'   => $f->isValid(),
                'error'     => $f->getError(),
                'errorMsg'  => $f->getErrorMessage(),
            ]);
        } else {
            Log::warning('No se recibió archivo. PHP_FILES vacío: ' . (empty($_FILES) ? 'sí' : 'no'));
        }

        // Detectar error de PHP antes de validar (archivo demasiado grande)
        if ($request->hasFile('audio_file') === false
            && $request->server('CONTENT_LENGTH') > 0
            && empty($_FILES) && empty($_POST)) {
            Log::error('Archivo supera límite PHP antes de llegar a Laravel');
            return back()->withErrors(['audio_file' => 'El archivo supera el límite de subida del servidor (100MB máx).'])->withInput();
        }

        $request->validate([
            'title'      => 'required|string|max:255',
            'audio_file' => 'nullable|file|extensions:mp3,ogg,wav,m4a,flac,aac,webm,opus|max:102400',
            'url'        => 'nullable|string|max:500',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        Log::info('Validación pasada OK');

        if (!$request->hasFile('audio_file') && !$request->filled('url')) {
            Log::warning('Sin archivo ni URL — devolviendo error');
            return back()->withErrors(['audio_file' => 'Debes subir un archivo de audio o ingresar una URL.'])->withInput();
        }

        $filePath = null;
        if ($request->hasFile('audio_file') && $request->file('audio_file')->isValid()) {
            $filePath = $request->file('audio_file')->store('music', 'public');
            Log::info('Archivo guardado en', [$filePath]);
        }

        MusicTrack::create([
            'title'      => $request->title,
            'url'        => $filePath ? null : $request->url,
            'file_path'  => $filePath,
            'sort_order' => MusicTrack::max('sort_order') + 1,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        Log::info('=== MUSIC STORE: completado ===');

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
            'audio_file' => 'nullable|file|extensions:mp3,ogg,wav,m4a,flac,aac,webm,opus|max:102400',
            'url'        => 'nullable|string|max:500',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $filePath = $musicTrack->file_path;
        $url = $musicTrack->url;

        if ($request->hasFile('audio_file') && $request->file('audio_file')->isValid()) {
            // Borrar archivo anterior si existía
            if ($musicTrack->file_path) {
                Storage::disk('public')->delete($musicTrack->file_path);
            }
            $filePath = $request->file('audio_file')->store('music', 'public');
            $url = null;
        } elseif ($request->filled('url') && $request->url !== $musicTrack->url) {
            // Nueva URL ingresada: borrar archivo subido si había
            if ($musicTrack->file_path) {
                Storage::disk('public')->delete($musicTrack->file_path);
            }
            $filePath = null;
            $url = $request->url;
        }

        if (!$filePath && !$url) {
            return back()->withErrors(['audio_file' => 'Debes subir un archivo o ingresar una URL.'])->withInput();
        }

        $musicTrack->update([
            'title'      => $request->title,
            'url'        => $url,
            'file_path'  => $filePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.music-tracks.index')
            ->with('success', 'Pista actualizada correctamente.');
    }

    public function destroy(MusicTrack $musicTrack)
    {
        if ($musicTrack->file_path) {
            Storage::disk('public')->delete($musicTrack->file_path);
        }
        $musicTrack->delete();
        return redirect()->route('admin.music-tracks.index')
            ->with('success', 'Pista eliminada correctamente.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:music_tracks,id']);
        DB::transaction(function () use ($request) {
            foreach ($request->order as $position => $id) {
                MusicTrack::where('id', $id)->update(['sort_order' => $position]);
            }
        });
        return response()->json(['ok' => true]);
    }
}
