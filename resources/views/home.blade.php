@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="relative min-h-screen flex items-center justify-center px-6 pt-24 pb-12 overflow-hidden">

    <!-- Glow radial central -->
    <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 60% at 50% 40%, rgba(168,85,247,0.08) 0%, transparent 70%)"></div>

    <div class="relative z-10 max-w-6xl mx-auto w-full flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 max-w-xl">
            @if($settings['commissions_open'] === 'true')
            <div class="inline-flex items-center gap-2 text-xs font-medium px-4 py-2 rounded-full mb-6 badge-glow"
                 style="background: color-mix(in srgb, var(--accent) 12%, transparent); border: 1px solid color-mix(in srgb, var(--accent) 35%, transparent); color: var(--accent); animation-delay:0s">
                <span class="w-2 h-2 rounded-full animate-pulse" style="background: var(--accent)"></span>
                {{ $settings['commissions_status'] ?? 'Comisiones abiertas' }}
            </div>
            @else
            <div class="inline-flex items-center gap-2 bg-red-500/15 border border-red-500/30 text-red-300 text-xs font-medium px-4 py-2 rounded-full mb-6">
                <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                {{ $settings['commissions_status'] ?? 'Comisiones cerradas' }}
            </div>
            @endif

            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="animated-gradient-text">
                    {{ $settings['hero_title'] ?? 'Ilustraciones que cobran vida' }}
                </span>
            </h1>
            <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                {{ $settings['hero_subtitle'] ?? '' }}
            </p>
            <div class="flex gap-4 flex-wrap">
                <a href="#precios"
                   class="relative bg-gradient-to-r from-pink-500 to-purple-500 text-white px-8 py-3 rounded-full font-medium hover:opacity-90 transition hover:scale-105 hover:shadow-lg hover:shadow-pink-500/30">
                    Ver comisiones ✦
                </a>
                <a href="#portfolio"
                   class="border border-white/20 text-white px-8 py-3 rounded-full font-medium hover:border-purple-400 hover:bg-purple-500/10 transition hover:scale-105">
                    Ver portafolio
                </a>
            </div>

            <!-- Scroll indicator -->
            <div class="mt-16 flex flex-col items-start gap-1">
                <div class="flex gap-1">
                    @for($i = 0; $i < 3; $i++)
                    <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 to-purple-500 animate-bounce"
                          style="animation-delay: {{ $i * 0.15 }}s; animation-duration: 1.2s;"></span>
                    @endfor
                </div>
                <span class="text-gray-600 text-xs">Scroll para explorar</span>
            </div>
        </div>

        <div class="flex-1 flex justify-center">
            <div class="relative w-80 h-80 float-anim">
                <!-- Anillo exterior girando -->
                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-pink-500 via-purple-500 to-cyan-400 hero-avatar-ring opacity-90"></div>
                <!-- Anillo medio decorativo -->
                <div class="absolute inset-3 rounded-full" style="border: 1px dashed rgba(168,85,247,0.4); animation: spin-reverse 15s linear infinite;"></div>
                <!-- Interior -->
                <div class="absolute inset-1 rounded-full bg-gray-950 hero-avatar-glow flex items-center justify-center overflow-hidden">
                    @if(!empty($settings['logo_hero']))
                        <img src="{{ Storage::url($settings['logo_hero']) }}" alt="{{ $settings['artist_name'] ?? '' }}"
                            class="w-full h-full object-contain p-6">
                    @else
                        <span class="text-9xl font-bold animated-gradient-text">
                            {{ strtoupper(substr($settings['artist_name'] ?? 'A', 0, 1)) }}
                        </span>
                    @endif
                </div>
                <!-- Puntos orbitales -->
                <div class="absolute inset-0" style="animation: spin-slow 6s linear infinite;">
                    <div class="absolute top-0 left-1/2 w-3 h-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-pink-400 shadow-lg shadow-pink-400/50"></div>
                </div>
                <div class="absolute inset-0" style="animation: spin-reverse 9s linear infinite;">
                    <div class="absolute bottom-0 right-4 w-2 h-2 rounded-full bg-purple-400 shadow-lg shadow-purple-400/50"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
@if(($settings['happy_clients'] ?? 0) > 0 || $totalCompleted > 0 || $portfolioCount > 0 || ($settings['years_experience'] ?? 0) > 0)
<section id="stats" class="py-16 px-6 border-t border-white/5">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center stagger">
        @php $statsData = [
            ['value' => $totalCompleted, 'label' => 'Comisiones completadas', 'icon' => '✦'],
            ['value' => (int)($settings['happy_clients'] ?? 0), 'label' => 'Clientes satisfechos', 'icon' => '💜'],
            ['value' => $portfolioCount, 'label' => 'Trabajos en portafolio', 'icon' => '🎨'],
            ['value' => (int)($settings['years_experience'] ?? 0), 'label' => 'Años de experiencia', 'icon' => '⭐'],
        ]; @endphp
        @foreach($statsData as $stat)
        @if($stat['value'] > 0)
        <div x-data="{ count: 0, target: {{ $stat['value'] }} }"
             x-intersect="let s = Math.ceil(target/60); let t = setInterval(() => { count = Math.min(count + s, target); if (count >= target) clearInterval(t); }, 16);"
             class="reveal bg-gray-800/50 border border-white/5 rounded-2xl p-6 card-glow">
            <div class="text-3xl mb-2">{{ $stat['icon'] }}</div>
            <div class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent" x-text="count + '+'"></div>
            <p class="text-gray-400 text-xs mt-1">{{ $stat['label'] }}</p>
        </div>
        @endif
        @endforeach
    </div>
</section>
@endif

