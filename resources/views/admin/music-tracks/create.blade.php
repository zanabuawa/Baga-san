@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.music-tracks.index') }}" class="admin-back-btn">← Volver</a>
    <h1 class="text-2xl font-bold text-white">Nueva pista de música</h1>
</div>

<div class="max-w-lg admin-card p-8">
    <form action="{{ route('admin.music-tracks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-field">
            <label class="admin-label">Título de la pista</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="admin-input" placeholder="Ej: Lofi chill vibes">
            @error('title') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        {{-- UPLOAD DE ARCHIVO --}}
        <div class="admin-field">
            <label class="admin-label">Archivo de audio</label>
            <label id="upload-label" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-white/10 rounded-2xl cursor-pointer hover:border-purple-500/50 hover:bg-purple-500/5 transition group">
                <div id="upload-idle" class="text-center">
                    <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">🎵</div>
                    <p class="text-gray-400 text-sm">Haz clic para subir un audio</p>
                    <p class="text-gray-600 text-xs mt-1">MP3, OGG, WAV, M4A — Máx. 50MB</p>
                </div>
                <div id="upload-selected" class="text-center hidden">
                    <div class="text-3xl mb-2">✅</div>
                    <p class="text-green-400 text-sm font-medium" id="upload-filename"></p>
                    <p class="text-gray-500 text-xs mt-1">Haz clic para cambiar</p>
                </div>
                <input type="file" name="audio_file" id="audio_file" accept=".mp3,.ogg,.wav,.m4a,.flac" class="hidden" onchange="handleFileSelect(this)">
            </label>
            @error('audio_file') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="relative my-4 flex items-center gap-3">
            <div class="flex-1 h-px bg-white/10"></div>
            <span class="text-gray-500 text-xs">o usa una URL</span>
            <div class="flex-1 h-px bg-white/10"></div>
        </div>

        <div class="admin-field">
            <label class="admin-label">URL del audio (alternativa)</label>
            <input type="text" name="url" value="{{ old('url') }}"
                class="admin-input" placeholder="https://ejemplo.com/cancion.mp3">
            <p class="text-gray-600 text-xs mt-1">Solo si no subiste archivo.</p>
            @error('url') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="admin-field flex items-end pb-1">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-700 peer-checked:bg-purple-500 rounded-full transition-colors"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="text-sm text-gray-400">Activa</span>
                </label>
            </div>
        </div>

        <button type="submit" class="admin-btn-primary w-full mt-4">
            🎵 Crear pista
        </button>
    </form>
</div>

<script>
function handleFileSelect(input) {
    const idle = document.getElementById('upload-idle');
    const selected = document.getElementById('upload-selected');
    const filename = document.getElementById('upload-filename');
    if (input.files && input.files[0]) {
        idle.classList.add('hidden');
        selected.classList.remove('hidden');
        filename.textContent = input.files[0].name;
    } else {
        idle.classList.remove('hidden');
        selected.classList.add('hidden');
    }
}
</script>

@endsection
