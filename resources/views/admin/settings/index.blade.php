@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-8">Configuración de la página</h1>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
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
        <h2 class="text-sm font-semibold text-gray-300 mb-6">Imágenes / Logos</h2>

        @php
            $logoHero    = $settings['logo_hero']    ?? null;
            $logoNavbar  = $settings['logo_navbar']  ?? null;
            $logoFavicon = $settings['logo_favicon'] ?? null;
        @endphp

        {{-- ── Logo del hero ── --}}
        <div class="mb-6" x-data="{ removing: false }">
            <p class="text-sm font-medium text-gray-200 mb-1">Logo del hero</p>
            <p class="text-xs text-gray-500 mb-3">Aparece dentro del círculo animado en la página principal. Recomendado: cuadrado, fondo transparente (PNG/WebP/SVG).</p>
            @if($logoHero)
            <div class="flex items-center gap-4 mb-3 p-3 bg-white/5 rounded-xl border border-white/10">
                <img src="{{ Storage::url($logoHero) }}" alt="Hero actual" class="h-14 w-14 object-contain rounded-lg bg-white/5 p-1">
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 truncate">Imagen actual</p>
                </div>
                <label class="flex items-center gap-2 cursor-pointer shrink-0">
                    <input type="checkbox" name="remove_logo_hero" value="1" x-model="removing" class="w-4 h-4 rounded accent-red-500">
                    <span class="text-xs text-red-400">Eliminar</span>
                </label>
            </div>
            @endif
            <div x-show="!removing">
                <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-white/10 rounded-xl cursor-pointer hover:border-purple-500/40 hover:bg-white/2 transition"
                    x-data="{ preview: null }"
                    @dragover.prevent
                    @drop.prevent="const f=$event.dataTransfer.files[0]; if(f){preview=URL.createObjectURL(f);$refs.inHero.files=$event.dataTransfer.files;}">
                    <template x-if="preview"><img :src="preview" class="h-16 object-contain rounded-lg"></template>
                    <template x-if="!preview">
                        <div class="flex flex-col items-center gap-1.5 pointer-events-none">
                            <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs text-gray-500">PNG, SVG, WebP — máx. 2 MB</span>
                            <span class="text-xs text-purple-400">Haz clic o arrastra aquí</span>
                        </div>
                    </template>
                    <input type="file" name="logo_hero" accept="image/*" class="hidden" x-ref="inHero"
                        @change="preview=$event.target.files[0]?URL.createObjectURL($event.target.files[0]):null">
                </label>
                @error('logo_hero') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ── Logo del navbar ── --}}
        <div class="mb-6" x-data="{ removing: false }">
            <p class="text-sm font-medium text-gray-200 mb-1">Logo del navbar</p>
            <p class="text-xs text-gray-500 mb-3">Aparece en la barra de navegación superior. Recomendado: horizontal, altura ~40 px, fondo transparente.</p>
            @if($logoNavbar)
            <div class="flex items-center gap-4 mb-3 p-3 bg-white/5 rounded-xl border border-white/10">
                <img src="{{ Storage::url($logoNavbar) }}" alt="Navbar actual" class="h-10 max-w-[140px] object-contain rounded bg-white/5 p-1">
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 truncate">Imagen actual</p>
                </div>
                <label class="flex items-center gap-2 cursor-pointer shrink-0">
                    <input type="checkbox" name="remove_logo_navbar" value="1" x-model="removing" class="w-4 h-4 rounded accent-red-500">
                    <span class="text-xs text-red-400">Eliminar</span>
                </label>
            </div>
            @endif
            <div x-show="!removing">
                <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-white/10 rounded-xl cursor-pointer hover:border-purple-500/40 hover:bg-white/2 transition"
                    x-data="{ preview: null }"
                    @dragover.prevent
                    @drop.prevent="const f=$event.dataTransfer.files[0]; if(f){preview=URL.createObjectURL(f);$refs.inNav.files=$event.dataTransfer.files;}">
                    <template x-if="preview"><img :src="preview" class="h-10 object-contain rounded"></template>
                    <template x-if="!preview">
                        <div class="flex flex-col items-center gap-1.5 pointer-events-none">
                            <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs text-gray-500">PNG, SVG, WebP — máx. 2 MB</span>
                            <span class="text-xs text-purple-400">Haz clic o arrastra aquí</span>
                        </div>
                    </template>
                    <input type="file" name="logo_navbar" accept="image/*" class="hidden" x-ref="inNav"
                        @change="preview=$event.target.files[0]?URL.createObjectURL($event.target.files[0]):null">
                </label>
                @error('logo_navbar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ── Favicon ── --}}
        <div class="mb-8" x-data="{ removing: false }">
            <p class="text-sm font-medium text-gray-200 mb-1">Favicon (icono del navegador)</p>
            <p class="text-xs text-gray-500 mb-3">Aparece en el tab del navegador. Recomendado: cuadrado, 32×32 o 64×64 px, PNG o ICO.</p>
            @if($logoFavicon)
            <div class="flex items-center gap-4 mb-3 p-3 bg-white/5 rounded-xl border border-white/10">
                <img src="{{ Storage::url($logoFavicon) }}" alt="Favicon actual" class="h-10 w-10 object-contain rounded bg-white/5 p-1">
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 truncate">Imagen actual</p>
                </div>
                <label class="flex items-center gap-2 cursor-pointer shrink-0">
                    <input type="checkbox" name="remove_logo_favicon" value="1" x-model="removing" class="w-4 h-4 rounded accent-red-500">
                    <span class="text-xs text-red-400">Eliminar</span>
                </label>
            </div>
            @endif
            <div x-show="!removing">
                <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-white/10 rounded-xl cursor-pointer hover:border-purple-500/40 hover:bg-white/2 transition"
                    x-data="{ preview: null }"
                    @dragover.prevent
                    @drop.prevent="const f=$event.dataTransfer.files[0]; if(f){preview=URL.createObjectURL(f);$refs.inFav.files=$event.dataTransfer.files;}">
                    <template x-if="preview"><img :src="preview" class="h-14 w-14 object-contain rounded"></template>
                    <template x-if="!preview">
                        <div class="flex flex-col items-center gap-1.5 pointer-events-none">
                            <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs text-gray-500">PNG, ICO — máx. 2 MB</span>
                            <span class="text-xs text-purple-400">Haz clic o arrastra aquí</span>
                        </div>
                    </template>
                    <input type="file" name="logo_favicon" accept="image/*,.ico" class="hidden" x-ref="inFav"
                        @change="preview=$event.target.files[0]?URL.createObjectURL($event.target.files[0]):null">
                </label>
                @error('logo_favicon') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
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