<!-- PORTFOLIO -->
<section id="portfolio" class="py-20 px-6 bg-gray-900/50" x-data="{ activeFilter: 'todos' }">
    <div class="max-w-6xl mx-auto">
        <span class="text-accent text-xs font-semibold uppercase tracking-widest reveal">Trabajos</span>
        <h2 class="text-3xl font-bold mt-2 mb-4 reveal">Portafolio</h2>
        <p class="text-gray-400 mb-8 reveal">Una selección de mis trabajos más recientes.</p>

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
                class="bg-gray-800 border border-white/5 rounded-2xl overflow-hidden card-glow group">
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
<!-- EMOTE PREVIEWER -->
<section id="emote-preview" class="py-20 px-6 reveal"
    x-data="{
        previewUrl: null,
        sizes: [28, 56, 112],
        loadImage(e) {
            const file = e.target.files[0];
            if (file) this.previewUrl = URL.createObjectURL(file);
        }
    }">
    <div class="max-w-6xl mx-auto">
        <span class="text-accent text-xs font-semibold uppercase tracking-widest">Herramienta</span>
        <h2 class="text-3xl font-bold mt-2 mb-2">Previsualizador de emotes</h2>
        <p class="text-gray-400 mb-10">Sube tu imagen y mira cómo se ve en Twitch a diferentes tamaños.</p>

        <div class="grid md:grid-cols-2 gap-8 items-start">
            <!-- Control -->
            <div class="bg-gray-800 border border-white/5 rounded-2xl p-8 card-glow">
                <label class="block text-xs text-gray-400 mb-3">Selecciona una imagen</label>
                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-white/10 rounded-xl cursor-pointer hover:border-purple-500/50 transition">
                    <span class="text-4xl mb-2">🖼️</span>
                    <span class="text-gray-400 text-sm">Haz clic para subir</span>
                    <span class="text-gray-600 text-xs mt-1">PNG, JPG, WebP</span>
                    <input type="file" accept="image/*" class="hidden" @change="loadImage($event)">
                </label>

                <template x-if="previewUrl">
                    <div class="mt-6">
                        <p class="text-xs text-gray-400 mb-3">Imagen cargada — vista previa original:</p>
                        <img :src="previewUrl" alt="Preview" class="w-28 h-28 object-contain rounded-xl border border-white/10 bg-gray-900">
                    </div>
                </template>
            </div>

            <!-- Preview en chat simulado -->
            <div class="bg-gray-800 border border-white/5 rounded-2xl p-8 card-glow">
                <p class="text-xs text-gray-400 mb-4 uppercase tracking-widest">Vista en Twitch Chat</p>

                <template x-if="previewUrl">
                    <div class="space-y-6">
                        <template x-for="size in sizes" :key="size">
                            <div>
                                <p class="text-xs text-gray-500 mb-2" x-text="size + 'px'"></p>
                                <div class="bg-gray-950 rounded-xl p-4 flex items-center gap-2">
                                    <span class="text-sm text-purple-300 font-semibold">Usuario:</span>
                                    <span class="text-gray-300 text-sm">Mira este emote</span>
                                    <img :src="previewUrl" :style="'width:' + size + 'px; height:' + size + 'px; object-fit:contain'" alt="emote" class="inline-block">
                                    <span class="text-gray-300 text-sm">increíble!</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="!previewUrl">
                    <div class="flex flex-col items-center justify-center h-40 text-gray-600">
                        <span class="text-4xl mb-2">👈</span>
                        <p class="text-sm">Sube una imagen para ver la preview</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>

<!-- PRECIOS -->
<section id="precios" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <span class="text-accent text-xs font-semibold uppercase tracking-widest reveal">Comisiones</span>
        <h2 class="text-3xl font-bold mt-2 mb-4 reveal">Precios y paquetes</h2>
        <p class="text-gray-400 mb-16 reveal">Elige el paquete que mejor se adapte a tus necesidades.</p>

        {{-- Categorías con sus paquetes --}}
        @foreach($categories as $category)
        @if($category->packages->isNotEmpty())
        <div class="mb-16">
            <div class="flex flex-col items-center text-center mb-8">
                @if($category->icon)
                <span class="text-3xl mb-2">{{ $category->icon }}</span>
                @endif
                <h3 class="text-2xl font-bold">{{ $category->name }}</h3>
                @if($category->description)
                <p class="text-gray-400 text-sm mt-1">{{ $category->description }}</p>
                @endif
            </div>

            <div class="flex flex-wrap justify-center gap-6 stagger">
                @foreach($category->packages as $package)
                <div class="reveal bg-gray-800 border rounded-2xl p-8 relative card-glow w-full md:w-80
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
                        @foreach($package->products as $product)
                        <li class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="w-1.5 h-1.5 bg-purple-400 rounded-full flex-shrink-0"></span>
                            @if($product->pivot->quantity > 1)
                            <span class="text-purple-400 font-semibold">×{{ $product->pivot->quantity }}</span>
                            @endif
                            {{ $product->name }}
                        </li>
                        @endforeach
                        @foreach($package->features ?? [] as $feature)
                        <li class="flex items-center gap-2 text-sm text-gray-400">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full flex-shrink-0"></span>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <button
                        @click="$store.modal.openWithPackage('{{ addslashes($package->name) }}', {{ $package->price }})"
                        class="w-full block text-center py-3 rounded-full text-sm font-medium transition cursor-pointer
                            {{ $package->is_featured
                                ? 'bg-gradient-to-r from-pink-500 to-purple-500 text-white hover:opacity-90'
                                : 'border border-white/15 text-white hover:border-purple-400 hover:bg-purple-500/10' }}">
                        Solicitar paquete ✦
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
            <div class="flex flex-wrap justify-center gap-6 stagger">
                @foreach($packages as $package)
                <div class="reveal bg-gray-800 border rounded-2xl p-8 relative card-glow
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
                        @foreach($package->products as $product)
                        <li class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="w-1.5 h-1.5 bg-purple-400 rounded-full flex-shrink-0"></span>
                            @if($product->pivot->quantity > 1)
                            <span class="text-purple-400 font-semibold">×{{ $product->pivot->quantity }}</span>
                            @endif
                            {{ $product->name }}
                        </li>
                        @endforeach
                        @foreach($package->features ?? [] as $feature)
                        <li class="flex items-center gap-2 text-sm text-gray-400">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full flex-shrink-0"></span>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <button
                        @click="$store.modal.openWithPackage('{{ addslashes($package->name) }}', {{ $package->price }})"
                        class="w-full block text-center py-3 rounded-full text-sm font-medium transition cursor-pointer
                            {{ $package->is_featured
                                ? 'bg-gradient-to-r from-pink-500 to-purple-500 text-white hover:opacity-90'
                                : 'border border-white/15 text-white hover:border-purple-400 hover:bg-purple-500/10' }}">
                        Solicitar paquete ✦
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>


