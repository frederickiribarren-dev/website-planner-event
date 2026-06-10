<!-- MODAL IMPORTAR LISTA -->
<div id="modalImport" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500/50 transition-opacity" onclick="closeModal('modalImport')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="relative z-10 inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-6 py-8 bg-white">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Importar Lista</h3>
                    <button onclick="closeModal('modalImport')" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-5">
                    <!-- Zona de carga -->
                    <label for="importFileInput" class="block p-8 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 flex flex-col items-center justify-center hover:border-emerald-500 hover:bg-emerald-50 transition-all cursor-pointer">
                        <input id="importFileInput" type="file" class="sr-only" accept=".xlsx,.xls,.csv,.ods">
                        <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <p class="font-bold text-slate-800">Haz clic para seleccionar el archivo</p>
                        <p id="importFileName" class="text-sm text-slate-500 mt-1">Soporta .xlsx .xls .csv .ods</p>
                    </label>

                    <!-- Mensaje de estado -->
                    <div id="importStatusMsg" class="hidden p-3 rounded-xl text-sm font-medium text-center"></div>

                    <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl text-xs text-amber-800 leading-relaxed">
                        <strong>Formato sin encabezados:</strong> Columna A = Nombre, B = Email, C = Teléfono.<br>
                        <strong>Con encabezados:</strong> Primera fila con "Nombre", "Email", "Teléfono".
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('modalImport')"
                                class="flex-1 px-4 py-3 rounded-xl font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Cancelar
                        </button>
                        <button type="button" id="btnProcesar" onclick="processImportFile()"
                                class="flex-1 px-4 py-3 rounded-xl font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-lg">
                            Procesar Archivo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VER DETALLE LISTA INVITADOS -->
