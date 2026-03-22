
@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.portfolio.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Editar pieza</h1>
</div>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.portfolio.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Título</label>
            <input type="text" name="title" value="{{ old('title', $portfolio->title) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
            @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Descripción</label>
            <textarea name="description" rows="3"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">{{ old('description', $portfolio->description) }}</textarea>
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Categoría</label>
            <select name="category_id"
                class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
                <option value="">Sin categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $portfolio->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->icon }} {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Imagen actual</label>
            <img src="{{ Storage::url($portfolio->image_path) }}" alt="{{ $portfolio->title }}"
                class="w-32 h-32 object-cover rounded-xl mb-3">
            <label class="block text-xs text-gray-400 mb-2">Cambiar imagen (opcional)</label>
            <input type="file" name="image" accept="image/*"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-400 focus:outline-none focus:border-purple-500">
            @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Orden</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $portfolio->sort_order) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_visible" id="is_visible" value="1"
                {{ $portfolio->is_visible ? 'checked' : '' }}
                class="w-4 h-4 rounded accent-purple-500">
            <label for="is_visible" class="text-sm text-gray-400">Visible en la página pública</label>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Actualizar pieza
        </button>
    </form>
</div>

@endsection