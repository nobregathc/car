<?php

namespace App\Http\Controllers;

use App\Models\CategoriaServico;
use App\Models\Servico;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
public function index(Request $request)
    {
        $categorias = CategoriaServico::orderBy('nome')->get();

        $query = Servico::with('categoria');

        if ($request->filled('categoria')) {
            $query->where('categoria_servico_id', $request->input('categoria'));
        }

        $direcao = $request->input('direcao') === 'asc' ? 'asc' : 'desc';

        $servicos = $query->orderBy('created_at', $direcao)
            ->paginate(9)
            ->withQueryString();

        return view('servicos.index', compact('servicos', 'categorias'));
    }
    public function show(Servico $servico)
    {
        $servico->load('categoria');

        return view('servicos.show', compact('servico'));
    }

    public function create()
    {
        $categorias = CategoriaServico::orderBy('nome')->get();

        return view('servicos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $dados = $this->validarServico($request);

        if ($request->hasFile('imagem')) {
            $upload = Cloudinary::upload($request->file('imagem')->getRealPath(), [
                'folder' => 'autofix/servicos',
            ]);
            $dados['imagem_url'] = $upload->getSecurePath();
        }

        unset($dados['imagem']);

        $servico = Servico::create($dados);

        return redirect()
            ->route('servicos.show', $servico)
            ->with('sucesso', 'Serviço criado com sucesso!');
    }

    public function edit(Servico $servico)
    {
        $categorias = CategoriaServico::orderBy('nome')->get();

        return view('servicos.edit', compact('servico', 'categorias'));
    }

    public function update(Request $request, Servico $servico)
    {
        $dados = $this->validarServico($request);

        if ($request->hasFile('imagem')) {
            $upload = Cloudinary::upload($request->file('imagem')->getRealPath(), [
                'folder' => 'autofix/servicos',
            ]);
            $dados['imagem_url'] = $upload->getSecurePath();
        }

        unset($dados['imagem']);

        $servico->update($dados);

        return redirect()
            ->route('servicos.show', $servico)
            ->with('sucesso', 'Serviço atualizado com sucesso!');
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();

        return redirect()
            ->route('servicos.index')
            ->with('sucesso', 'Serviço eliminado com sucesso!');
    }

    private function validarServico(Request $request): array
    {
        return $request->validate([
            'categoria_servico_id' => ['required', 'exists:categoria_servicos,id'],
            'nome' => ['required', 'string', 'min:3', 'max:150'],
            'descricao' => ['required', 'string', 'min:10', 'max:2000'],
            'preco' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'duracao_minutos' => ['required', 'integer', 'min:1', 'max:10000'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'categoria_servico_id.required' => 'Deve selecionar uma categoria para o serviço.',
            'categoria_servico_id.exists' => 'A categoria selecionada não é válida.',
            'nome.required' => 'O nome do serviço é obrigatório.',
            'nome.min' => 'O nome do serviço deve ter pelo menos 3 caracteres.',
            'descricao.required' => 'A descrição do serviço é obrigatória.',
            'descricao.min' => 'A descrição deve ter pelo menos 10 caracteres.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico válido.',
            'preco.min' => 'O preço não pode ser inferior a 0 €.',
            'duracao_minutos.required' => 'A duração estimada (em minutos) é obrigatória.',
            'duracao_minutos.integer' => 'A duração deve ser um número inteiro de minutos.',
            'duracao_minutos.min' => 'A duração mínima deve ser de 1 minuto.',
            'imagem.image' => 'O ficheiro carregado tem de ser uma imagem.',
            'imagem.mimes' => 'A imagem deve estar no formato JPG, JPEG, PNG ou WEBP.',
            'imagem.max' => 'A imagem não pode ultrapassar os 2 MB.',
        ]);
    }
}   