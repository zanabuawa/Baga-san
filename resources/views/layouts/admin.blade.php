<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin · {{ config('app.name') }}</title>
    @php $faviconPath = \App\Models\PageSetting::where('key','logo_favicon')->value('value'); @endphp
    @if($faviconPath)
    <link rel="icon" href="{{ Storage::url($faviconPath) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── ADMIN DESIGN SYSTEM ────────────────────────── */
        .admin-sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            font-weight: 500;
            transition: all 0.15s ease;
            color: #9ca3af;
            position: relative;
        }
        .admin-sidebar-link:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }
        .admin-sidebar-link.active {
            background: linear-gradient(135deg, rgba(236,72,153,0.15), rgba(168,85,247,0.15));
            color: #fff;
            border: 1px solid rgba(168,85,247,0.2);
        }
        .admin-sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            bottom: 25%;
            width: 3px;
            background: linear-gradient(180deg, #ec4899, #a855f7);
            border-radius: 0 3px 3px 0;
        }
        .admin-card {
            background: rgba(17,24,39,0.8);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1rem;
            backdrop-filter: blur(8px);
        }
        .admin-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 0.75rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            color: #fff;
            outline: none;
            transition: border-color 0.15s;
        }
        .admin-input:focus {
            border-color: rgba(168,85,247,0.5);
            background: rgba(168,85,247,0.04);
        }
        .admin-label {
            display: block;
            font-size: 0.75rem;
            color: #9ca3af;
            margin-bottom: 0.375rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .admin-field { margin-bottom: 1.25rem; }
        .admin-error { color: #f87171; font-size: 0.75rem; margin-top: 0.25rem; }
        .admin-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #ec4899, #a855f7);
            color: #fff;
            padding: 0.625rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: opacity 0.15s, transform 0.15s;
            border: none;
            cursor: pointer;
            text-decoration: none;
            justify-content: center;
        }
        .admin-btn-primary:hover { opacity: 0.9; transform: scale(1.02); }
        .admin-back-btn {
            color: #9ca3af;
            font-size: 0.875rem;
            transition: color 0.15s;
            text-decoration: none;
        }
        .admin-back-btn:hover { color: #fff; }
        .admin-badge-success {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(16,185,129,0.12);
            color: #6ee7b7;
            border: 1px solid rgba(16,185,129,0.2);
        }
        .admin-badge-muted {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(255,255,255,0.05);
            color: #6b7280;
            border: 1px solid rgba(255,255,255,0.08);
        }
        .admin-badge-yellow {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(234,179,8,0.12);
            color: #fde047;
            border: 1px solid rgba(234,179,8,0.2);
        }
        .admin-badge-blue {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(59,130,246,0.12);
            color: #93c5fd;
            border: 1px solid rgba(59,130,246,0.2);
        }
        .admin-badge-purple {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(168,85,247,0.12);
            color: #d8b4fe;
            border: 1px solid rgba(168,85,247,0.2);
        }
        .admin-action-btn {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(255,255,255,0.08);
            color: #9ca3af;
            transition: all 0.15s;
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .admin-action-btn:hover { border-color: rgba(168,85,247,0.5); color: #fff; }
        .admin-action-btn-danger {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(255,255,255,0.08);
            color: #9ca3af;
            transition: all 0.15s;
            background: transparent;
            cursor: pointer;
        }
        .admin-action-btn-danger:hover { border-color: rgba(239,68,68,0.5); color: #f87171; }

        /* Table */
        .admin-table th { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; }

        /* select */
        .admin-input option { background: #111827; }

        /* Sidebar scrollbar */
        aside::-webkit-scrollbar { width: 4px; }
        aside::-webkit-scrollbar-track { background: transparent; }
        aside::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-950 text-white antialiased">

{{-- FONDO SUTIL --}}
<div class="fixed inset-0 pointer-events-none z-0" style="background: radial-gradient(ellipse 80% 50% at 20% 0%, rgba(168,85,247,0.04) 0%, transparent 60%), radial-gradient(ellipse 60% 40% at 80% 100%, rgba(236,72,153,0.03) 0%, transparent 60%);"></div>

<div class="flex min-h-screen relative z-10">

    <!-- ── SIDEBAR ──────────────────────────────────── -->
    <aside class="w-60 flex flex-col fixed h-full z-40 overflow-y-auto"
           style="background: rgba(9,13,24,0.95); backdrop-filter: blur(20px); border-right: 1px solid rgba(255,255,255,0.05);">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-white/5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, #ec4899, #a855f7);">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-sm text-white">Panel Admin</p>
                    <p class="text-xs text-gray-500">{{ config('app.name') }}</p>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <p class="text-gray-600 text-xs font-semibold uppercase tracking-widest px-3 mb-2">Principal</p>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                {{-- Bar chart --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.commissions.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}">
                {{-- Clipboard list --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                    <line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/>
                </svg>
                Comisiones
            </a>
            <a href="{{ route('admin.portfolio.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">
                {{-- Image / gallery --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                Portafolio
            </a>

            <p class="text-gray-600 text-xs font-semibold uppercase tracking-widest px-3 mt-4 mb-2">Tienda</p>
            <a href="{{ route('admin.packages.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                {{-- Layers / package --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                </svg>
                Paquetes
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                {{-- Tag --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
                Categorías
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                {{-- Shopping bag --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
                Productos
            </a>
            <a href="{{ route('admin.discount-codes.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.discount-codes.*') ? 'active' : '' }}">
                {{-- Percent --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="19" y1="5" x2="5" y2="19"/>
                    <circle cx="6.5" cy="6.5" r="2.5"/>
                    <circle cx="17.5" cy="17.5" r="2.5"/>
                </svg>
                Descuentos
            </a>

            <p class="text-gray-600 text-xs font-semibold uppercase tracking-widest px-3 mt-4 mb-2">Contenido</p>
            <a href="{{ route('admin.process-steps.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.process-steps.*') ? 'active' : '' }}">
                {{-- Steps / arrow cycle --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <polyline points="23 4 23 10 17 10"/>
                    <polyline points="1 20 1 14 7 14"/>
                    <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
                </svg>
                Proceso
            </a>
            <a href="{{ route('admin.faqs.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                {{-- Help circle --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                FAQ
            </a>
            <a href="{{ route('admin.music-tracks.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.music-tracks.*') ? 'active' : '' }}">
                {{-- Music note --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M9 18V5l12-2v13"/>
                    <circle cx="6" cy="18" r="3"/>
                    <circle cx="18" cy="16" r="3"/>
                </svg>
                Música
            </a>

            <p class="text-gray-600 text-xs font-semibold uppercase tracking-widest px-3 mt-4 mb-2">Sitio</p>
            <a href="{{ route('admin.settings.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                {{-- Gear / settings --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                </svg>
                Configuración
            </a>
            <a href="{{ route('admin.social-links.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
                {{-- Share / network --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="18" cy="5" r="3"/>
                    <circle cx="6" cy="12" r="3"/>
                    <circle cx="18" cy="19" r="3"/>
                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                </svg>
                Redes sociales
            </a>
        </nav>

        {{-- User --}}
        <div class="px-3 py-4 border-t border-white/5">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0"
                     style="background: linear-gradient(135deg, #ec4899, #a855f7);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">Admin</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="admin-sidebar-link text-xs">
                {{-- Eye --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Ver página pública
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-sidebar-link w-full text-left text-red-400 hover:text-red-300 hover:bg-red-500/5 text-xs">
                    {{-- Log out --}}
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- ── MAIN CONTENT ────────────────────────────── -->
    <main class="flex-1 min-h-screen" style="margin-left: 240px;">

        {{-- Top bar --}}
        <header class="sticky top-0 z-30 px-8 py-4 flex items-center justify-between"
                style="background: rgba(9,13,24,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.04);">
            <div class="text-sm text-gray-400">
                {{-- Breadcrumb dinámico --}}
                @if(request()->routeIs('admin.dashboard'))
                    <span class="text-white font-medium">Dashboard</span>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Admin</a>
                    <span class="mx-2 text-gray-600">/</span>
                    <span class="text-white font-medium capitalize">{{ ucfirst(request()->segment(2)) }}</span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank"
                   class="text-xs text-gray-500 hover:text-white transition flex items-center gap-1">
                    <span>↗</span> Ver sitio
                </a>
            </div>
        </header>

        <div class="p-8">
            {{-- Alerts --}}
            @if(session('success'))
            <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-sm px-5 py-3.5 rounded-xl mb-6">
                <span class="text-lg">✅</span>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-500/10 border border-red-500/20 text-red-300 text-sm px-5 py-3.5 rounded-xl mb-6">
                <span class="text-lg">❌</span>
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="flex items-start gap-3 bg-red-500/10 border border-red-500/20 text-red-300 text-sm px-5 py-3.5 rounded-xl mb-6">
                <span class="text-lg shrink-0">⚠️</span>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