<!-- CALCULADORA -->
@php
    $firstTabId = null;
    foreach ($categories as $cat) {
        if ($products->get($cat->id, collect())->isNotEmpty()) { $firstTabId = $cat->id; break; }
    }
    if (!$firstTabId && $products->get(null, collect())->isNotEmpty()) $firstTabId = 'other';
@endphp
<section id="calculadora" class="py-20 px-6 bg-gray-900/50"
    x-data="calculator()"
    x-init="activeTab = '{{ $firstTabId }}'">
    <div class="max-w-7xl mx-auto">
        <span class="text-accent text-xs font-semibold uppercase tracking-widest reveal">Personalizado</span>
        <h2 class="text-3xl font-bold mt-2 mb-2 reveal">Arma tu paquete</h2>
        <p class="text-gray-400 mb-10 reveal">Selecciona los productos que necesitas y calculamos el total al instante.</p>

        <div class="flex gap-6 items-start" style="align-items:stretch">

            {{-- ── SIDEBAR DE CATEGORÍAS ────────────────────────────────────── --}}
            <aside class="hidden lg:flex flex-col gap-1 w-52 flex-shrink-0 overflow-y-auto" style="height:480px;scrollbar-width:none">
                @foreach($categories as $cat)
                    @if($products->get($cat->id, collect())->isNotEmpty())
                    <button
                        @click="activeTab = '{{ $cat->id }}'"
                        :class="activeTab === '{{ $cat->id }}'
                            ? 'bg-white/10 text-white border-l-2 border-accent pl-3'
                            : 'text-gray-400 hover:text-white hover:bg-white/5 pl-4'"
                        class="flex items-center gap-2.5 w-full text-left py-2.5 pr-3 rounded-r-xl text-sm font-medium transition-all duration-200">
                        <span class="text-base leading-none">{{ $cat->icon }}</span>
                        <span class="truncate">{{ $cat->name }}</span>
                    </button>
                    @endif
                @endforeach
                @if($products->get(null, collect())->isNotEmpty())
                <button
                    @click="activeTab = 'other'"
                    :class="activeTab === 'other'
                        ? 'bg-white/10 text-white border-l-2 border-accent pl-3'
                        : 'text-gray-400 hover:text-white hover:bg-white/5 pl-4'"
                    class="flex items-center gap-2.5 w-full text-left py-2.5 pr-3 rounded-r-xl text-sm font-medium transition-all duration-200">
                    <span class="text-base leading-none">✦</span>
                    <span>Otros</span>
                </button>
                @endif

                {{-- Divider + counter --}}
                <div class="mt-4 pt-4 border-t border-white/10">
                    <p class="text-xs text-gray-500 px-4">
                        <span x-show="count > 0">
                            <span class="text-accent font-semibold" x-text="count"></span> ítem(s) seleccionado(s)
                        </span>
                        <span x-show="count === 0" class="text-gray-600">Sin ítems aún</span>
                    </p>
                </div>
            </aside>

            {{-- ── MOBILE: pills horizontales ──────────────────────────────── --}}
            <div class="lg:hidden w-full flex gap-2 overflow-x-auto pb-3 mb-2 -mx-1 px-1" style="scrollbar-width:none">
                @foreach($categories as $cat)
                    @if($products->get($cat->id, collect())->isNotEmpty())
                    <button
                        @click="activeTab = '{{ $cat->id }}'"
                        :class="activeTab === '{{ $cat->id }}'
                            ? 'bg-accent/20 text-white border-accent/60'
                            : 'text-gray-400 border-white/10 hover:border-white/30'"
                        class="flex items-center gap-1.5 flex-shrink-0 border px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200">
                        {{ $cat->icon }} {{ $cat->name }}
                    </button>
                    @endif
                @endforeach
                @if($products->get(null, collect())->isNotEmpty())
                <button
                    @click="activeTab = 'other'"
                    :class="activeTab === 'other' ? 'bg-accent/20 text-white border-accent/60' : 'text-gray-400 border-white/10 hover:border-white/30'"
                    class="flex items-center gap-1.5 flex-shrink-0 border px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200">
                    ✦ Otros
                </button>
                @endif
            </div>

            {{-- ── GRID DE PRODUCTOS ────────────────────────────────────────── --}}
            <div class="flex-1 min-w-0 overflow-y-auto pr-1" style="height:480px;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.08) transparent">
                @foreach($categories as $cat)
                    @php $catProducts = $products->get($cat->id, collect()); @endphp
                    @if($catProducts->isNotEmpty())
                    <div
                        x-show="activeTab === '{{ $cat->id }}'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="grid sm:grid-cols-2 gap-3">
                        @foreach($catProducts as $product)
                        <div class="bg-gray-800/80 border border-white/5 rounded-xl p-4 flex gap-4 items-start
                                    hover:border-accent/40 hover:bg-gray-800 transition-all duration-200 group">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-white leading-snug">{{ $product->name }}</p>
                                @if($product->description)
                                <p class="text-gray-400 text-xs mt-1 leading-relaxed line-clamp-2">{{ $product->description }}</p>
                                @endif
                                <p class="text-accent text-sm font-bold mt-2">${{ number_format($product->price, 2) }} <span class="text-gray-500 font-normal text-xs">USD</span></p>
                            </div>
                            <button
                                @click="addProduct({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})"
                                class="flex-shrink-0 w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-gray-400
                                       group-hover:bg-accent/20 group-hover:border-accent/50 group-hover:text-white
                                       flex items-center justify-center text-xl font-light transition-all duration-200 hover:scale-110">
                                +
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                @endforeach

                @php $sinCategoria = $products->get(null, collect()); @endphp
                @if($sinCategoria->isNotEmpty())
                <div
                    x-show="activeTab === 'other'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="grid sm:grid-cols-2 gap-3">
                    @foreach($sinCategoria as $product)
                    <div class="bg-gray-800/80 border border-white/5 rounded-xl p-4 flex gap-4 items-start
                                hover:border-accent/40 hover:bg-gray-800 transition-all duration-200 group">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-white leading-snug">{{ $product->name }}</p>
                            @if($product->description)
                            <p class="text-gray-400 text-xs mt-1 leading-relaxed line-clamp-2">{{ $product->description }}</p>
                            @endif
                            <p class="text-accent text-sm font-bold mt-2">${{ number_format($product->price, 2) }} <span class="text-gray-500 font-normal text-xs">USD</span></p>
                        </div>
                        <button
                            @click="addProduct({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})"
                            class="flex-shrink-0 w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-gray-400
                                   group-hover:bg-accent/20 group-hover:border-accent/50 group-hover:text-white
                                   flex items-center justify-center text-xl font-light transition-all duration-200 hover:scale-110">
                            +
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── RESUMEN DEL PEDIDO ───────────────────────────────────────── --}}
            <div class="hidden lg:block w-80 flex-shrink-0" style="height:480px;overflow-y:auto;scrollbar-width:none">
                <div class="bg-gray-800/90 border border-white/8 rounded-2xl p-6 backdrop-blur">
                    <h3 class="font-semibold mb-1 text-sm text-gray-300 uppercase tracking-widest">Tu pedido</h3>

                    <div x-show="items.length === 0" class="text-center py-10">
                        <div class="text-4xl mb-3 opacity-30">🛒</div>
                        <p class="text-gray-500 text-xs">Agrega productos para calcular tu total.</p>
                    </div>

                    <div x-show="items.length > 0">
                        <div class="space-y-2.5 mb-5 max-h-52 overflow-y-auto pr-1" style="scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.1) transparent">
                            <template x-for="item in items" :key="item.id">
                                <div class="flex items-center gap-3 py-2 border-b border-white/5">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-white truncate" x-text="item.name"></p>
                                        <p class="text-gray-500 text-xs" x-text="'$' + item.price.toFixed(2) + ' c/u'"></p>
                                    </div>
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <button @click="decreaseQty(item.id)"
                                            class="w-5 h-5 rounded-full border border-white/10 text-gray-400 hover:border-accent/60 hover:text-white transition text-xs flex items-center justify-center">−</button>
                                        <span class="text-xs font-bold w-4 text-center tabular-nums" x-text="item.qty"></span>
                                        <button @click="increaseQty(item.id)"
                                            class="w-5 h-5 rounded-full border border-white/10 text-gray-400 hover:border-accent/60 hover:text-white transition text-xs flex items-center justify-center">+</button>
                                        <button @click="removeItem(item.id)"
                                            class="w-5 h-5 rounded-full border border-red-500/20 text-red-400 hover:border-red-400 transition text-xs flex items-center justify-center ml-0.5">✕</button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Código de descuento --}}
                        <div class="mb-4">
                            <div class="flex gap-2">
                                <input type="text" x-model="discountCode" placeholder="Código de descuento"
                                    @keydown.enter.prevent="applyDiscount()"
                                    :disabled="discountApplied"
                                    class="flex-1 bg-white/5 border border-white/10 rounded-xl px-3 py-2 text-xs text-white font-mono uppercase focus:outline-none focus:border-purple-500 disabled:opacity-50"
                                    style="text-transform:uppercase">
                                <button @click="applyDiscount()" :disabled="discountApplied || discountLoading"
                                    class="px-3 py-2 rounded-xl bg-purple-500/20 border border-purple-500/30 text-purple-300 text-xs font-medium hover:bg-purple-500/30 transition disabled:opacity-50 whitespace-nowrap">
                                    <span x-show="!discountLoading">Aplicar</span>
                                    <span x-show="discountLoading">...</span>
                                </button>
                            </div>
                            <p x-show="discountMessage" x-text="discountMessage" class="text-emerald-400 text-xs mt-1"></p>
                            <p x-show="discountError" x-text="discountError" class="text-red-400 text-xs mt-1"></p>
                        </div>

                        <div class="border-t border-white/10 pt-3 mb-5">
                            <div x-show="discountApplied" class="flex justify-between items-center mb-1.5">
                                <span class="text-xs text-gray-400">Subtotal</span>
                                <span class="text-xs text-gray-400" x-text="'$' + subtotal.toFixed(2)"></span>
                            </div>
                            <div x-show="discountApplied" class="flex justify-between items-center mb-1.5">
                                <span class="text-xs text-emerald-400">Descuento</span>
                                <span class="text-xs text-emerald-400" x-text="'−$' + discountAmount.toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="font-semibold text-sm">Total estimado</span>
                                <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent tabular-nums"
                                    x-text="'$' + total.toFixed(2)"></span>
                            </div>
                            <p class="text-gray-600 text-xs mt-1">El precio final puede variar.</p>
                        </div>

                        <button type="button" @click="openModal()"
                            class="w-full block text-center bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition text-sm">
                            Solicitar este paquete ✦
                        </button>
                        <button @click="items = []; resetDiscount()"
                            class="w-full text-center text-gray-600 hover:text-red-400 text-xs mt-2.5 transition">
                            Limpiar selección
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MOBILE: resumen flotante --}}
        <div x-show="items.length > 0" x-transition
            class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-gray-900/95 border-t border-white/10 backdrop-blur px-4 py-3">
            <div class="flex items-center justify-between max-w-lg mx-auto">
                <div>
                    <p class="text-xs text-gray-400"><span class="font-bold text-white" x-text="count"></span> ítem(s)</p>
                    <p class="text-lg font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent tabular-nums"
                        x-text="'$' + total.toFixed(2) + ' USD'"></p>
                </div>
                <button type="button" @click="openModal()"
                    class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:opacity-90 transition">
                    Solicitar ✦
                </button>
            </div>
        </div>
    </div>
