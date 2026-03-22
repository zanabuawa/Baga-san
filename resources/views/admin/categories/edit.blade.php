@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Editar categoría</h1>
</div>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Ícono (emoji)</label>
            <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Descripción</label>
            <textarea name="description" rows="2"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Orden</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                {{ $category->is_active ? 'checked' : '' }}
                class="w-4 h-4 rounded accent-purple-500">
            <label for="is_active" class="text-sm text-gray-400">Visible en la página pública</label>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Actualizar categoría
        </button>
    </form>
</div>

@endsection