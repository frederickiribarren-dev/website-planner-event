<!-- Modal de Confirmación de Envío -->
<div id="confirmSendModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay con blur -->
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
            <div class="bg-white px-8 pt-10 pb-8 sm:p-10 sm:pb-8">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-3xl bg-cyan-50 sm:mx-0 sm:h-14 sm:w-14">
                        <svg class="h-8 w-8 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="mt-6 text-center sm:mt-0 sm:ml-6 sm:text-left">
                        <h3 class="text-xl font-black text-slate-800 leading-tight">Confirmación de Envío</h3>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-slate-500 leading-relaxed">
                                Selecciona cómo deseas continuar. Puedes guardar este evento en tus invitaciones como un <strong>Borrador</strong> para seguir editándolo más tarde, o proceder a <strong>Enviar</strong>.
                            </p>
                            <p class="text-xs font-semibold text-cyan-700/80 mt-3 italic bg-cyan-50/50 p-3 rounded-xl border border-cyan-100/50">
                                * Nota: Al presionar "Enviar", el evento se mantendrá como Borrador temporalmente hasta que se implemente la lógica definitiva de envío de correos.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50/50 px-8 py-6 sm:flex sm:flex-row-reverse sm:px-10 gap-3">
                <button type="button" onclick="submitFormWithStatus('Borrador')" class="inline-flex w-full justify-center rounded-2xl bg-cyan-800 px-6 py-4 text-xs font-black uppercase tracking-widest text-white shadow-lg shadow-cyan-900/10 hover:bg-cyan-900 transition-all focus:outline-none sm:w-auto">
                    Enviar
                </button>
                <button type="button" onclick="submitFormWithStatus('Borrador')" class="inline-flex w-full justify-center rounded-2xl bg-slate-200 px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-700 hover:bg-slate-300 transition-all focus:outline-none sm:w-auto">
                    Borrador
                </button>
                <button type="button" onclick="closeSendModal()" class="mt-3 inline-flex w-full justify-center rounded-2xl bg-white px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-400 border border-slate-200 hover:bg-slate-50 transition-all sm:mt-0 sm:w-auto">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openSendModal() {
        const modal = document.getElementById('confirmSendModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSendModal() {
        const modal = document.getElementById('confirmSendModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function submitFormWithStatus(status) {
        const statusInput = document.getElementById('estado_input');
        if (statusInput) {
            statusInput.value = status;
        }
        
        // Ejecutar envío del formulario
        const form = document.getElementById('multiStepForm');
        if (form) {
            form.submit();
        }
    }
</script>
