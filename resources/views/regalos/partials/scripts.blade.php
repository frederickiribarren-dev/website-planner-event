<script>
    // ─── DATOS DEL JSON (desde Laravel) ───────────────────────────────────────
    const dataCategorias = @json($categorias ?? []);
    let giftItems = [];

    function sincronizarGiftItems() {
        giftItems = [];
        Object.keys(dataCategorias).forEach(catName => {
            dataCategorias[catName].forEach(item => {
                giftItems.push({
                    id: item.id,
                    name: item.nombre,
                    category: catName,
                    description: item.descripcion,
                    img: item.imagen_portada_url || 'https://placehold.co/400x300/f1f5f9/94a3b8?text=Sin+imagen'
                });
            });
        });
    }
    sincronizarGiftItems();

    // ─── ESTADO GLOBAL ─────────────────────────────────────────────────────────
    let selectedItems      = [];
    let savedLists         = [];
    let currentCategory    = 'Ropa';
    let currentDetailListId = null;
    let currentDetailCategory = 'Ropa';
    let currentCreateCategory = 'Ropa';
    let currentItemForModal = null;
    let editingListId      = null;

    // ─── NAVEGACIÓN DE VISTAS ─────────────────────────────────────────────────
    function showView(view) {
        document.querySelectorAll('.view-content').forEach(v => v.classList.add('hidden'));
        const target = document.getElementById('view-' + view);
        if (target) target.classList.remove('hidden');

        const title    = document.getElementById('view-title');
        const subtitle = document.getElementById('view-subtitle');
        const toggleBtn  = document.getElementById('btn-toggle-view');
        const toggleText = document.getElementById('btn-toggle-text');
        const toggleIcon = document.getElementById('btn-toggle-icon');
        const actionBtn  = document.getElementById('btn-action');
        const actionText = document.getElementById('btn-action-text');
        const actionIcon = document.getElementById('btn-action-icon');

        if (view === 'lists') {
            if (title)    title.innerText    = 'Lista de Regalos';
            if (subtitle) subtitle.innerText = 'Gestiona los regalos que tus invitados pueden elegir.';
            if (toggleBtn)  toggleBtn.setAttribute('onclick', "showView('catalogo')");
            if (toggleText) toggleText.innerText = 'Ver catálogo';
            if (toggleIcon) toggleIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>';
            if (actionBtn)  {
                actionBtn.setAttribute('onclick', "showView('create')");
                actionBtn.classList.remove('hidden');
            }
            if (actionText) actionText.innerText = 'Añadir lista';
            if (actionIcon) actionIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';
            
            // Limpiar estado al volver al inicio
            editingListId = null;
            selectedItems = [];
            const nameInput = document.getElementById('listNameInput');
            if (nameInput) { nameInput.value = ''; nameInput.disabled = false; }
            
            renderSavedLists();

        } else if (view === 'catalogo') {
            if (title)    title.innerText    = 'Catálogo de Regalos';
            if (subtitle) subtitle.innerText = 'Explora todos los productos disponibles.';
            if (toggleBtn)  toggleBtn.setAttribute('onclick', "showView('lists')");
            if (toggleText) toggleText.innerText = 'Volver a listas';
            if (toggleIcon) toggleIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>';
            if (actionBtn)  {
                actionBtn.setAttribute('onclick', "showView('create')");
                actionBtn.classList.remove('hidden');
            }
            if (actionText) actionText.innerText = 'Añadir lista';
            if (actionIcon) actionIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';
            renderCatalogGrid();

        } else if (view === 'create') {
            if (title)    title.innerText    = editingListId ? 'Editar Lista de Regalos' : 'Nueva Lista de Regalos';
            if (subtitle) subtitle.innerText = 'Selecciona los productos que deseas incluir.';
            if (toggleBtn)  toggleBtn.setAttribute('onclick', "showView('lists')");
            if (toggleText) toggleText.innerText = 'Volver a listas';
            if (toggleIcon) toggleIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>';
            if (actionBtn)  {
                actionBtn.setAttribute('onclick', "saveCurrentList()");
                actionBtn.classList.remove('hidden');
            }
            if (actionText) actionText.innerText = 'Guardar Lista';
            if (actionIcon) actionIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            
            updateCounter();
            renderCreateGrid();

        } else if (view === 'detail') {
            if (title)    title.innerText    = 'Detalle de Lista';
            if (subtitle) subtitle.innerText = 'Estado de los regalos seleccionados.';
            if (toggleBtn)  toggleBtn.setAttribute('onclick', "showView('lists')");
            if (toggleText) toggleText.innerText = 'Volver a listas';
            if (toggleIcon) toggleIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7h18"></path></svg>';
            if (actionBtn)  actionBtn.classList.add('hidden');
            renderDetailGrid();
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ─── CATÁLOGO (solo lectura) ───────────────────────────────────────────────
    function renderCatalogGrid() {
        const grid = document.getElementById('catalogoGrid');
        if (!grid) return;
        grid.innerHTML = '';
        const items = giftItems.filter(i => i.category === currentCategory);
        if (items.length === 0) {
            grid.innerHTML = `<div class="col-span-full py-16 text-center"><p class="text-slate-400 italic">No hay productos en la categoría ${currentCategory}.</p></div>`;
            return;
        }
        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden';
            card.innerHTML = `
                <div class="overflow-hidden bg-white">
                    <img src="${item.img}" alt="${item.name}" class="w-full h-auto block">
                </div>
                <div class="p-5">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${item.category}</span>
                    <h4 class="font-bold text-slate-800 mt-1 truncate">${item.name}</h4>
                    <p class="text-xs text-slate-400 italic mt-1 line-clamp-2">${item.description || ''}</p>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function filterCategory(cat) {
        currentCategory = cat;
        document.querySelectorAll('.category-btn').forEach(btn => {
            if (btn.innerText.trim() === cat) {
                btn.classList.add('bg-cyan-700', 'text-white');
                btn.classList.remove('text-slate-500', 'hover:bg-slate-50');
            } else {
                btn.classList.remove('bg-cyan-700', 'text-white');
                btn.classList.add('text-slate-500', 'hover:bg-slate-50');
            }
        });
        renderCatalogGrid();
    }

    // ─── CREACIÓN DE LISTA ─────────────────────────────────────────────────────
    function filterCreateCategory(cat) {
        currentCreateCategory = cat;
        document.querySelectorAll('.create-cat-btn').forEach(btn => {
            if (btn.innerText.trim() === cat) {
                btn.classList.add('bg-cyan-700', 'text-white');
                btn.classList.remove('text-slate-500', 'hover:bg-slate-50');
            } else {
                btn.classList.remove('bg-cyan-700', 'text-white');
                btn.classList.add('text-slate-500', 'hover:bg-slate-50');
            }
        });
        renderCreateGrid();
    }

    function renderCreateGrid() {
        const grid = document.getElementById('itemsGrid');
        if (!grid) return;
        grid.innerHTML = '';
        const items = giftItems.filter(i => i.category === currentCreateCategory);
        if (items.length === 0) {
            grid.innerHTML = `<div class="col-span-full py-16 text-center"><p class="text-slate-400 italic">No hay productos en esta categoría.</p></div>`;
            return;
        }
        items.forEach(item => {
            const isSelected = selectedItems.find(s => s.id === item.id);
            const card = document.createElement('div');
            card.className = `bg-white rounded-[2rem] border-2 transition-all overflow-hidden ${isSelected ? 'border-cyan-500 shadow-lg shadow-cyan-50' : 'border-slate-100 hover:border-slate-200'}`;
            card.innerHTML = `
                <div class="overflow-hidden bg-white relative">
                    <img src="${item.img}" alt="${item.name}" class="w-full h-auto block">
                    ${isSelected ? `
                        <div class="absolute top-3 right-3 bg-cyan-600 text-white p-1.5 rounded-full shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    ` : ''}
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-slate-800 text-sm truncate">${item.name}</h4>
                    <p class="text-[10px] text-slate-400 italic mt-1 line-clamp-2">${item.description || ''}</p>
                    <div class="mt-3 flex gap-2">
                        <button onclick="openGiftModal(${item.id})"
                            class="flex-1 py-2 text-xs font-bold rounded-xl transition-all bg-slate-50 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 border border-slate-100">
                            ${isSelected ? 'Modificar' : 'Seleccionar'}
                        </button>
                        ${isSelected ? `
                        <button onclick="removeItem(${item.id})"
                            class="py-2 px-3 text-xs font-bold rounded-xl transition-all bg-red-50 text-red-400 hover:text-red-600 hover:bg-red-100 border border-red-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>` : ''}
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    // ─── MODAL DE DETALLE / CONFIGURACIÓN DE REGALO ────────────────────────────
    function openGiftModal(id) {
        const item = giftItems.find(i => i.id === id);
        if (!item) return;
        currentItemForModal = item;
        const isSelected = selectedItems.find(s => s.id === id);

        const modalTitle = document.getElementById('modalTitle');
        const modalItemName = document.getElementById('modalItemName');
        const modalItemCat = document.getElementById('modalItemCat');
        const modalImg = document.getElementById('modalImg');
        const modalSubmitBtn = document.getElementById('modalSubmitBtn');
        const qtyLabel = document.getElementById('qtyLabel');

        if (modalTitle)    modalTitle.innerText    = isSelected ? 'Modificar Regalo' : 'Configurar Regalo';
        if (modalItemName) modalItemName.innerText  = item.name;
        if (modalItemCat)  modalItemCat.innerText   = item.category;
        if (modalImg)      modalImg.src             = item.img;
        if (modalSubmitBtn) modalSubmitBtn.innerText = isSelected ? 'Actualizar' : 'Agregar';

        document.getElementById('m_link1').value = isSelected ? (isSelected.link1 || '') : '';
        document.getElementById('m_link2').value = isSelected ? (isSelected.link2 || '') : '';
        document.getElementById('m_link3').value = isSelected ? (isSelected.link3 || '') : '';

        if (qtyLabel) {
            qtyLabel.innerText = item.category === 'Grupales' ? 'Cantidad de personas para unir' : 'Cantidad necesaria';
        }
        document.getElementById('m_qty').value = isSelected ? (isSelected.qty || 1) : 1;

        document.getElementById('modalGiftDetail').style.display = 'block';
    }

    function closeGiftModal() {
        document.getElementById('modalGiftDetail').style.display = 'none';
        currentItemForModal = null;
    }

    function confirmAddGift() {
        if (!currentItemForModal) return;
        const id = currentItemForModal.id;
        const idx = selectedItems.findIndex(s => s.id === id);
        const itemData = {
            ...currentItemForModal,
            link1: document.getElementById('m_link1').value,
            link2: document.getElementById('m_link2').value,
            link3: document.getElementById('m_link3').value,
            qty:   document.getElementById('m_qty').value || 1,
            gifted: false
        };
        if (idx > -1) {
            selectedItems[idx] = itemData;
            showToast('¡Actualizado con éxito!', 'success');
        } else {
            selectedItems.push(itemData);
            showToast('¡Agregado a la lista!', 'success');
        }
        updateCounter();
        renderCreateGrid();
        closeGiftModal();
    }

    function removeItem(id) {
        selectedItems = selectedItems.filter(s => s.id !== id);
        updateCounter();
        renderCreateGrid();
        showToast('Eliminado de la lista', 'warning');
    }

    function updateCounter() {
        const counter = document.getElementById('selectedCount');
        if (counter) {
            const totalQty = selectedItems.reduce((sum, item) => {
                const addAmount = item.category === 'Grupales' ? 1 : parseInt(item.qty || 1);
                return sum + addAmount;
            }, 0);
            counter.innerText = totalQty;
        }
    }

    // ─── GUARDAR LISTA ─────────────────────────────────────────────────────────
    function saveCurrentList() {
        if (selectedItems.length === 0) {
            showToast('Selecciona al menos un regalo para tu lista.', 'warning');
            return;
        }
        const nameInput = document.getElementById('listNameInput');
        const name = nameInput ? nameInput.value.trim() : '';
        if (!name) {
            showToast('Dale un nombre a tu lista antes de guardar.', 'error');
            if (nameInput) nameInput.focus();
            return;
        }
        if (editingListId) {
            const idx = savedLists.findIndex(l => l.id === editingListId);
            if (idx > -1) { savedLists[idx].items = [...selectedItems]; showToast('¡Lista actualizada!', 'success'); }
        } else {
            savedLists.push({ id: Date.now(), name, items: [...selectedItems], date: new Date().toLocaleDateString() });
            showToast('¡Lista guardada con éxito!', 'success');
        }
        showView('lists');
    }

    // ─── TABLAS DE LISTAS GUARDADAS ────────────────────────────────────────────
    function renderSavedLists() {
        const body = document.getElementById('savedListsBody');
        const emptyRow = document.getElementById('emptyStateRow');
        if (!body) return;

        // Limpiar filas de datos previas (no el emptyStateRow)
        Array.from(body.querySelectorAll('tr:not(#emptyStateRow)')).forEach(r => r.remove());

        if (savedLists.length === 0) {
            if (emptyRow) emptyRow.classList.remove('hidden');
            return;
        }
        if (emptyRow) emptyRow.classList.add('hidden');

        savedLists.forEach(list => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50/30 transition-colors group';
            row.innerHTML = `
                <td class="px-8 py-5">
                    <p class="font-bold text-slate-700">${list.name}</p>
                    <p class="text-xs text-slate-400 mt-0.5">${list.date}</p>
                </td>
                <td class="px-8 py-5">
                    <span class="px-4 py-1.5 bg-cyan-50 text-cyan-700 rounded-full text-[10px] font-black uppercase tracking-widest">${list.items.length} productos</span>
                </td>
                <td class="px-8 py-5">
                    <span class="text-sm text-slate-400">${list.date}</span>
                </td>
                <td class="px-8 py-5 text-right space-x-2 whitespace-nowrap">
                    <button onclick="viewListDetail(${list.id})" class="px-4 py-2 bg-slate-100 text-cyan-700 text-xs font-bold rounded-xl hover:bg-cyan-600 hover:text-white transition-all">Ver lista</button>
                    <button onclick="editList(${list.id})" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:border-cyan-500 hover:text-cyan-600 transition-all">Editar</button>
                    <button onclick="deleteList(${list.id})" class="p-2 bg-red-50 text-red-400 hover:text-red-600 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            `;
            body.appendChild(row);
        });
    }

    function editList(id) {
        const list = savedLists.find(l => l.id === id);
        if (!list) return;
        editingListId = id;
        selectedItems = [...list.items];
        const nameInput = document.getElementById('listNameInput');
        if (nameInput) { nameInput.value = list.name; nameInput.disabled = true; }
        updateCounter();
        showView('create');
        showToast('Modo edición activado', 'success');
    }

    function deleteList(id) {
        savedLists = savedLists.filter(l => l.id !== id);
        renderSavedLists();
        showToast('Lista eliminada.', 'warning');
    }

    // ─── DETALLE DE LISTA ──────────────────────────────────────────────────────
    function viewListDetail(id) {
        currentDetailListId = id;
        const list = savedLists.find(l => l.id === id);
        if (!list) return;
        const el = document.getElementById('detailListName');
        if (el) el.innerText = list.name;
        currentDetailCategory = 'Ropa';
        showView('detail');
    }

    function filterDetailCategory(cat) {
        currentDetailCategory = cat;
        document.querySelectorAll('.det-category-btn').forEach(btn => {
            if (btn.innerText.trim() === cat) {
                btn.classList.add('bg-cyan-700', 'text-white');
                btn.classList.remove('text-slate-500', 'hover:bg-slate-50');
            } else {
                btn.classList.remove('bg-cyan-700', 'text-white');
                btn.classList.add('text-slate-500', 'hover:bg-slate-50');
            }
        });
        renderDetailGrid();
    }

    function renderDetailGrid() {
        const grid = document.getElementById('detailItemsGrid');
        const list = savedLists.find(l => l.id === currentDetailListId);
        if (!grid || !list) return;
        grid.innerHTML = '';
        const items = list.items.filter(i => i.category === currentDetailCategory);
        if (items.length === 0) {
            grid.innerHTML = `<div class="col-span-full py-16 text-center"><p class="text-slate-400 italic">No hay productos en esta categoría.</p></div>`;
            return;
        }
        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm';
            card.innerHTML = `
                <div class="overflow-hidden bg-white">
                    <img src="${item.img}" alt="${item.name}" class="w-full h-auto block">
                </div>
                <div class="p-5">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${item.category}</span>
                    <h4 class="font-bold text-slate-800 mt-1 truncate">${item.name}</h4>
                    <p class="text-xs text-slate-400 italic mt-1 line-clamp-2">${item.description || ''}</p>
                    <div class="mt-3 pt-3 border-t border-slate-50">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-full border border-emerald-100">Disponible</span>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    // ─── TOAST ─────────────────────────────────────────────────────────────────
    function showToast(msg, type = 'success') {
        const toast   = document.getElementById('toastSuccess');
        const icon    = document.getElementById('toastIcon');
        const message = document.getElementById('toastMessage');
        if (!toast || !icon || !message) return;
        toast.classList.remove('bg-emerald-600', 'bg-red-600', 'bg-amber-500');
        if (type === 'success') {
            toast.classList.add('bg-emerald-600');
            icon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
        } else if (type === 'error') {
            toast.classList.add('bg-red-600');
            icon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        } else if (type === 'warning') {
            toast.classList.add('bg-amber-500');
            icon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
        }
        message.innerText = msg;
        toast.classList.remove('-translate-y-20', 'opacity-0', 'pointer-events-none');
        setTimeout(() => toast.classList.add('-translate-y-20', 'opacity-0', 'pointer-events-none'), 3000);
    }

    // ─── INICIALIZACIÓN ────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        renderSavedLists();
    });
</script>