@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.commissions.index') }}" class="admin-back-btn">← Volver</a>
    <h1 class="text-2xl font-bold">Nueva comisión</h1>
</div>

<div class="max-w-2xl admin-card p-8">
    <form action="{{ route('admin.commissions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-field">
            <label class="admin-label">Nombre del cliente</label>
            <input type="text" name="client_name" value="{{ old('client_name') }}" class="admin-input"
                placeholder="Nombre completo">
            @error('client_name') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Email</label>
            <input type="email" name="client_email" value="{{ old('client_email') }}" class="admin-input"
                placeholder="correo@ejemplo.com">
            @error('client_email') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Discord <span class="text-gray-600 font-normal">(opcional)</span></label>
            <input type="text" name="client_discord" value="{{ old('client_discord') }}" class="admin-input"
                placeholder="usuario#0000">
        </div>

        <div class="admin-field">
            <label class="admin-label">Tipo de comisión</label>
            <select name="commission_type" class="admin-input">
                <option value="">Selecciona una opción</option>
                <option value="emote"    {{ old('commission_type') === 'emote'    ? 'selected' : '' }}>Emote sencillo</option>
                <option value="pack"     {{ old('commission_type') === 'pack'     ? 'selected' : '' }}>Pack streamer</option>
                <option value="branding" {{ old('commission_type') === 'branding' ? 'selected' : '' }}>Branding completo</option>
            </select>
            @error('commission_type') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Descripción del proyecto</label>
            <textarea name="description" rows="4" class="admin-input"
                placeholder="Detalles del pedido...">{{ old('description') }}</textarea>
            @error('description') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div class="admin-field">
            <label class="admin-label">Estado</label>
            <select name="status" class="admin-input">
                <option value="pending"     {{ old('status') === 'pending'     ? 'selected' : '' }}>Pendiente</option>
                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En progreso</option>
                <option value="delivered"   {{ old('status') === 'delivered'   ? 'selected' : '' }}>Entregado</option>
                <option value="paid"        {{ old('status') === 'paid'        ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>

        <div class="admin-field">
            <label class="admin-label">Precio acordado (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                class="admin-input" placeholder="0.00">
        </div>

        <div class="admin-field">
            <label class="admin-label">Notas internas</label>
            <textarea name="notes" rows="3" class="admin-input"
                placeholder="Notas privadas sobre esta comisión...">{{ old('notes') }}</textarea>
        </div>

        {{-- Imágenes de referencia --}}
        <div class="admin-field">
            <label class="admin-label">Imágenes de referencia <span class="text-gray-600 font-normal">(opcional)</span></label>
            <label for="refs-input"
                class="flex flex-col items-center justify-center gap-3 w-full h-40 rounded-xl border-2 border-dashed border-white/15 bg-white/5 cursor-pointer hover:border-purple-500/60 hover:bg-white/8 transition group"
                x-data="{ fileNames: '' }"
                @dragover.prevent
                @drop.prevent="
                    const files = $event.dataTransfer.files;
                    if (files.length) {
                        fileNames = Array.from(files).map(f => f.name).join(', ');
                        $refs.refsInput.files = files;
                    }
                ">
                <svg class="w-8 h-8 text-gray-500 group-hover:text-purple-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                <span class="text-sm text-gray-400 group-hover:text-white transition text-center px-4"
                    x-text="fileNames || 'Arrastra imágenes o haz clic para seleccionar'"></span>
                <span class="text-xs text-gray-600">Puedes seleccionar varias · JPG, PNG o WebP · Máx 2 MB c/u</span>
                <input id="refs-input" x-ref="refsInput" type="file" name="references[]"
                    multiple accept="image/*" class="hidden"
                    @change="fileNames = Array.from($event.target.files).map(f => f.name).join(', ')">
            </label>
        </div>

        <button type="submit" class="admin-btn-primary w-full">Crear comisión</button>
    </form>
</div>

@endsection
