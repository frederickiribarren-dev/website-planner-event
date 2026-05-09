
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Crear Nuevo Evento') }}
            </h2>
        </div>
        <div class="flex justify-center mt-6 mb-2">
            <div class="flex items-center gap-4 sm:gap-6">
                <div class="flex flex-col items-center step-indicator" data-step="1">
                    <div class="step-dot w-8 h-8 flex items-center justify-center rounded-full bg-cyan-700 text-white font-bold border-4 border-cyan-700 transition-all text-xs">1</div>
                    <span class="step-label text-[10px] mt-1 font-semibold text-cyan-700 transition-all uppercase tracking-tighter">Detalles</span>
                </div>
                <div class="w-6 sm:w-8 h-1 bg-gray-200 step-line" data-step="1"></div>
                <div class="flex flex-col items-center step-indicator" data-step="2">
                    <div class="step-dot w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200 transition-all text-xs">2</div>
                    <span class="step-label text-[10px] mt-1 font-semibold text-gray-400 transition-all uppercase tracking-tighter">Invitados</span>
                </div>
                <div class="w-6 sm:w-8 h-1 bg-gray-200 step-line" data-step="2"></div>
                <div class="flex flex-col items-center step-indicator" data-step="3">
                    <div class="step-dot w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200 transition-all text-xs">3</div>
                    <span class="step-label text-[10px] mt-1 font-semibold text-gray-400 transition-all uppercase tracking-tighter">Imagen</span>
                </div>
                <div class="w-6 sm:w-8 h-1 bg-gray-200 step-line" data-step="3"></div>
                <div class="flex flex-col items-center step-indicator" data-step="4">
                    <div class="step-dot w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200 transition-all text-xs">4</div>
                    <span class="step-label text-[10px] mt-1 font-semibold text-gray-400 transition-all uppercase tracking-tighter">Mensaje</span>
                </div>
                <div class="w-6 sm:w-8 h-1 bg-gray-200 step-line" data-step="4"></div>
                <div class="flex flex-col items-center step-indicator" data-step="5">
                    <div class="step-dot w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200 transition-all text-xs">5</div>
                    <span class="step-label text-[10px] mt-1 font-semibold text-gray-400 transition-all uppercase tracking-tighter">Resumen</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <form id="multiStepForm" method="POST" action="{{ route('eventos.store') }}">
            @csrf
            
            @include('eventos.partials.step1')
            @include('eventos.partials.step2')
            @include('eventos.partials.step3')
            @include('eventos.partials.step4')
            @include('eventos.partials.step5')
        </form>
    </div>

    @include('eventos.partials.scripts')
</x-app-layout>