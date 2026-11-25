@extends('layouts.oficina')

@section('titulo', 'Categorias - AutoFix')

@section('conteudo')
    @include('partials.destaque')

    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <span class="w-2.5 h-6 bg-sky-500 rounded-full"></span>
                Categorias de Serviços
            </h1>
            <p class="text-xs text-slate-400 mt-1">Especialidades e áreas de intervenção da oficina AutoFix</p>
        </div>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('categorias.create') }}" class="px-4 py-2.5 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-xl text-sm flex items-center gap-1.5 shadow-lg shadow-sky-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Criar Categoria
                </a>
            @endif
        @endauth
    </div>

    @if($categorias->isEmpty())
        <div class="bg-slate-900 p-10 rounded-2xl border border-slate-800 text-center text-slate-400">
            <p class="mb-4">Ainda não existem categorias registadas.</p>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('categorias.create') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-xl text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Criar primeira Categoria
                    </a>
                @endif
            @endauth
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categorias as $categoria)
                <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 hover:border-slate-700 transition flex flex-col justify-between shadow-lg">
                    <div>
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <h2 class="text-lg font-bold text-white">{{ $categoria->nome }}</h2>
                            <span class="px-2.5 py-0.5 bg-slate-800 text-amber-400 text-xs rounded-full border border-slate-700/80 font-semibold shrink-0">
                                {{ $categoria->servicos_count }} {{ Str::plural('serviço', $categoria->servicos_count) }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mb-6 leading-relaxed">{{ $categoria->descricao }}</p>
                    </div>

                    <div>
                        <a href="{{ route('categorias.show', $categoria) }}" class="block text-center w-full py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold rounded-xl border border-slate-700 transition">
                            Ver serviços desta categoria &rarr;
                        </a>

                        @auth
                            @if(auth()->user()->is_admin)
                                <div class="mt-3 pt-3 border-t border-slate-800 flex justify-end gap-2">
                                    <a href="{{ route('categorias.edit', $categoria) }}" class="px-3 py-1 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs rounded-lg transition font-medium">
                                        Editar
                                    </a>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('Apagar categoria e os seus serviços?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 text-xs rounded-lg transition font-medium cursor-pointer">
                                            Apagar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $categorias->links() }}
        </div>
    @endif
@endsection
