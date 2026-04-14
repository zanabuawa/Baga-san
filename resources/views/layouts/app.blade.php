<!DOCTYPE html>
<html lang="es" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings['artist_name'] ?? 'Artist Portfolio' }}</title>
    @if(!empty($settings['logo_favicon']))
    <link rel="icon" href="{{ Storage::url($settings['logo_favicon']) }}">
    @endif

    <!-- Tema: se aplica antes del render para evitar flash -->
    <script>
        (function() {
            var saved = localStorage.getItem('bagasan_theme');
            var def = '{{ $settings['default_theme'] ?? 'dark' }}';
            document.documentElement.setAttribute('data-theme', saved || def);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── VARIABLES COMPLETAS POR TEMA ─────────────────── */
        :root {
            --accent: #E6A4B4;
            --accent2: #c084fc;
            --bg-body: #030712;
            --bg-card: rgba(17,24,39,0.9);
            --bg-nav: rgba(3,7,18,0.82);
            --bg-section: rgba(17,24,39,0.4);
            --text-primary: #ffffff;
            --text-muted: #9ca3af;
            --blob1: rgba(236,72,153,0.38);
            --blob2: rgba(168,85,247,0.18);
            --blob3: rgba(139,92,246,0.32);
            --blob4: rgba(59,130,246,0.14);
            --border: rgba(255,255,255,0.06);
            --particle1: rgba(236,72,153,;
            --particle2: rgba(168,85,247,;
            --particle3: rgba(96,165,250,;
        }
        [data-theme="dark"] {
            --accent: #E6A4B4; --accent2: #c084fc;
            --bg-body: #030712; --bg-card: rgba(17,24,39,0.9);
            --bg-nav: rgba(3,7,18,0.82); --bg-section: rgba(17,24,39,0.4);
            --text-primary: #ffffff; --text-muted: #9ca3af;
            --blob1: rgba(236,72,153,0.35); --blob2: rgba(168,85,247,0.18);
            --blob3: rgba(139,92,246,0.30); --blob4: rgba(59,130,246,0.12);
            --border: rgba(255,255,255,0.06);
        }
        [data-theme="light"] {
            --accent: #db2777; --accent2: #9333ea;
            --bg-body: #f0f4f8; --bg-card: rgba(255,255,255,0.95);
            --bg-nav: rgba(240,244,248,0.92); --bg-section: rgba(229,234,239,0.6);
            --text-primary: #111827; --text-muted: #6b7280;
            --blob1: rgba(219,39,119,0.12); --blob2: rgba(147,51,234,0.08);
            --blob3: rgba(168,85,247,0.1); --blob4: rgba(59,130,246,0.06);
            --border: rgba(0,0,0,0.07);
        }
        [data-theme="red"] {
            --accent: #ef4444; --accent2: #f97316;
            --bg-body: #0c0505; --bg-card: rgba(28,10,10,0.95);
            --bg-nav: rgba(12,5,5,0.88); --bg-section: rgba(30,10,10,0.4);
            --text-primary: #fff5f5; --text-muted: #9ca3af;
            --blob1: rgba(239,68,68,0.35); --blob2: rgba(249,115,22,0.18);
            --blob3: rgba(220,38,38,0.30); --blob4: rgba(239,68,68,0.10);
            --border: rgba(239,68,68,0.08);
        }
        [data-theme="gold"] {
            --accent: #f59e0b; --accent2: #f97316;
            --bg-body: #0a0800; --bg-card: rgba(26,20,0,0.95);
            --bg-nav: rgba(10,8,0,0.88); --bg-section: rgba(30,22,0,0.4);
            --text-primary: #fffbf0; --text-muted: #a8a29e;
            --blob1: rgba(245,158,11,0.35); --blob2: rgba(249,115,22,0.18);
            --blob3: rgba(217,119,6,0.30); --blob4: rgba(251,191,36,0.10);
            --border: rgba(245,158,11,0.08);
        }
        [data-theme="blue"] {
            --accent: #3b82f6; --accent2: #6366f1;
            --bg-body: #03070f; --bg-card: rgba(8,15,30,0.95);
            --bg-nav: rgba(3,7,15,0.88); --bg-section: rgba(10,18,35,0.4);
            --text-primary: #f0f6ff; --text-muted: #9ca3af;
            --blob1: rgba(59,130,246,0.35); --blob2: rgba(99,102,241,0.18);
            --blob3: rgba(96,165,250,0.30); --blob4: rgba(59,130,246,0.10);
            --border: rgba(59,130,246,0.08);
        }
        [data-theme="purple"] {
            --accent: #a855f7; --accent2: #ec4899;
            --bg-body: #07030f; --bg-card: rgba(15,8,30,0.95);
            --bg-nav: rgba(7,3,15,0.88); --bg-section: rgba(18,10,35,0.4);
            --text-primary: #faf5ff; --text-muted: #a78bfa;
            --blob1: rgba(168,85,247,0.38); --blob2: rgba(236,72,153,0.18);
            --blob3: rgba(124,58,237,0.30); --blob4: rgba(168,85,247,0.10);
            --border: rgba(168,85,247,0.08);
        }

        /* Botón activo en tema switcher */
        .theme-btn.active { outline: 2px solid white; outline-offset: 2px; }

        /* Transición suave al cambiar tema */
        body { transition: background-color 0.5s ease, color 0.3s ease; }
    </style>
</head>

<body class="antialiased bg-grid-lines" style="background-color: var(--bg-body, #030712); color: var(--text-primary, #ffffff);">

    <!-- FONDO: BLOBS ANIMADOS -->
    <div class="bg-blob bg-blob-1" aria-hidden="true"></div>
    <div class="bg-blob bg-blob-2" aria-hidden="true"></div>
    <div class="bg-blob bg-blob-3" aria-hidden="true"></div>

    <!-- CURSOR GLOW -->
    <div class="cursor-glow" id="cursor-glow" aria-hidden="true"></div>

    <!-- CANVAS PARTÍCULAS (toda la página) -->
    <canvas id="hero-canvas" aria-hidden="true"></canvas>

    <!-- BARRA DE COLOR SUPERIOR (cambia con el tema) -->
    <div class="theme-top-bar" aria-hidden="true"></div>

    <!-- NAV -->
    <nav id="main-nav" class="themed-nav fixed top-[3px] left-0 right-0 z-50 bg-gray-950/80 backdrop-blur-md">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="font-bold text-xl flex items-center gap-1 group">
                @if(!empty($settings['logo_navbar']))
                    <img src="{{ Storage::url($settings['logo_navbar']) }}" alt="{{ $settings['artist_name'] ?? 'Logo' }}"
                        class="h-9 w-auto max-w-[140px] object-contain group-hover:opacity-90 transition">
                @else
                    <span class="bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent group-hover:opacity-90 transition">
                        {{ $settings['artist_name'] ?? 'Artist' }}
                    </span>
                    <span class="text-pink-400 group-hover:rotate-12 transition-transform duration-300 inline-block">✦</span>
                @endif
            </a>

            <!-- Desktop links -->
            <ul class="hidden md:flex items-center gap-6">
                <li><a href="#portfolio" class="nav-link-accent text-gray-400 hover:text-white text-sm transition-colors">Portafolio</a></li>
                <li><a href="#cola" class="nav-link-accent text-gray-400 hover:text-white text-sm transition-colors">Cola</a></li>
                <li><a href="#precios" class="nav-link-accent text-gray-400 hover:text-white text-sm transition-colors">Comisiones</a></li>
                <li><a href="#faq" class="nav-link-accent text-gray-400 hover:text-white text-sm transition-colors">FAQ</a></li>
                <li><a href="#sobre-mi" class="nav-link-accent text-gray-400 hover:text-white text-sm transition-colors">Sobre mí</a></li>
                <li>
                    <a href="#carrito" x-show="count > 0" x-transition
                        class="relative flex items-center gap-2 border border-purple-500/40 text-purple-300 text-sm px-3 py-1.5 rounded-full hover:border-purple-400 transition">
                        🛒
                        <span class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs w-4 h-4 rounded-full flex items-center justify-center font-bold"
                            x-text="count"></span>
                    </a>
                </li>
                <li><a href="#contacto" class="btn-accent text-white text-sm px-4 py-2 rounded-full">Contactar</a></li>
                <!-- THEME SWITCHER -->
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-white/8 transition text-base"
                        title="Cambiar tema">
                        🎨
                    </button>
                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 top-11 bg-gray-900/95 backdrop-blur-md border border-white/10 rounded-2xl p-3 flex gap-2 shadow-xl shadow-black/40 z-50">
                        @foreach(['dark' => ['color' => '#E6A4B4', 'label' => 'Rosa'], 'light' => ['color' => '#f9fafb', 'label' => 'Claro'], 'red' => ['color' => '#ef4444', 'label' => 'Rojo'], 'gold' => ['color' => '#f59e0b', 'label' => 'Dorado'], 'blue' => ['color' => '#3b82f6', 'label' => 'Azul'], 'purple' => ['color' => '#a855f7', 'label' => 'Morado']] as $theme => $info)
                        <button onclick="setTheme('{{ $theme }}')" title="{{ $info['label'] }}"
                            class="theme-btn w-7 h-7 rounded-full transition-all hover:scale-115 hover:ring-2 ring-white/40 ring-offset-1 ring-offset-gray-900"
                            style="background-color: {{ $info['color'] }}"
                            id="theme-btn-{{ $theme }}">
                        </button>
                        @endforeach
                    </div>
                </li>
            </ul>

            <!-- Mobile hamburger -->
            <button id="mobile-menu-btn" class="md:hidden w-9 h-9 flex flex-col items-center justify-center gap-1.5 rounded-xl hover:bg-white/5 transition" aria-label="Menú">
                <span class="hamburger-line w-5 h-0.5 bg-gray-400 rounded transition-all duration-300"></span>
                <span class="hamburger-line w-5 h-0.5 bg-gray-400 rounded transition-all duration-300"></span>
                <span class="hamburger-line w-5 h-0.5 bg-gray-400 rounded transition-all duration-300"></span>
            </button>
        </div>
    </nav>

    <!-- MOBILE MENU -->
    <div id="mobile-nav-menu" class="mobile-nav-menu" aria-hidden="true">
        <ul class="space-y-1">
            <li><a href="#portfolio" class="block text-gray-300 hover:text-white py-3 px-4 rounded-xl hover:bg-white/5 transition text-sm" onclick="closeMobileMenu()">Portafolio</a></li>
            <li><a href="#cola" class="block text-gray-300 hover:text-white py-3 px-4 rounded-xl hover:bg-white/5 transition text-sm" onclick="closeMobileMenu()">Cola</a></li>
            <li><a href="#precios" class="block text-gray-300 hover:text-white py-3 px-4 rounded-xl hover:bg-white/5 transition text-sm" onclick="closeMobileMenu()">Comisiones</a></li>
            <li><a href="#faq" class="block text-gray-300 hover:text-white py-3 px-4 rounded-xl hover:bg-white/5 transition text-sm" onclick="closeMobileMenu()">FAQ</a></li>
            <li><a href="#sobre-mi" class="block text-gray-300 hover:text-white py-3 px-4 rounded-xl hover:bg-white/5 transition text-sm" onclick="closeMobileMenu()">Sobre mí</a></li>
            <li class="pt-3 border-t border-white/6">
                <a href="#contacto" onclick="closeMobileMenu()"
                    class="block text-center btn-accent text-white py-3 px-4 rounded-xl text-sm font-medium">
                    Contactar ✦
                </a>
            </li>
        </ul>
        <!-- Theme switcher mobile -->
        <div class="mt-4 pt-4 border-t border-white/6">
            <p class="text-xs text-gray-500 mb-3 px-1">Tema de color</p>
            <div class="flex gap-2 flex-wrap px-1">
                @foreach(['dark' => ['color' => '#E6A4B4', 'label' => 'Rosa'], 'light' => ['color' => '#f9fafb', 'label' => 'Claro'], 'red' => ['color' => '#ef4444', 'label' => 'Rojo'], 'gold' => ['color' => '#f59e0b', 'label' => 'Dorado'], 'blue' => ['color' => '#3b82f6', 'label' => 'Azul'], 'purple' => ['color' => '#a855f7', 'label' => 'Morado']] as $theme => $info)
                <button onclick="setTheme('{{ $theme }}')" title="{{ $info['label'] }}"
                    class="theme-btn w-8 h-8 rounded-full transition-all hover:scale-110 hover:ring-2 ring-white/40 ring-offset-1 ring-offset-gray-950 flex items-center justify-center text-xs"
                    style="background-color: {{ $info['color'] }}"
                    id="theme-btn-mobile-{{ $theme }}">
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CONTENIDO -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="relative border-t border-white/5 text-center py-10 text-sm overflow-hidden"
            style="color: var(--text-muted, #6b7280); @if(!empty($musicTracks) && $musicTracks->isNotEmpty()) padding-bottom: 6rem; @endif">
        <!-- Línea de acento superior del footer -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-px" style="background: linear-gradient(90deg, transparent, var(--accent), transparent); opacity: 0.5;"></div>
        © {{ date('Y') }} <span class="font-medium" style="color: var(--accent)">{{ $settings['artist_name'] ?? 'Artist' }}</span> · Hecho con mucho color y café ☕
    </footer>

    <!-- MUSIC PLAYER (barra fija inferior) -->
    @stack('music-player')


    <script>
function calculator() {
    return {
        activeTab: null,
        items: [],
        discountCode: '',
        discountAmount: 0,
        discountApplied: false,
        discountMessage: '',
        discountError: '',
        discountLoading: false,

        addProduct(id, name, price) {
            const existing = this.items.find(i => i.id === id);
            if (existing) {
                existing.qty++;
            } else {
                this.items.push({ id, name, price, qty: 1 });
            }
            this.resetDiscount();
        },

        removeItem(id) {
            this.items = this.items.filter(i => i.id !== id);
            this.resetDiscount();
        },

        increaseQty(id) {
            const item = this.items.find(i => i.id === id);
            if (item) item.qty++;
            this.resetDiscount();
        },

        decreaseQty(id) {
            const item = this.items.find(i => i.id === id);
            if (item) {
                item.qty--;
                if (item.qty <= 0) this.removeItem(id);
            }
            this.resetDiscount();
        },

        get subtotal() {
            return this.items.reduce((sum, i) => sum + (i.price * i.qty), 0);
        },

        get total() {
            return Math.max(0, this.subtotal - this.discountAmount);
        },

        get count() {
            return this.items.reduce((sum, i) => sum + i.qty, 0);
        },

        resetDiscount() {
            this.discountAmount = 0;
            this.discountApplied = false;
            this.discountMessage = '';
            this.discountError = '';
        },

        async applyDiscount() {
            if (!this.discountCode.trim()) return;
            this.discountLoading = true;
            this.discountError = '';
            this.discountMessage = '';

            try {
                const res = await fetch('{{ route('descuento.aplicar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ code: this.discountCode, total: this.subtotal }),
                });
                const data = await res.json();
                if (data.valid) {
                    this.discountAmount = data.discount_amount;
                    this.discountApplied = true;
                    this.discountMessage = data.message;
                } else {
                    this.discountError = data.message;
                }
            } catch(e) {
                this.discountError = 'Error al validar el código.';
            } finally {
                this.discountLoading = false;
            }
        },

        openModal() {
            Alpine.store('modal').openWithCart(
                this.items,
                this.total,
                this.subtotal,
                this.discountAmount,
                this.discountCode,
                this.discountApplied
            );
        }
    }
}

// Alpine store — modal de pedido
document.addEventListener('alpine:init', () => {
    Alpine.store('modal', {
        open: false,
        items: [],
        totalVal: 0,
        subtotalVal: 0,
        discountAmt: 0,
        discountCodeVal: '',
        commissionType: '',

        openWithPackage(name, price) {
            this.items = [{ name, price, qty: 1 }];
            this.subtotalVal = price;
            this.totalVal = price;
            this.discountAmt = 0;
            this.discountCodeVal = '';
            this.commissionType = name;
            this.open = true;
            document.body.style.overflow = 'hidden';
        },

        openWithCart(items, total, subtotal, discountAmt, discountCode, discountApplied) {
            this.items = items.map(i => ({ ...i }));
            this.totalVal = total;
            this.subtotalVal = subtotal;
            this.discountAmt = discountApplied ? discountAmt : 0;
            this.discountCodeVal = discountApplied ? discountCode : '';
            this.commissionType = 'Personalizado';
            this.open = true;
            document.body.style.overflow = 'hidden';
        },

        close() {
            this.open = false;
            document.body.style.overflow = '';
        },

        get orderSummaryText() {
            if (!this.items.length) return '';
            let lines = this.items.map(i => `${i.qty}x ${i.name} ($${(i.price * i.qty).toFixed(2)})`);
            let text = 'Pedido:\n' + lines.join('\n');
            if (this.discountAmt > 0) {
                text += `\nDescuento (${this.discountCodeVal}): -$${this.discountAmt.toFixed(2)}`;
            }
            text += `\nTotal estimado: $${this.totalVal.toFixed(2)} USD`;
            return text;
        }
    });
});

// Theme switcher
function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('bagasan_theme', theme);
    document.querySelectorAll('.theme-btn').forEach(b => b.classList.remove('active'));
    const btn = document.getElementById('theme-btn-' + theme);
    if (btn) btn.classList.add('active');
    const btnMobile = document.getElementById('theme-btn-mobile-' + theme);
    if (btnMobile) btnMobile.classList.add('active');
}

// Mobile menu
function closeMobileMenu() {
    const menu = document.getElementById('mobile-nav-menu');
    const btn = document.getElementById('mobile-menu-btn');
    if (menu) { menu.classList.remove('open'); menu.setAttribute('aria-hidden', 'true'); }
    if (btn) btn.setAttribute('aria-expanded', 'false');
}

// Marcar botón activo al cargar
document.addEventListener('DOMContentLoaded', function() {
    const current = document.documentElement.getAttribute('data-theme') || 'dark';
    const btn = document.getElementById('theme-btn-' + current);
    if (btn) btn.classList.add('active');
    const btnMobile = document.getElementById('theme-btn-mobile-' + current);
    if (btnMobile) btnMobile.classList.add('active');

    // ── MOBILE MENU ───────────────────────────────────────────
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-nav-menu');
    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.toggle('open');
            mobileMenu.setAttribute('aria-hidden', String(!isOpen));
            mobileBtn.setAttribute('aria-expanded', String(isOpen));
            // Animar hamburger
            const lines = mobileBtn.querySelectorAll('.hamburger-line');
            if (isOpen) {
                lines[0].style.transform = 'translateY(8px) rotate(45deg)';
                lines[1].style.opacity = '0';
                lines[2].style.transform = 'translateY(-8px) rotate(-45deg)';
            } else {
                lines.forEach(l => { l.style.transform = ''; l.style.opacity = ''; });
            }
        });
    }

    // ── NAV SCROLL EFFECT ─────────────────────────────────────
    const nav = document.getElementById('main-nav');
    if (nav) {
        const onScroll = () => {
            if (window.scrollY > 20) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    // ── CURSOR GLOW ──────────────────────────────────────────
    const glow = document.getElementById('cursor-glow');
    if (glow) {
        document.addEventListener('mousemove', (e) => {
            glow.style.left = e.clientX + 'px';
            glow.style.top  = e.clientY + 'px';
            glow.style.transform = 'translate(-50%, -50%)';
        });
    }

    // ── SCROLL REVEAL ─────────────────────────────────────────
    const reveals = document.querySelectorAll('.reveal, .reveal-scale');
    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                revealObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => revealObs.observe(el));

    // ── STAGGER CHILDREN ──────────────────────────────────────
    const staggerObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.querySelectorAll(':scope > *').forEach(child => {
                    child.classList.add('reveal', 'visible');
                });
                staggerObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.stagger').forEach(el => staggerObs.observe(el));

    // ── HERO CANVAS PARTICLES ─────────────────────────────────
    const canvas = document.getElementById('hero-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let W, H, particles = [];

        function resize() {
            W = canvas.width  = canvas.offsetWidth;
            H = canvas.height = canvas.offsetHeight;
        }

        function randomBetween(a, b) { return a + Math.random() * (b - a); }

        function createParticle() {
            return {
                x: randomBetween(0, W),
                y: randomBetween(0, H),
                r: randomBetween(0.8, 2.5),
                vx: randomBetween(-0.3, 0.3),
                vy: randomBetween(-0.6, -0.1),
                alpha: randomBetween(0.2, 0.8),
                color: Math.random() > 0.5
                    ? `rgba(236,72,153,`
                    : Math.random() > 0.5
                        ? `rgba(168,85,247,`
                        : `rgba(96,165,250,`,
                life: randomBetween(80, 200),
                age: 0,
            };
        }

        function init() {
            particles = Array.from({ length: 80 }, createParticle);
        }

        function draw() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach((p, i) => {
                p.x  += p.vx;
                p.y  += p.vy;
                p.age++;
                const fade = p.age < 20
                    ? p.age / 20
                    : p.age > p.life - 20
                        ? (p.life - p.age) / 20
                        : 1;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.color + (p.alpha * fade) + ')';
                ctx.fill();

                if (p.age >= p.life || p.y < -10) {
                    particles[i] = createParticle();
                    particles[i].y = H + 10;
                }
            });
            requestAnimationFrame(draw);
        }

        resize();
        init();
        draw();
        window.addEventListener('resize', () => { resize(); init(); });
    }
});
</script>

@stack('scripts')

</body>

</html>