@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="min-h-screen flex items-center justify-center px-6 pt-24 pb-12">
    <div class="max-w-6xl mx-auto w-full flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 max-w-xl">
            @if($settings['commissions_open'] === 'true')
            <div class="inline-flex items-center gap-2 bg-purple-500/15 border border-purple-500/30 text-purple-300 text-xs font-medium px-4 py-2 rounded-full mb-6">
                <span class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></span>
                {{ $settings['commissions_status'] ?? 'Comisiones abiertas' }}
            </div>
            @else
            <div class="inline-flex items-center gap-2 bg-red-500/15 border border-red-500/30 text-red-300 text-xs font-medium px-4 py-2 rounded-full mb-6">
                <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                {{ $settings['commissions_status'] ?? 'Comisiones cerradas' }}
            </div>
            @endif

            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="bg-gradient-to-r from-pink-500 via-purple-500 to-cyan-400 bg-clip-text text-transparent">
                    {{ $settings['hero_title'] ?? 'Ilustraciones que cobran vida' }}
                </span>
            </h1>
            <p class="text-gray-400 text-lg mb-8">
                {{ $settings['hero_subtitle'] ?? '' }}
            </p>
            <div class="flex gap-4 flex-wrap">
                <a href="#precios" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-6 py-3 rounded-full font-medium hover:opacity-90 transition">Ver comisiones</a>
                <a href="#portfolio" class="border border-white/20 text-white px-6 py-3 rounded-full font-medium hover:border-purple-400 hover:bg-purple-500/10 transition">Ver portafolio</a>
            </div>
        </div>
        <div class="flex-1 flex justify-center">
            <div class="relative w-72 h-72">
                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-pink-500 via-purple-500 to-cyan-400 animate-spin" style="animation-duration:8s"></div>
                <div class="absolute inset-1 rounded-full bg-gray-950 flex items-center justify-center">
                    <span class="text-8xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent">
                        {{ strtoupper(substr($settings['artist_name'] ?? 'A', 0, 1)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PORTFOLIO -->
<section id="portfolio" class="py-20 px-6 bg-gray-900/50" x-data="{ activeFilter: 'todos' }">
    <div class="max-w-6xl mx-auto">
        <span class="text-purple-400 text-xs font-semibold uppercase tracking-widest">Trabajos</span>
        <h2 class="text-3xl font-bold mt-2 mb-4">Portafolio</h2>
        <p class="text-gray-400 mb-8">Una selección de mis trabajos más recientes.</p>

        @if($portfolio->isNotEmpty())
        {{-- Tabs de filtro --}}
        <div class="flex gap-2 flex-wrap mb-10">
            <button
                @click="activeFilter = 'todos'"
                :class="activeFilter === 'todos'
                    ? 'bg-gradient-to-r from-pink-500 to-purple-500 text-white border-transparent'
                    : 'border-white/10 text-gray-400 hover:border-purple-400 hover:text-white'"
                class="px-4 py-2 rounded-full text-sm border transition">
                Todos
            </button>
            @foreach($portfolioCategories as $cat)
            <button
                @click="activeFilter = '{{ $cat->id }}'"
                :class="activeFilter === '{{ $cat->id }}'
                    ? 'bg-gradient-to-r from-pink-500 to-purple-500 text-white border-transparent'
: 'border-white/10 text-gray-400 hover:border-purple-400 hover:text-white'"
                class="px-4 py-2 rounded-full text-sm border transition">
                {{ $cat->icon }} {{ $cat->name }}
            </button>
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($portfolio as $item)
            <div
                x-show="activeFilter === 'todos' || activeFilter === '{{ $item->category_id }}'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden hover:-translate-y-1 transition group">
                <div class="aspect-square overflow-hidden">
                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-3">
                    <p class="font-medium text-sm">{{ $item->title }}</p>
                    <p class="text-gray-400 text-xs mt-1">{{ $item->portfolioCategory->name ?? 'Sin categoría' }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-12">Próximamente...</p>
        @endif
    </div>
</section>
<!-- PRECIOS -->
<section id="precios" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <span class="text-purple-400 text-xs font-semibold uppercase tracking-widest">Comisiones</span>
        <h2 class="text-3xl font-bold mt-2 mb-4">Precios y paquetes</h2>
        <p class="text-gray-400 mb-16">Elige el paquete que mejor se adapte a tus necesidades.</p>

        {{-- Categorías con sus paquetes --}}
        @foreach($categories as $category)
        @if($category->packages->isNotEmpty())
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                @if($category->icon)
                <span class="text-3xl">{{ $category->icon }}</span>
                @endif
                <div>
                    <h3 class="text-2xl font-bold">{{ $category->name }}</h3>
                    @if($category->description)
                    <p class="text-gray-400 text-sm mt-1">{{ $category->description }}</p>
                    @endif
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($category->packages as $package)
                <div class="bg-gray-800 border rounded-2xl p-8 relative hover:-translate-y-1 transition
                        {{ $package->is_featured ? 'border-purple-500/40 bg-gradient-to-b from-purple-500/10 to-transparent' : 'border-white/5' }}">
                    @if($package->is_featured)
                    <span class="absolute top-4 right-4 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Popular</span>
                    @endif
                    <h3 class="text-xl font-bold mb-2">{{ $package->name }}</h3>
                    <p class="text-gray-400 text-sm mb-6">{{ $package->description }}</p>
                    <div class="text-4xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent mb-1">
                        ${{ number_format($package->price, 2) }}
                    </div>
                    <p class="text-gray-500 text-xs mb-6">USD</p>
                    <ul class="space-y-2 mb-8">
                        @foreach($package->features as $feature)
                        <li class="flex items-center gap-2 text-sm text-gray-400">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full flex-shrink-0"></span>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <button
                        @click="addItem({{ $package->id }}, '{{ addslashes($package->name) }}', {{ $package->price }}, '{{ addslashes($category->name) }}')"
                        class="w-full block text-center py-3 rounded-full text-sm font-medium transition cursor-pointer
                            {{ $package->is_featured
                                ? 'bg-gradient-to-r from-pink-500 to-purple-500 text-white hover:opacity-90'
                                : 'border border-white/15 text-white hover:border-purple-400 hover:bg-purple-500/10' }}">
                        + Agregar al pedido
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

        {{-- Paquetes sin categoría --}}
        @if($packages->isNotEmpty())
        <div class="mb-16">
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($packages as $package)
                <div class="bg-gray-800 border rounded-2xl p-8 relative hover:-translate-y-1 transition
                    {{ $package->is_featured ? 'border-purple-500/40 bg-gradient-to-b from-purple-500/10 to-transparent' : 'border-white/5' }}">
                    @if($package->is_featured)
                    <span class="absolute top-4 right-4 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Popular</span>
                    @endif
                    <h3 class="text-xl font-bold mb-2">{{ $package->name }}</h3>
                    <p class="text-gray-400 text-sm mb-6">{{ $package->description }}</p>
                    <div class="text-4xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent mb-1">
                        ${{ number_format($package->price, 2) }}
                    </div>
                    <p class="text-gray-500 text-xs mb-6">USD</p>
                    <ul class="space-y-2 mb-8">
                        @foreach($package->features as $feature)
                        <li class="flex items-center gap-2 text-sm text-gray-400">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full flex-shrink-0"></span>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <button
                        @click="addItem({{ $package->id }}, '{{ addslashes($package->name) }}', {{ $package->price }}, 'General')"
                        class="w-full block text-center py-3 rounded-full text-sm font-medium transition cursor-pointer
                            {{ $package->is_featured
                                ? 'bg-gradient-to-r from-pink-500 to-purple-500 text-white hover:opacity-90'
                                : 'border border-white/15 text-white hover:border-purple-400 hover:bg-purple-500/10' }}">
                        + Agregar al pedido
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>


<!-- CALCULADORA -->
<section id="calculadora" class="py-20 px-6 bg-gray-900/50" x-data="calculator()">
    <div class="max-w-6xl mx-auto">
        <span class="text-purple-400 text-xs font-semibold uppercase tracking-widest">Personalizado</span>
        <h2 class="text-3xl font-bold mt-2 mb-4">Arma tu paquete</h2>
        <p class="text-gray-400 mb-10">Selecciona los productos que necesitas y te calculamos el total al instante.</p>

        <div class="grid md:grid-cols-2 gap-8">

            <!-- Productos disponibles -->
            <div>
                @foreach($categories as $category)
                    @php $catProducts = $products->get($category->id, collect()); @endphp
                    @if($catProducts->isNotEmpty())
                    <div class="mb-8">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">
                            {{ $category->icon }} {{ $category->name }}
                        </h3>
                        <div class="space-y-3">
                            @foreach($catProducts as $product)
                            <div class="bg-gray-800 border border-white/5 rounded-xl p-4 flex items-center justify-between hover:border-purple-500/30 transition">
                                <div class="flex-1">
                                    <p class="font-medium text-sm">{{ $product->name }}</p>
                                    @if($product->description)
                                    <p class="text-gray-400 text-xs mt-1">{{ $product->description }}</p>
                                    @endif
                                    <p class="text-purple-300 text-sm font-medium mt-1">${{ number_format($product->price, 2) }} USD</p>
                                </div>
                                <button
                                    @click="addProduct({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})"
                                    class="ml-4 w-8 h-8 rounded-full bg-gradient-to-r from-pink-500 to-purple-500 text-white flex items-center justify-center hover:opacity-90 transition text-lg font-bold flex-shrink-0">
                                    +
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach

                @php $sinCategoria = $products->get(null, collect()); @endphp
                @if($sinCategoria->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">Otros</h3>
                    <div class="space-y-3">
                        @foreach($sinCategoria as $product)
                        <div class="bg-gray-800 border border-white/5 rounded-xl p-4 flex items-center justify-between hover:border-purple-500/30 transition">
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $product->name }}</p>
                                @if($product->description)
                                <p class="text-gray-400 text-xs mt-1">{{ $product->description }}</p>
                                @endif
                                <p class="text-purple-300 text-sm font-medium mt-1">${{ number_format($product->price, 2) }} USD</p>
                            </div>
                            <button
                                @click="addProduct({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})"
                                class="ml-4 w-8 h-8 rounded-full bg-gradient-to-r from-pink-500 to-purple-500 text-white flex items-center justify-center hover:opacity-90 transition text-lg font-bold flex-shrink-0">
                                +
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Resumen del pedido -->
            <div class="sticky top-24">
                <div class="bg-gray-800 border border-white/5 rounded-2xl p-6">
                    <h3 class="font-semibold mb-6 text-sm text-gray-400 uppercase tracking-widest">Tu pedido personalizado</h3>

                    <div x-show="items.length === 0" class="text-center py-8">
                        <p class="text-gray-500 text-sm">Agrega productos para calcular tu total.</p>
                    </div>

                    <div x-show="items.length > 0">
                        <div class="space-y-3 mb-6">
                            <template x-for="item in items" :key="item.id">
                                <div class="flex items-center justify-between border-b border-white/5 pb-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium" x-text="item.name"></p>
                                        <p class="text-purple-300 text-xs" x-text="'$' + item.price.toFixed(2) + ' c/u'"></p>
                                    </div>
                                    <div class="flex items-center gap-2 ml-4">
                                        <button @click="decreaseQty(item.id)"
                                            class="w-6 h-6 rounded-full border border-white/10 text-gray-400 hover:border-purple-400 hover:text-white transition text-xs flex items-center justify-center">
                                            −
                                        </button>
                                        <span class="text-sm font-medium w-4 text-center" x-text="item.qty"></span>
                                        <button @click="increaseQty(item.id)"
                                            class="w-6 h-6 rounded-full border border-white/10 text-gray-400 hover:border-purple-400 hover:text-white transition text-xs flex items-center justify-center">
                                            +
                                        </button>
                                        <button @click="removeItem(item.id)"
                                            class="w-6 h-6 rounded-full border border-red-500/20 text-red-400 hover:border-red-400 transition text-xs flex items-center justify-center ml-1">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="border-t border-white/10 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-sm">Total estimado</span>
                                <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent"
                                    x-text="'$' + total.toFixed(2)"></span>
                            </div>
                            <p class="text-gray-500 text-xs mt-2">El precio final puede variar según los detalles.</p>
                        </div>

                        <a :href="'#contacto'"
                            @click="setOrder()"
                            class="block text-center bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition text-sm">
                            Solicitar este paquete ✦
                        </a>
                        <button @click="items = []"
                            class="w-full text-center text-gray-500 hover:text-red-400 text-xs mt-3 transition">
                            Limpiar selección
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- COLA DE COMISIONES -->
<section id="cola" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <span class="text-purple-400 text-xs font-semibold uppercase tracking-widest">Cola</span>
        <h2 class="text-3xl font-bold mt-2 mb-4">Estado de comisiones</h2>
        <p class="text-gray-400 mb-10">
            {{ $inProgress->count() }} de {{ $slots }} espacios ocupados actualmente.
        </p>

        <!-- SLOTS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-16">

            @foreach($inProgress as $index => $commission)
            <div class="bg-gray-800 border border-blue-500/30 rounded-2xl p-5 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-blue-300 bg-blue-500/15 px-2 py-1 rounded-full">
                        Slot #{{ $index + 1 }}
                    </span>
                    <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                </div>
                <p class="font-medium text-sm mb-1">{{ $commission->client_name }}</p>
                <p class="text-gray-400 text-xs">{{ ucfirst($commission->commission_type) }}</p>
                <p class="text-blue-300 text-xs mt-2 font-medium">En progreso</p>
            </div>
            @endforeach

            @for($i = 0; $i < $availableSlots; $i++)
                <div class="bg-gray-800/50 border border-dashed border-white/10 rounded-2xl p-5 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-gray-500 bg-white/5 px-2 py-1 rounded-full">
                        Slot #{{ $inProgress->count() + $i + 1 }}
                    </span>
                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                </div>
                <p class="font-medium text-sm mb-1 text-gray-400">Disponible</p>
                <p class="text-gray-600 text-xs">Sin asignar</p>
                <p class="text-emerald-400 text-xs mt-2 font-medium">Abierto</p>
        </div>
        @endfor

    </div>

    @if($completedCommissions->isNotEmpty())
    <!-- CLIENTES SATISFECHOS -->
    <div class="border-t border-white/5 pt-16">
        <div class="text-center mb-10">
            <span class="text-purple-400 text-xs font-semibold uppercase tracking-widest">Clientes</span>
            <h3 class="text-2xl font-bold mt-2 mb-3">Gracias a cada uno de ustedes 💜</h3>
            <p class="text-gray-400 text-sm max-w-lg mx-auto">
                Cada comisión es un proyecto especial. Gracias por confiar en mi arte.
            </p>
            <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-sm font-medium px-5 py-2 rounded-full mt-4">
                +{{ $totalCompleted }} clientes satisfechos
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($completedCommissions as $commission)
            <div class="bg-gray-800 border border-white/5 rounded-2xl p-5 hover:-translate-y-1 transition">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500/30 to-purple-500/30 border border-purple-500/20 flex items-center justify-center mb-3">
                    <span class="text-sm font-bold text-purple-300">
                        {{ strtoupper(substr($commission->client_name, 0, 1)) }}
                    </span>
                </div>
                <p class="font-medium text-sm mb-1">{{ $commission->client_name }}</p>
                <p class="text-gray-400 text-xs">{{ ucfirst($commission->commission_type) }}</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="text-emerald-400 text-xs">✓</span>
                    <span class="text-emerald-400 text-xs font-medium">Completado</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    </div>
</section>

<!-- SOBRE MÍ -->
<section id="sobre-mi" class="py-20 px-6 bg-gray-900/50">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-16 items-center">
        <div class="w-64 h-64 rounded-2xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 border border-purple-500/20 flex items-center justify-center flex-shrink-0">
            <span class="text-9xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent">
                {{ strtoupper(substr($settings['artist_name'] ?? 'A', 0, 1)) }}
            </span>
        </div>
        <div>
            <span class="text-purple-400 text-xs font-semibold uppercase tracking-widest">Sobre mí</span>
            <h2 class="text-3xl font-bold mt-2 mb-6">Hola, soy {{ $settings['artist_name'] ?? '' }} 👋</h2>
            <p class="text-gray-400 leading-relaxed">{{ $settings['bio'] ?? '' }}</p>
        </div>
    </div>
</section>

<!-- CONTACTO -->
<section id="contacto" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <span class="text-purple-400 text-xs font-semibold uppercase tracking-widest">Contacto</span>
        <h2 class="text-3xl font-bold mt-2 mb-10">¿Listo para tu comisión?</h2>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Links sociales -->
            <div>
                <p class="text-gray-400 mb-6">Encuéntrame en mis redes o llena el formulario.</p>
                <div class="flex flex-col gap-3">
                    @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" target="_blank"
                        class="flex items-center gap-3 bg-gray-800 border border-white/5 rounded-xl px-4 py-3 text-gray-400 hover:border-purple-400 hover:text-white transition text-sm">

                        @if($link->platform === 'x')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.402 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                        Twitter / X

                        @elseif($link->platform === 'instagram')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                        Instagram

                        @elseif($link->platform === 'discord')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z" />
                        </svg>
                        Discord

                        @elseif($link->platform === 'paypal')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M7.076 21.337H2.47a.641.641 0 01-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42c.045 1.72-.534 3.503-2.068 4.596-1.678 1.19-3.912 1.377-5.878 1.377H11.5c-.524 0-.968.382-1.05.9l-1.179 7.468h3.44c.524 0 .968-.382 1.05-.9l.902-5.713c.082-.518.526-.9 1.05-.9h.637c3.979 0 7.093-1.617 8.003-6.293.38-1.98.116-3.595-.963-4.494a3.35 3.35 0 00-.169-.041z" />
                        </svg>
                        PayPal
                        @endif

                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('contacto.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 border border-white/5 rounded-2xl p-8"> @csrf
                @if(session('success'))
                <div class="bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-sm px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
                @endif
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Nombre</label>
                        <input type="text" name="client_name" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500" placeholder="Tu nombre">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Email</label>
                        <input type="email" name="client_email" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500" placeholder="tu@email.com">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs text-gray-400 mb-1">Tipo de comisión</label>
                    <select name="commission_type" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500">
                        <option value="">Selecciona una opción</option>
                        <option value="emote">Emote sencillo</option>
                        <option value="pack">Pack streamer</option>
                        <option value="branding">Branding completo</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-xs text-gray-400 mb-1">Cuéntame sobre tu proyecto</label>
                    <textarea name="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500" placeholder="Describe tu personaje, colores, estilo..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-xs text-gray-400 mb-1">Imágenes de referencia (opcional)</label>
                    <input type="file" name="references[]" multiple accept="image/*"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-400 focus:outline-none focus:border-purple-500">
                    <p class="text-gray-500 text-xs mt-1">Puedes subir varias imágenes. JPG, PNG o WebP. Máx 2MB cada una.</p>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
                    Enviar solicitud ✦
                </button>

            </form>
        </div>
    </div>
</section>

@endsection