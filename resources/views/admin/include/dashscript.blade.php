<script>
    const allProducts = [{
            name: 'T-Shirt',
            category: 'Women Cloths',
            price: 79.80,
            stock: 79,
            status: 'Scheduled',
            color: '#f59e0b'
        },
        {
            name: 'Shirt',
            category: 'Man Cloths',
            price: 76.89,
            stock: 86,
            status: 'Active',
            color: '#6b7280'
        },
        {
            name: 'Pant',
            category: 'Kid Cloths',
            price: 86.65,
            stock: 74,
            status: 'Draft',
            color: '#92400e'
        },
        {
            name: 'Sweater',
            category: 'Man Cloths',
            price: 56.07,
            stock: 69,
            status: 'Active',
            color: '#1f2937'
        },
        {
            name: 'Sweater',
            category: 'Man Cloths',
            price: 56.07,
            stock: 69,
            status: 'Scheduled',
            color: '#374151'
        },
        {
            name: 'Light Jacket',
            category: 'Women Cloths',
            price: 36.00,
            stock: 65,
            status: 'Draft',
            color: '#3b82f6'
        },
        {
            name: 'Half Shirt',
            category: 'Man Cloths',
            price: 46.78,
            stock: 58,
            status: 'Active',
            color: '#d1d5db'
        },
        {
            name: 'Half Shirt',
            category: 'Sweater',
            price: 46.78,
            stock: 58,
            status: 'Active',
            color: '#60a5fa'
        },
        {
            name: 'Half Shirt',
            category: 'Man Cloths',
            price: 46.78,
            stock: 58,
            status: 'Scheduled',
            color: '#1f2937'
        },
        {
            name: 'Half Shirt',
            category: 'Kid',
            price: 46.78,
            stock: 58,
            status: 'Active',
            color: '#9ca3af'
        },
        {
            name: 'Hoodie',
            category: 'Man Cloths',
            price: 62.00,
            stock: 44,
            status: 'Active',
            color: '#4b5563'
        },
        {
            name: 'Cargo Pants',
            category: 'Kid Cloths',
            price: 49.99,
            stock: 33,
            status: 'Draft',
            color: '#6b7280'
        },
        {
            name: 'Denim Jacket',
            category: 'Women Cloths',
            price: 99.00,
            stock: 20,
            status: 'Active',
            color: '#2563eb'
        },
        {
            name: 'Polo Shirt',
            category: 'Man Cloths',
            price: 39.50,
            stock: 91,
            status: 'Scheduled',
            color: '#0f172a'
        },
        {
            name: 'Mini Skirt',
            category: 'Women Cloths',
            price: 29.95,
            stock: 55,
            status: 'Active',
            color: '#f43f5e'
        },
        {
            name: 'Blazer',
            category: 'Man Cloths',
            price: 120.00,
            stock: 18,
            status: 'Draft',
            color: '#1e293b'
        },
        {
            name: 'Summer Dress',
            category: 'Women Cloths',
            price: 54.90,
            stock: 47,
            status: 'Active',
            color: '#fbbf24'
        },
        {
            name: 'Kids Tee',
            category: 'Kid Cloths',
            price: 19.99,
            stock: 110,
            status: 'Active',
            color: '#10b981'
        },
        {
            name: 'Trench Coat',
            category: 'Women Cloths',
            price: 149.00,
            stock: 12,
            status: 'Scheduled',
            color: '#78350f'
        },
        {
            name: 'Joggers',
            category: 'Man Cloths',
            price: 44.00,
            stock: 63,
            status: 'Active',
            color: '#374151'
        },
    ];

    let filteredProducts = [...allProducts];
    const PAGE_SIZE = 10;
    let currentPage = 1;

    function getTotalPages() {
        return Math.max(1, Math.ceil(filteredProducts.length / PAGE_SIZE));
    }

    function statusBadge(s) {
        const m = {
            Active: 'bg-green-50 text-green-600 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800',
            Scheduled: 'bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
            Draft: 'bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
        };
        return `<span class="status-badge inline-block px-2.5 py-1 rounded-lg ${m[s] || ''}">${s}</span>`;
    }

    function prodIcon(color) {
        return `<div class="prod-img" style="background:${color}22;"><svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z" stroke="${color}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>`;
    }

    function renderTable() {
        const rows = filteredProducts.slice((currentPage - 1) * PAGE_SIZE, currentPage * PAGE_SIZE);
        document.getElementById('productTable').innerHTML = rows.map(p => `
      <tr class="row-hover border-b border-gray-50 dark:border-neutral-700/60 last:border-0">
        <td class="px-5 py-3.5"><input type="checkbox" class="row-check"></td>
        <td class="px-4 py-3.5"><div class="flex items-center gap-3">${prodIcon(p.color)}<span class="font-medium text-gray-800 dark:text-gray-100 text-[13.5px]">${p.name}</span></div></td>
        <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 text-[13px]">${p.category}</td>
        <td class="px-4 py-3.5 font-semibold text-gray-700 dark:text-gray-200 text-[13.5px]">₦${p.price.toFixed(2)}</td>
        <td class="px-4 py-3.5 text-gray-600 dark:text-gray-300 text-[13.5px]">${p.stock}</td>
        <td class="px-4 py-3.5">${statusBadge(p.status)}</td>
        <td class="px-4 py-3.5 text-right"><a href="#" class="text-brand dark:text-blue-400 font-semibold text-[13px] hover:underline">Details</a></td>
      </tr>`).join('');
        document.getElementById('productCount').textContent = filteredProducts.length + ' items';
    }

    function renderCards() {
        const rows = filteredProducts.slice((currentPage - 1) * PAGE_SIZE, currentPage * PAGE_SIZE);
        document.getElementById('productCards').innerHTML = rows.length ?
            rows.map(p => `
        <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition-colors">
          ${prodIcon(p.color)}
          <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between gap-2">
              <span class="font-semibold text-gray-800 dark:text-gray-100 text-sm truncate">${p.name}</span>
              ${statusBadge(p.status)}
            </div>
            <div class="flex items-center gap-2 mt-0.5 flex-wrap">
              <span class="text-xs text-gray-400 dark:text-gray-500">${p.category}</span>
              <span class="text-xs text-gray-300 dark:text-gray-600">·</span>
              <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">₦${p.price.toFixed(2)}</span>
              <span class="text-xs text-gray-300 dark:text-gray-600">·</span>
              <span class="text-xs text-gray-500 dark:text-gray-400">${p.stock} in stock</span>
            </div>
          </div>
          <a href="#" class="text-brand dark:text-blue-400 text-xs font-semibold ml-1 flex-shrink-0">Details</a>
        </div>`).join('') :
            `<div class="py-12 text-center text-gray-400 text-sm">No products found</div>`;
    }

    function renderPagination() {
        const total = getTotalPages();
        let pages = [];
        if (total <= 5) pages = Array.from({
            length: total
        }, (_, i) => i + 1);
        else if (currentPage <= 3) pages = [1, 2, 3, '...', total];
        else if (currentPage >= total - 2) pages = [1, '...', total - 2, total - 1, total];
        else pages = [1, '...', currentPage - 1, currentPage, currentPage + 1, '...', total];
        document.getElementById('paginationNums').innerHTML = pages.map(p =>
            p === '...' ?
            `<span class="px-1 text-gray-400 text-sm select-none">…</span>` :
            `<button class="page-num ${p === currentPage ? 'active' : ''}" onclick="changePage(${p})">${p}</button>`
        ).join('');
    }

    function changePage(p) {
        const total = getTotalPages();
        if (p < 1 || p > total) return;
        currentPage = p;
        renderTable();
        renderCards();
        renderPagination();
        const sa = document.getElementById('selectAll');
        if (sa) sa.checked = false;
    }

    function toggleAll(cb) {
        document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
    }

    function handleSearch(q) {
        const lo = q.toLowerCase();
        filteredProducts = allProducts.filter(p =>
            p.name.toLowerCase().includes(lo) ||
            p.category.toLowerCase().includes(lo) ||
            p.status.toLowerCase().includes(lo)
        );
        currentPage = 1;
        renderTable();
        renderCards();
        renderPagination();
    }

    // Theme
    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        html.classList.toggle('dark', !isDark);
        html.classList.toggle('light', isDark);
        localStorage.setItem('theme', isDark ? 'light' : 'dark');
    }
    (function() {
        const saved = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const useDark = saved === 'dark' || (!saved && prefersDark);
        document.documentElement.classList.toggle('dark', useDark);
        document.documentElement.classList.toggle('light', !useDark);
    })();

    // Sidebar
    function openSidebar() {
        const sb = document.getElementById('sidebar'),
            ov = document.getElementById('sidebarOverlay');
        ov.classList.remove('hidden');
        requestAnimationFrame(() => {
            ov.classList.remove('opacity-0');
            sb.classList.remove('-translate-x-full');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        const sb = document.getElementById('sidebar'),
            ov = document.getElementById('sidebarOverlay');
        sb.classList.add('-translate-x-full');
        ov.classList.add('opacity-0');
        setTimeout(() => ov.classList.add('hidden'), 280);
        document.body.style.overflow = '';
    }

    // Modal
    function showAddModal() {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
    }

    function hideModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('modal').classList.remove('flex');
    }

    function addProduct() {
        const name = document.getElementById('newName').value.trim();
        const category = document.getElementById('newCategory').value;
        const status = document.getElementById('newStatus').value;
        const price = parseFloat(document.getElementById('newPrice').value) || 0;
        const stock = parseInt(document.getElementById('newStock').value) || 0;
        if (!name) {
            document.getElementById('newName').focus();
            return;
        }
        const pal = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#14b8a6', '#f43f5e'];
        allProducts.unshift({
            name,
            category,
            price,
            stock,
            status,
            color: pal[Math.floor(Math.random() * pal.length)]
        });
        filteredProducts = [...allProducts];
        hideModal();
        currentPage = 1;
        renderTable();
        renderCards();
        renderPagination();
        ['newName', 'newPrice', 'newStock'].forEach(id => document.getElementById(id).value = '');
    }

    // Init
    renderTable();
    renderCards();
    renderPagination();
</script>
