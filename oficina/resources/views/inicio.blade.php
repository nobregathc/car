@extends('layouts.oficina')

@section('titulo', 'AutoFix - Oficina Mecânica')

@section('conteudo')
    @include('partials.destaque')

    <!-- Secção Categorias -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-6 bg-sky-500 rounded-full"></span>
                <h2 class="text-xl font-bold text-white">Categorias de Serviços</h2>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('categorias.create') }}" class="px-3 py-1 bg-sky-600 hover:bg-sky-500 text-white font-semibold rounded-lg text-xs flex items-center gap-1 shadow-sm transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            + Criar Categoria
                        </a>
                    @endif
                @endauth
            </div>
            <a href="{{ route('categorias.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300 transition flex items-center gap-1">
                Ver todas &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($categorias as $categoria)
                <a href="{{ route('categorias.show', $categoria) }}" class="bg-slate-900 hover:bg-slate-850 p-5 rounded-2xl border border-slate-800 hover:border-amber-500/50 transition-all block group shadow-md">
                    <div class="flex justify-between items-start gap-2">
                        <h3 class="font-bold text-slate-100 group-hover:text-amber-400 transition text-base">{{ $categoria->nome }}</h3>
                        <span class="text-xs px-2.5 py-0.5 bg-slate-800 text-slate-300 rounded-full border border-slate-700/60 shrink-0 font-medium">
                            {{ $categoria->servicos_count }} {{ Str::plural('serviço', $categoria->servicos_count) }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2 line-clamp-2 leading-relaxed">{{ $categoria->descricao }}</p>
                </a>
            @empty
                <div class="col-span-full bg-slate-900 p-8 rounded-2xl border border-slate-800 text-center text-slate-400 text-sm">
                    Nenhuma categoria registada.
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('categorias.create') }}" class="text-amber-400 font-semibold hover:underline ml-1">Criar categoria</a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>
    </section>

    <!-- Secção Serviços Recentes -->
    <section>
        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-6 bg-amber-500 rounded-full"></span>
                <h2 class="text-xl font-bold text-white">Serviços Disponíveis</h2>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('servicos.create') }}" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-lg text-xs flex items-center gap-1 shadow-sm transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            + Criar Serviço
                        </a>
                    @endif
                @endauth
            </div>
            <a href="{{ route('servicos.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300 transition flex items-center gap-1">
                Ver todos &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($servicosRecentes as $servico)
                <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden flex flex-col hover:border-slate-700 transition shadow-lg group">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ $servico->imagem_url ?? 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?w=800' }}" 
                             alt="{{ $servico->nome }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-900/90 text-amber-400 backdrop-blur border border-slate-800">
                            {{ $servico->categoria->nome }}
                        </span>
                    </div>

                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-white text-base leading-snug">{{ $servico->nome }}</h3>
                            <p class="text-xs text-slate-400 mt-1.5 line-clamp-2 leading-relaxed">{{ $servico->descricao }}</p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-800 flex justify-between items-center">
                            <div>
                                <span class="text-lg font-black text-amber-400">{{ number_format($servico->preco, 2, ',', ' ') }} €</span>
                                <span class="text-xs text-slate-400 ml-1.5">• {{ $servico->duracao_minutos }} min</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('servicos.show', $servico) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold rounded-lg border border-slate-700 transition">
                                    Detalhes
                                </a>
                                @if(!auth()->user()?->is_admin)
                                    <a href="{{ route('agendamentos.create', ['servico' => $servico->id]) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold rounded-lg transition shadow-sm">
                                        Agendar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-slate-900 p-8 rounded-2xl border border-slate-800 text-center text-slate-400 text-sm">
                    Nenhum serviço registado.
                </div>
            @endforelse
        </div>
    </section>
@endsection
