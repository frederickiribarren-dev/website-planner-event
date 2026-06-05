    <script>
        let guests = [];
        let currentPage = 1;
        const itemsPerPage = 5;
        let selectedImageUrl = 'https://img.freepik.com/vector-premium/lindo-baby-shower-invitacion-bebe-nino-elefante_23-2148443916.jpg';

        function goToStep(step) {
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
                const summaryCount = document.getElementById('summary-guest-count');
                const previewToCount = document.getElementById('preview-to-count');
                if (summaryCount) {
                    const txt = guests.length + (guests.length === 1 ? ' Invitado' : ' Invitados');
                    summaryCount.innerText = txt;
                    if(previewToCount) previewToCount.innerText = `Lista de Invitados (${guests.length})`;
                }
                
                // Actualizar datos de la vista previa final
                const babyName = document.getElementById('nombre_bebe').value || 'Leo';
                const finalPreviewTitle = document.getElementById('final_preview_title');
                if(finalPreviewTitle) finalPreviewTitle.innerHTML = `Baby Shower de <br><span class="italic text-[#427A79] font-medium">${babyName}</span>`;
                
                const subject = document.getElementById('email_subject') ? document.getElementById('email_subject').value : null;
                const finalSubject = subject || `¡Estás invitado al Baby Shower de ${babyName}!`;
                if(document.getElementById('preview-subject-final')) document.getElementById('preview-subject-final').innerText = finalSubject;
                
                const message = document.getElementById('email_message') ? document.getElementById('email_message').value : null;
                const finalMessage = message || 'Estamos muy emocionados de compartir este momento tan especial contigo. Acompáñanos a celebrar la llegada de nuestro pequeño.';
                if(document.getElementById('final_preview_message')) document.getElementById('final_preview_message').innerText = finalMessage;
                
                const date = document.getElementById('fecha_evento').value || 'Fecha por definir';
                if(document.getElementById('final_preview_date')) document.getElementById('final_preview_date').innerText = date;
                
                const location = document.getElementById('direcion_evento').value || 'Lugar por definir';
                if(document.getElementById('final_preview_location')) document.getElementById('final_preview_location').innerText = location;
                
                if(document.getElementById('final_preview_img')) {
                    document.getElementById('final_preview_img').src = selectedImageUrl;
                }
            }
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function selectTemplate(url, index) {
            selectedImageUrl = url;
            document.querySelectorAll('.template-card').forEach(c => c.classList.remove('border-cyan-600', 'scale-[1.02]'));
            document.querySelectorAll('.check-icon').forEach(i => i.classList.add('opacity-0'));
            const cards = document.querySelectorAll('.template-card');
            cards[index].classList.add('border-cyan-600', 'scale-[1.02]');
            cards[index].querySelector('.check-icon').classList.remove('opacity-0');
            if(document.getElementById('step3_preview_img')) document.getElementById('step3_preview_img').src = url;
            if(document.getElementById('mobile_preview_img')) document.getElementById('mobile_preview_img').src = url;
        }

        function previewSelectedImage(input, type) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    selectedImageUrl = e.target.result;
                    if(document.getElementById('step3_preview_img')) document.getElementById('step3_preview_img').src = selectedImageUrl;
                    if(document.getElementById('mobile_preview_img')) document.getElementById('mobile_preview_img').src = selectedImageUrl;
                    document.querySelectorAll('.template-card').forEach(c => c.classList.remove('border-cyan-600', 'scale-[1.02]'));
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function addGuest() {
            const name = document.getElementById('guest_name').value;
            const email = document.getElementById('guest_email').value;
            const phone = document.getElementById('guest_phone').value;
            if (!name) return alert('El nombre es obligatorio');
            guests.unshift({ id: Date.now(), name, email, phone });
            document.getElementById('guest_name').value = '';
            document.getElementById('guest_email').value = '';
            document.getElementById('guest_phone').value = '';
            currentPage = 1;
            renderGuests();
        }

        function removeGuest(id) {
            guests = guests.filter(g => g.id !== id);
            renderGuests();
        }

        function renderGuests() {
            const body = document.getElementById('guest-table-body');
            body.innerHTML = '';
            const startIndex = (currentPage - 1) * itemsPerPage;
            const paginatedItems = guests.slice(startIndex, startIndex + itemsPerPage);
            paginatedItems.forEach(guest => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50/50';
                row.innerHTML = `<td class="px-8 py-5 text-sm font-bold text-gray-800">${guest.name}</td><td class="px-8 py-5 text-xs text-gray-500">${guest.email || '---'}</td><td class="px-8 py-5 text-xs text-gray-600">${guest.phone || '---'}</td><td class="px-8 py-5 text-right"><button type="button" onclick="removeGuest(${guest.id})" class="text-gray-300 hover:text-red-500">Eliminar</button></td>`;
                body.appendChild(row);
            });
            document.getElementById('guest-count').innerText = `${guests.length} Añadidos`;
            document.getElementById('total-guests-label').innerText = guests.length;
            document.getElementById('pagination-info').innerText = `${startIndex + 1}-${Math.min(startIndex + itemsPerPage, guests.length)}`;
        }

        function prevPage() { if (currentPage > 1) { currentPage--; renderGuests(); } }
        function nextPage() { if (currentPage < Math.ceil(guests.length / itemsPerPage)) { currentPage++; renderGuests(); } }

        function loadPrebuiltList(type) {
            const data = {
                familia: [{ id: 1, name: 'Tía Carmen', email: 'c@f.com', phone: '123' }, { id: 2, name: 'Abuela María', email: '', phone: '456' }],
                amigos: [{ id: 3, name: 'Carlos Ruiz', email: 'c@r.com', phone: '789' }]
            };
            guests = [...guests, ...(data[type] || [])];
            renderGuests();
        }

        function updatePreview() {
            const subject = document.getElementById('email_subject').value;
            const message = document.getElementById('email_message').value;
            if(document.getElementById('preview_subject')) document.getElementById('preview_subject').innerText = subject || '¡Estás invitado!';
            if(document.getElementById('preview_message')) document.getElementById('preview_message').innerText = message || 'Nos llena de alegría invitarte...';
        }
    </script>
