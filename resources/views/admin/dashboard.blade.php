@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <a href="{{ route('admin.commissions.create') }}" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:opacity-90 transition">
        + Nueva comisión
    </a>
</div>
<!-- STATS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-400 text-xs mb-2">Total comisiones</p>
        <p class="text-3xl font-bold">{{ $stats['total_commissions'] }}</p>
    </div>
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-400 text-xs mb-2">Pendientes</p>
        <p class="text-3xl font-bold text-yellow-400">{{ $stats['pending_commissions'] }}</p>
    </div>
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-400 text-xs mb-2">En progreso</p>
        <p class="text-3xl font-bold text-blue-400">{{ $stats['in_progress'] }}</p>
    </div>
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-400 text-xs mb-2">Piezas en portafolio</p>
        <p class="text-3xl font-bold text-purple-400">{{ $stats['total_portfolio'] }}</p>
    </div>
</div>

<!-- COMISIONES RECIENTES -->
<div class="bg-gray-800 border border-white/5 rounded-2xl p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-semibold">Comisiones recientes</h2>
        <a href="{{ route('admin.commissions.index') }}" class="text-purple-400 text-sm hover:text-purple-300">Ver todas →</a>
    </div>

    @if($recent_commissions->isEmpty())
        <p class="text-gray-500 text-sm text-center py-8">No hay comisiones todavía.</p>
    @else
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5">
                <th class="text-left pb-3">Cliente</th>
                <th class="text-left pb-3">Tipo</th>
                <th class="text-left pb-3">Estado</th>
                <th class="text-left pb-3">Fecha</th>
                <th class="text-left pb-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($recent_commissions as $commission)
            <tr>
                <td class="py-3">
                    <p class="font-medium">{{ $commission->client_name }}</p>
                    <p class="text-gray-400 text-xs">{{ $commission->client_email }}</p>
                </td>
                <td class="py-3 text-gray-400">{{ ucfirst($commission->commission_type) }}</td>
                <td class="py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        @if($commission->status === 'pending') bg-yellow-500/15 text-yellow-300
                        @elseif($commission->status === 'in_progress') bg-blue-500/15 text-blue-300
                        @elseif($commission->status === 'delivered') bg-purple-500/15 text-purple-300
                        @elseif($commission->status === 'paid') bg-emerald-500/15 text-emerald-300
                        @endif">
                        {{ $commission->status_label }}
                    </span>
                </td>
                <td class="py-3 text-gray-400 text-xs">{{ $commission->created_at->format('d/m/Y') }}</td>
                <td class="py-3">
                    <a href="{{ route('admin.commissions.show', $commission) }}" class="text-purple-400 hover:text-purple-300">Ver →</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection