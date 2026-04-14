{{-- Uso: @include('admin.partials.sortable-table', ['route' => route('admin.faqs.reorder')]) --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function () {
    const tbody = document.getElementById('sortable-tbody');
    if (!tbody) return;
    const toast = document.getElementById('sort-toast');
    let timer;
    Sortable.create(tbody, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'bg-white/5',
        onEnd() {
            const ids = [...tbody.querySelectorAll('[data-id]')].map(el => el.dataset.id);
            fetch('{{ $route }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ order: ids }),
            });
            clearTimeout(timer);
            toast.classList.remove('opacity-0');
            timer = setTimeout(() => toast.classList.add('opacity-0'), 2000);
        },
    });
})();
</script>
<div id="sort-toast"
     class="fixed bottom-6 right-6 bg-gray-800 border border-white/10 text-white text-sm px-4 py-2.5 rounded-xl shadow-xl opacity-0 transition-opacity duration-300 pointer-events-none z-50">
    Orden guardado ✓
</div>