</section>

<!-- COLA DE COMISIONES -->
<section id="cola" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <span class="text-accent text-xs font-semibold uppercase tracking-widest reveal">Cola</span>
        <h2 class="text-3xl font-bold mt-2 mb-4 reveal">Estado de comisiones</h2>
        <p class="text-gray-400 mb-10">
            {{ $inProgress->count() }} de {{ $slots }} espacios ocupados actualmente.
        </p>

        <!-- SLOTS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-16 stagger">

            @foreach($inProgress as $index => $commission)
            @if($commission->is_priority)
            <div class="reveal rounded-2xl p-5 relative overflow-hidden"
                style="background: linear-gradient(135deg, #1a1a2e, #16213e); border: 2px solid transparent; background-clip: padding-box;">
                <!-- Borde arcoíris animado para prioridad -->
                <div class="absolute inset-0 rounded-2xl -z-10" style="background: linear-gradient(90deg, #ff6b9d, #c084fc, #60a5fa, #34d399, #fbbf24, #ff6b9d); animation: spin 3s linear infinite; background-size: 300%;"></div>
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 via-pink-500 to-purple-500"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-yellow-300 bg-yellow-500/15 px-2 py-1 rounded-full">
                        ★ Prioridad
                    </span>
                    <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                </div>
                <p class="font-medium text-sm mb-1 text-yellow-100">{{ $commission->client_name }}</p>
                <p class="text-gray-400 text-xs">{{ ucfirst($commission->commission_type) }}</p>
                <p class="text-yellow-400 text-xs mt-2 font-medium">En progreso · Prioritario</p>
            </div>
            @else
            <div class="reveal bg-gray-800 border border-blue-500/30 rounded-2xl p-5 relative overflow-hidden">
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
            @endif
            @endforeach

            @for($i = 0; $i < $availableSlots; $i++)
                <div class="reveal bg-gray-800/50 border border-dashed border-white/10 rounded-2xl p-5 relative overflow-hidden">
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
            <span class="text-accent text-xs font-semibold uppercase tracking-widest">Clientes</span>
            <h3 class="text-2xl font-bold mt-2 mb-3">Gracias a cada uno de ustedes 💜</h3>
            <p class="text-gray-400 text-sm max-w-lg mx-auto">
                Cada comisión es un proyecto especial. Gracias por confiar en mi arte.
            </p>
            <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-sm font-medium px-5 py-2 rounded-full mt-4">
                +{{ $totalCompleted }} clientes satisfechos
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 stagger">
            @foreach($completedCommissions as $commission)
            <div class="reveal bg-gray-800 border border-white/5 rounded-2xl p-5 card-glow">
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

