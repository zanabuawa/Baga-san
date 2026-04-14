@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Pasos del proceso</h1>
    <a href="{{ route('admin.process-steps.create') }}"
        class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm px-5 py-2.5 rounded-full hover:opacity-90 transition">
        + Nuevo paso
    </a>
</div>

@if($steps->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400">No hay pasos todavía. Crea al menos 3 para mostrar la sección.</p>
    </div>
@else
<p class="text-gray-500 text-sm mb-4">Arrastra las filas para cambiar el orden.</p>
<div class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5 bg-gray-900/50">
                <th class="px-4 py-4 w-8"></th>
                <th class="text-left px-6 py-4">Ícono</th>
                <th class="text-left px-6 py-4">Título</th>
                <th class="text-left px-6 py-4">Estado</th>
                <th class="text-left px-6 py-4"></th>
            </tr>
        </thead>
        <tbody id="sortable-tbody" class="divide-y divide-white/5">
            @foreach($steps as $step)
            <tr class="hover:bg-white/2 transition" data-id="{{ $step->id }}">
                <td class="px-4 py-4 text-gray-600 cursor-grab active:cursor-grabbing drag-handle select-none text-lg text-center">⠿</td>
                <td class="px-6 py-4 text-2xl">{{ $step->icon ?? '—' }}</td>
                <td class="px-6 py-4 font-medium">{{ $step->title }}</td>
                <td class="px-6 py-4">
                    @if($step->is_active)
                        <span class="px-2 py-1 rounded-full text-xs bg-emerald-500/15 text-emerald-300">Visible</span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs bg-gray-500/15 text-gray-400">Oculto</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.process-steps.edit', $step) }}"
                            class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.process-steps.destroy', $step) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este paso?')"
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
@include('admin.partials.sortable-table', ['route' => route('admin.process-steps.reorder')])
@endif

@endsection
