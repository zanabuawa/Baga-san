@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-8">Links sociales</h1>

<div class="max-w-2xl bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.social-links.update') }}" method="POST">
        @csrf

        @foreach(['x' => '𝕏  Twitter / X', 'instagram' => '📸  Instagram', 'discord' => '💬  Discord', 'paypal' => '💳  PayPal', 'whatsapp' => '💚  WhatsApp'] as $platform => $label)
        <div class="mb-6 pb-6 border-b border-white/5 last:border-0 last:mb-0 last:pb-0">
            <p class="text-sm font-medium mb-3">{{ $label }}</p>
            <div class="mb-3">
                <label class="block text-xs text-gray-400 mb-2">URL</label>
                <input type="url" name="links[{{ $platform }}][url]"
                    value="{{ old("links.{$platform}.url", $links[$platform]->url ?? '') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                    placeholder="https://...">
                @error("links.{$platform}.url") <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="links[{{ $platform }}][is_active]"
                    id="active_{{ $platform }}" value="1"
                    {{ ($links[$platform]->is_active ?? false) ? 'checked' : '' }}
                    class="w-4 h-4 rounded accent-purple-500">
                <label for="active_{{ $platform }}" class="text-xs text-gray-400">Mostrar en la página pública</label>
            </div>
        </div>
        @endforeach

        <button type="submit"
            class="w-full mt-6 bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Guardar links
        </button>
    </form>
</div>

@endsection