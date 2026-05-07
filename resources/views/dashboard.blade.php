<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-950">Lista de Regalos</h1>
                <p class="text-gray-500 mt-1">Crea una lista de deseos única y organizada.</p>
            </div>
            <button class="bg-cyan-800 text-white px-6 py-3 rounded-full font-medium hover:bg-cyan-900 transition-colors shadow-sm">
                + Añadir Regalo
            </button>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 flex items-center gap-4">
             <div class="p-4 bg-red-50 rounded-full text-red-500">❤️</div>
             <div>
                 <p class="text-sm text-gray-400">Total Regalos</p>
                 <p class="text-3xl font-bold">24</p>
             </div>
        </div>
    </div>
</x-app-layout>
