<x-app-layout>
    <style>
        .gift-card-selected {
            border-color: #0891b2 !important;
            background-color: #f0f9ff !important;
        }
        .view-section {
            display: none;
        }
        .view-section.active {
            display: block;
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Lista de Regalos') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Gestiona los regalos que tus invitados pueden elegir.</p>
            </div>
            <div id="headerActions">
                <!-- Se llenará dinámicamente -->
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- VISTA INICIAL -->
        <div id="viewInitial" class="view-section active py-4">
            <!-- Estado Vacío -->
            <div id="emptyState" class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-cyan-100 text-cyan-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Aún no tienes listas de regalos</h3>
                    <p class="text-slate-500 mb-8 text-sm">Crea una lista personalizada para que tus invitados sepan qué necesitas para tu evento.</p>
                    <button onclick="changeView('selection')" class="px-8 py-3 bg-cyan-700 hover:bg-cyan-800 text-white font-bold rounded-full transition-all transform active:scale-95 flex items-center gap-2 mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Agregar lista de regalos
                    </button>
                </div>
            </div>

            <!-- Tabla de Listas (Se muestra si hay datos) -->
            <div id="savedListsContainer" class="hidden text-left">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80">
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre de la Lista</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Ítems</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="savedListsBody" class="divide-y divide-slate-50">
                            <!-- Inyectado por JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- VISTA SELECCIÓN -->
        <div id="viewSelection" class="view-section">
            <!-- Nombre de la Lista y Botón Agregar -->
            <div class="flex flex-col md:flex-row items-end gap-6 mb-8">
                <div class="w-full max-w-md">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nombre de tu Lista</label>
                    <input type="text" id="listNameInput" placeholder="Ej. Mi Baby Shower" class="w-full h-[54px] px-6 rounded-2xl border-slate-100 bg-white shadow-sm focus:border-cyan-500 focus:ring-cyan-500 transition-all font-bold text-slate-700">
                </div>
                <button onclick="openCreateGiftModal()" class="px-8 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 hover:border-cyan-500 hover:text-cyan-600 transition-all flex items-center gap-3 shadow-sm h-[54px] group">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-cyan-100 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-slate-500 group-hover:text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span>Agregar regalo personalizado</span>
                </button>
            </div>

            <!-- Barra de Categorías -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <div class="flex bg-white p-1 rounded-2xl border border-slate-100 shadow-sm overflow-x-auto max-w-full h-[48px]">
                    <button onclick="filterCategory('Ropa')" class="category-btn active px-6 py-2 rounded-xl text-sm font-bold transition-all whitespace-nowrap bg-cyan-700 text-white">Ropa</button>
                    <button onclick="filterCategory('Utensilios')" class="category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Utensilios</button>
                    <button onclick="filterCategory('Accesorios')" class="category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Accesorios</button>
                    <button onclick="filterCategory('Grupales')" class="category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Grupales</button>
                </div>
                <button onclick="changeView('review')" class="px-6 h-[48px] bg-slate-100 border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-all flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Ver seleccionados (<span id="selectedCount">0</span>)
                </button>
            </div>

            <!-- Grid de Ítems -->
            <div id="itemsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Inyectado por JS -->
            </div>
        </div>

        <!-- VISTA REVISIÓN -->
        <div id="viewReview" class="view-section">
            <div class="mb-8 flex items-center justify-center relative min-h-[40px]">
                <button onclick="changeView('selection')" class="absolute left-0 flex items-center gap-2 text-cyan-600 font-bold hover:text-cyan-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Seguir seleccionando
                </button>
                <h3 class="text-xl font-bold text-slate-800">Resumen de Selección</h3>
            </div>

            <!-- Barra de Categorías en Resumen -->
            <div class="flex bg-white p-1 rounded-2xl border border-slate-100 shadow-sm overflow-x-auto max-w-full mb-8 w-fit">
                <button onclick="filterReviewCategory('Ropa')" class="rev-category-btn active px-6 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap bg-cyan-700 text-white">Ropa</button>
                <button onclick="filterReviewCategory('Utensilios')" class="rev-category-btn px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Utensilios</button>
                <button onclick="filterReviewCategory('Accesorios')" class="rev-category-btn px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Accesorios</button>
                <button onclick="filterReviewCategory('Grupales')" class="rev-category-btn px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Grupales</button>
            </div>

            <div id="reviewItemsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Ítems seleccionados filtrados por categoría -->
            </div>
        </div>

        <!-- VISTA DETALLE DE LISTA (SOLO LECTURA / ESTADO) -->
        <div id="viewListDetails" class="view-section">
            <div class="mb-8 flex flex-col gap-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-800" id="detailListName">Nombre de la Lista</h3>
                    <p class="text-sm text-slate-400">Estado de los regalos para este evento.</p>
                </div>
                
                <!-- Filtros Detalle (Alineados a la izquierda) -->
                <div class="flex bg-white p-1 rounded-2xl border border-slate-100 shadow-sm overflow-x-auto h-[48px] w-fit">
                    <button onclick="filterDetailCategory('Ropa')" class="det-category-btn active px-6 py-2 rounded-xl text-sm font-bold transition-all whitespace-nowrap bg-cyan-700 text-white">Ropa</button>
                    <button onclick="filterDetailCategory('Utensilios')" class="det-category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Utensilios</button>
                    <button onclick="filterDetailCategory('Accesorios')" class="det-category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Accesorios</button>
                    <button onclick="filterDetailCategory('Grupales')" class="det-category-btn px-6 py-2 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all whitespace-nowrap">Grupales</button>
                </div>
            </div>

            <!-- Grid de Ítems en Detalle -->
            <div id="detailItemsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Inyectado por JS -->
            </div>
        </div>
    </div>

    @include('regalos.partials.modal-crear-regalo')

    @include('regalos.partials.modal-detalle-regalo')

    @include('regalos.partials.toast-notifications')

    @include('regalos.partials.scripts')
</x-app-layout>
