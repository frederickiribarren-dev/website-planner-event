<x-invitado-layout>
    {{-- Header Mesa Regalos --}}
    <div class="text-center mb-12 mt-12">
        <h2 class="text-3xl md:text-4xl font-black text-cyan-800 tracking-tight mb-4">Mesa de Regalos</h2>
        <p class="text-slate-500 font-medium max-w-xl mx-auto leading-relaxed">
            Ayúdanos a preparar la llegada de Emma. Aquí encontrarás algunas ideas que nos encantaría recibir, o puedes proponernos algo especial.
        </p>
    </div>

    {{-- Filtros --}}
    <div class="flex justify-center mb-12">
        <div class="flex bg-slate-100 p-1.5 rounded-full shadow-inner overflow-x-auto max-w-full">
            <button class="px-6 py-2.5 rounded-full text-sm font-bold bg-cyan-700 text-white shadow-md whitespace-nowrap">Todos</button>
            <button class="px-6 py-2.5 rounded-full text-sm font-bold text-slate-500 hover:text-slate-800 whitespace-nowrap">Utensilios</button>
            <button class="px-6 py-2.5 rounded-full text-sm font-bold text-slate-500 hover:text-slate-800 whitespace-nowrap">Ropa</button>
            <button class="px-6 py-2.5 rounded-full text-sm font-bold text-slate-500 hover:text-slate-800 whitespace-nowrap">Accesorios</button>
            <button class="px-6 py-2.5 rounded-full text-sm font-bold text-slate-500 hover:text-slate-800 whitespace-nowrap">Regalos grupales</button>
        </div>
    </div>

    {{-- Grid de Regalos --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        {{-- Item 1 --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="relative bg-slate-50 aspect-video overflow-hidden group">
                <img src="https://placehold.co/600x400/f8fafc/94a3b8?text=Esterilizador" alt="Esterilizador" class="w-full h-full object-cover">
                <button class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-300 hover:text-rose-500 shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </button>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h4 class="text-xl font-bold text-slate-800 mb-2">Esterilizador</h4>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6 flex-1">Esterilizador de biberones eléctrico, súper práctico para mantener todo limpio.</p>
                <button class="w-full bg-cyan-800 text-white font-bold text-xs uppercase tracking-widest py-4 rounded-xl hover:bg-cyan-900 transition-colors shadow-lg shadow-cyan-900/20">
                    Seleccionar
                </button>
            </div>
        </div>

        {{-- Item 2 --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="relative bg-slate-50 aspect-video overflow-hidden group">
                <img src="https://placehold.co/600x400/f8fafc/94a3b8?text=Set+de+Ropita" alt="Set de Ropita" class="w-full h-full object-cover">
                <button class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-300 hover:text-rose-500 shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </button>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h4 class="text-xl font-bold text-slate-800 mb-2">Set de Ropita</h4>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6 flex-1">Conjunto de algodón orgánico talla 0-3 meses, tonos pastel preferiblemente.</p>
                <button class="w-full bg-cyan-800 text-white font-bold text-xs uppercase tracking-widest py-4 rounded-xl hover:bg-cyan-900 transition-colors shadow-lg shadow-cyan-900/20">
                    Seleccionar
                </button>
            </div>
        </div>

        {{-- Item 3 (Grupal) --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative">
            <div class="absolute top-4 right-0 bg-rose-500 text-white text-[9px] font-black uppercase tracking-widest py-1.5 px-4 rounded-l-full shadow-md z-10">
                Regalo Grupal
            </div>
            <div class="relative bg-slate-50 aspect-video overflow-hidden group">
                <img src="https://placehold.co/600x400/f8fafc/94a3b8?text=Cuna+Colecho" alt="Cuna Colecho" class="w-full h-full object-cover">
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h4 class="text-xl font-bold text-slate-800 mb-2">Cuna Colecho</h4>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6 flex-1">Para tener a Emma cerquita durante sus primeros meses. Es una compra grande, así que decidimos hacerlo grupal.</p>
                <button class="w-full bg-rose-50 text-rose-600 border border-rose-200 font-bold text-xs uppercase tracking-widest py-4 rounded-xl hover:bg-rose-100 transition-colors">
                    Aportar a este regalo
                </button>
            </div>
        </div>

    </div>

</x-invitado-layout>
