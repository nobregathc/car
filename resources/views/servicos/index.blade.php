@extends('layouts.oficina')

@section('titulo', 'Serviços - AutoFix')

@section('conteudo')
    @include('partials.destaque')

    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <span class="w-2.5 h-6 bg-amber-500 rounded-full"></span>
                Serviços Disponíveis
            </h1>
            <p class="text-xs text-slate-400 mt-1">Todos os serviços de manutenção, mecânica e diagnóstico da AutoFix</p>
        </div>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('servicos.create') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-sm flex items-center gap-1.5 shadow-lg shadow-emerald-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Criar Serviço
                </a>
            @endif
        @endauth
    </div>

    <!-- Barra de Filtros -->
    <div class="flex flex-wrap justify-between items-center gap-3 mb-8 bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-md">
        <form method="GET" action="{{ route('servicos.index') }}" class="flex items-center gap-2">
            <select name="categoria" onchange="this.form.submit()" class="rounded-xl bg-slate-950 border border-slate-700 text-slate-200 text-sm px-3.5 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                <option value="">Todas as categorias</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nome }}
                    </option>
                @endforeach
            </select>
            @if(request('categoria'))
                <a href="{{ route('servicos.index') }}" class="text-xs text-amber-400 hover:underline px-2">Limpar filtro</a>
            @endif
        </form>

        <div class="flex items-center gap-2 text-xs">
            <a href="{{ request()->fullUrlWithQuery(['direcao' => 'desc']) }}"
               class="px-3 py-2 rounded-xl border transition {{ request('direcao', 'desc') === 'desc' ? 'bg-amber-500 text-slate-950 font-bold border-amber-500 shadow-sm' : 'bg-slate-950 text-slate-300 border-slate-700 hover:bg-slate-800' }}">
                Mais recentes
            </a>
            <a href="{{ request()->fullUrlWithQuery(['direcao' => 'asc']) }}"
               class="px-3 py-2 rounded-xl border transition {{ request('direcao') === 'asc' ? 'bg-amber-500 text-slate-950 font-bold border-amber-500 shadow-sm' : 'bg-slate-950 text-slate-300 border-slate-700 hover:bg-slate-800' }}">
                Mais antigos
            </a>
        </div>
    </div>

    @if($servicos->isEmpty())
        <div class="bg-slate-900 p-10 rounded-2xl border border-slate-800 text-center text-slate-400">
            <p class="mb-4">Sem serviços registados.</p>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('servicos.create') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-sm transition">
                        + Criar Primeiro Serviço
                    </a>
                @endif
            @endauth
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($servicos as $servico)
                <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden flex flex-col shadow-lg hover:border-slate-700 transition group">
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
                            <h2 class="font-bold text-white text-base">{{ $servico->nome }}</h2>
                            <p class="text-xs text-slate-400 mt-2 line-clamp-2 leading-relaxed">{{ $servico->descricao }}</p>
                        </div>

                        <div>
                            <div class="pt-4 mt-4 border-t border-slate-800 flex justify-between items-center">
                                <div>
                                    <span class="text-lg font-black text-amber-400">{{ number_format($servico->preco, 2, ',', ' ') }} €</span>
                                    <span class="text-xs text-slate-400 ml-1">• {{ $servico->duracao_minutos }} min</span>
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

                            @auth
                                @if(auth()->user()->is_admin)
                                    <div class="mt-3 pt-3 border-t border-slate-800/60 flex justify-end gap-2">
                                        <a href="{{ route('servicos.edit', $servico) }}" class="px-2.5 py-1 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs rounded-lg transition font-medium">
                                            Editar
                                        </a>
                                        <form action="{{ route('servicos.destroy', $servico) }}" method="POST" onsubmit="return confirm('Apagar este serviço?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 text-xs rounded-lg transition font-medium cursor-pointer">
                                                Apagar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $servicos->links() }}
        </div>
    @endif
@endsection
