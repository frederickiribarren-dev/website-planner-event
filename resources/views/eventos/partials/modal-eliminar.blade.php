<!-- Modal de Confirmación de Eliminación -->
<div id="deleteEventModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay con blur -->
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
            <div class="bg-white px-8 pt-10 pb-8 sm:p-10 sm:pb-8">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-3xl bg-red-50 sm:mx-0 sm:h-14 sm:w-14">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div class="mt-6 text-center sm:mt-0 sm:ml-6 sm:text-left">
                        <h3 class="text-xl font-black text-slate-800 leading-tight" id="modal-title-delete">¿Eliminar este evento permanentemente?</h3>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-slate-500 leading-relaxed">
                                Esta acción eliminará por completo el evento, la lista de invitados y toda la información asociada. <span class="text-red-600 font-bold uppercase tracking-widest text-[10px]">Esta acción no se puede deshacer</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50/50 px-8 py-6 sm:flex sm:flex-row-reverse sm:px-10 gap-3">
                <form id="confirmDeleteForm" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-red-600 px-8 py-4 text-xs font-black uppercase tracking-widest text-white shadow-lg shadow-red-200 hover:bg-red-700 transition-all focus:outline-none sm:w-auto">
                        Sí, eliminar permanentemente
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 inline-flex w-full justify-center rounded-2xl bg-white px-8 py-4 text-xs font-black uppercase tracking-widest text-slate-500 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all sm:mt-0 sm:w-auto">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteEventModal');
        const form = document.getElementById('confirmDeleteForm');
        form.action = actionUrl;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Evitar scroll
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteEventModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restaurar scroll
    }
</script>
