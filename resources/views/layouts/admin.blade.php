<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 border-r border-white/5 flex flex-col fixed h-full">
        <div class="p-6 border-b border-white/5">
            <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent">
                ✦ Panel Admin
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('admin.portfolio.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.portfolio.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                🎨 Portafolio
            </a>
            <a href="{{ route('admin.commissions.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.commissions.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                📋 Comisiones
            </a>
            <a href="{{ route('admin.packages.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.packages.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                💰 Paquetes
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.categories.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                🏷️ Categorías
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.products.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                📦 Productos
            </a>
            <a href="{{ route('admin.discount-codes.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.discount-codes.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                🎟️ Descuentos
            </a>
            <a href="{{ route('admin.process-steps.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.process-steps.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                📋 Proceso
            </a>
            <a href="{{ route('admin.faqs.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.faqs.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                ❓ FAQ
            </a>
            <a href="{{ route('admin.music-tracks.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.music-tracks.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                🎵 Música
            </a>
            <a href="{{ route('admin.settings.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.settings.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                ⚙️ Configuración
            </a>
            <a href="{{ route('admin.social-links.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition
               {{ request()->routeIs('admin.social-links.*') ? 'bg-purple-500/20 text-purple-300' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                🔗 Links sociales
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
            <p class="text-xs text-gray-500 mb-3">{{ auth()->user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-sm text-gray-400 hover:text-white transition px-4 py-2 rounded-xl hover:bg-white/5">
                    Cerrar sesión
                </button>
            </form>
            <a href="{{ route('home') }}" class="block text-sm text-gray-400 hover:text-white transition px-4 py-2 rounded-xl hover:bg-white/5 mt-1">
                Ver página pública
            </a>
        </div>
    </aside>

    <!-- CONTENIDO -->
    <main class="flex-1 min-h-screen p-8" style="margin-left: 256px;">        @if(session('success'))
        <div class="bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-sm px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>

</div>

</body>
</html>