@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.packages.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Agregar paquete</h1>
</div>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.packages.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Nombre del paquete</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Ej: Pack streamer">
            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Descripción</label>
            <textarea name="description" rows="2"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Breve descripción del paquete">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Precio (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="0.00">
            @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Características</label>
            <textarea name="features" rows="5"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Una característica por línea:
5 emotes personalizados
3 revisiones por emote
Entrega en 10-14 días">{{ old('features') }}</textarea>
            <p class="text-gray-500 text-xs mt-1">Escribe una característica por línea.</p>
            @error('features') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
<div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Categoría</label>
            <select name="category_id"
                class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
                <option value="">Sin categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->icon }} {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Orden</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
        </div>

        <div class="mb-4 flex items-center gap-3">
            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                {{ old('is_featured') ? 'checked' : '' }}
                class="w-4 h-4 rounded accent-purple-500">
            <label for="is_featured" class="text-sm text-gray-400">Marcar como popular</label>
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                {{ old('is_active', true) ? 'checked' : '' }}
                class="w-4 h-4 rounded accent-purple-500">
            <label for="is_active" class="text-sm text-gray-400">Visible en la página pública</label>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Guardar paquete
        </button>
    </form>
</div>

@endsection