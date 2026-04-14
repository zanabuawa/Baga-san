@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Paquetes de precios</h1>
    <a href="{{ route('admin.packages.create') }}" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:opacity-90 transition">
        + Agregar paquete
    </a>
</div>

@if($packages->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400">No hay paquetes todavía.</p>
    </div>
@else
<p class="text-gray-500 text-sm mb-4">Arrastra las tarjetas para cambiar el orden.</p>
<div id="sortable-grid" class="grid md:grid-cols-3 gap-6">
    @foreach($packages as $package)
    <div class="bg-gray-800 border rounded-2xl p-6 relative cursor-grab active:cursor-grabbing select-none
        {{ $package->is_featured ? 'border-purple-500/40' : 'border-white/5' }}"
        data-id="{{ $package->id }}">
        @if($package->is_featured)
        <span class="absolute top-4 right-4 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs px-3 py-1 rounded-full">Popular</span>
        @endif
        @if(!$package->is_active)
        <span class="absolute top-4 left-4 bg-gray-700 text-gray-400 text-xs px-3 py-1 rounded-full">Oculto</span>
        @endif
        <h3 class="font-bold text-lg mb-1">{{ $package->name }}</h3>
        <p class="text-gray-400 text-sm mb-4">{{ $package->description }}</p>
        <p class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent mb-1">
            ${{ number_format($package->price, 2) }}
        </p>
        <p class="text-gray-500 text-xs mb-4">USD</p>
        <ul class="space-y-1 mb-6">
            @foreach($package->features as $feature)
            <li class="flex items-center gap-2 text-xs text-gray-400">
                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full flex-shrink-0"></span>
                {{ $feature }}
            </li>
            @endforeach
        </ul>
        <div class="flex gap-2">
            <a href="{{ route('admin.packages.edit', $package) }}"
                class="flex-1 text-center text-xs py-2 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                Editar
            </a>
            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('¿Eliminar este paquete?')"
                    class="text-xs py-2 px-3 rounded-lg border border-white/10 text-gray-400 hover:text-red-400 hover:border-red-400 transition">
                    ✕
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const grid = document.getElementById('sortable-grid');
const toast = document.getElementById('sort-toast');
let timer;
Sortable.create(grid, {
    animation: 150,
    ghostClass: 'opacity-30',
    onEnd() {
        const ids = [...grid.querySelectorAll('[data-id]')].map(el => el.dataset.id);
        fetch('{{ route('admin.packages.reorder') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ order: ids }),
        });
        clearTimeout(timer);
        toast.classList.remove('opacity-0');
        timer = setTimeout(() => toast.classList.add('opacity-0'), 2000);
    },
});
</script>
<div id="sort-toast"
     class="fixed bottom-6 right-6 bg-gray-800 border border-white/10 text-white text-sm px-4 py-2.5 rounded-xl shadow-xl opacity-0 transition-opacity duration-300 pointer-events-none z-50">
    Orden guardado ✓
</div>
@endif

@endsection
