@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.products.index') }}" class="admin-back-btn">← Volver</a>
    <h1 class="text-2xl font-bold">Editar producto</h1>
</div>

<div class="max-w-2xl admin-card p-8">
    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="admin-field">
            <label class="admin-label">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="admin-input">
            @error('name') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Descripción</label>
            <textarea name="description" rows="2" class="admin-input">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="admin-field">
            <label class="admin-label">Precio unitario (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                class="admin-input" placeholder="0.00">
            @error('price') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Categoría</label>
            <select name="category_id" class="admin-input">
                <option value="">Sin categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->icon }} {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="admin-field">
            <label class="admin-label">Orden</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}" class="admin-input">
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                {{ $product->is_active ? 'checked' : '' }} class="w-4 h-4 rounded accent-purple-500">
            <label for="is_active" class="text-sm text-gray-400 cursor-pointer">Visible en la calculadora</label>
        </div>

        <button type="submit" class="admin-btn-primary w-full">Actualizar producto</button>
    </form>
</div>

@endsection
