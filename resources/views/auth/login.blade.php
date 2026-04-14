<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso · {{ config('app.name') }}</title>
    @php
        $faviconPath  = \App\Models\PageSetting::where('key','logo_favicon')->value('value');
        $logoNavbar   = \App\Models\PageSetting::where('key','logo_navbar')->value('value');
        $artistName   = \App\Models\PageSetting::where('key','artist_name')->value('value') ?? config('app.name');
    @endphp
    @if($faviconPath)
    <link rel="icon" href="{{ Storage::url($faviconPath) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #030712; }

        .login-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        .login-blob-1 {
            width: 520px; height: 520px;
            top: -120px; left: -120px;
            background: radial-gradient(circle, rgba(236,72,153,0.18) 0%, transparent 70%);
        }
        .login-blob-2 {
            width: 480px; height: 480px;
            bottom: -100px; right: -80px;
            background: radial-gradient(circle, rgba(168,85,247,0.16) 0%, transparent 70%);
        }
        .login-blob-3 {
            width: 320px; height: 320px;
            top: 40%; left: 50%;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, rgba(139,92,246,0.10) 0%, transparent 70%);
        }

        .login-card {
            background: rgba(17,24,39,0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 1.5rem;
        }

        .login-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 0.875rem;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            color: #fff;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .login-input::placeholder { color: #4b5563; }
        .login-input:focus {
            border-color: rgba(168,85,247,0.55);
            background: rgba(168,85,247,0.05);
        }
        .login-input.error {
            border-color: rgba(239,68,68,0.5);
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #ec4899, #a855f7);
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 9999px;
            font-size: 0.9375rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            letter-spacing: 0.01em;
        }
        .login-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(168,85,247,0.3);
        }
        .login-btn:active { transform: translateY(0); }

        .grid-bg {
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        @keyframes float-slow {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-10px); }
        }
        .float-anim { animation: float-slow 5s ease-in-out infinite; }

        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        .animated-gradient-text {
            background: linear-gradient(90deg, #ec4899, #a855f7, #ec4899);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 antialiased grid-bg" style="color:#fff;">

    <!-- Blobs de fondo -->
    <div class="login-blob login-blob-1" aria-hidden="true"></div>
    <div class="login-blob login-blob-2" aria-hidden="true"></div>
    <div class="login-blob login-blob-3" aria-hidden="true"></div>

    <div class="relative z-10 w-full max-w-md">

        <!-- Logo / marca -->
        <div class="text-center mb-8 float-anim">
            @if($logoNavbar)
                <img src="{{ Storage::url($logoNavbar) }}" alt="{{ $artistName }}"
                    class="h-14 w-auto mx-auto object-contain mb-3">
            @else
                <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center text-2xl font-bold mb-3"
                     style="background: linear-gradient(135deg, #ec4899, #a855f7); box-shadow: 0 8px 32px rgba(168,85,247,0.35);">
                    {{ strtoupper(substr($artistName, 0, 1)) }}
                </div>
            @endif
            <h1 class="text-2xl font-bold animated-gradient-text">{{ $artistName }}</h1>
            <p class="text-gray-500 text-sm mt-1">Panel de administración</p>
        </div>

        <!-- Tarjeta -->
        <div class="login-card px-8 py-8">

            <!-- Estado de sesión (ej: "contraseña restablecida") -->
            @if(session('status'))
            <div class="flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-sm px-4 py-3 rounded-xl mb-6">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        Correo electrónico
                    </label>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        required autofocus autocomplete="username"
                        placeholder="correo@ejemplo.com"
                        class="login-input {{ $errors->has('email') ? 'error' : '' }}">
                    @error('email')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-6" x-data="{ show: false }">
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Contraseña
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-purple-400 hover:text-purple-300 transition">
                            ¿Olvidaste tu contraseña?
                        </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" :type="show ? 'text' : 'password'" name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••"
                            class="login-input pr-11 {{ $errors->has('password') ? 'error' : '' }}">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Recordar sesión -->
                <div class="flex items-center gap-2.5 mb-7">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 rounded accent-purple-500 cursor-pointer">
                    <label for="remember_me" class="text-sm text-gray-400 cursor-pointer select-none">
                        Mantener sesión iniciada
                    </label>
                </div>

                <!-- Botón -->
                <button type="submit" class="login-btn">
                    Iniciar sesión
                </button>
            </form>
        </div>

        <!-- Volver al sitio -->
        <p class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs text-gray-600 hover:text-gray-400 transition inline-flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al sitio
            </a>
        </p>

    </div>

</body>
</html>
