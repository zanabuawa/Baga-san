@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.commissions.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Nueva comisión</h1>
</div>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
<form action="{{ route('admin.commissions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Nombre del cliente</label>
            <input type="text" name="client_name" value="{{ old('client_name') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Nombre completo">
            @error('client_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Email</label>
            <input type="email" name="client_email" value="{{ old('client_email') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="correo@ejemplo.com">
            @error('client_email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Discord (opcional)</label>
            <input type="text" name="client_discord" value="{{ old('client_discord') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="usuario#0000">
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Tipo de comisión</label>
            <select name="commission_type"
                class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
                <option value="">Selecciona una opción</option>
                <option value="emote" {{ old('commission_type') === 'emote' ? 'selected' : '' }}>Emote sencillo</option>
                <option value="pack" {{ old('commission_type') === 'pack' ? 'selected' : '' }}>Pack streamer</option>
                <option value="branding" {{ old('commission_type') === 'branding' ? 'selected' : '' }}>Branding completo</option>
            </select>
            @error('commission_type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Descripción del proyecto</label>
            <textarea name="description" rows="4"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Detalles del pedido...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Estado</label>
            <select name="status"
                class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En progreso</option>
                <option value="delivered" {{ old('status') === 'delivered' ? 'selected' : '' }}>Entregado</option>
                <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Precio acordado (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="0.00">
        </div>

        <div class="mb-8">
            <label class="block text-xs text-gray-400 mb-2">Notas internas</label>
            <textarea name="notes" rows="3"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Notas privadas sobre esta comisión...">{{ old('notes') }}</textarea>
        </div>
<div class="mb-8">
            <label class="block text-xs text-gray-400 mb-2">Imágenes de referencia (opcional)</label>
            <input type="file" name="references[]" multiple accept="image/*"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-400 focus:outline-none focus:border-purple-500">
            <p class="text-gray-500 text-xs mt-1">Puedes subir varias imágenes. JPG, PNG o WebP. Máx 2MB cada una.</p>
        </div>
        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Crear comisión
        </button>
    </form>
</div>

@endsection