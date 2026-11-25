<?php

namespace App\Http\Controllers;

use App\Models\CategoriaServico;
use Illuminate\Http\Request;

class CategoriaServicoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaServico::withCount('servicos')
            ->orderBy('nome')
            ->paginate(9);

        return view('categorias.index', compact('categorias'));
    }

    public function show(CategoriaServico $categoria)
    {
        // Carrega os serviços associados a esta categoria (Relação 1:N)
        $servicos = $categoria->servicos()
            ->orderBy('nome')
            ->paginate(9);

        return view('categorias.show', compact('categoria', 'servicos'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:100', 'unique:categoria_servicos,nome'],
            'descricao' => ['nullable', 'string', 'max:1000'],
        ], [
            'nome.required' => 'O nome da categoria é obrigatório.',
            'nome.min' => 'O nome da categoria deve ter pelo menos 3 caracteres.',
            'nome.unique' => 'Já existe uma categoria com esse nome.',
            'descricao.max' => 'A descrição não pode ultrapassar os 1000 caracteres.',
        ]);

        CategoriaServico::create($dados);

        return redirect()
            ->route('categorias.index')
            ->with('sucesso', 'Categoria criada com sucesso!');
    }

    public function edit(CategoriaServico $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, CategoriaServico $categoria)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:100', 'unique:categoria_servicos,nome,' . $categoria->id],
            'descricao' => ['nullable', 'string', 'max:1000'],
        ], [
            'nome.required' => 'O nome da categoria é obrigatório.',
            'nome.min' => 'O nome da categoria deve ter pelo menos 3 caracteres.',
            'nome.unique' => 'Já existe outra categoria com esse nome.',
            'descricao.max' => 'A descrição não pode ultrapassar os 1000 caracteres.',
        ]);

        $categoria->update($dados);

        return redirect()
            ->route('categorias.show', $categoria)
            ->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    public function destroy(CategoriaServico $categoria)
    {
        // Como a migration tem onDelete('cascade'), os serviços associados são eliminados automaticamente
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('sucesso', 'Categoria e respetivos serviços eliminados com sucesso!');
    }
}