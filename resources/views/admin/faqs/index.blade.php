@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Preguntas frecuentes (FAQ)</h1>
    <a href="{{ route('admin.faqs.create') }}"
        class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm px-5 py-2.5 rounded-full hover:opacity-90 transition">
        + Nueva pregunta
    </a>
</div>

@if($faqs->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400">No hay preguntas frecuentes todavía.</p>
    </div>
@else
<p class="text-gray-500 text-sm mb-4">Arrastra las filas para cambiar el orden.</p>
<div class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5 bg-gray-900/50">
                <th class="px-4 py-4 w-8"></th>
                <th class="text-left px-6 py-4">Pregunta</th>
                <th class="text-left px-6 py-4">Estado</th>
                <th class="text-left px-6 py-4"></th>
            </tr>
        </thead>
        <tbody id="sortable-tbody" class="divide-y divide-white/5">
            @foreach($faqs as $faq)
            <tr class="hover:bg-white/2 transition" data-id="{{ $faq->id }}">
                <td class="px-4 py-4 text-gray-600 cursor-grab active:cursor-grabbing drag-handle select-none text-lg text-center">⠿</td>
                <td class="px-6 py-4 font-medium">{{ Str::limit($faq->question, 70) }}</td>
                <td class="px-6 py-4">
                    @if($faq->is_active)
                        <span class="px-2 py-1 rounded-full text-xs bg-emerald-500/15 text-emerald-300">Visible</span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs bg-gray-500/15 text-gray-400">Oculto</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.faqs.edit', $faq) }}"
                            class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar esta pregunta?')"
                                class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-red-400 hover:border-red-400 transition">
                                ✕
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('admin.partials.sortable-table', ['route' => route('admin.faqs.reorder')])
@endif

@endsection
