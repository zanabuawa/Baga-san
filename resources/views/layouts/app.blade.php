<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['artist_name'] ?? 'Artist Portfolio' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-950 text-white antialiased">
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
            </ul>
        </div>
    </nav>

    <!-- CONTENIDO -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="border-t border-white/5 text-center py-8 text-gray-500 text-sm">
        © {{ date('Y') }} <span class="bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent font-medium">{{ $settings['artist_name'] ?? 'Artist' }}</span> · Hecho con mucho color y café ☕
    </footer>


    <script>
function calculator() {
    return {
        items: [],

        addProduct(id, name, price) {
            const existing = this.items.find(i => i.id === id);
            if (existing) {
                existing.qty++;
            } else {
                this.items.push({ id, name, price, qty: 1 });
            }
        },

        removeItem(id) {
            this.items = this.items.filter(i => i.id !== id);
        },

        increaseQty(id) {
            const item = this.items.find(i => i.id === id);
            if (item) item.qty++;
        },

        decreaseQty(id) {
            const item = this.items.find(i => i.id === id);
            if (item) {
                item.qty--;
                if (item.qty <= 0) this.removeItem(id);
            }
        },

        get total() {
            return this.items.reduce((sum, i) => sum + (i.price * i.qty), 0);
        },

        setOrder() {
            const summary = this.items
                .map(i => `${i.qty}x ${i.name} ($${(i.price * i.qty).toFixed(2)})`)
                .join('\n');

            const total = `\n\nTotal estimado: $${this.total.toFixed(2)} USD`;

            setTimeout(() => {
                const textarea = document.querySelector('textarea[name="description"]');
                if (textarea) {
                    textarea.value = 'Paquete personalizado:\n' + summary + total;
                }
            }, 300);
        }
    }
}
</script>

</body>

</html>