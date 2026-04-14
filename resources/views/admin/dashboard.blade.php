@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        <p class="text-gray-400 text-sm mt-1">Bienvenido de vuelta, {{ auth()->user()->name }} 👋</p>
    </div>
    <a href="{{ route('admin.commissions.create') }}" class="admin-btn-primary">
        + Nueva comisión
    </a>
</div>

<!-- STATS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="admin-card p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10" style="background: #ec4899; transform: translate(30%, -30%); filter: blur(20px);"></div>
        <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest mb-3">Total</p>
        <p class="text-4xl font-bold text-white">{{ $stats['total_commissions'] }}</p>
        <p class="text-gray-500 text-xs mt-1">comisiones</p>
    </div>
    <div class="admin-card p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10" style="background: #eab308; transform: translate(30%, -30%); filter: blur(20px);"></div>
        <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest mb-3">Pendientes</p>
        <p class="text-4xl font-bold text-yellow-400">{{ $stats['pending_commissions'] }}</p>
        <p class="text-gray-500 text-xs mt-1">esperando respuesta</p>
    </div>
    <div class="admin-card p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10" style="background: #3b82f6; transform: translate(30%, -30%); filter: blur(20px);"></div>
        <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest mb-3">En progreso</p>
        <p class="text-4xl font-bold text-blue-400">{{ $stats['in_progress'] }}</p>
        <p class="text-gray-500 text-xs mt-1">actualmente</p>
    </div>
    <div class="admin-card p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-10" style="background: #a855f7; transform: translate(30%, -30%); filter: blur(20px);"></div>
        <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest mb-3">Portafolio</p>
        <p class="text-4xl font-bold text-purple-400">{{ $stats['total_portfolio'] }}</p>
        <p class="text-gray-500 text-xs mt-1">piezas publicadas</p>
    </div>
</div>

<!-- ACCESOS RÁPIDOS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    @foreach([
        ['icon' => '🎨', 'label' => 'Portafolio', 'route' => 'admin.portfolio.index', 'color' => 'from-pink-500/10 to-purple-500/10 border-pink-500/20'],
        ['icon' => '💰', 'label' => 'Paquetes', 'route' => 'admin.packages.index', 'color' => 'from-yellow-500/10 to-orange-500/10 border-yellow-500/20'],
        ['icon' => '🎵', 'label' => 'Música', 'route' => 'admin.music-tracks.index', 'color' => 'from-blue-500/10 to-cyan-500/10 border-blue-500/20'],
        ['icon' => '⚙️', 'label' => 'Configuración', 'route' => 'admin.settings.index', 'color' => 'from-gray-500/10 to-gray-400/10 border-gray-500/20'],
    ] as $quick)
    <a href="{{ route($quick['route']) }}"
       class="admin-card p-4 flex items-center gap-3 hover:scale-105 transition-transform bg-gradient-to-br {{ $quick['color'] }}">
        <span class="text-2xl">{{ $quick['icon'] }}</span>
        <span class="text-sm font-medium text-gray-300">{{ $quick['label'] }}</span>
    </a>
    @endforeach
</div>

<!-- COMISIONES RECIENTES -->
<div class="admin-card overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5 border-b border-white/5">
        <h2 class="font-semibold text-white">Comisiones recientes</h2>
        <a href="{{ route('admin.commissions.index') }}" class="text-purple-400 text-xs hover:text-purple-300 transition">Ver todas →</a>
    </div>

    @if($recent_commissions->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500 text-sm">No hay comisiones todavía.</p>
        </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 bg-white/2">
                    <th class="text-left px-6 py-3 admin-table">Cliente</th>
                    <th class="text-left px-6 py-3 admin-table">Tipo</th>
                    <th class="text-left px-6 py-3 admin-table">Estado</th>
                    <th class="text-left px-6 py-3 admin-table">Fecha</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($recent_commissions as $commission)
                <tr class="hover:bg-white/2 transition">
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
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $commission->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.commissions.show', $commission) }}"
                           class="admin-action-btn">Ver →</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