<!-- PROCESO -->
@if($processSteps->isNotEmpty())
<section id="proceso" class="py-20 px-6 bg-gray-900/50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14 reveal">
            <span class="text-accent text-xs font-semibold uppercase tracking-widest">¿Cómo funciona?</span>
            <h2 class="text-3xl font-bold mt-2 mb-3">El proceso de trabajo</h2>
            <p class="text-gray-400 max-w-lg mx-auto">Simple, transparente y enfocado en tu visión.</p>
        </div>

        <div class="grid md:grid-cols-{{ $processSteps->count() >= 3 ? '3' : $processSteps->count() }} gap-8 stagger">
            @foreach($processSteps as $step)
            <div class="reveal relative text-center group">
                @if(!$loop->last)
                <div class="hidden md:block absolute top-10 left-1/2 w-full h-px bg-gradient-to-r from-purple-500/50 to-transparent -z-0"></div>
                @endif
                <div class="relative z-10 w-20 h-20 rounded-full bg-gradient-to-br from-pink-500/20 to-purple-500/20 border border-purple-500/30 flex items-center justify-center mx-auto mb-5 group-hover:border-purple-400 transition">
                    <span class="text-3xl">{{ $step->icon ?? '✦' }}</span>
                </div>
                <div class="w-6 h-6 rounded-full bg-gradient-to-r from-pink-500 to-purple-500 flex items-center justify-center mx-auto mb-4 text-xs font-bold">
                    {{ $loop->iteration }}
                </div>
                <h3 class="font-bold text-lg mb-3">{{ $step->title }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $step->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- FAQ -->
@if($faqs->isNotEmpty())
<section id="faq" class="py-20 px-6">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="text-accent text-xs font-semibold uppercase tracking-widest">Dudas</span>
            <h2 class="text-3xl font-bold mt-2 mb-3">Preguntas frecuentes</h2>
            <p class="text-gray-400">Todo lo que necesitas saber antes de hacer tu pedido.</p>
        </div>

        <div class="space-y-3" x-data="{ open: null }">
            @foreach($faqs as $faq)
            <div class="reveal bg-gray-800 border border-white/5 rounded-2xl overflow-hidden transition"
                :class="open === {{ $faq->id }} ? 'border-purple-500/30' : ''">
                <button
                    @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}"
                    class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-white/2 transition">
                    <span class="font-medium text-sm pr-4">{{ $faq->question }}</span>
                    <span class="text-purple-400 text-lg transition flex-shrink-0"
                        :class="open === {{ $faq->id }} ? 'rotate-45' : 'rotate-0'"
                        style="transition: transform 0.2s">+</span>
                </button>
                <div x-show="open === {{ $faq->id }}" x-collapse>
                    <div class="px-6 pb-5 text-gray-400 text-sm leading-relaxed border-t border-white/5 pt-4">
                        {{ $faq->answer }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- SOBRE MÍ -->
<section id="sobre-mi" class="py-20 px-6 bg-gray-900/50">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-16 items-center">
        <div class="reveal-scale w-64 h-64 rounded-2xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 border border-purple-500/20 flex items-center justify-center flex-shrink-0">
            <span class="text-9xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent">
                {{ strtoupper(substr($settings['artist_name'] ?? 'A', 0, 1)) }}
            </span>
        </div>
        <div class="reveal">
            <span class="text-accent text-xs font-semibold uppercase tracking-widest">Sobre mí</span>
            <h2 class="text-3xl font-bold mt-2 mb-6">Hola, soy {{ $settings['artist_name'] ?? '' }} 👋</h2>
            <p class="text-gray-400 leading-relaxed">{{ $settings['bio'] ?? '' }}</p>
        </div>
    </div>
</section>

<!-- CONTACTO -->
<section id="contacto" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <span class="text-accent text-xs font-semibold uppercase tracking-widest reveal">Contacto</span>
        <h2 class="text-3xl font-bold mt-2 mb-3 reveal">¿Tienes alguna pregunta?</h2>
        <p class="text-gray-400 mb-10 reveal">Si quieres solicitar una comisión usa el botón en los paquetes. Este formulario es para dudas o consultas generales.</p>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Links sociales -->
            <div class="reveal">
                <p class="text-gray-400 mb-6">También puedes encontrarme en mis redes.</p>
                <div class="flex flex-col gap-3 stagger">
                    @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" target="_blank"
                        class="reveal flex items-center gap-3 bg-gray-800 border border-white/5 rounded-xl px-4 py-3 text-gray-400 hover:border-purple-400 hover:text-white transition text-sm card-glow">

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

                        @elseif($link->platform === 'whatsapp')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp
                        @endif

                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('contacto.store') }}" method="POST" class="reveal bg-gray-800 border border-white/5 rounded-2xl p-8 card-glow"> @csrf
                <input type="hidden" name="commission_type" value="Consulta general">
                @if(session('success'))
                <div class="bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-sm px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
                @endif
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-xs text-gray-400 mb-1.5">Nombre</label>
                        <input type="text" name="client_name" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500" placeholder="Tu nombre">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1.5">Email</label>
                        <input type="email" name="client_email" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500" placeholder="tu@email.com">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-xs text-gray-400 mb-1.5">Tu mensaje</label>
                    <textarea name="description" rows="5" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500" placeholder="¿En qué puedo ayudarte?"></textarea>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 rounded-full font-medium hover:opacity-90 transition">
                    Enviar mensaje
                </button>
            </form>
        </div>
    </div>
