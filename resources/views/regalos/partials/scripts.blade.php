<script>
    const giftItems = [
        { id: 1, name: 'Conjunto Algodón Orgánico', category: 'Ropa', description: 'Suave algodón 100% orgánico ideal para recién nacidos.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_clothes_gift_1778200658377.png' },
        { id: 2, name: 'Pack de Bodies (3 unidades)', category: 'Ropa', description: 'Bodies de manga corta con cierres automáticos.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_clothes_gift_1778200658377.png' },
        { id: 3, name: 'Set Biberones Pro', category: 'Utensilios', description: 'Sistema anti-cólicos avanzado para una alimentación tranquila.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_bottle_set_1778200680488.png' },
        { id: 4, name: 'Esterilizador Eléctrico', category: 'Utensilios', description: 'Esteriliza hasta 6 biberones en solo 5 minutos.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_bottle_set_1778200680488.png' },
        { id: 5, name: 'Sonajero Madera', category: 'Accesorios', description: 'Madera natural pulida, segura para morder y jugar.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_rattle_toy_1778200699425.png' },
        { id: 6, name: 'Manta de Crochet', category: 'Accesorios', description: 'Hecha a mano con lana hipoalergénica de alta calidad.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_rattle_toy_1778200699425.png' },
        { id: 7, name: 'Coche de Paseo Luxury', category: 'Grupales', description: 'Suspensión premium y plegado ultra compacto.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_stroller_luxury_1778200759339.png' },
        { id: 8, name: 'Cuna Pro Inteligente', category: 'Grupales', description: 'Control de temperatura y música relajante integrada.', img: '/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/baby_stroller_luxury_1778200759339.png' }
    ];

    let selectedItems = [];
    let savedLists = [];
    let currentCategory = 'Ropa';
    let currentReviewCategory = 'Ropa';
    let currentItemForModal = null;
    let editingListId = null; // Para saber si estamos editando una lista existente

    // MODAL CREAR REGALO
    function openCreateGiftModal() {
        document.getElementById('modalCreateGift').style.display = 'block';
    }

    function closeCreateGiftModal() {
        document.getElementById('modalCreateGift').style.display = 'none';
        // Limpiar form
        document.getElementById('n_name').value = '';
        document.getElementById('n_desc').value = '';
        document.getElementById('newGiftPreview').src = '';
        document.getElementById('newGiftPreview').classList.add('hidden');
        document.getElementById('newGiftPlaceholder').classList.remove('hidden');
    }

    function previewNewGiftImg(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('newGiftPreview').src = e.target.result;
                document.getElementById('newGiftPreview').classList.remove('hidden');
                document.getElementById('newGiftPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function createNewGift() {
        const name = document.getElementById('n_name').value;
        const cat = document.getElementById('n_cat').value;
        const desc = document.getElementById('n_desc').value;
        const img = document.getElementById('newGiftPreview').src;

        if (!name || !img) {
            showToast('Por favor, completa el nombre y sube una imagen.', 'warning');
            return;
        }

        const newGift = {
            id: Date.now(), // ID temporal
            name: name,
            category: cat,
            description: desc,
            img: img
        };

        giftItems.unshift(newGift); // Agregar al inicio
        showToast('Regalo creado y añadido al catálogo', 'success');
        
        // Cambiar a la categoría del regalo creado para que se vea
        filterCategory(cat);
        closeCreateGiftModal();
    }

    function changeView(view) {
        document.querySelectorAll('.view-section').forEach(s => s.classList.remove('active'));
        document.getElementById('view' + view.charAt(0).toUpperCase() + view.slice(1)).classList.add('active');
        
        const headerActions = document.getElementById('headerActions');
        headerActions.innerHTML = '';

        if (view === 'initial') {
            if (savedLists.length > 0) {
                headerActions.innerHTML = `
                    <button onclick="changeView('selection')" class="px-6 py-2.5 bg-cyan-700 hover:bg-cyan-800 text-white font-bold rounded-full transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Nueva lista
                    </button>
                `;
            }
        }

        if (view === 'selection' || view === 'review') {
            headerActions.innerHTML = `
                <button onclick="saveCurrentList()" class="px-6 py-2 bg-cyan-700 hover:bg-cyan-800 text-white font-bold rounded-full transition-all">
                    Guardar lista
                </button>
            `;
        }

        if (view === 'selection') renderGrid();
        if (view === 'review') renderReview();
    }

    function filterCategory(cat) {
        currentCategory = cat;
        document.querySelectorAll('.category-btn').forEach(btn => {
            if (btn.innerText === cat) {
                btn.classList.add('bg-cyan-700', 'text-white');
                btn.classList.remove('text-slate-500', 'hover:bg-slate-50');
            } else {
                btn.classList.remove('bg-cyan-700', 'text-white');
                btn.classList.add('text-slate-500', 'hover:bg-slate-50');
            }
        });
        renderGrid();
    }

    function filterReviewCategory(cat) {
        currentReviewCategory = cat;
        document.querySelectorAll('.rev-category-btn').forEach(btn => {
            if (btn.innerText === cat) {
                btn.classList.add('bg-cyan-700', 'text-white');
                btn.classList.remove('text-slate-500', 'hover:bg-slate-50');
            } else {
                btn.classList.remove('bg-cyan-700', 'text-white');
                btn.classList.add('text-slate-500', 'hover:bg-slate-50');
            }
        });
        renderReview();
    }

    function renderGrid() {
        const grid = document.getElementById('itemsGrid');
        grid.innerHTML = '';
        
        giftItems.filter(i => i.category === currentCategory).forEach(item => {
            const isSelected = selectedItems.find(s => s.id === item.id);
            const card = document.createElement('div');
            card.className = `bg-white rounded-3xl border-2 transition-all overflow-hidden ${isSelected ? 'border-cyan-500 shadow-lg shadow-cyan-50' : 'border-slate-100'}`;
            
            card.innerHTML = `
                <div class="h-48 overflow-hidden relative">
                    <img src="${item.img}" class="w-full h-full object-cover">
                    ${isSelected ? `
                        <div class="absolute top-4 right-4 bg-cyan-600 text-white p-1.5 rounded-full shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    ` : ''}
                </div>
                <div class="p-6 text-center flex flex-col h-[180px]">
                    <h4 class="font-bold text-slate-800 mb-1 truncate">${item.name}</h4>
                    <p class="text-xs text-slate-400 mb-4 line-clamp-2 italic flex-1">${item.description || 'Sin descripción disponible.'}</p>
                    
                    <div class="flex flex-col gap-2 mt-auto">
                        ${isSelected ? 
                            `
                            <button onclick="openGiftModal(${item.id})" class="w-full py-2.5 bg-cyan-50 text-cyan-700 text-xs font-bold rounded-xl hover:bg-cyan-100 transition-all border border-cyan-100">Modificar</button>
                            <button onclick="removeItem(${item.id})" class="w-full py-2.5 bg-red-50 text-red-500 text-xs font-bold rounded-xl hover:bg-red-100 transition-all border border-red-100 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Eliminar
                            </button>
                            ` :
                            `<button onclick="openGiftModal(${item.id})" class="w-full py-2.5 bg-slate-50 text-slate-700 text-xs font-bold rounded-xl hover:bg-cyan-50 hover:text-cyan-700 border border-slate-100 transition-all">Seleccionar</button>`
                        }
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function openGiftModal(id) {
        const item = giftItems.find(i => i.id === id);
        const isSelected = selectedItems.find(s => s.id === id);
        currentItemForModal = item;

        document.getElementById('modalTitle').innerText = isSelected ? 'Modificar Regalo' : 'Configurar Regalo';
        document.getElementById('modalItemName').innerText = item.name;
        document.getElementById('modalItemCat').innerText = item.category;
        document.getElementById('modalImg').src = item.img;
        
        document.getElementById('m_link1').value = isSelected ? (isSelected.link1 || '') : '';
        document.getElementById('m_link2').value = isSelected ? (isSelected.link2 || '') : '';
        document.getElementById('m_link3').value = isSelected ? (isSelected.link3 || '') : '';
        
        const qtyLabel = document.getElementById('qtyLabel');
        if (item.category === 'Grupales') {
            qtyLabel.innerText = 'Cantidad de personas para unir';
            document.getElementById('m_qty').value = isSelected ? (isSelected.qty || 2) : 2;
        } else {
            qtyLabel.innerText = 'Cantidad necesaria';
            document.getElementById('m_qty').value = isSelected ? (isSelected.qty || 1) : 1;
        }

        document.getElementById('modalSubmitBtn').innerText = isSelected ? 'Actualizar' : 'Agregar';
        document.getElementById('modalGiftDetail').style.display = 'block';
    }

    function closeGiftModal() {
        document.getElementById('modalGiftDetail').style.display = 'none';
        currentItemForModal = null;
    }

    function confirmAddGift() {
        const id = currentItemForModal.id;
        const isSelectedIdx = selectedItems.findIndex(s => s.id === id);
        
        const itemData = {
            ...currentItemForModal,
            link1: document.getElementById('m_link1').value,
            link2: document.getElementById('m_link2').value,
            link3: document.getElementById('m_link3').value,
            qty: document.getElementById('m_qty').value,
            gifted: false // Para saber si ya ha sido regalado
        };

        if (isSelectedIdx > -1) {
            selectedItems[isSelectedIdx] = itemData;
            showToast('Se actualizó con éxito', 'success');
        } else {
            selectedItems.push(itemData);
            showToast('Se agregó con éxito', 'success');
        }

        updateCounter();
        renderGrid();
        closeGiftModal();
    }

    function showToast(msg, type = 'success') {
        const toast = document.getElementById('toastSuccess');
        const icon = document.getElementById('toastIcon');
        const message = document.getElementById('toastMessage');
        
        // Limpiar clases previas
        toast.classList.remove('bg-emerald-600', 'bg-red-600', 'bg-amber-500');
        
        // Configurar por tipo
        if (type === 'success') {
            toast.classList.add('bg-emerald-600');
            icon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
        } else if (type === 'error') {
            toast.classList.add('bg-red-600');
            icon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>';
        } else if (type === 'warning') {
            toast.classList.add('bg-amber-500');
            icon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
        }

        message.innerText = msg;
        toast.classList.remove('-translate-y-20', 'opacity-0', 'pointer-events-none');
        
        setTimeout(() => {
            toast.classList.add('-translate-y-20', 'opacity-0', 'pointer-events-none');
        }, 3000);
    }

    function removeItem(id) {
        selectedItems = selectedItems.filter(s => s.id !== id);
        updateCounter();
        renderGrid();
        showToast('Eliminado de la lista', 'warning');
    }

    function updateCounter() {
        const counter = document.getElementById('selectedCount');
        if (counter) counter.innerText = selectedItems.length;
    }

    function renderReview() {
        const grid = document.getElementById('reviewItemsGrid');
        if (!grid) return;
        
        grid.innerHTML = '';

        const filteredSelected = selectedItems.filter(s => s.category === currentReviewCategory);

        if (filteredSelected.length === 0) {
            grid.innerHTML = `<div class="col-span-full py-20 text-center"><p class="text-slate-400 italic">No tienes regalos seleccionados en la categoría ${currentReviewCategory}.</p></div>`;
            return;
        }

        filteredSelected.forEach(item => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-full';
            const isGrupal = item.category === 'Grupales';
            const label = isGrupal ? 'Personas' : 'Unidades';
            const icon = isGrupal ? 
                `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>` : 
                `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>`;
            
            card.innerHTML = `
                <div class="h-44 overflow-hidden relative">
                    <img src="${item.img}" class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <span class="bg-slate-900/80 backdrop-blur-md text-white px-3 py-1.5 rounded-full text-[11px] font-bold flex items-center gap-2 shadow-xl border border-white/10">
                            ${icon}
                            ${item.qty} ${label}
                        </span>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="min-w-0">
                            <h4 class="font-bold text-slate-800 text-base mb-0.5 truncate">${item.name}</h4>
                            <p class="text-[10px] text-slate-400 italic line-clamp-1">${item.description || 'Sin descripción'}</p>
                        </div>
                        <button onclick="removeItem(${item.id}); renderReview()" class="p-2 bg-red-50 text-red-400 hover:text-red-600 rounded-xl transition-all shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    
                    <div class="space-y-2 mt-auto">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Enlaces Guardados:</p>
                        <div class="space-y-1.5">
                            ${item.link1 ? `<p class="text-xs text-slate-600 truncate flex items-center gap-2 bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-100 hover:border-cyan-200 transition-colors"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>${item.link1}</p>` : ''}
                            ${item.link2 ? `<p class="text-xs text-slate-600 truncate flex items-center gap-2 bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-100 hover:border-cyan-200 transition-colors"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>${item.link2}</p>` : ''}
                            ${item.link3 ? `<p class="text-xs text-slate-600 truncate flex items-center gap-2 bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-100 hover:border-cyan-200 transition-colors"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>${item.link3}</p>` : ''}
                            ${(!item.link1 && !item.link2 && !item.link3) ? '<p class="text-xs text-slate-300 italic px-2.5">Sin referencias guardadas</p>' : ''}
                        </div>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function saveCurrentList() {
        if (selectedItems.length === 0) {
            showToast('Selecciona al menos un regalo para tu lista.', 'warning');
            return;
        }

        const nameInput = document.getElementById('listNameInput');
        const name = nameInput.value.trim();

        if (!name) {
            showToast('Por favor, dale un nombre a tu lista antes de guardar.', 'error');
            nameInput.focus();
            return;
        }

        if (editingListId) {
            const idx = savedLists.findIndex(l => l.id === editingListId);
            if (idx > -1) {
                savedLists[idx].items = [...selectedItems];
                showToast('¡Lista actualizada con éxito!', 'success');
            }
        } else {
            savedLists.push({
                id: Date.now(),
                name: name,
                items: [...selectedItems],
                date: new Date().toLocaleDateString()
            });
            showToast('¡Lista guardada con éxito!', 'success');
        }

        // Limpiar todo
        selectedItems = [];
        nameInput.value = '';
        nameInput.disabled = false;
        editingListId = null;
        updateCounter();
        renderSavedLists();
        changeView('initial');
    }

    function editList(id) {
        const list = savedLists.find(l => l.id === id);
        if (!list) return;

        editingListId = id;
        selectedItems = [...list.items];
        
        const nameInput = document.getElementById('listNameInput');
        nameInput.value = list.name;
        nameInput.disabled = true; // No permitir editar el nombre

        updateCounter();
        changeView('selection');
        showToast('Modo edición activado', 'success');
    }

    function deleteList(id) {
        savedLists = savedLists.filter(l => l.id !== id);
        renderSavedLists();
        showToast('Lista eliminada.', 'warning');
    }

    function renderSavedLists() {
        const container = document.getElementById('savedListsContainer');
        const body = document.getElementById('savedListsBody');
        const emptyState = document.getElementById('emptyState');
        
        if (!container || !body) return;
        
        if (savedLists.length > 0) {
            emptyState.classList.add('hidden');
            container.classList.remove('hidden');
            body.innerHTML = '';
            savedLists.forEach(list => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-slate-50/50 transition-colors';
                row.innerHTML = `
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-800">${list.name}</p>
                        <p class="text-xs text-slate-500">${list.date}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-cyan-100 text-cyan-700 rounded-full text-xs font-bold">
                            ${list.items.length} productos
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="viewListDetails(${list.id})" class="px-4 py-2 bg-slate-100 text-cyan-700 text-xs font-bold rounded-xl hover:bg-cyan-600 hover:text-white transition-all">Ver lista</button>
                            <button onclick="editList(${list.id})" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:border-cyan-500 hover:text-cyan-600 transition-all">Editar</button>
                            <button onclick="deleteList(${list.id})" class="p-2 bg-red-50 text-red-400 hover:text-red-600 rounded-xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                `;
                body.appendChild(row);
            });
        } else {
            emptyState.classList.remove('hidden');
            container.classList.add('hidden');
        }
    }

    let currentDetailListId = null;
    let currentDetailCategory = 'Ropa';

    function viewListDetails(id) {
        currentDetailListId = id;
        const list = savedLists.find(l => l.id === id);
        if (!list) return;

        document.getElementById('detailListName').innerText = list.name;
        changeView('listDetails');
    }

    function filterDetailCategory(cat) {
        currentDetailCategory = cat;
        document.querySelectorAll('.det-category-btn').forEach(btn => {
            if (btn.innerText === cat) {
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
            grid.innerHTML = `<div class="col-span-full py-20 text-center"><p class="text-slate-400 italic">No hay productos en esta categoría.</p></div>`;
            return;
        }

        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-[2rem] border border-slate-100 overflow-hidden flex flex-col h-full shadow-sm';
            
            // Simulación de lógica de disponibilidad para el ejemplo
            const totalNeeded = parseInt(item.qty);
            const taken = Math.floor(Math.random() * (totalNeeded + 1)); // Simulación
            const remaining = totalNeeded - taken;
            
            let statusHtml = '';
            if (totalNeeded === 1) {
                if (taken === 1) {
                    statusHtml = `<span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-black uppercase rounded-full">No disponible</span>`;
                } else {
                    statusHtml = `<span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-full border border-emerald-100">Libre</span>`;
                }
            } else {
                if (remaining === 0) {
                    statusHtml = `<span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-black uppercase rounded-full">Agotado</span>`;
                } else {
                    statusHtml = `<span class="px-3 py-1 bg-cyan-50 text-cyan-600 text-[10px] font-black uppercase rounded-full border border-cyan-100">${remaining} de ${totalNeeded} disponibles</span>`;
                }
            }

            card.innerHTML = `
                <div class="h-44 overflow-hidden relative">
                    <img src="${item.img}" class="w-full h-full object-cover">
                    <div class="absolute bottom-4 left-4">
                        ${statusHtml}
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h4 class="font-bold text-slate-800 mb-1 truncate">${item.name}</h4>
                    <p class="text-[10px] text-slate-400 italic mb-4 line-clamp-2">${item.description || 'Sin descripción'}</p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${item.category}</span>
                        <div class="flex gap-1">
                            ${Array.from({length: totalNeeded}).map((_, i) => `
                                <div class="w-2 h-2 rounded-full ${i < (totalNeeded - remaining) ? 'bg-slate-200' : 'bg-cyan-500'}"></div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    // ACTUALIZAR changeView para soportar la nueva vista
    const originalChangeView = changeView;
    changeView = function(view) {
        document.querySelectorAll('.view-section').forEach(s => s.classList.remove('active'));
        const targetView = document.getElementById('view' + view.charAt(0).toUpperCase() + view.slice(1));
        if (targetView) targetView.classList.add('active');
        
        const headerActions = document.getElementById('headerActions');
        headerActions.innerHTML = '';

        if (view === 'initial') {
            editingListId = null;
            const nameInput = document.getElementById('listNameInput');
            if (nameInput) {
                nameInput.value = '';
                nameInput.disabled = false;
            }
            selectedItems = [];
            updateCounter();

            if (savedLists.length > 0) {
                headerActions.innerHTML = `
                    <button onclick="changeView('selection')" class="px-6 py-2.5 bg-cyan-700 hover:bg-cyan-800 text-white font-bold rounded-full transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Nueva lista
                    </button>
                `;
            }
        }

        if (view === 'selection' || view === 'review') {
            headerActions.innerHTML = `
                <button onclick="saveCurrentList()" class="px-6 py-2 bg-cyan-700 hover:bg-cyan-800 text-white font-bold rounded-full transition-all">
                    Guardar lista
                </button>
            `;
        }

        if (view === 'selection') renderGrid();
        if (view === 'review') renderReview();
        if (view === 'listDetails') {
            headerActions.innerHTML = `
                <button onclick="changeView('initial')" class="px-6 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-full hover:bg-slate-200 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a mis listas
                </button>
            `;
            renderDetailGrid();
        }
    };
</script>
