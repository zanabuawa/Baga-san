@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Códigos de descuento</h1>
    <a href="{{ route('admin.discount-codes.create') }}"
        class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm px-5 py-2.5 rounded-full hover:opacity-90 transition">
        + Nuevo código
    </a>
</div>

@if($codes->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400">No hay códigos de descuento todavía.</p>
    </div>
@else
<div class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5 bg-gray-900/50">
                <th class="text-left px-6 py-4">Código</th>
                <th class="text-left px-6 py-4">Descuento</th>
                <th class="text-left px-6 py-4">Usos</th>
                <th class="text-left px-6 py-4">Estado</th>
                <th class="text-left px-6 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($codes as $code)
            <tr class="hover:bg-white/2 transition">
                <td class="px-6 py-4">
                    <span class="font-mono font-medium text-pink-300">{{ $code->code }}</span>
                </td>
                <td class="px-6 py-4 text-emerald-400 font-semibold">{{ $code->percentage }}%</td>
                <td class="px-6 py-4 text-gray-400">
                    {{ $code->uses_count }} / {{ $code->uses_limit ?? '∞' }}
                </td>
                <td class="px-6 py-4">
                    @if($code->isValid())
                        <span class="px-2 py-1 rounded-full text-xs bg-emerald-500/15 text-emerald-300">Activo</span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs bg-gray-500/15 text-gray-400">Inactivo</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.discount-codes.edit', $code) }}"
                            class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.discount-codes.destroy', $code) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este código?')"
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
@endif

@endsection
