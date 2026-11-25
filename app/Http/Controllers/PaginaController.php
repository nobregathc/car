<?php

namespace App\Http\Controllers;

use App\Models\CategoriaServico;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaginaController extends Controller
{
    public function inicio()
    {
        $servicosRecentes = Servico::with('categoria')
            ->latest()
            ->take(6)
            ->get();

        $categorias = CategoriaServico::withCount('servicos')->get();

        return view('inicio', compact('servicosRecentes', 'categorias'));
    }

    public function contacto()
    {
        return view('contacto');
    }

    public function enviarContacto(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'assunto' => ['required', 'string', 'min:3', 'max:150'],
            'mensagem' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'nome.required' => 'Por favor, indique o seu nome.',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'email.required' => 'O endereço de email é obrigatório.',
            'email.email' => 'Por favor, introduza um endereço de email válido.',
            'assunto.required' => 'O assunto é obrigatório.',
            'assunto.min' => 'O assunto deve ter pelo menos 3 caracteres.',
            'mensagem.required' => 'A mensagem não pode estar vazia.',
            'mensagem.min' => 'A mensagem deve ter pelo menos 10 caracteres.',
        ]);

        // Envio de email simples (usa MAIL_MAILER=log no .env se ainda não configuraste SMTP)
        Mail::raw(
            "Nova mensagem de contacto no portal AutoFix:\n\n" .
            "Nome: {$dados['nome']}\n" .
            "Email: {$dados['email']}\n" .
            "Assunto: {$dados['assunto']}\n\n" .
            "Mensagem:\n{$dados['mensagem']}",
            function ($message) use ($dados) {
                $message->to('geral@autofix-oficina.pt')
                        ->replyTo($dados['email'], $dados['nome'])
                        ->subject('Contacto AutoFix: ' . $dados['assunto']);
            }
        );

        return redirect()
            ->route('contacto')
            ->with('sucesso', 'A sua mensagem foi enviada com sucesso! Entraremos em contacto brevemente.');
    }
}