<div id="modalVerListaDetalle" class="fixed inset-0 z-50 overflow-y-auto" style="display:none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="cerrarVerListaDetalle()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="relative z-10 inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full border border-slate-100">
            <div class="bg-white px-8 py-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter" id="detalleListaNombre">Lista</h3>
                    <button onclick="cerrarVerListaDetalle()" class="p-2 bg-slate-50 text-slate-400 hover:text-slate-600 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100">
                    <span class="text-4xl font-black text-cyan-700" id="detalleListaCount">0</span>
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mt-2">Invitados en esta lista</p>
                </div>
                <div class="mt-6 flex gap-3">
                    <button onclick="cerrarVerListaDetalle()" class="flex-1 px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all text-xs uppercase tracking-widest">Cerrar</button>
                    <a id="detalleListaEditarLink" href="#" class="flex-1 text-center px-6 py-3 bg-cyan-700 text-white font-bold rounded-2xl hover:bg-cyan-800 transition-all text-xs uppercase tracking-widest">Ver completa</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    // Guardar referencia al archivo seleccionado
    var _importFile = null;

    // Usar label+input sr-only → más compatible en Linux
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById('importFileInput');
        if (!input) return;
        input.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            _importFile = file;
            var label = document.getElementById('importFileName');
            if (label) label.innerText = '✓ ' + file.name;
            showImportStatus('Archivo listo: ' + file.name + ' (' + Math.round(file.size/1024) + ' KB)', 'ok');
        });
    });

    function showImportStatus(msg, type) {
        var el = document.getElementById('importStatusMsg');
        if (!el) return;
        el.className = 'p-3 rounded-xl text-sm font-medium text-center ';
        el.className += type === 'ok'  ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' :
                        type === 'err' ? 'bg-red-50 text-red-700 border border-red-200' :
                                         'bg-slate-50 text-slate-600 border border-slate-200';
        el.innerText = msg;
        el.classList.remove('hidden');
    }

    // Exponer globalmente
    window.processImportFile = function () {
        if (!_importFile) {
            showImportStatus('Primero selecciona un archivo.', 'err');
            return;
        }

        // Verificar que XLSX esté disponible
        if (typeof XLSX === 'undefined') {
            showImportStatus('Cargando librería... espera 2 segundos e intenta de nuevo.', 'err');
            return;
        }

        showImportStatus('Procesando...', 'info');

        var reader = new FileReader();
        reader.onload = function (e) {
            try {
                var data    = new Uint8Array(e.target.result);
                var wb      = XLSX.read(data, { type: 'array' });
                var sheet   = wb.Sheets[wb.SheetNames[0]];
                var rows    = XLSX.utils.sheet_to_json(sheet, { header: 1, defval: '' });

                if (!rows || rows.length < 1) {
                    showImportStatus('El archivo está vacío.', 'err');
                    return;
                }

                // Detectar si hay encabezados
                var firstRow = rows[0].map(function(h){ return String(h).toLowerCase().trim(); });
                var hasHdr = firstRow.some(function(h){
                    return h.includes('nombre') || h === 'name' ||
                           h.includes('email')  || h.includes('correo') ||
                           h.includes('tel')    || h.includes('fono') || h.includes('phone');
                });

                var nameIdx, emailIdx, phoneIdx, startRow;
                if (hasHdr) {
                    nameIdx  = firstRow.findIndex(function(h){ return h.includes('nombre') || h === 'name'; });
                    emailIdx = firstRow.findIndex(function(h){ return h.includes('email')  || h.includes('correo'); });
                    phoneIdx = firstRow.findIndex(function(h){ return h.includes('tel')    || h.includes('fono') || h.includes('phone'); });
                    startRow = 1;
                    if (nameIdx === -1) {
                        showImportStatus('No se encontró columna "Nombre" en los encabezados.', 'err');
                        return;
                    }
                } else {
                    // Sin encabezados: A=Nombre, B=Email, C=Teléfono
                    nameIdx  = 0;
                    emailIdx = 1;
                    phoneIdx = 2;
                    startRow = 0;
                }

                var added = 0;
                for (var i = startRow; i < rows.length; i++) {
                    var row = rows[i];
                    if (!row || row.every(function(c){ return String(c).trim() === ''; })) continue;
                    var name  = String(row[nameIdx]  || '').trim();
                    var email = emailIdx >= 0 ? String(row[emailIdx] || '').trim() : '';
                    var phone = phoneIdx >= 0 ? String(row[phoneIdx] || '').trim() : '';
                    if (!name) continue;

                    // tempGuests es global en creacion-invitacion.blade.php
                    if (typeof tempGuests !== 'undefined') {
                        tempGuests.push({ id: Date.now() + Math.random(), name: name, email: email, phone: phone, contact: email || phone || '---' });
                    }
                    added++;
                }

                _importFile = null;
                document.getElementById('importFileName').innerText = 'Soporta .xlsx .xls .csv .ods';
                document.getElementById('importStatusMsg').classList.add('hidden');

                if (added > 0) {
                    closeModal('modalImport');
                    if (typeof renderTempGuests !== 'undefined') renderTempGuests();
                    if (typeof showView !== 'undefined') showView('create');
                } else {
                    showImportStatus('No se encontraron filas con datos. Revisa el archivo.', 'err');
                }

            } catch (err) {
                showImportStatus('Error al procesar: ' + err.message, 'err');
                console.error('Import error:', err);
            }
        };

        reader.onerror = function() {
            showImportStatus('No se pudo leer el archivo.', 'err');
        };

        reader.readAsArrayBuffer(_importFile);
    };

    // ─── VER DETALLE LISTA ────────────────────────────────────────────────
    window.verListaDetalle = function(listaId, listaNombre, totalInvitados) {
        document.getElementById('detalleListaNombre').innerText = listaNombre;
        document.getElementById('detalleListaCount').innerText  = totalInvitados;
        var link = document.getElementById('detalleListaEditarLink');
        if (link) link.href = '/listas-invitados/' + listaId;
        document.getElementById('modalVerListaDetalle').style.display = 'block';
    };

    window.cerrarVerListaDetalle = function() {
        document.getElementById('modalVerListaDetalle').style.display = 'none';
    };
})();
</script>
