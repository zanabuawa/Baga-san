@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Productos</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:opacity-90 transition">
        + Agregar producto
    </a>
</div>

@if($products->isEmpty())
    <div class="bg-gray-800 border border-white/5 rounded-2xl p-12 text-center">
        <p class="text-gray-400 mb-4">No hay productos todavía.</p>
        <a href="{{ route('admin.products.create') }}" class="text-purple-400 hover:text-purple-300 text-sm">Agregar el primero →</a>
    </div>
@else
<div class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 text-xs border-b border-white/5 bg-gray-900/50">
                <th class="text-left px-6 py-4">Producto</th>
                <th class="text-left px-6 py-4">Categoría</th>
                <th class="text-left px-6 py-4">Precio</th>
                <th class="text-left px-6 py-4">Estado</th>
                <th class="text-left px-6 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($products as $product)
            <tr class="hover:bg-white/2 transition">
                <td class="px-6 py-4">
                    <p class="font-medium">{{ $product->name }}</p>
                    @if($product->description)
                    <p class="text-gray-400 text-xs mt-1">{{ Str::limit($product->description, 60) }}</p>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-400">
                    {{ $product->category?->icon }} {{ $product->category?->name ?? '—' }}
                </td>
                <td class="px-6 py-4 font-medium text-purple-300">
                    ${{ number_format($product->price, 2) }}
                </td>
                <td class="px-6 py-4">
                    @if($product->is_active)
                    <span class="px-2 py-1 rounded-full text-xs bg-emerald-500/15 text-emerald-300">Activo</span>
                    @else
                    <span class="px-2 py-1 rounded-full text-xs bg-gray-500/15 text-gray-400">Oculto</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-purple-400 transition">
                            Editar
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este producto?')"
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