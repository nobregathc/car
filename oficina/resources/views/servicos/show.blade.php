@extends('layouts.oficina')

@section('titulo', $servico->nome . ' - AutoFix')

@section('conteudo')
    <div class="mb-5">
        <a href="{{ route('servicos.index') }}" class="text-xs font-semibold text-slate-400 hover:text-amber-400 transition flex items-center gap-1.5">
            &larr; Voltar à Lista de Serviços
        </a>
    </div>

    <div class="bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <!-- Imagem -->
            <div class="h-64 md:h-full relative overflow-hidden bg-slate-950">
                <img src="{{ $servico->imagem_url ?? 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?w=800' }}" 
                     alt="{{ $servico->nome }}" 
                     class="w-full h-full object-cover">
            </div>

            <!-- Informação do Serviço -->
            <div class="p-6 sm:p-10 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <a href="{{ route('categorias.show', $servico->categoria) }}" class="px-3 py-1 bg-slate-800 text-amber-400 text-xs font-bold rounded-lg border border-slate-700 hover:border-amber-500/50 transition">
                            {{ $servico->categoria->nome }}
                        </a>
                        <span class="text-xs text-slate-400">Criado a {{ $servico->created_at?->format('d/m/Y') }}</span>
                    </div>

                    <h1 class="text-3xl font-extrabold text-white mb-4 leading-tight">{{ $servico->nome }}</h1>
                    <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-line mb-6">{{ $servico->descricao }}</p>

                    <!-- Preço e Duração -->
                    <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl bg-slate-950 border border-slate-800 mb-6">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Preço Base</span>
                            <span class="text-3xl font-black text-amber-400">{{ number_format($servico->preco, 2, ',', ' ') }} €</span>
                            <span class="block text-[10px] text-slate-500">IVA incluído</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tempo Estimado</span>
                            <span class="text-2xl font-bold text-white">{{ $servico->duracao_minutos }} min</span>
                            <span class="block text-[10px] text-slate-500">Aproximado</span>
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="pt-6 border-t border-slate-800 flex flex-wrap items-center justify-between gap-3">
                    @auth
                        @if(auth()->user()->is_admin)
                            <div class="flex gap-2">
                                <a href="{{ route('servicos.edit', $servico) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs rounded-xl transition shadow">
                                    Editar Serviço
                                </a>
                                <form action="{{ route('servicos.destroy', $servico) }}" method="POST" onsubmit="return confirm('Eliminar este serviço definitivamente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-bold text-xs rounded-xl transition shadow cursor-pointer">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('agendamentos.create', ['servico' => $servico->id]) }}" class="w-full sm:w-auto px-6 py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-sm rounded-xl transition shadow-lg shadow-amber-500/20 text-center flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Agendar este Serviço
                            </a>
                        @endif
                    @else
                        <a href="{{ route('agendamentos.create', ['servico' => $servico->id]) }}" class="w-full sm:w-auto px-6 py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-sm rounded-xl transition shadow-lg shadow-amber-500/20 text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Agendar este Serviço
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
