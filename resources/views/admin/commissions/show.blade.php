@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Comisiones</h1>
</div>

@if($commissions->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400">No hay comisiones todavía.</p>
    </div>
@else
<div class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5 bg-gray-900/50">
                <th class="text-left px-6 py-4">Cliente</th>
                <th class="text-left px-6 py-4">Tipo</th>
                <th class="text-left px-6 py-4">Estado</th>
                <th class="text-left px-6 py-4">Precio</th>
                <th class="text-left px-6 py-4">Fecha</th>
                <th class="text-left px-6 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($commissions as $commission)
            <tr class="hover:bg-white/2 transition">
                <td class="px-6 py-4">
                    <p class="font-medium">{{ $commission->client_name }}</p>
                    <p class="text-gray-400 text-xs">{{ $commission->client_email }}</p>
                </td>
                <td class="px-6 py-4 text-gray-400">{{ ucfirst($commission->commission_type) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        @if($commission->status === 'pending') bg-yellow-500/15 text-yellow-300
                        @elseif($commission->status === 'in_progress') bg-blue-500/15 text-blue-300
                        @elseif($commission->status === 'delivered') bg-purple-500/15 text-purple-300
                        @elseif($commission->status === 'paid') bg-emerald-500/15 text-emerald-300
                        @endif">
                        {{ $commission->status_label }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-400">
                    {{ $commission->price ? '$'.number_format($commission->price, 2) : '—' }}
                </td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $commission->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.commissions.show', $commission) }}"
                            class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                            Ver
                        </a>
                        <a href="{{ route('admin.commissions.edit', $commission) }}"
                            class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.commissions.destroy', $commission) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar esta comisión?')"
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
    <div class="px-6 py-4 border-t border-white/5">
        {{ $commissions->links() }}
    </div>
</div>
@endif

@endsection