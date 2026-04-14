@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white">Pistas de música</h1>
        <p class="text-gray-400 text-sm mt-1">Las pistas activas suenan en el reproductor de la página pública.</p>
    </div>
    <a href="{{ route('admin.music-tracks.create') }}" class="admin-btn-primary">
        + Nueva pista
    </a>
</div>

@if($tracks->isEmpty())
    <div class="admin-card p-16 text-center">
        <div class="text-5xl mb-4">🎵</div>
        <p class="text-gray-400 text-sm">No hay pistas todavía.</p>
        <a href="{{ route('admin.music-tracks.create') }}" class="inline-block mt-4 admin-btn-primary text-sm">
            Subir primera pista
        </a>
    </div>
@else
<p class="text-gray-500 text-sm mb-4">Arrastra las filas para cambiar el orden.</p>
<div class="admin-card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5 bg-white/2">
                <th class="px-4 py-4 w-8"></th>
                <th class="text-left px-6 py-4 font-medium">Título</th>
                <th class="text-left px-6 py-4 font-medium">Fuente</th>
                <th class="text-left px-6 py-4 font-medium">Preview</th>
                <th class="text-left px-6 py-4 font-medium">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody id="sortable-tbody" class="divide-y divide-white/5">
            @foreach($tracks as $track)
            <tr class="hover:bg-white/2 transition group" data-id="{{ $track->id }}">
                <td class="px-4 py-4 text-gray-600 cursor-grab active:cursor-grabbing drag-handle select-none text-lg text-center">⠿</td>
                <td class="px-6 py-4">
                    <p class="font-medium text-white">{{ $track->title }}</p>
                </td>
                <td class="px-6 py-4">
                    @if($track->file_path)
                        <span class="inline-flex items-center gap-1.5 text-xs text-purple-300 bg-purple-500/10 px-2 py-1 rounded-full">
                            📁 Archivo subido
                        </span>
                    @elseif($track->url)
                        <span class="inline-flex items-center gap-1.5 text-xs text-blue-300 bg-blue-500/10 px-2 py-1 rounded-full">
                            🔗 URL externa
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($track->audio_url)
                    <audio controls class="h-7 w-48 opacity-70 group-hover:opacity-100 transition">
                        <source src="{{ $track->audio_url }}">
                    </audio>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($track->is_active)
                        <span class="admin-badge-success">Activa</span>
                    @else
                        <span class="admin-badge-muted">Inactiva</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('admin.music-tracks.edit', $track) }}" class="admin-action-btn">
                            Editar
                        </a>
                        <form action="{{ route('admin.music-tracks.destroy', $track) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar esta pista?')"
                                class="admin-action-btn-danger">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('admin.partials.sortable-table', ['route' => route('admin.music-tracks.reorder')])
@endif

@endsection