</section>

{{-- ── MODAL DE PEDIDO ──────────────────────────────────────────────── --}}
<div
    x-data="{
        clientName: '',
        clientEmail: '',
        clientMessage: '',
        fileNames: [],
        totalFileSize: 0,
        get sizeOver() { return this.totalFileSize > 20 * 1024 * 1024; },
        handleFiles(e) {
            const f = Array.from(e.target.files);
            this.fileNames = f.map(x => x.name);
            this.totalFileSize = f.reduce((s, x) => s + x.size, 0);
        },
        send() {
            const summary = $store.modal.orderSummaryText;
            const full = summary + (this.clientMessage.trim() ? '\n\nMensaje:\n' + this.clientMessage.trim() : '');
            this.$refs.descInput.value = full;
            this.$refs.orderForm.submit();
        }
    }"
    x-show="$store.modal.open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[200] flex items-end sm:items-center justify-center p-0 sm:p-4"
    style="display:none"
    @keydown.escape.window="$store.modal.close()">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-950/75 backdrop-blur-sm" @click="$store.modal.close()"></div>

    {{-- Panel --}}
    <div class="relative z-10 w-full sm:max-w-2xl max-h-[92vh] overflow-y-auto
                bg-gray-900 border-t sm:border border-white/10 sm:rounded-2xl shadow-2xl"
         @click.stop
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

        {{-- Header --}}
        <div class="flex items-center justify-between px-10 py-7 border-b border-white/8 sticky top-0 bg-gray-900 z-10">
            <div>
                <h2 class="text-lg font-bold text-white">Solicitar comisión</h2>
                <p class="text-gray-500 text-sm mt-0.5">Revisa tu pedido y completa los datos</p>
            </div>
            <button @click="$store.modal.close()"
                class="w-9 h-9 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition">
                ✕
            </button>
        </div>

        {{-- Resumen del pedido --}}
        <div class="px-10 py-8 border-b border-white/8">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Resumen del pedido</p>
            <div class="space-y-3">
                <template x-for="item in $store.modal.items" :key="item.name">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-400 flex-shrink-0"></span>
                            <span class="text-sm text-white truncate"
                                  x-text="(item.qty > 1 ? '×' + item.qty + ' ' : '') + item.name"></span>
                        </div>
                        <span class="text-sm text-gray-300 tabular-nums flex-shrink-0"
                              x-text="'$' + (item.price * item.qty).toFixed(2)"></span>
                    </div>
                </template>
            </div>
            <div class="mt-5 pt-4 border-t border-white/8 space-y-2">
                <template x-if="$store.modal.discountAmt > 0">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-emerald-400">Descuento
                            (<span x-text="$store.modal.discountCodeVal"></span>)
                        </span>
                        <span class="text-sm text-emerald-400 tabular-nums"
                              x-text="'−$' + $store.modal.discountAmt.toFixed(2)"></span>
                    </div>
                </template>
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-base">Total estimado</span>
                    <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent tabular-nums"
                          x-text="'$' + $store.modal.totalVal.toFixed(2) + ' USD'"></span>
                </div>
                <p class="text-gray-600 text-xs">El precio final puede variar según los detalles.</p>
            </div>
        </div>

        {{-- Formulario --}}
        <form x-ref="orderForm" action="{{ route('contacto.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="commission_type" :value="$store.modal.commissionType">
            <input type="hidden" name="description" x-ref="descInput">

            <div class="px-10 py-8 space-y-7">

                {{-- Nombre + Email --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            Nombre <span class="text-pink-400">*</span>
                        </label>
                        <input type="text" name="client_name" x-model="clientName" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500 transition"
                            placeholder="Tu nombre">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            Email <span class="text-pink-400">*</span>
                        </label>
                        <input type="email" name="client_email" x-model="clientEmail" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500 transition"
                            placeholder="tu@email.com">
                    </div>
                </div>

                {{-- Mensaje --}}
                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        Mensaje para el artista <span class="text-pink-400">*</span>
                    </label>
                    <textarea x-model="clientMessage" rows="6"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"
                        placeholder="Describe tu personaje, colores, estilo, referencias de inspiración..."></textarea>
                </div>

                {{-- Imágenes de referencia --}}
                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        Imágenes de referencia <span class="text-gray-600">(opcional)</span>
                    </label>
                    <label for="modal-ref-upload"
                        :class="sizeOver ? 'border-red-500/50 bg-red-500/5' : 'border-white/15 bg-white/5 hover:border-purple-500/60 hover:bg-white/8'"
                        class="flex flex-col items-center justify-center gap-3 w-full h-36 rounded-xl border-2 border-dashed cursor-pointer transition group">
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-purple-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span class="text-sm text-gray-400 group-hover:text-white transition text-center px-6 truncate max-w-full"
                              x-text="fileNames.length ? fileNames.length + ' archivo(s): ' + fileNames.join(', ') : 'Arrastra imágenes o haz clic para seleccionar'"></span>
                        <input id="modal-ref-upload" type="file" name="references[]"
                            multiple accept="image/*" class="hidden"
                            @change="handleFiles($event)">
                    </label>

                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs text-gray-600">JPG, PNG, GIF o WebP · Máx. 20 MB en total (límite de correo)</span>
                        <span x-show="totalFileSize > 0"
                              :class="sizeOver ? 'text-red-400 font-semibold' : 'text-gray-500'"
                              class="text-xs tabular-nums"
                              x-text="(totalFileSize / (1024 * 1024)).toFixed(1) + ' MB'"></span>
                    </div>

                    <div x-show="sizeOver"
                         x-transition
                         class="mt-3 flex items-start gap-2.5 bg-red-500/10 border border-red-500/25 rounded-xl px-4 py-3">
                        <span class="text-red-400 text-base leading-none flex-shrink-0 mt-0.5">⚠️</span>
                        <p class="text-red-300 text-sm leading-relaxed">
                            El total supera 20 MB, que es el límite para enviar por correo.
                            Selecciona menos archivos o usa imágenes más pequeñas.
                        </p>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-10 pb-10 flex gap-4 border-t border-white/8 pt-7">
                <button type="button" @click="$store.modal.close()"
                    class="flex-1 border border-white/10 text-gray-400 hover:text-white hover:border-white/30 py-3.5 rounded-full text-sm font-medium transition">
                    Cancelar
                </button>
                <button type="button" @click="send()"
                    :disabled="!clientName.trim() || !clientEmail.trim() || !clientMessage.trim() || sizeOver"
                    class="flex-1 bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3.5 rounded-full text-sm font-medium hover:opacity-90 transition disabled:opacity-40 disabled:cursor-not-allowed">
                    Enviar solicitud ✦
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@if($musicTracks->isNotEmpty())
@push('music-player')
{{-- ── REPRODUCTOR MULTI-PISTA ────────────────────────────────── --}}
<div id="music-player"
     x-data="multiPlayer({{ $musicTracks->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'url' => $t->audio_url])->values()->toJson() }})"
     class="fixed bottom-0 left-0 right-0 z-[55]"
     style="background: rgba(6,9,20,0.96); backdrop-filter: blur(20px); border-top: 1px solid rgba(255,255,255,0.06);">

    {{-- Línea de acento superior --}}
    <div class="h-0.5 w-full" style="background: linear-gradient(90deg, transparent, var(--accent), var(--accent2), transparent);"></div>

    {{-- Barra compacta (siempre visible) --}}
    <div class="px-4 py-2.5 flex items-center gap-3 max-w-7xl mx-auto">
        {{-- Ícono + toggle panel --}}
        <button @click="panelOpen = !panelOpen"
            class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 transition-all"
            :style="anyPlaying ? 'background: linear-gradient(135deg, var(--accent), var(--accent2));' : 'background: rgba(255,255,255,0.08);'"
            title="Ver pistas">
            <span class="text-sm" :class="anyPlaying ? 'animate-pulse' : ''">🎵</span>
        </button>

        {{-- Info pista activa --}}
        <div class="flex-1 min-w-0">
            <template x-if="anyPlaying">
                <div>
                    <p class="text-xs text-white font-medium truncate" x-text="activeTitles"></p>
                    <p class="text-xs" style="color: var(--accent)">Reproduciendo</p>
                </div>
            </template>
            <template x-if="!anyPlaying">
                <p class="text-xs text-gray-500">Haz clic en una pista para reproducir</p>
            </template>
        </div>

        {{-- Volumen global --}}
        <div class="hidden sm:flex items-center gap-2">
            <span class="text-gray-500 text-xs">🔉</span>
            <input type="range" min="0" max="1" step="0.05" :value="globalVolume"
                @input="setGlobalVolume(parseFloat($event.target.value))"
                class="w-20 cursor-pointer" style="accent-color: var(--accent)">
        </div>

        {{-- Parar todo --}}
        <button x-show="anyPlaying" @click="stopAll()" x-transition
            class="text-xs text-gray-500 hover:text-red-400 transition px-2 py-1 rounded-lg hover:bg-red-500/10">
            ⏹ Parar
        </button>

        {{-- Flecha panel --}}
        <button @click="panelOpen = !panelOpen"
            class="text-gray-500 hover:text-white transition text-xs px-1"
            :title="panelOpen ? 'Cerrar' : 'Ver pistas'">
            <span :class="panelOpen ? 'rotate-180' : ''" class="inline-block transition-transform duration-200">▲</span>
        </button>
    </div>

    {{-- Panel expandido con todas las pistas --}}
    <div x-show="panelOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="border-t border-white/5 px-4 py-3 max-w-7xl mx-auto">
        <p class="text-xs text-gray-500 mb-3 uppercase tracking-widest font-semibold">Pistas · reproducción simultánea</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            <template x-for="track in tracks" :key="track.id">
                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all"
                     :style="playing[track.id] ? 'background: color-mix(in srgb, var(--accent) 12%, transparent); border: 1px solid color-mix(in srgb, var(--accent) 25%, transparent);' : 'background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);'">
                    {{-- Play/Pause --}}
                    <button @click="toggle(track.id)"
                        class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center transition-all"
                        :style="playing[track.id] ? 'background: linear-gradient(135deg, var(--accent), var(--accent2));' : 'background: rgba(255,255,255,0.08);'">
                        <span class="text-xs" x-text="playing[track.id] ? '⏸' : '▶'"></span>
                    </button>

                    {{-- Título + equalizer --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium truncate"
                           :style="playing[track.id] ? 'color: var(--accent);' : 'color: #e5e7eb;'"
                           x-text="track.title"></p>
                        <template x-if="playing[track.id]">
                            <div class="flex items-end gap-0.5 mt-1 h-3">
                                <div class="w-0.5 rounded-sm animate-equalizer-1" style="background: var(--accent);"></div>
                                <div class="w-0.5 rounded-sm animate-equalizer-2" style="background: var(--accent2);"></div>
                                <div class="w-0.5 rounded-sm animate-equalizer-3" style="background: var(--accent);"></div>
                                <div class="w-0.5 rounded-sm animate-equalizer-2" style="background: var(--accent2);"></div>
                                <div class="w-0.5 rounded-sm animate-equalizer-1" style="background: var(--accent);"></div>
                            </div>
                        </template>
                    </div>

                    {{-- Volumen individual --}}
                    <input type="range" min="0" max="1" step="0.05"
                        :value="volumes[track.id] ?? 0.5"
                        @input="setVolume(track.id, parseFloat($event.target.value))"
                        class="w-14 cursor-pointer" style="accent-color: var(--accent2)"
                        title="Volumen">
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function multiPlayer(tracks) {
    return {
        tracks,
        audioInstances: {},
        playing: {},
        volumes: {},
        globalVolume: 0.5,
        panelOpen: false,

        init() {
            const savedVol = localStorage.getItem('bagasan_global_vol');
            if (savedVol) this.globalVolume = parseFloat(savedVol);

            tracks.forEach(t => {
                this.playing[t.id] = false;
                this.volumes[t.id] = this.globalVolume;
            });
        },

        getAudio(id) {
            if (!this.audioInstances[id]) {
                const track = this.tracks.find(t => t.id === id);
                if (!track) return null;
                const a = new Audio(track.url);
                a.volume = this.volumes[id] ?? this.globalVolume;
                a.addEventListener('ended', () => { this.playing[id] = false; });
                this.audioInstances[id] = a;
            }
            return this.audioInstances[id];
        },

        toggle(id) {
            const a = this.getAudio(id);
            if (!a) return;
            if (this.playing[id]) {
                a.pause();
                this.playing[id] = false;
            } else {
                a.play().then(() => { this.playing[id] = true; }).catch(() => {});
            }
        },

        stopAll() {
            Object.keys(this.audioInstances).forEach(id => {
                this.audioInstances[id].pause();
                this.audioInstances[id].currentTime = 0;
                this.playing[id] = false;
            });
        },

        setVolume(id, v) {
            this.volumes[id] = v;
            if (this.audioInstances[id]) this.audioInstances[id].volume = v;
        },

        setGlobalVolume(v) {
            this.globalVolume = v;
            localStorage.setItem('bagasan_global_vol', v);
            Object.keys(this.audioInstances).forEach(id => {
                this.audioInstances[id].volume = v;
                this.volumes[id] = v;
            });
        },

        get anyPlaying() {
            return Object.values(this.playing).some(v => v);
        },

        get activeTitles() {
            return this.tracks
                .filter(t => this.playing[t.id])
                .map(t => t.title)
                .join(' · ');
        }
    };
}
</script>

<style>
@keyframes equalizer-1 {
    0%, 100% { height: 4px; }
    50% { height: 12px; }
}
@keyframes equalizer-2 {
    0%, 100% { height: 10px; }
    33% { height: 3px; }
    66% { height: 12px; }
}
@keyframes equalizer-3 {
    0%, 100% { height: 7px; }
    25% { height: 12px; }
    75% { height: 3px; }
}
.animate-equalizer-1 { animation: equalizer-1 0.8s ease-in-out infinite; }
.animate-equalizer-2 { animation: equalizer-2 1.1s ease-in-out infinite; }
.animate-equalizer-3 { animation: equalizer-3 0.9s ease-in-out infinite; }
</style>
@endpush
@endif