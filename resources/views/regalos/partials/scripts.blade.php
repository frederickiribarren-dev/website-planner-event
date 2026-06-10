<script>
    const dataCategorias = @json($categorias ?? []);
    let giftItems = [];

    /**
     * Sincroniza y procesa los regalos disponibles desde la base de datos hacia el formato requerido en el frontend.
     */
    function sincronizarGiftItems() {
        giftItems = [];
        if (!dataCategorias) return;
        
        Object.keys(dataCategorias).forEach(catName => {
            dataCategorias[catName].forEach(item => {
                let urlImagen = item.imagen_portada_url || item.img;
                
                if (urlImagen && !/^https?:\/\//i.test(urlImagen)) {
                    urlImagen = urlImagen.replace(/^img\/regalos\//i, 'regalos/');
                    urlImagen = '/storage/' + urlImagen;
                }

                giftItems.push({
                    id: item.id,
                    name: item.nombre || item.name || item.nombre_regalo,
                    category: catName, 
                    description: item.descripcion || item.description,
                    img: urlImagen || 'https://placehold.co/400x300/f1f5f9/94a3b8?text=Sin+imagen'
                });
            });
        });
    }

    let selectedItems      = [];
    let savedLists         = [];
    let currentCategory    = 'Ropa';
    let currentDetailListId = null;
    let currentDetailCategory = 'Ropa';
    let currentCreateCategory = 'Ropa';
    let currentItemForModal = null;
    let editingListId      = null;

    /**
     * Alterna la visualización entre las distintas secciones de la gestión de regalos actualizando textos y botones.
     */
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
            
            editingListId = null;
            selectedItems = [];
            const nameInput = document.getElementById('listNameInput');
            if (nameInput) { nameInput.value = ''; nameInput.disabled = false; }
            const descInput = document.getElementById('listDescInput');
            if (descInput) descInput.value = '';
            
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
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * Renderiza los regalos del catálogo principal según la categoría actualmente seleccionada.
     */
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

    /**
     * Actualiza la categoría seleccionada en el catálogo y refresca los elementos mostrados.
     */
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

    /**
     * Filtra los elementos mostrados durante la creación de la lista según la categoría seleccionada.
     */
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

    /**
     * Renderiza la cuadrícula de productos disponibles para la categoría actual durante la creación o edición de una lista.
     */
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
                    <img src="${item.img}" alt="${item.name}" class="w-full h-auto object-cover block">
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

    /**
     * Muestra el modal para configurar las opciones específicas (enlaces y cantidades) de un regalo seleccionado.
     */
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

    /**
     * Oculta el modal de configuración de regalo y limpia la selección actual temporal.
     */
    function closeGiftModal() {
        document.getElementById('modalGiftDetail').style.display = 'none';
        currentItemForModal = null;
    }

    /**
     * Confirma y guarda la configuración del regalo seleccionado en el listado activo.
     */
    function confirmAddGift() {
        if (!currentItemForModal) return;
        const id = currentItemForModal.id;
        const idx = selectedItems.findIndex(s => s.id === id);
        
        const itemData = {
            ...currentItemForModal,
            link1: document.getElementById('m_link1').value,
            link2: document.getElementById('m_link2').value,
            link3: document.getElementById('m_link3').value,
            qty:   parseInt(document.getElementById('m_qty').value) || 1,
            gifted: false
        };

        if (idx > -1) {
            selectedItems[idx] = itemData;
            showToast('¡Regalo actualizado en la lista!', 'success');
        } else {
            selectedItems.push(itemData);
            showToast('¡Regalo agregado a la lista!', 'success');
        }

        updateCounter();
        renderCreateGrid();
        closeGiftModal();
    }

    /**
     * Elimina un regalo específico del listado activo actualmente seleccionado.
     */
    function removeItem(id) {
        selectedItems = selectedItems.filter(s => s.id !== id);
        updateCounter();
        renderCreateGrid();
        showToast('Eliminado de la lista', 'warning');
    }

    /**
     * Calcula y actualiza el contador total de regalos seleccionados en la lista activa.
     */
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

    /**
     * Valida, procesa y guarda la lista de regalos completa enviando los datos al servidor.
     */
    function saveCurrentList() {
        const nameInput = document.getElementById('listNameInput');
        const name = nameInput ? nameInput.value.trim() : '';

        if (!name) {
            showToast('Ingresa un nombre para la lista.', 'error');
            return;
        }

        if (selectedItems.length === 0) {
            showToast('Selecciona al menos un regalo para tu lista.', 'error');
            return;
        }

        const regalosData = selectedItems.map(item => ({
            regalocatalogo: parseInt(item.id),
            qty: parseInt(item.qty) || 1,
            link_referencia: item.link1 || '',
            link_referencia_2: item.link2 || '',
            link_referencia_3: item.link3 || ''
        }));

        const payload = {
            nombre: name,
            descripcion: document.getElementById('listDescInput')?.value || '',
            evento_id: document.getElementById('listEventoInput')?.value || null,
            regalos: regalosData
        };

        const url = editingListId 
            ? `/listas-regalos/${editingListId}` 
            : '{{ route("listas-regalos.store") }}';
            
        const method = editingListId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify(payload)
        })
        .then(async response => {
            const text = await response.text(); 
            try {
                return JSON.parse(text); 
            } catch (e) {
                console.error("Error devuelto por Laravel en HTML:", text);
                throw new Error("El servidor no devolvió un JSON válido.");
            }
        })
        .then(data => {
            if (data.success) {
                showToast(editingListId ? '¡Lista actualizada!' : '¡Lista guardada!', 'success');
                window.location.reload();
            } else {
                showToast(data.message || 'Error al procesar la lista.', 'error');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            showToast('Ocurrió un error al guardar la lista.', 'error');
        });
    }

    /**
     * Cierra el modal de creación de un regalo personalizado de forma segura sin bloquear la UI.
     */
    function closeCreateGiftModal() {
        const inputNombre = document.getElementById('n_name');
        if (inputNombre) {
            const modal = inputNombre.closest('.fixed');
            if (modal) {
                modal.classList.add('hidden');
                modal.style.removeProperty('display');
            }
        }
    }

    /**
     * Envía la información de un regalo personalizado al servidor, lo agrega al catálogo y lo auto-selecciona.
     */
    function createNewGift() {
        const name = document.getElementById('n_name')?.value.trim();
        const cat = document.getElementById('n_cat')?.value;
        const desc = document.getElementById('n_desc')?.value.trim();

        if (!name) {
            showToast('Ingresa un nombre para el regalo.', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('nombre_regalo', name);
        formData.append('descripcion', desc || '');
        formData.append('categoria', cat || 'Ropa');
        formData.append('link_referencia', document.getElementById('giftLink1')?.value || '');
        formData.append('link_referencia_2', document.getElementById('giftLink2')?.value || '');
        formData.append('link_referencia_3', document.getElementById('giftLink3')?.value || '');
        formData.append('precio_estimado', document.getElementById('giftPrice')?.value || '');
        
        const userQty = parseInt(document.getElementById('giftQty')?.value) || 1;
        formData.append('cantidad_solicitada', userQty);

        const fileInput = document.getElementById('newGiftImgInput');
        if (fileInput && fileInput.files.length > 0) {
            formData.append('imagen_portada', fileInput.files[0]); 
        }

        fetch('{{ route("regalos.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: formData 
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('¡Regalo personalizado creado y seleccionado!', 'success');
                
                closeCreateGiftModal();
                
                const catFrontend = (cat === 'Grupal' || cat === 'Grupales') ? 'Grupales' : cat;
                
                let imagenFinal = data.gift.imagen_portada_url;
                if (imagenFinal && !/^https?:\/\//i.test(imagenFinal)) {
                    imagenFinal = '/storage/' + imagenFinal.replace(/^img\/regalos\//i, 'regalos/');
                } else if (!imagenFinal) {
                    imagenFinal = 'https://placehold.co/400x300/f1f5f9/94a3b8?text=Nuevo+Regalo';
                }

                const nuevoRegaloParaData = {
                    id: data.gift.id,
                    nombre: data.gift.nombre_regalo,
                    descripcion: data.gift.descripcion,
                    imagen_portada_url: data.gift.imagen_portada_url 
                };
                
                if (!dataCategorias[catFrontend]) dataCategorias[catFrontend] = [];
                dataCategorias[catFrontend].unshift(nuevoRegaloParaData);

                selectedItems.push({
                    id: data.gift.id,
                    name: data.gift.nombre_regalo,
                    category: catFrontend,
                    description: data.gift.descripcion,
                    img: imagenFinal,
                    link1: document.getElementById('giftLink1')?.value || '',
                    link2: document.getElementById('giftLink2')?.value || '',
                    link3: document.getElementById('giftLink3')?.value || '',
                    qty: userQty,
                    gifted: false
                });
                updateCounter();

                sincronizarGiftItems();
                filterCreateCategory(catFrontend);

                if (typeof filterCategory === 'function') {
                    filterCategory(catFrontend);
                }

                if (typeof renderCreateGrid === 'function') {
                    renderCreateGrid(); 
                }

                if(document.getElementById('n_name')) document.getElementById('n_name').value = '';
                if(document.getElementById('n_desc')) document.getElementById('n_desc').value = '';
                if(document.getElementById('giftPrice')) document.getElementById('giftPrice').value = '';
                if(document.getElementById('giftQty')) document.getElementById('giftQty').value = 1;
                if(document.getElementById('giftLink1')) document.getElementById('giftLink1').value = '';
                if(document.getElementById('giftLink2')) document.getElementById('giftLink2').value = '';
                if(document.getElementById('giftLink3')) document.getElementById('giftLink3').value = '';
                if(fileInput) fileInput.value = '';
                
                const preview = document.getElementById('newGiftPreview');
                if (preview) { preview.src = ''; preview.classList.add('hidden'); }
                document.getElementById('newGiftPlaceholder')?.classList.remove('hidden');

            } else {
                showToast(data.message || 'Error al crear el regalo.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error de conexión al crear el regalo.', 'error');
        });
    }

    /**
     * Renderiza la tabla visual de las listas de regalos previamente guardadas.
     */
    function renderSavedLists() {
        const body = document.getElementById('savedListsBody');
        const emptyRow = document.getElementById('emptyStateRow');
        if (!body) return;

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

    /**
     * Prepara la interfaz y carga los datos para editar una lista de regalos guardada.
     */
    function editList(id) {
        const list = savedLists.find(l => l.id === id);
        if (!list) return;

        editingListId = id;

        selectedItems = list.items.map(savedItem => {
            const catalogItem = giftItems.find(g => g.name === savedItem.name);
            return {
                ...savedItem,
                id: catalogItem ? catalogItem.id : savedItem.id 
            };
        });

        const nameInput = document.getElementById('listNameInput'); 
        if (nameInput) nameInput.value = list.name;

        const descInput = document.getElementById('listDescInput');
        if (descInput) descInput.value = list.description || '';

        const eventoSelect = document.getElementById('listEventoInput');
        if (eventoSelect) eventoSelect.value = list.evento_id || '';

        updateCounter();
        showView('create');

        if (selectedItems.length > 0) {
            filterCreateCategory(selectedItems[0].category);
        } else {
            filterCreateCategory('Ropa');
        }

        showToast('Modo edición activado', 'success');
    }

    /**
     * Elimina definitivamente una lista de regalos realizando una petición al servidor.
     */
    function deleteList(id) {
        if (!confirm('¿Estás seguro de que deseas eliminar esta lista de regalos por completo?')) return;

        fetch(`/listas-regalos/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                savedLists = savedLists.filter(l => l.id !== id);
                renderSavedLists();
                showToast('Lista eliminada de la base de datos.', 'warning');
            } else {
                showToast(data.message || 'No se pudo eliminar la lista.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error de conexión con el servidor.', 'error');
        });
    }

    /**
     * Abre el modal y muestra los detalles completos de todos los regalos en la lista guardada seleccionada.
     */
    function viewListDetail(id) {
        currentDetailListId = id;
        const list = savedLists.find(l => l.id === id);
        if (!list) return;

        const modalTitle = document.getElementById('viewListName');
        if (modalTitle) modalTitle.innerText = list.name;

        const grid = document.getElementById('viewListItemsGrid');
        if (grid) {
            grid.innerHTML = ''; 

            if (list.items.length === 0) {
                grid.innerHTML = `<div class="col-span-full text-center py-8 text-slate-400 italic">Esta lista no tiene regalos seleccionados.</div>`;
            } else {
                list.items.forEach(item => {
                    const itemCard = document.createElement('div');
                    itemCard.className = 'bg-slate-50 rounded-2xl p-4 border border-slate-100 flex flex-col justify-between';

                    const linksData = [item.link1, item.link2, item.link3].filter(l => l && l.trim() !== '');
                    const linksHtml = linksData.length > 0
                        ? `<div class="flex flex-col gap-1.5 mt-3">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Referencias</span>
                            ${linksData.map((link, idx) => `
                                <a href="${link}" target="_blank"
                                   class="flex items-center gap-1.5 text-xs font-bold text-cyan-600 hover:text-cyan-800 hover:underline truncate">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Link ${idx + 1}
                                </a>
                            `).join('')}
                        </div>`
                        : '';

                    itemCard.innerHTML = `
                        <div>
                            <img src="${item.img}" alt="${item.name}" class="w-full h-auto block rounded-xl mb-3">
                            <span class="text-[10px] font-bold text-cyan-600 uppercase tracking-widest">${item.category}</span>
                            <h4 class="font-bold text-slate-800 text-sm truncate mt-0.5">${item.name}</h4>
                            <p class="text-xs text-slate-400 line-clamp-2 mt-1">${item.description || 'Sin descripción'}</p>
                            ${linksHtml}
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Cant: ${item.qty}</span>
                            ${item.category === 'Grupales' ? `<span class="text-[10px] font-black text-rose-400 uppercase tracking-widest bg-rose-50 px-3 py-1 rounded-full border border-rose-100">Grupal</span>` : ''}
                        </div>
                    `;
                    grid.appendChild(itemCard);
                });
            }
        }

        const modal = document.getElementById('modalViewList');
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.display = 'block';
        }
    }

    /**
     * Oculta el modal de visualización de detalles de la lista.
     */
    function closeViewListModal() {
        const modal = document.getElementById('modalViewList');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    }

    /**
     * Muestra una notificación emergente con estilos personalizables según el tipo de alerta.
     */
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

    document.addEventListener('DOMContentLoaded', () => {
        
        document.getElementById('newGiftImgInput')?.addEventListener('change', function(e) {
            const preview = document.getElementById('newGiftPreview');
            const placeholder = document.getElementById('newGiftPlaceholder');
            const file = e.target.files[0];

            if (file && preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); 
                    if (placeholder) placeholder.classList.add('hidden'); 
                }
                reader.readAsDataURL(file);
            }
        });

        const listasRegalosData = @json($listasRegalos ?? []);
        if (listasRegalosData && listasRegalosData.length > 0) {
            listasRegalosData.forEach(lista => {
                const items = lista.regalos.map(regalo => {
                    let nombreCat = regalo.categoria ? regalo.categoria.nombre : 'Ropa';
                    if (nombreCat === 'Grupal') nombreCat = 'Grupales';

                    let imagenFinal = regalo.imagen_portada_url;
                    if (imagenFinal && !/^https?:\/\//i.test(imagenFinal)) {
                        imagenFinal = imagenFinal.replace(/^img\/regalos\//i, 'regalos/');
                        imagenFinal = '/storage/' + imagenFinal;
                    } else if (!imagenFinal) {
                        imagenFinal = 'https://placehold.co/400x300/f1f5f9/94a3b8?text=Regalo';
                    }

                    return {
                        id: regalo.id,
                        name: regalo.nombre_regalo,
                        category: nombreCat,
                        description: regalo.descripcion,
                        img: imagenFinal, 
                        link1: regalo.link_referencia,
                        link2: regalo.link_referencia_2,
                        link3: regalo.link_referencia_3,
                        qty: regalo.cantidad_solicitada || 1,
                        gifted: false
                    };
                });
                savedLists.push({
                    id: lista.id,
                    name: lista.nombre,
                    description: lista.descripcion,
                    items: items,
                    date: new Date(lista.created_at).toLocaleDateString('es-ES'),
                    evento_id: lista.evento_id,
                    estado: lista.estado
                });
            });
        }
        
        if (typeof renderSavedLists === 'function') renderSavedLists();
        sincronizarGiftItems(); 
        
        if (typeof filterCreateCategory === 'function') {
            filterCreateCategory(currentCreateCategory || 'Ropa');
        } else if (typeof renderCreateGrid === 'function') {
            renderCreateGrid(currentCreateCategory || 'Ropa');
        }
    });
</script>