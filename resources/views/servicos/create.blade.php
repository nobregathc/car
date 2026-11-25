@extends('layouts.oficina')

@section('titulo', 'Novo Serviço - AutoFix')

@section('conteudo')
    <div class="max-w-2xl mx-auto bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-2xl">
        <div class="flex items-center gap-2 mb-6">
            <span class="w-2.5 h-6 bg-emerald-500 rounded-full"></span>
            <h1 class="text-2xl font-bold text-white">Adicionar Novo Serviço</h1>
        </div>

        <form action="{{ route('servicos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="categoria_servico_id" class="block text-sm font-medium text-slate-300 mb-1">Categoria *</label>
                <select name="categoria_servico_id" id="categoria_servico_id" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                    <option value="">Selecione uma categoria...</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_servico_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_servico_id')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nome" class="block text-sm font-medium text-slate-300 mb-1">Nome do Serviço *</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" placeholder="Ex: Mudança de Óleo 5W30" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                @error('nome')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descricao" class="block text-sm font-medium text-slate-300 mb-1">Descrição detalhada *</label>
                <textarea name="descricao" id="descricao" rows="4" placeholder="Descreva o que está incluído no serviço..." class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>{{ old('descricao') }}</textarea>
                @error('descricao')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="preco" class="block text-sm font-medium text-slate-300 mb-1">Preço (€) *</label>
                    <input type="number" step="0.01" min="0" name="preco" id="preco" value="{{ old('preco') }}" placeholder="Ex: 85.00" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                    @error('preco')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duracao_minutos" class="block text-sm font-medium text-slate-300 mb-1">Duração (minutos) *</label>
                    <input type="number" min="1" name="duracao_minutos" id="duracao_minutos" value="{{ old('duracao_minutos') }}" placeholder="Ex: 45" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                    @error('duracao_minutos')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="imagem" class="block text-sm font-medium text-slate-300 mb-1">Fotografia do Serviço (JPG, PNG, WEBP — máx. 2MB)</label>
                <input type="file" name="imagem" id="imagem" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 cursor-pointer">
                @error('imagem')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-5 border-t border-slate-800">
                <a href="{{ route('servicos.index') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 rounded-xl text-sm font-semibold transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-emerald-600/20 transition cursor-pointer flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Guardar Serviço
                </button>
            </div>
        </form>
    </div>
@endsection
