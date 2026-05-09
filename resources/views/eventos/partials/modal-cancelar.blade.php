
<!-- Modal de Confirmación de Cancelación -->
<div id="cancelEventModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay con blur -->
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
            <div class="bg-white px-8 pt-10 pb-8 sm:p-10 sm:pb-8">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-3xl bg-red-50 sm:mx-0 sm:h-14 sm:w-14">
                        <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="mt-6 text-center sm:mt-0 sm:ml-6 sm:text-left">
                        <h3 class="text-xl font-black text-slate-800 leading-tight" id="modal-title italic">¿Cancelar este evento?</h3>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-slate-500 leading-relaxed">
                                Estás a punto de cancelar este evento. El registro se mantendrá en tu historial pero cambiará su estado a <span class="text-red-500 font-bold uppercase tracking-widest text-[10px]">Cancelado</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50/50 px-8 py-6 sm:flex sm:flex-row-reverse sm:px-10 gap-3">
                <form id="confirmCancelForm" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-red-500 px-8 py-4 text-xs font-black uppercase tracking-widest text-white shadow-lg shadow-red-200 hover:bg-red-600 transition-all focus:outline-none sm:w-auto">
                        Sí, cancelar evento
                    </button>
                </form>
                <button type="button" onclick="closeCancelModal()" class="mt-3 inline-flex w-full justify-center rounded-2xl bg-white px-8 py-4 text-xs font-black uppercase tracking-widest text-slate-500 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all sm:mt-0 sm:w-auto">
                    No, mantenerlo
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openCancelModal(actionUrl) {
        const modal = document.getElementById('cancelEventModal');
        const form = document.getElementById('confirmCancelForm');
        form.action = actionUrl;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Evitar scroll
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelEventModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restaurar scroll
    }
</script>
