@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white">Comisiones</h1>
        <p class="text-gray-400 text-sm mt-1">{{ $commissions->total() }} comisiones en total</p>
    </div>
    <a href="{{ route('admin.commissions.create') }}" class="admin-btn-primary">+ Nueva comisión</a>
</div>

@if($commissions->isEmpty())
    <div class="admin-card p-16 text-center">
        <div class="text-4xl mb-4">📋</div>
        <p class="text-gray-400">No hay comisiones todavía.</p>
    </div>
@else
<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 bg-white/2">
                    <th class="text-left px-6 py-3 admin-table">Cliente</th>
                    <th class="text-left px-6 py-3 admin-table">Tipo</th>
                    <th class="text-left px-6 py-3 admin-table">Estado</th>
                    <th class="text-left px-6 py-3 admin-table">Prioridad</th>
                    <th class="text-left px-6 py-3 admin-table">Precio</th>
                    <th class="text-left px-6 py-3 admin-table">Fecha</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($commissions as $commission)
                <tr class="hover:bg-white/2 transition group">
                    <td class="px-6 py-4">
                        <p class="font-medium text-white">{{ $commission->client_name }}</p>
                        <p class="text-gray-500 text-xs">{{ $commission->client_email }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs capitalize">{{ $commission->commission_type }}</td>
                    <td class="px-6 py-4">
                        @if($commission->status === 'pending')
                            <span class="admin-badge-yellow">{{ $commission->status_label }}</span>
                        @elseif($commission->status === 'in_progress')
                            <span class="admin-badge-blue">{{ $commission->status_label }}</span>
                        @elseif($commission->status === 'delivered')
                            <span class="admin-badge-purple">{{ $commission->status_label }}</span>
                        @elseif($commission->status === 'paid')
                            <span class="admin-badge-success">{{ $commission->status_label }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.commissions.togglePriority', $commission) }}" method="POST">
                            @csrf
                            <button type="submit" title="Toggle prioridad"
                                class="text-xl transition hover:scale-125 {{ $commission->is_priority ? 'text-yellow-400' : 'text-gray-700 hover:text-yellow-400' }}">
                                ★
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-gray-300 font-medium text-xs">
                        {{ $commission->price ? '$'.number_format($commission->price, 2) : '—' }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $commission->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1.5 justify-end">
                            <a href="{{ route('admin.commissions.show', $commission) }}" class="admin-action-btn">Ver</a>
                            <a href="{{ route('admin.commissions.edit', $commission) }}" class="admin-action-btn">Editar</a>
                            <form action="{{ route('admin.commissions.destroy', $commission) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar esta comisión?')"
                                    class="admin-action-btn-danger">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($commissions->hasPages())
    <div class="px-6 py-4 border-t border-white/5">
        {{ $commissions->links() }}
    </div>
    @endif
</div>
@endif

@endsection
