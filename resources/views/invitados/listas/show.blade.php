<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">{{ $lista_invitado->nombre }}</h2>
                <p class="text-slate-500 font-medium mt-1">Detalle de la lista de invitados</p>
            </div>
            <a href="{{ route('invitados.creacion') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-xs font-bold bg-white border border-slate-200 text-slate-500 hover:text-cyan-600 hover:border-cyan-200 shadow-sm uppercase tracking-widest transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-3xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Info de la lista --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nombre</p>
                <p class="text-xl font-black text-slate-800">{{ $lista_invitado->nombre }}</p>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Categoría</p>
                <span class="px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full text-xs font-black uppercase tracking-widest">
                    {{ $lista_invitado->categoria ?? 'Sin categoría' }}
                </span>
            </div>
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Invitados</p>
                <p class="text-4xl font-black text-cyan-700">{{ $lista_invitado->invitados->count() }}</p>
            </div>
        </div>

        {{-- Tabla de invitados --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Email</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Teléfono</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Asistencia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($lista_invitado->invitados as $invitado)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-8 py-5 font-bold text-slate-700">{{ $invitado->nombre }}</td>
                                <td class="px-8 py-5 text-sm text-slate-500">{{ $invitado->email ?? '—' }}</td>
                                <td class="px-8 py-5 text-sm text-slate-500">{{ $invitado->telefono ?? '—' }}</td>
                                <td class="px-8 py-5">
                                    @php
                                        $color = match($invitado->estado_asistencia) {
                                            'Confirmado' => 'bg-emerald-100 text-emerald-700',
                                            'Rechazado'  => 'bg-red-100 text-red-600',
                                            default      => 'bg-slate-100 text-slate-500',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 {{ $color }} rounded-full text-[10px] font-black uppercase tracking-widest">
                                        {{ $invitado->estado_asistencia ?? 'Sin responder' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-slate-400 italic">Esta lista no tiene invitados aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
