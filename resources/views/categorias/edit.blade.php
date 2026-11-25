@extends('layouts.oficina')

@section('titulo', 'Editar Categoria - AutoFix')

@section('conteudo')
    <div class="max-w-xl mx-auto bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-2xl">
        <div class="flex items-center gap-2 mb-6">
            <span class="w-2.5 h-6 bg-amber-500 rounded-full"></span>
            <h1 class="text-2xl font-bold text-white">Editar Categoria: <span class="text-amber-400">{{ $categoria->nome }}</span></h1>
        </div>

        <form action="{{ route('categorias.update', $categoria) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-sm font-medium text-slate-300 mb-1">Nome da Categoria *</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome', $categoria->nome) }}" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                @error('nome')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descricao" class="block text-sm font-medium text-slate-300 mb-1">Descrição</label>
                <textarea name="descricao" id="descricao" rows="4" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition">{{ old('descricao', $categoria->descricao) }}</textarea>
                @error('descricao')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-5 border-t border-slate-800">
                <a href="{{ route('categorias.show', $categoria) }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 rounded-xl text-sm font-semibold transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-sm shadow-lg shadow-amber-500/20 transition cursor-pointer flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Atualizar Categoria
                </button>
            </div>
        </form>
    </div>
@endsection
