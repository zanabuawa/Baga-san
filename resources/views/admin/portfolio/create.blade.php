@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.portfolio.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Agregar pieza</h1>
</div>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Título</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Nombre de la pieza">
            @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Descripción</label>
            <textarea name="description" rows="3"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Descripción opcional">{{ old('description') }}</textarea>
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
            <label class="block text-xs text-gray-400 mb-2">Imagen</label>
            <input type="file" name="image" accept="image/*"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-400 focus:outline-none focus:border-purple-500">
            <p class="text-gray-500 text-xs mt-1">JPG, PNG, GIF o WebP. Máximo 2MB.</p>
            @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Orden</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_visible" id="is_visible" value="1"
                {{ old('is_visible', true) ? 'checked' : '' }}
                class="w-4 h-4 rounded accent-purple-500">
            <label for="is_visible" class="text-sm text-gray-400">Visible en la página pública</label>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Guardar pieza
        </button>
    </form>
</div>

@endsection