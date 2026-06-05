<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 id="view-title" class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ __('Lista de Regalos') }}
                </h2>
                <p id="view-subtitle" class="text-slate-600 font-medium mt-1">Gestiona los regalos que tus invitados pueden elegir.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button id="btn-toggle-view" onclick="showView('catalogo')"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-full text-xs font-bold transition-all transform active:scale-95 bg-white border border-slate-200 text-slate-500 hover:text-cyan-600 hover:border-cyan-200 gap-2 shadow-sm uppercase tracking-widest">
                    <span id="btn-toggle-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </span>
                    <span id="btn-toggle-text">Ver catálogo</span>
                </button>
                <button id="btn-action" onclick="showView('create')"
                    class="inline-flex items-center justify-center px-8 py-3 rounded-full text-xs font-bold transition-all transform active:scale-95 bg-cyan-700 text-white hover:bg-cyan-800 gap-2 shadow-lg shadow-cyan-900/20 uppercase tracking-widest">
                    <span id="btn-action-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></span>
                    <span id="btn-action-text">Añadir lista</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- VISTA 1: LISTAS GUARDADAS (Principal) --}}
        <div id="view-lists" class="view-content space-y-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre de la Lista</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Productos</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Fecha</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="savedListsBody" class="divide-y divide-slate-50">
                            <tr id="emptyStateRow">
                                <td colspan="4" class="px-8 py-10 text-center text-slate-500">
                                    Aún no tienes listas de regalos.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- VISTA 2: CATÁLOGO DE REGALOS --}}
        <div id="view-catalogo" class="view-content hidden space-y-8">
            {{-- Filtros de Categoría --}}
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex bg-white p-1 rounded-2xl border border-slate-100 shadow-sm overflow-x-auto h-[48px]">
                    <button onclick="filterCategory('Ropa')" class="category-btn px-6 py-2 rounded-xl text-sm font-bold transition-all whitespace-nowrap bg-cyan-700 text-white">Ropa</button>
                    <button onclick="filterCategory('Utensilios')" class="category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Utensilios</button>
                    <button onclick="filterCategory('Accesorios')" class="category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Accesorios</button>
                    <button onclick="filterCategory('Grupales')" class="category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Grupales</button>
                </div>
            </div>

            {{-- Grid de Productos --}}
            <div id="catalogoGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Inyectado por JS --}}
            </div>
        </div>

        {{-- VISTA 3: CREACIÓN DE LISTA --}}
        <div id="view-create" class="view-content hidden space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                {{-- Panel de configuración --}}
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3">Nombre de la Lista</label>
                            <input type="text" id="listNameInput" placeholder="Ej. Regalos Baby Shower"
                                class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 transition text-sm font-medium text-slate-700">
                        </div>

                        <div class="pt-4 border-t border-slate-50">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">Filtrar catálogo por categoría</p>
                            <div class="flex flex-col gap-2">
                                <button onclick="filterCreateCategory('Ropa')" class="create-cat-btn px-4 py-3 rounded-2xl text-sm font-bold transition-all text-left bg-cyan-700 text-white">Ropa</button>
                                <button onclick="filterCreateCategory('Utensilios')" class="create-cat-btn px-4 py-3 rounded-2xl text-sm font-bold transition-all text-left text-slate-500 hover:bg-slate-50">Utensilios</button>
                                <button onclick="filterCreateCategory('Accesorios')" class="create-cat-btn px-4 py-3 rounded-2xl text-sm font-bold transition-all text-left text-slate-500 hover:bg-slate-50">Accesorios</button>
                                <button onclick="filterCreateCategory('Grupales')" class="create-cat-btn px-4 py-3 rounded-2xl text-sm font-bold transition-all text-left text-slate-500 hover:bg-slate-50">Grupales</button>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Seleccionados</span>
                            <span id="selectedCount" class="px-4 py-1 bg-cyan-50 text-cyan-700 rounded-full text-xs font-black">0</span>
                        </div>
                    </div>
                </div>

                {{-- Grid de selección --}}
                <div class="lg:col-span-8 flex flex-col gap-6">
                    <div id="itemsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- Inyectado por JS --}}
                    </div>
            </div>
        </div>

        {{-- VISTA 4: DETALLE DE LISTA --}}
        <div id="view-detail" class="view-content hidden space-y-8">
            <div class="flex items-center justify-between mb-2">
                <button onclick="showView('lists')" class="text-xs font-bold text-slate-400 hover:text-slate-600 flex items-center gap-2 uppercase tracking-widest transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a mis listas
                </button>
                <h4 id="detailListName" class="font-black text-xl text-slate-800"></h4>
            </div>

            <div class="flex bg-white p-1 rounded-2xl border border-slate-100 shadow-sm overflow-x-auto h-[48px] w-fit">
                <button onclick="filterDetailCategory('Ropa')" class="det-category-btn px-6 py-2 rounded-xl text-sm font-bold transition-all whitespace-nowrap bg-cyan-700 text-white">Ropa</button>
                <button onclick="filterDetailCategory('Utensilios')" class="det-category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Utensilios</button>
                <button onclick="filterDetailCategory('Accesorios')" class="det-category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Accesorios</button>
                <button onclick="filterDetailCategory('Grupales')" class="det-category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Grupales</button>
            </div>

            <div id="detailItemsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Inyectado por JS --}}
            </div>
        </div>

    </div>

    @include('regalos.partials.modal-crear-regalo')
    @include('regalos.partials.modal-detalle-regalo')
    @include('regalos.partials.toast-notifications')
    @include('regalos.partials.scripts')

    <style>
        .view-content { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>

</x-app-layout>
