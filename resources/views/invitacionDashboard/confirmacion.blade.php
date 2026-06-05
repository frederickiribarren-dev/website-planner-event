<x-invitado-layout>
    {{-- Header Central --}}
    <div class="text-center mb-12 mt-12">
        <h2 class="text-3xl md:text-4xl font-black text-cyan-800 tracking-tight mb-4">Confirmación — Fiesta de Emma</h2>
        <p class="text-slate-500 font-medium max-w-xl mx-auto leading-relaxed">
            Estamos emocionados de compartir este momento contigo. Por favor, ayúdanos a organizarnos confirmando tu asistencia y eligiendo un detalle.
        </p>
    </div>

    {{-- Grid de Tarjetas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        {{-- Tarjeta 1: Regalo --}}
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-rose-50 to-orange-50 rounded-[2.5rem] p-8 border border-rose-100 shadow-sm relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        <h3 class="text-xl font-black text-slate-800">Elección de Regalo</h3>
                    </div>
                    <p class="text-sm text-slate-600 mb-8 font-medium leading-relaxed">Puedes elegir algo de nuestra lista cuidadosamente seleccionada o sorprendernos con tu propia idea.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('invitado.regalos') }}" class="flex-1 bg-cyan-800 text-white text-xs font-bold uppercase tracking-widest rounded-2xl py-4 px-4 text-center hover:bg-cyan-900 transition-colors shadow-lg shadow-cyan-900/20">
                            Regalos propuestos
                        </a>
                        <button onclick="openProponerModal()" class="flex-1 bg-white text-rose-500 border border-rose-200 text-xs font-bold uppercase tracking-widest rounded-2xl py-4 px-4 text-center hover:bg-rose-50 transition-colors">
                            Proponer regalo
                        </button>
                    </div>
                </div>
            </div>

            {{-- Estado del Regalo --}}
            <div class="bg-white rounded-[2.5rem] p-8 border border-dashed border-slate-200 text-center shadow-sm">
                <div class="w-10 h-10 bg-slate-100 text-slate-400 rounded-full mx-auto flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Estado actual</p>
                <h4 class="text-lg font-bold text-slate-800 mb-4">Regalo aún no escogido</h4>
                <a href="{{ route('invitado.regalos') }}" class="text-sm font-bold text-cyan-600 hover:text-cyan-700 hover:underline">Ir a Mesa de regalo</a>
            </div>
        </div>

        {{-- Tarjeta 2: Asistencia --}}
        <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <h3 class="text-xl font-black text-slate-800">Confirmar Asistencia</h3>
            </div>
            <p class="text-sm text-slate-500 mb-8 font-medium">¿Nos acompañarás en este día especial?</p>

            {{-- Radio Buttons Asistencia --}}
            <div class="flex bg-slate-50 p-1 rounded-2xl mb-10 border border-slate-100">
                <label class="flex-1 text-center cursor-pointer relative">
                    <input type="radio" name="asistencia" value="yes" class="peer sr-only" checked>
                    <div class="py-3 px-4 rounded-xl text-sm font-bold text-slate-500 peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Asistir
                    </div>
                </label>
                <label class="flex-1 text-center cursor-pointer relative">
                    <input type="radio" name="asistencia" value="no" class="peer sr-only">
                    <div class="py-3 px-4 rounded-xl text-sm font-bold text-slate-500 peer-checked:bg-white peer-checked:text-red-500 peer-checked:shadow-sm transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        No asistir
                    </div>
                </label>
            </div>

            {{-- Contador Asistentes --}}
            <div class="mb-12">
                <label class="block text-xs font-bold text-slate-500 mb-4">Número de asistentes (incluyéndote)</label>
                <div class="flex items-center justify-between bg-slate-50 rounded-2xl p-2 border border-slate-100">
                    <button class="w-12 h-12 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-white transition-all bg-transparent font-bold text-xl">
                        -
                    </button>
                    <span class="text-2xl font-black text-slate-800 w-16 text-center">2</span>
                    <button class="w-12 h-12 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-white transition-all bg-transparent font-bold text-xl shadow-sm bg-white">
                        +
                    </button>
                </div>
            </div>

            <button class="w-full bg-cyan-800 text-white font-bold text-sm uppercase tracking-widest py-5 rounded-2xl hover:bg-cyan-900 transition-colors shadow-xl shadow-cyan-900/20 flex items-center justify-center gap-2">
                Confirmar asistencia
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </button>
        </div>
    </div>

    {{-- Modal Proponer Regalo --}}
    <div id="modalProponer" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeProponerModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="relative z-10 inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                <div class="bg-white px-8 py-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Proponer un Regalo</h3>
                        <button onclick="closeProponerModal()" class="p-2 bg-slate-50 text-slate-400 hover:text-slate-600 rounded-full transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <p class="text-sm text-slate-500 mb-6 font-medium">Si tienes algo especial en mente que no está en la lista, ¡cuéntanos de qué se trata!</p>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Título del regalo</label>
                            <input type="text" placeholder="Ej. Sesión fotográfica para el bebé" class="w-full px-5 py-4 rounded-2xl border-none bg-slate-50 focus:ring-2 focus:ring-rose-500 transition-all text-sm font-medium text-slate-800 shadow-inner">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Descripción o Enlace (Opcional)</label>
                            <textarea rows="3" placeholder="Añade detalles o un link para que sepamos exactamente qué es..." class="w-full px-5 py-4 rounded-2xl border-none bg-slate-50 focus:ring-2 focus:ring-rose-500 transition-all text-sm font-medium text-slate-800 shadow-inner resize-none"></textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-8">
                        <button onclick="closeProponerModal()" class="flex-1 px-4 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all uppercase tracking-widest text-[11px]">Cancelar</button>
                        <button onclick="submitPropuesta()" class="flex-1 px-4 py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/30 uppercase tracking-widest text-[11px]">Enviar Propuesta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Toast Notification --}}
    <div id="customToast" class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-300 z-50 pointer-events-none flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl border bg-emerald-600 border-emerald-500 text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span class="text-sm font-bold tracking-wide">¡Propuesta enviada con éxito!</span>
    </div>

    <script>
        function openProponerModal() {
            document.getElementById('modalProponer').style.display = 'block';
        }
        function closeProponerModal() {
            document.getElementById('modalProponer').style.display = 'none';
        }
        function submitPropuesta() {
            closeProponerModal();
            // Show custom toast
            const toast = document.getElementById('customToast');
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }
    </script>
</x-invitado-layout>
