@extends('layouts.oficina')

@section('titulo', 'Meus Agendamentos - AutoFix')

@section('conteudo')
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-black text-white flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-amber-500 rounded-full"></span>
                    Os Meus Agendamentos
                </h1>
                <p class="text-xs text-slate-400 mt-1">Histórico e estado das suas marcações na AutoFix</p>
            </div>
            <a href="{{ route('agendamentos.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm rounded-xl transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Novo Agendamento
            </a>
        </div>

        @if($agendamentos->isEmpty())
            <div class="bg-slate-900 p-12 rounded-3xl border border-slate-800 text-center shadow-xl">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-800/80 border border-slate-700 flex items-center justify-center text-amber-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-1">Ainda não tem agendamentos</h3>
                <p class="text-xs text-slate-400 mb-6 max-w-sm mx-auto">Precisa de revisão, mudança de óleo ou diagnóstico? Agende agora com os nossos especialistas.</p>
                <a href="{{ route('agendamentos.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm rounded-xl transition shadow-md">
                    Marcar Agendamento
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($agendamentos as $agendamento)
                    <div class="bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-800 shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-slate-700 transition">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $agendamento->estado_badge_class }}">
                                    {{ $agendamento->estado_label }}
                                </span>
                                <span class="text-xs text-slate-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $agendamento->data_hora->format('d/m/Y') }} às {{ $agendamento->data_hora->format('H:i') }}h
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-white">
                                {{ $agendamento->servico->nome }}
                            </h3>

                            @if($agendamento->veiculo)
                                <p class="text-xs text-slate-300 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Veículo: <strong class="text-amber-400 font-semibold">{{ $agendamento->veiculo }}</strong>
                                </p>
                            @endif

                            @if($agendamento->observacoes)
                                <p class="text-xs text-slate-400 italic">"{{ $agendamento->observacoes }}"</p>
                            @endif

                            @if($agendamento->notas_admin)
                                <div class="mt-2 p-2.5 bg-slate-950 rounded-xl border border-slate-800 text-xs text-slate-300">
                                    <strong class="text-amber-400 block mb-0.5">Nota da Oficina:</strong>
                                    {{ $agendamento->notas_admin }}
                                </div>
                            @endif
                        </div>

                        <div class="sm:text-right shrink-0 flex sm:flex-col items-center sm:items-end justify-between gap-3 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-800">
                            <div>
                                <span class="text-xl font-black text-amber-400">{{ number_format($agendamento->servico->preco, 2, ',', ' ') }} €</span>
                                <span class="block text-[10px] text-slate-400">{{ $agendamento->servico->duracao_minutos }} min estimados</span>
                            </div>

                            @if($agendamento->estado === 'pendente')
                                <form action="{{ route('agendamentos.cancelar', $agendamento) }}" method="POST" onsubmit="return confirm('Deseja realmente cancelar esta marcação?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600/20 hover:bg-red-600 text-red-300 hover:text-white border border-red-500/30 text-xs font-semibold transition cursor-pointer">
                                        Cancelar Marcação
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $agendamentos->links() }}
            </div>
        @endif
    </div>
@endsection
