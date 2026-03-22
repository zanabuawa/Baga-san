@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Portafolio</h1>
    <a href="{{ route('admin.portfolio.create') }}" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:opacity-90 transition">
        + Agregar pieza
    </a>
</div>

@if($items->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400 mb-4">No hay piezas en el portafolio todavía.</p>
        <a href="{{ route('admin.portfolio.create') }}" class="text-purple-400 hover:text-purple-300 text-sm">Agregar la primera pieza →</a>
    </div>
@else
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($items as $item)
    <div class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden group">
        <div class="aspect-square overflow-hidden relative">
            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            @if(!$item->is_visible)
            <div class="absolute inset-0 bg-gray-950/70 flex items-center justify-center">
                <span class="text-xs text-gray-400">Oculto</span>
            </div>
            @endif
        </div>
        <div class="p-3">
            <p class="font-medium text-sm">{{ $item->title }}</p>
            <p class="text-gray-400 text-xs mt-1">{{ ucfirst($item->category) }}</p>
            <div class="flex gap-2 mt-3">
                <a href="{{ route('admin.portfolio.edit', $item) }}"
                   class="flex-1 text-center text-xs py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                    Editar
                </a>
                <form action="{{ route('admin.portfolio.destroy', $item) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar esta pieza?')"
                        class="text-xs py-1.5 px-3 rounded-lg border border-white/10 text-gray-400 hover:text-red-400 hover:border-red-400 transition">
                        ✕
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection