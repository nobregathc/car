@extends('layouts.oficina')

@section('titulo', $categoria->nome . ' - AutoFix')

@section('conteudo')
    <div class="mb-5">
        <a href="{{ route('categorias.index') }}" class="text-xs font-semibold text-slate-400 hover:text-amber-400 transition flex items-center gap-1.5">
            &larr; Voltar às Categorias
        </a>
    </div>

    <!-- Cabeçalho da Categoria -->
    <div class="bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-xl mb-8">
        <div class="flex flex-wrap justify-between items-start gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Especialidade</span>
                <h1 class="text-3xl font-extrabold text-white mt-1 mb-2">{{ $categoria->nome }}</h1>
                <p class="text-slate-300 text-sm max-w-3xl leading-relaxed">{{ $categoria->descricao }}</p>
            </div>

            @auth
                @if(auth()->user()->is_admin)
                    <div class="flex gap-2">
                        <a href="{{ route('categorias.edit', $categoria) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold rounded-xl transition shadow">
                            Editar Categoria
                        </a>
                        <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('Eliminar esta categoria irá eliminar todos os seus serviços. Confirmar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-xs font-bold rounded-xl transition shadow cursor-pointer">
                                Eliminar
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Lista de Serviços desta Categoria -->
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="w-2.5 h-5 bg-amber-500 rounded-full"></span>
            Serviços incluídos nesta categoria ({{ $servicos->total() }})
        </h2>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('servicos.create') }}" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-lg transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Novo Serviço
                </a>
            @endif
        @endauth
    </div>

    @if($servicos->isEmpty())
        <div class="bg-slate-900 p-10 rounded-2xl border border-slate-800 text-center text-slate-400 mb-10">
            <p class="mb-4">Ainda não existem serviços registados nesta categoria.</p>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('servicos.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-lg text-sm transition">
                        + Criar Serviço
                    </a>
                @endif
            @endauth
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($servicos as $servico)
                <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden flex flex-col shadow-lg">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ $servico->imagem_url ?? 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?w=800' }}" 
                             alt="{{ $servico->nome }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-white text-base">{{ $servico->nome }}</h3>
                            <p class="text-xs text-slate-400 mt-2 line-clamp-3 leading-relaxed">{{ $servico->descricao }}</p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-800 flex justify-between items-center">
                            <div>
                                <span class="text-lg font-black text-amber-400">{{ number_format($servico->preco, 2, ',', ' ') }} €</span>
                                <span class="text-xs text-slate-400 ml-1">• {{ $servico->duracao_minutos }} min</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('servicos.show', $servico) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold rounded-lg transition border border-slate-700">
                                    Abrir
                                </a>
                                @if(!auth()->user()?->is_admin)
                                    <a href="{{ route('agendamentos.create', ['servico' => $servico->id]) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold rounded-lg transition">
                                        Agendar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $servicos->links() }}
        </div>
    @endif
@endsection
