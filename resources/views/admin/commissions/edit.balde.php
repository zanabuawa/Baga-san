@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.commissions.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Editar comisión</h1>
</div>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.commissions.update', $commission) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Estado</label>
            <select name="status"
                class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
                <option value="pending" {{ $commission->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="in_progress" {{ $commission->status === 'in_progress' ? 'selected' : '' }}>En progreso</option>
                <option value="delivered" {{ $commission->status === 'delivered' ? 'selected' : '' }}>Entregado</option>
                <option value="paid" {{ $commission->status === 'paid' ? 'selected' : '' }}>Pagado</option>
            </select>
            @error('status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Precio acordado (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $commission->price) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="0.00">
            @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8">
            <label class="block text-xs text-gray-400 mb-2">Notas internas</label>
            <textarea name="notes" rows="5"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Notas privadas sobre esta comisión...">{{ old('notes', $commission->notes) }}</textarea>
        </div>

@if($commission->references->isNotEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-8">
        <h2 class="font-semibold mb-4">Imágenes de referencia</h2>
        <div class="grid grid-cols-3 gap-3">
            @foreach($commission->references as $ref)
            <div class="group relative">
                <img src="{{ Storage::url($ref->image_path) }}" alt="Referencia"
                    class="w-full aspect-square object-cover rounded-xl">
                <form action="{{ route('admin.references.destroy', $ref) }}" method="POST"
                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar imagen?')"
                        class="bg-red-500/80 text-white text-xs px-2 py-1 rounded-lg">
                        ✕
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Guardar cambios
        </button>
    </form>
</div>

@endsection