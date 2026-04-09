@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Pistas de música</h1>
    <a href="{{ route('admin.music-tracks.create') }}"
        class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm px-5 py-2.5 rounded-full hover:opacity-90 transition">
        + Nueva pista
    </a>
</div>

<p class="text-gray-400 text-sm mb-6">Las pistas activas se reproducen en el reproductor de la página principal. Puedes usar URLs directas de audio (mp3, ogg) o enlaces de servicios que permitan embed.</p>

@if($tracks->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400">No hay pistas todavía.</p>
    </div>
@else
<div class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5 bg-gray-900/50">
                <th class="text-left px-6 py-4">Orden</th>
                <th class="text-left px-6 py-4">Título</th>
                <th class="text-left px-6 py-4">URL</th>
                <th class="text-left px-6 py-4">Estado</th>
                <th class="text-left px-6 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($tracks as $track)
            <tr class="hover:bg-white/2 transition">
                <td class="px-6 py-4 text-gray-400">{{ $track->sort_order }}</td>
                <td class="px-6 py-4 font-medium">{{ $track->title }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs truncate max-w-xs">{{ $track->url }}</td>
                <td class="px-6 py-4">
                    @if($track->is_active)
                        <span class="px-2 py-1 rounded-full text-xs bg-emerald-500/15 text-emerald-300">Activa</span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs bg-gray-500/15 text-gray-400">Inactiva</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.music-tracks.edit', $track) }}"
                            class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.music-tracks.destroy', $track) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar esta pista?')"
                                class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-red-400 hover:border-red-400 transition">
                                ✕
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
