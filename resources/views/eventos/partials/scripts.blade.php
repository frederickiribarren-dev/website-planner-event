    <script>
        @php
            $invitadosData = [];
            if (isset($evento) && $evento->invitados) {
                $invitadosData = $evento->invitados->map(function($inv) {
                    return [
                        'id' => $inv->id,
                        'name' => $inv->nombre,
                        'email' => $inv->email,
                        'phone' => $inv->telefono
                    ];
                })->values()->all();
            }
        @endphp
        let guests = @json($invitadosData);
        let currentPage = 1;
        const itemsPerPage = 6;
        let selectedImageUrl = '{{ isset($evento) && $evento->imagen_portada_url ? $evento->imagen_portada_url : "https://img.freepik.com/vector-premium/lindo-baby-shower-invitacion-bebe-nino-elefante_23-2148443916.jpg" }}';
        let availableLists = @json($listasInvitados ?? []);
        let availableGiftLists = @json($listasRegalos ?? []);
        let allTemplates = @json($plantillas ?? []);
        let customUploadedImage = null;
        let currentImagePage = 1;
        const imagesPerPage = 5; // 5 images + 1 upload button

        document.addEventListener('DOMContentLoaded', () => {
            const editor = document.getElementById('email_message_editor');
            const hiddenInput = document.getElementById('email_message');
            if (editor && hiddenInput) {
                editor.innerHTML = hiddenInput.value || '';
            }
            @if(isset($evento))
            // Actualizar invitados JSON con datos cargados
            serializeGuests();
            @endif
            renderGuests();
            renderImageGrid();
            updatePreview();
            updateSummary();
            syncImageUrl();
        });

        /**
         * Navega entre los diferentes pasos del formulario, actualizando la interfaz y validando datos si es necesario.
         */
        function goToStep(step) {
            if (step === 5) {
                serializeGuests();
                updateSummary();
            }

            document.querySelectorAll('.step-content').forEach(s => s.classList.add('hidden'));
            document.getElementById('step' + step).classList.remove('hidden');
            document.querySelectorAll('.step-indicator').forEach(indicator => {
                const stepNum = parseInt(indicator.dataset.step);
                const dot = indicator.querySelector('.step-dot');
                const label = indicator.querySelector('.step-label');
                const line = document.querySelector(`.step-line[data-step="${stepNum - 1}"]`);
                if (stepNum < step) {
                    dot.className = 'step-dot w-8 h-8 flex items-center justify-center rounded-full bg-cyan-700 text-white font-bold border-4 border-cyan-700 transition-all text-xs';
                    label.className = 'step-label text-[10px] mt-1 font-semibold text-cyan-700 transition-all uppercase tracking-tighter';
                    if(line) line.className = 'w-6 sm:w-8 h-1 bg-cyan-700 step-line transition-all';
                } else if (stepNum === step) {
                    dot.className = 'step-dot w-8 h-8 flex items-center justify-center rounded-full bg-cyan-700 text-white font-bold border-4 border-cyan-700 transition-all text-xs';
                    label.className = 'step-label text-[10px] mt-1 font-semibold text-cyan-700 transition-all uppercase tracking-tighter';
                    if(line) line.className = 'w-6 sm:w-8 h-1 bg-gray-200 step-line transition-all';
                } else {
                    dot.className = 'step-dot w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200 transition-all text-xs';
                    label.className = 'step-label text-[10px] mt-1 font-semibold text-gray-400 transition-all uppercase tracking-tighter';
                    if(line) line.className = 'w-6 sm:w-8 h-1 bg-gray-200 step-line transition-all';
                }
            });

            if (step === 4) {
                const babyName = document.getElementById('nombre_bebe').value || 'Leo';
                const previewTitle = document.getElementById('preview_title');
                if(previewTitle) previewTitle.innerHTML = `Baby Shower de <br><span class="italic text-[#427A79] font-medium">${babyName}</span>`;
            }

            if (step === 5) {
                updateSummary();
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        /**
         * Sincroniza la URL de la imagen seleccionada con el campo oculto del formulario.
         */
        function syncImageUrl() {
            const hiddenInput = document.getElementById('imagen_portada_url');
            if (hiddenInput) {
                hiddenInput.value = selectedImageUrl;
            }
        }

        /**
         * Renderiza la cuadrícula de imágenes disponibles para la portada, incluyendo la paginación.
         */
        function renderImageGrid() {
            const container = document.getElementById('image-grid-container');
            if (!container) return;
            
            container.innerHTML = '';

            container.innerHTML += `
                <div class="relative group h-48">
                    <label class="cursor-pointer h-full flex flex-col items-center justify-center gap-3 bg-cyan-50 border-2 border-dashed border-cyan-200 rounded-[2rem] hover:bg-cyan-100 transition-all">
                        <div class="w-10 h-10 bg-cyan-600 text-white rounded-full flex items-center justify-center shadow-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
                        <span class="text-xs font-bold text-cyan-700">Subir propia</span>
                        <input type="file" name="imagen_portada" id="custom_image" class="hidden" accept="image/*" onchange="previewSelectedImage(this)">
                    </label>
                </div>
            `;

            let displayTemplates = customUploadedImage ? [customUploadedImage, ...allTemplates] : allTemplates;
            
            const startIndex = (currentImagePage - 1) * imagesPerPage;
            const paginatedTemplates = displayTemplates.slice(startIndex, startIndex + imagesPerPage);

            paginatedTemplates.forEach((url, index) => {
                const isSelected = selectedImageUrl === url;
                
                const cardHtml = `
                    <div onclick="selectTemplate('${url}')" class="template-card relative h-48 rounded-[2rem] overflow-hidden cursor-pointer border-4 ${isSelected ? 'border-cyan-600 scale-[1.02]' : 'border-transparent hover:scale-[1.02]'} transition-all bg-gray-100">
                        <img src="${url}" class="w-full h-full object-cover" alt="Plantilla">
                        <div class="absolute inset-0 flex items-center justify-center bg-cyan-900/0 hover:bg-cyan-900/10 transition-all">
                            <div class="check-icon ${isSelected ? '' : 'opacity-0'} w-8 h-8 bg-cyan-600 text-white rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += cardHtml;
            });

            const totalPages = Math.ceil(displayTemplates.length / imagesPerPage);
            document.getElementById('image-pagination-info').innerText = `Página ${currentImagePage} de ${totalPages || 1}`;
            document.getElementById('btn-prev-image').disabled = currentImagePage <= 1;
            document.getElementById('btn-next-image').disabled = currentImagePage >= totalPages;
        }

        /**
         * Retrocede a la página anterior de imágenes disponibles.
         */
        function prevImagePage() {
            if (currentImagePage > 1) {
                currentImagePage--;
                renderImageGrid();
            }
        }

        /**
         * Avanza a la siguiente página de imágenes disponibles.
         */
        function nextImagePage() {
            let displayTemplates = customUploadedImage ? [customUploadedImage, ...allTemplates] : allTemplates;
            const totalPages = Math.ceil(displayTemplates.length / imagesPerPage);
            if (currentImagePage < totalPages) {
                currentImagePage++;
                renderImageGrid();
            }
        }

        /**
         * Selecciona una plantilla de imagen específica y actualiza las previsualizaciones.
         */
        function selectTemplate(url) {
            selectedImageUrl = url;
            syncImageUrl();
            renderImageGrid();
            if(document.getElementById('step3_preview_img')) document.getElementById('step3_preview_img').src = url;
            if(document.getElementById('mobile_preview_img')) document.getElementById('mobile_preview_img').src = url;
        }

        /**
         * Previsualiza y establece como seleccionada una imagen subida por el usuario.
         */
        function previewSelectedImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    customUploadedImage = e.target.result;
                    selectedImageUrl = customUploadedImage;
                    currentImagePage = 1;
                    syncImageUrl();
                    renderImageGrid();
                    
                    if(document.getElementById('step3_preview_img')) document.getElementById('step3_preview_img').src = selectedImageUrl;
                    if(document.getElementById('mobile_preview_img')) document.getElementById('mobile_preview_img').src = selectedImageUrl;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        /**
         * Muestra una notificación emergente tipo toast en la pantalla.
         */
        function showToast(message, type = 'warning') {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none max-w-sm w-full px-4 sm:px-0';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-gray-100 flex items-center justify-between gap-4 transition-all duration-300 transform translate-x-12 opacity-0';
            
            let borderClass = 'border-l-4 border-l-cyan-500';
            let iconBg = 'bg-cyan-50 text-cyan-600';
            let iconSvg = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

            if (type === 'warning') {
                borderClass = 'border-l-4 border-l-amber-500';
                iconBg = 'bg-amber-50 text-amber-600';
                iconSvg = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
            } else if (type === 'error') {
                borderClass = 'border-l-4 border-l-rose-500';
                iconBg = 'bg-rose-50 text-rose-600';
                iconSvg = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            } else if (type === 'success') {
                borderClass = 'border-l-4 border-l-emerald-500';
                iconBg = 'bg-emerald-50 text-emerald-600';
                iconSvg = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
            }

            toast.className += ' ' + borderClass;

            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl ${iconBg} flex items-center justify-center shrink-0">
                        ${iconSvg}
                    </div>
                    <div class="text-sm font-semibold text-gray-800">${escapeHtml(message)}</div>
                </div>
                <button type="button" class="close-toast-btn text-gray-400 hover:text-gray-600 transition-colors focus:outline-none shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-12', 'opacity-0');
            }, 10);

            const closeBtn = toast.querySelector('.close-toast-btn');
            const dismiss = () => {
                toast.classList.add('translate-x-12', 'opacity-0');
                toast.addEventListener('transitionend', () => {
                    toast.remove();
                });
            };
            
            if (closeBtn) {
                closeBtn.addEventListener('click', dismiss);
            }

            setTimeout(dismiss, 4000);
        }

        let loadedLists = [];

        /**
         * Carga una lista de invitados existente y agrega sus miembros a la lista actual.
         */
        function loadExistingList(listaId) {
            if (!listaId) return;

            if (loadedLists.includes(listaId)) {
                showToast('Esta lista ya ha sido agregada.', 'warning');
                document.getElementById('lista_invitado_id').value = '';
                return;
            }

            const lista = availableLists.find(l => l.id == listaId);
            if (lista && lista.invitados) {
                const newGuests = lista.invitados.map(inv => ({
                    id: Date.now() + Math.floor(Math.random() * 10000),
                    name: inv.nombre,
                    email: inv.email || '',
                    phone: inv.telefono || ''
                }));
                
                guests = guests.concat(newGuests);
                loadedLists.push(listaId);
                
                currentPage = 1;
                renderGuests();
                updateSummary();
                
                document.getElementById('lista_invitado_id').value = '';
            }
        }

        /**
         * Añade un nuevo invitado a la lista de forma manual validando sus campos.
         */
        function addGuest() {
            const name = document.getElementById('guest_name').value.trim();
            const email = document.getElementById('guest_email').value.trim();
            const phone = document.getElementById('guest_phone').value.trim();

            if (!name) {
                showToast('El nombre del invitado es obligatorio.', 'warning');
                return;
            }

            if (email && !validateEmail(email)) {
                showToast('El correo electrónico ingresado no es válido.', 'warning');
                return;
            }

            guests.unshift({ id: Date.now(), name, email, phone });
            document.getElementById('guest_name').value = '';
            document.getElementById('guest_email').value = '';
            document.getElementById('guest_phone').value = '';
            currentPage = 1;
            renderGuests();
            updateSummary();
        }

        /**
         * Valida que el formato del correo electrónico ingresado sea correcto.
         */
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        /**
         * Elimina un invitado específico de la lista utilizando su identificador.
         */
        function removeGuest(id) {
            guests = guests.filter(g => g.id !== id);
            currentPage = Math.max(1, Math.ceil((guests.length) / itemsPerPage));
            renderGuests();
            updateSummary();
        }

        /**
         * Renderiza la tabla de invitados de acuerdo a la página actual y actualiza la paginación.
         */
        function renderGuests() {
            const body = document.getElementById('guest-table-body');
            body.innerHTML = '';

            if (guests.length === 0) {
                body.innerHTML = '<tr><td colspan="4" class="px-8 py-10 text-center text-gray-400 text-sm">No hay invitados agregados</td></tr>';
            } else {
                const startIndex = (currentPage - 1) * itemsPerPage;
                const paginatedItems = guests.slice(startIndex, startIndex + itemsPerPage);
                paginatedItems.forEach(guest => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50/50 border-b border-gray-100';
                    row.innerHTML = `
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">${escapeHtml(guest.name)}</td>
                        <td class="px-6 py-4 text-xs text-gray-500">${guest.email || '---'}</td>
                        <td class="px-6 py-4 text-xs text-gray-600">${guest.phone || '---'}</td>
                        <td class="px-6 py-4 text-right">
                            <button type="button" onclick="removeGuest(${guest.id})" class="text-red-500 hover:text-red-700 text-xs font-bold transition-colors">
                                ✕ Eliminar
                            </button>
                        </td>
                    `;
                    body.appendChild(row);
                });
            }

            document.getElementById('guest-count').innerText = `${guests.length} ${guests.length === 1 ? 'Invitado' : 'Invitados'}`;
            document.getElementById('total-guests-label').innerText = guests.length;

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, guests.length);
            document.getElementById('pagination-info').innerText = guests.length > 0 ? `${startIndex + 1}-${endIndex}` : '0-0';

            document.getElementById('btn-prev').disabled = currentPage <= 1;
            document.getElementById('btn-next').disabled = currentPage >= Math.ceil(guests.length / itemsPerPage);
        }

        /**
         * Retrocede a la página anterior en la tabla de invitados.
         */
        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderGuests();
            }
        }

        /**
         * Avanza a la siguiente página en la tabla de invitados.
         */
        function nextPage() {
            const totalPages = Math.ceil(guests.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderGuests();
            }
        }

        /**
         * Convierte la lista de invitados a formato JSON para enviarla con el formulario.
         */
        function serializeGuests() {
            syncImageUrl();
            document.getElementById('invitados_json').value = JSON.stringify(guests);
        }

        /**
         * Actualiza el resumen final del evento con todos los datos recolectados.
         */
        function updateSummary() {
            const summaryCount = document.getElementById('summary-guest-count');
            if (summaryCount) {
                summaryCount.innerText = `${guests.length} ${guests.length === 1 ? 'Invitado' : 'Invitados'}`;
            }

            const selectedGift = document.getElementById('lista_regalos_id');
            const giftSummary = document.getElementById('summary-gift-list');
            if (giftSummary) {
                const selectedOption = selectedGift ? selectedGift.options[selectedGift.selectedIndex] : null;
                if (selectedOption && selectedOption.value) {
                    giftSummary.innerHTML = `Lista seleccionada: <span class="font-bold text-gray-700">${selectedOption.text}</span>`;
                } else {
                    giftSummary.innerHTML = 'Lista seleccionada: <span class="font-bold text-gray-700">Sin lista asignada</span>';
                }
            }

            if (document.getElementById('preview-subject-final')) {
                const subject = document.getElementById('email_subject').value;
                document.getElementById('preview-subject-final').innerText = subject || '¡Estás invitado al Baby Shower!';
            }

            if (document.getElementById('final_preview_message')) {
                const message = document.getElementById('email_message').value;
                document.getElementById('final_preview_message').innerHTML = message || 'Estamos muy emocionados de compartir este momento tan especial contigo. Acompáñanos a celebrar la llegada de nuestro pequeño.';
            }

            if (document.getElementById('final_preview_title')) {
                const babyName = document.getElementById('nombre_bebe').value || 'Leo';
                document.getElementById('final_preview_title').innerHTML = `Baby Shower de <br><span class="italic text-[#427A79] font-medium">${babyName}</span>`;
            }

            if (document.getElementById('final_preview_date')) {
                const dateValue = document.getElementById('fecha_evento').value;
                document.getElementById('final_preview_date').innerText = dateValue ? formatEventDate(dateValue) : 'Fecha por definir';
            }

            if (document.getElementById('final_preview_location')) {
                const location = document.getElementById('ubicacion_nombre')?.value;
                document.getElementById('final_preview_location').innerText = location ? location : 'Lugar por definir';
            }

            if (document.getElementById('final_preview_img')) {
                document.getElementById('final_preview_img').src = selectedImageUrl;
            }
        }

        /**
         * Formatea la fecha seleccionada a un formato local en español legible.
         */
        function formatEventDate(dateValue) {
            try {
                const date = new Date(dateValue + 'T00:00:00');
                return new Intl.DateTimeFormat('es-ES', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(date);
            } catch (e) {
                return 'Fecha por definir';
            }
        }

        /**
         * Escapa caracteres especiales de HTML para evitar inyecciones XSS.
         */
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        /**
         * Actualiza la previsualización del asunto y cuerpo del mensaje.
         */
        function updatePreview() {
            const subject = document.getElementById('email_subject').value;
            const message = document.getElementById('email_message').value;
            if(document.getElementById('preview_subject')) document.getElementById('preview_subject').innerText = subject || '¡Estás invitado!';
            if(document.getElementById('preview_message')) document.getElementById('preview_message').innerHTML = message || 'Nos llena de alegría invitarte...';
            updateSummary();
        }

        /**
         * Aplica un formato de texto específico al editor visual y sincroniza el contenido.
         */
        function formatText(command) {
            document.execCommand(command, false, null);
            const editor = document.getElementById('email_message_editor');
            if (editor) {
                editor.focus();
                syncEditorContent();
            }
        }

        /**
         * Sincroniza el contenido del editor visual con el campo oculto del formulario.
         */
        function syncEditorContent() {
            const editor = document.getElementById('email_message_editor');
            const hiddenInput = document.getElementById('email_message');
            if (editor && hiddenInput) {
                if (editor.innerText.trim() === '') {
                    editor.innerHTML = '';
                }
                hiddenInput.value = editor.innerHTML;
                updatePreview();
            }
        }

        /**
         * Prepara y serializa los datos de los invitados antes de enviar el formulario.
         */
        document.getElementById('multiStepForm')?.addEventListener('submit', function(e) {
            serializeGuests();
        });
    </script>
