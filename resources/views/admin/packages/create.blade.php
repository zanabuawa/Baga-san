@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.packages.index') }}" class="admin-back-btn">← Volver</a>
    <h1 class="text-2xl font-bold">Agregar paquete</h1>
</div>

<div class="max-w-2xl admin-card p-8">
    <form action="{{ route('admin.packages.store') }}" method="POST">
        @csrf

        <div class="admin-field">
            <label class="admin-label">Nombre del paquete</label>
            <input type="text" name="name" value="{{ old('name') }}" class="admin-input"
                placeholder="Ej: Pack streamer">
            @error('name') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Descripción</label>
            <textarea name="description" rows="2" class="admin-input"
                placeholder="Breve descripción del paquete">{{ old('description') }}</textarea>
            @error('description') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Precio (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                class="admin-input" placeholder="0.00">
            @error('price') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        {{-- Productos incluidos --}}
        <div class="admin-field">
            <label class="admin-label">Productos incluidos</label>
            <div class="rounded-xl border border-white/10 bg-white/5 divide-y divide-white/5">
                @forelse($products as $product)
                <label class="flex items-center gap-4 px-4 py-3 cursor-pointer hover:bg-white/5 transition">
                    <input type="checkbox" name="products[]" value="{{ $product->id }}"
                        {{ in_array($product->id, old('products', [])) ? 'checked' : '' }}
                        class="w-4 h-4 rounded accent-purple-500 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <span class="text-sm text-white font-medium">{{ $product->name }}</span>
                        <span class="text-xs text-gray-400 ml-2">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-xs text-gray-500">Cant.</span>
                        <input type="number" name="quantities[{{ $product->id }}]"
                            value="{{ old("quantities.{$product->id}", 1) }}"
                            min="1" max="99"
                            class="w-14 bg-white/10 border border-white/10 rounded-lg px-2 py-1 text-xs text-white text-center focus:outline-none focus:border-purple-500">
                    </div>
                </label>
                @empty
                <p class="px-4 py-3 text-sm text-gray-500">No hay productos activos. <a href="{{ route('admin.products.create') }}" class="text-purple-400 hover:underline">Crear producto</a></p>
                @endforelse
            </div>
            @error('products') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        {{-- Características extra (texto libre) --}}
        <div class="admin-field">
            <label class="admin-label">Características adicionales <span class="text-gray-600 font-normal">(opcional)</span></label>
            <textarea name="features" rows="4" class="admin-input font-mono text-xs"
                placeholder="Una por línea:&#10;3 revisiones por emote&#10;Entrega en 10–14 días&#10;PNG + PSD incluidos">{{ old('features') }}</textarea>
            <p class="text-gray-600 text-xs mt-1">Para notas de entrega, revisiones u otras condiciones del paquete.</p>
        </div>

        <div class="admin-field">
            <label class="admin-label">Categoría</label>
            <select name="category_id" class="admin-input">
                <option value="">Sin categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->icon }} {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-6 mb-8">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                    {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded accent-purple-500">
                <span class="text-sm text-gray-400">Marcar como popular</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded accent-purple-500">
                <span class="text-sm text-gray-400">Visible en la página pública</span>
            </label>
        </div>

        <button type="submit" class="admin-btn-primary w-full">Guardar paquete</button>
    </form>
</div>

@endsection
