@extends('layouts.oficina')

@section('titulo', 'Contacto - AutoFix')

@section('conteudo')
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Estamos aqui para ajudar</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Fale Connosco</h1>
            <p class="text-slate-400 text-sm mt-2">Dúvidas, pedidos de orçamento ou apoio ao agendamento</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Informações -->
            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white mb-4">Informações de Contacto</h2>

                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <strong class="block text-white">Localização</strong>
                                Rua da Mecânica, nº 123<br>4000-001 Porto, Portugal
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <div>
                                <strong class="block text-white">Telefone</strong>
                                +351 220 000 000
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <div>
                                <strong class="block text-white">Email</strong>
                                geral@oficina.pt
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-800 text-xs text-slate-400">
                    <strong class="text-white block mb-1">Horário de Funcionamento</strong>
                    Segunda a Sexta: 08:30 – 18:30<br>Sábado: 09:00 – 13:00
                </div>
            </div>

            <!-- Formulário -->
            <div class="md:col-span-2 bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-xl">
                <form action="{{ route('contacto.enviar') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nome" class="block text-xs font-semibold text-slate-300 mb-1">Nome completo *</label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome', auth()->user()->name ?? '') }}" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                        </div>
                        <div>
                            <label for="telefone" class="block text-xs font-semibold text-slate-300 mb-1">Telefone (opcional)</label>
                            <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label for="mensagem" class="block text-xs font-semibold text-slate-300 mb-1">Mensagem *</label>
                        <textarea name="mensagem" id="mensagem" rows="5" placeholder="Escreva aqui a sua questão ou detalhe da intervenção..." class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>{{ old('mensagem') }}</textarea>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-sm shadow-lg shadow-amber-500/20 transition cursor-pointer">
                            Enviar Mensagem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
