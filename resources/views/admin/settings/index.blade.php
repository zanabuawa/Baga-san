@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-8">Configuración de la página</h1>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Nombre del artista</label>
            <input type="text" name="artist_name" value="{{ old('artist_name', $settings['artist_name'] ?? '') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Tu nombre artístico">
            @error('artist_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Título del hero</label>
            <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Frase principal de la página">
            @error('hero_title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Subtítulo del hero</label>
            <textarea name="hero_subtitle" rows="2"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Descripción breve de tus servicios">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
            @error('hero_subtitle') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Biografía</label>
            <textarea name="bio" rows="4"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Cuéntale a tus visitantes sobre ti">{{ old('bio', $settings['bio'] ?? '') }}</textarea>
            @error('bio') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Tiempo de entrega</label>
            <input type="text" name="delivery_time" value="{{ old('delivery_time', $settings['delivery_time'] ?? '') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Ej: 5–7 días">
            @error('delivery_time') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Espacios de comisiones (slots)</label>
            <input type="number" name="commission_slots" value="{{ old('commission_slots', $settings['commission_slots'] ?? '8') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="8">
            <p class="text-gray-500 text-xs mt-1">Número total de espacios visibles en la cola.</p>
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Texto del estado de comisiones</label>
            <input type="text" name="commissions_status" value="{{ old('commissions_status', $settings['commissions_status'] ?? '') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Ej: Comisiones abiertas">
            @error('commissions_status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="commissions_open" id="commissions_open" value="1"
                {{ ($settings['commissions_open'] ?? 'false') === 'true' ? 'checked' : '' }}
                class="w-4 h-4 rounded accent-purple-500">
            <label for="commissions_open" class="text-sm text-gray-400">Comisiones abiertas</label>
        </div>

        <div class="mb-8">
            <label class="block text-xs text-gray-400 mb-2">Correo de contacto</label>
            <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="correo@ejemplo.com">
            <p class="text-gray-500 text-xs mt-1">Este correo recibirá los mensajes del formulario de contacto.</p>
            @error('contact_email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <hr class="border-white/10 my-6">
        <h2 class="text-sm font-semibold text-gray-300 mb-4">Estadísticas visibles</h2>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-xs text-gray-400 mb-2">Clientes satisfechos</label>
                <input type="number" name="happy_clients" value="{{ old('happy_clients', $settings['happy_clients'] ?? '0') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                    placeholder="0" min="0">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-2">Años de experiencia</label>
                <input type="number" name="years_experience" value="{{ old('years_experience', $settings['years_experience'] ?? '0') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                    placeholder="0" min="0">
            </div>
        </div>

        <hr class="border-white/10 my-6">
        <h2 class="text-sm font-semibold text-gray-300 mb-4">Apariencia</h2>

        <div class="mb-8">
            <label class="block text-xs text-gray-400 mb-2">Tema predeterminado</label>
            <select name="default_theme"
                class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
                @foreach(['dark' => 'Oscuro (Rosa)', 'light' => 'Claro', 'red' => 'Rojo', 'gold' => 'Dorado', 'blue' => 'Azul', 'purple' => 'Púrpura'] as $value => $label)
                    <option value="{{ $value }}" {{ ($settings['default_theme'] ?? 'dark') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Guardar configuración
        </button>
    </form>
</div>

@endsection