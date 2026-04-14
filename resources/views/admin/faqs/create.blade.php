@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.faqs.index') }}" class="text-gray-400 hover:text-white transition">← Volver</a>
    <h1 class="text-2xl font-bold">Nueva pregunta frecuente</h1>
</div>

<div class="max-w-lg bg-gray-800 border border-white/5 rounded-2xl p-8">
    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Pregunta</label>
            <input type="text" name="question" value="{{ old('question') }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="¿Cuánto tarda una comisión?">
            @error('question') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-xs text-gray-400 mb-2">Respuesta</label>
            <textarea name="answer" rows="4"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500"
                placeholder="Escribe la respuesta...">{{ old('answer') }}</textarea>
            @error('answer') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                class="w-4 h-4 rounded accent-purple-500">
            <label for="is_active" class="text-sm text-gray-400">Visible en la página</label>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
            Crear pregunta
        </button>
    </form>
</div>

@endsection
