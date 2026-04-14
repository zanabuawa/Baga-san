@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.portfolio.index') }}" class="admin-back-btn">← Volver</a>
    <h1 class="text-2xl font-bold">Agregar pieza</h1>
</div>

<div class="max-w-2xl admin-card p-8">
    <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-field">
            <label class="admin-label">Título</label>
            <input type="text" name="title" value="{{ old('title') }}" class="admin-input"
                placeholder="Nombre de la pieza">
            @error('title') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Descripción</label>
            <textarea name="description" rows="3" class="admin-input"
                placeholder="Descripción opcional">{{ old('description') }}</textarea>
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

        {{-- Imagen con zona de drop estilizada --}}
        <div class="admin-field">
            <label class="admin-label">Imagen</label>
            <label for="image-input"
                class="flex flex-col items-center justify-center gap-3 w-full h-40 rounded-xl border-2 border-dashed border-white/15 bg-white/5 cursor-pointer hover:border-purple-500/60 hover:bg-white/8 transition group"
                x-data="{ fileName: '' }"
                @dragover.prevent
                @drop.prevent="
                    const f = $event.dataTransfer.files[0];
                    if (f) { fileName = f.name; $refs.imgInput.files = $event.dataTransfer.files; }
                ">
                <svg class="w-8 h-8 text-gray-500 group-hover:text-purple-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 17.25V18a1.5 1.5 0 001.5 1.5h15A1.5 1.5 0 0021 18v-.75M3 3h18M3 7.5h18" />
                </svg>
                <span class="text-sm text-gray-400 group-hover:text-white transition" x-text="fileName || 'Arrastra una imagen o haz clic para seleccionar'"></span>
                <span class="text-xs text-gray-600">JPG, PNG, GIF o WebP · Máx 2 MB</span>
                <input id="image-input" x-ref="imgInput" type="file" name="image" accept="image/*" class="hidden"
                    @change="fileName = $event.target.files[0]?.name ?? ''">
            </label>
            @error('image') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_visible" id="is_visible" value="1"
                {{ old('is_visible', true) ? 'checked' : '' }} class="w-4 h-4 rounded accent-purple-500">
            <label for="is_visible" class="text-sm text-gray-400 cursor-pointer">Visible en la página pública</label>
        </div>

        <button type="submit" class="admin-btn-primary w-full">Guardar pieza</button>
    </form>
</div>

@endsection
