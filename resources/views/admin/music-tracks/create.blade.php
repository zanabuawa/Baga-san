@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.music-tracks.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Nueva pista de música</h1>
</div>

<div class="max-w-lg bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.music-tracks.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Título de la pista</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Ej: Jazz chill">
            @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">URL del archivo de audio</label>
            <input type="text" name="url" value="{{ old('url') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="https://ejemplo.com/musica.mp3">
            <p class="text-gray-500 text-xs mt-1">URL directa a un archivo .mp3, .ogg o .wav.</p>
            @error('url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Orden</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                min="0">
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                class="w-4 h-4 rounded accent-purple-500">
            <label for="is_active" class="text-sm text-gray-400">Activa</label>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Crear pista
        </button>
    </form>
</div>

@endsection
