@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white">Portafolio</h1>
        <p class="text-gray-400 text-sm mt-1">{{ $items->count() }} piezas publicadas</p>
    </div>
    <a href="{{ route('admin.portfolio.create') }}" class="admin-btn-primary">
        + Agregar pieza
    </a>
</div>

@if($items->isEmpty())
    <div class="admin-card p-16 text-center">
        <div class="text-5xl mb-4">🎨</div>
        <p class="text-gray-400 mb-4">No hay piezas en el portafolio todavía.</p>
        <a href="{{ route('admin.portfolio.create') }}" class="admin-btn-primary text-sm">Agregar la primera pieza</a>
    </div>
@else
<p class="text-gray-500 text-sm mb-4">Arrastra las piezas para cambiar el orden en que aparecen.</p>

<div id="sortable-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
    @foreach($items as $item)
    <div class="admin-card overflow-hidden group hover:scale-[1.02] transition-transform duration-200 cursor-grab active:cursor-grabbing select-none"
         data-id="{{ $item->id }}">
        <div class="aspect-square overflow-hidden relative">
            {{-- Handle visual --}}
            <div class="absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition">
                <div class="bg-gray-900/70 backdrop-blur-sm rounded-md px-1.5 py-1 text-gray-300 text-xs">⠿</div>
            </div>
            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-400 pointer-events-none">
            <div class="absolute inset-0 bg-gray-950/0 group-hover:bg-gray-950/70 transition-all duration-200 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                <a href="{{ route('admin.portfolio.edit', $item) }}"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-sm transition">
                    ✏️
                </a>
                <form action="{{ route('admin.portfolio.destroy', $item) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar esta pieza?')"
                        class="w-9 h-9 rounded-full bg-red-500/20 hover:bg-red-500/40 backdrop-blur-sm flex items-center justify-center text-red-300 text-sm transition">
                        🗑️
                    </button>
                </form>
            </div>
            @if(!$item->is_visible)
            <div class="absolute top-2 left-2">
                <span class="admin-badge-muted text-xs">Oculto</span>
            </div>
            @endif
        </div>
        <div class="p-3">
            <p class="font-medium text-sm text-white truncate">{{ $item->title }}</p>
            <p class="text-gray-500 text-xs mt-0.5">{{ $item->portfolioCategory->name ?? 'Sin categoría' }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Toast de guardado --}}
<div id="save-toast" class="fixed bottom-6 right-6 bg-gray-800 border border-white/10 text-white text-sm px-4 py-2.5 rounded-xl shadow-xl opacity-0 transition-opacity duration-300 pointer-events-none">
    Orden guardado ✓
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const grid = document.getElementById('sortable-grid');
const toast = document.getElementById('save-toast');
let toastTimer;

Sortable.create(grid, {
    animation: 150,
    ghostClass: 'opacity-30',
    onEnd() {
        const ids = [...grid.querySelectorAll('[data-id]')].map(el => el.dataset.id);

        fetch('{{ route('admin.portfolio.reorder') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ order: ids }),
        });

        clearTimeout(toastTimer);
        toast.classList.remove('opacity-0');
        toastTimer = setTimeout(() => toast.classList.add('opacity-0'), 2000);
    },
});
</script>
@endif

@endsection
