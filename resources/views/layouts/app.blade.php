<!DOCTYPE html>
<html lang="es" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings['artist_name'] ?? 'Artist Portfolio' }}</title>

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
        /* Variables de color por tema */
        [data-theme="dark"]   { --accent: #E6A4B4; --accent2: #c084fc; }
        [data-theme="light"]  { --accent: #db2777; --accent2: #9333ea; }
        [data-theme="red"]    { --accent: #ef4444; --accent2: #dc2626; }
        [data-theme="gold"]   { --accent: #f59e0b; --accent2: #d97706; }
        [data-theme="blue"]   { --accent: #3b82f6; --accent2: #6366f1; }
        [data-theme="purple"] { --accent: #a855f7; --accent2: #7c3aed; }

        /* Botón activo en tema switcher */
        .theme-btn.active { outline: 2px solid white; outline-offset: 2px; }
    </style>
</head>

<body class="bg-gray-950 text-white antialiased bg-grid-lines">

    <!-- FONDO: BLOBS ANIMADOS -->
    <div class="bg-blob bg-blob-1" aria-hidden="true"></div>
    <div class="bg-blob bg-blob-2" aria-hidden="true"></div>
    <div class="bg-blob bg-blob-3" aria-hidden="true"></div>

    <!-- CURSOR GLOW -->
    <div class="cursor-glow" id="cursor-glow" aria-hidden="true"></div>

    <!-- CANVAS PARTÍCULAS (toda la página) -->
    <canvas id="hero-canvas" aria-hidden="true"></canvas>

    <!-- NAV -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-950/80 backdrop-blur-md border-b border-white/5">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent">
                {{ $settings['artist_name'] ?? 'Artist' }} ✦
            </a>
            <ul class="hidden md:flex items-center gap-8">
                <li><a href="#portfolio" class="text-gray-400 hover:text-white text-sm transition">Portafolio</a></li>
                <li><a href="#cola" class="text-gray-400 hover:text-white text-sm transition">Cola</a></li>
                <li><a href="#precios" class="text-gray-400 hover:text-white text-sm transition">Comisiones</a></li>
                <li><a href="#faq" class="text-gray-400 hover:text-white text-sm transition">FAQ</a></li>
                <li><a href="#sobre-mi" class="text-gray-400 hover:text-white text-sm transition">Sobre mí</a></li>
                <li>
                    <a href="#carrito" x-show="count > 0" x-transition
                        class="relative flex items-center gap-2 border border-purple-500/40 text-purple-300 text-sm px-4 py-2 rounded-full hover:border-purple-400 transition">
                        🛒 Pedido
                        <span class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold"
                            x-text="count"></span>
                    </a>
                </li>
                <li><a href="#contacto" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm px-4 py-2 rounded-full hover:opacity-90 transition">Contactar</a></li>
                <!-- THEME SWITCHER -->
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-gray-400 hover:text-white text-sm px-2 py-2 rounded-full hover:bg-white/5 transition" title="Cambiar tema">
                        🎨
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 top-10 bg-gray-900 border border-white/10 rounded-2xl p-3 flex gap-2 z-50">
                        @foreach(['dark' => '#E6A4B4', 'light' => '#f9fafb', 'red' => '#ef4444', 'gold' => '#f59e0b', 'blue' => '#3b82f6', 'purple' => '#a855f7'] as $theme => $color)
                        <button onclick="setTheme('{{ $theme }}')" title="{{ $theme }}"
                            class="theme-btn w-6 h-6 rounded-full transition hover:scale-110"
                            style="background-color: {{ $color }}"
                            id="theme-btn-{{ $theme }}">
                        </button>
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- CONTENIDO -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="border-t border-white/5 text-center py-8 text-gray-500 text-sm">
        © {{ date('Y') }} <span class="bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent font-medium">{{ $settings['artist_name'] ?? 'Artist' }}</span> · Hecho con mucho color y café ☕
    </footer>

    <!-- MUSIC PLAYER (barra fija inferior) -->
    @stack('music-player')


    <script>
function calculator() {
    return {
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

        setOrder() {
            const summary = this.items
                .map(i => `${i.qty}x ${i.name} ($${(i.price * i.qty).toFixed(2)})`)
                .join('\n');

            let totalLine = `\n\nTotal estimado: $${this.total.toFixed(2)} USD`;
            if (this.discountApplied) {
                totalLine = `\nDescuento (${this.discountCode}): -$${this.discountAmount.toFixed(2)}\nTotal con descuento: $${this.total.toFixed(2)} USD`;
            }

            setTimeout(() => {
                const textarea = document.querySelector('textarea[name="description"]');
                if (textarea) {
                    textarea.value = 'Paquete personalizado:\n' + summary + totalLine;
                }
            }, 300);
        }
    }
}

// Theme switcher
function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('bagasan_theme', theme);
    document.querySelectorAll('.theme-btn').forEach(b => b.classList.remove('active'));
    const btn = document.getElementById('theme-btn-' + theme);
    if (btn) btn.classList.add('active');
}

// Marcar botón activo al cargar
document.addEventListener('DOMContentLoaded', function() {
    const current = document.documentElement.getAttribute('data-theme') || 'dark';
    const btn = document.getElementById('theme-btn-' + current);
    if (btn) btn.classList.add('active');

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