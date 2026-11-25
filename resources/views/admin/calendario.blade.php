@extends('layouts.oficina')

@section('titulo', 'Calendário de Agendamentos - AutoFix Admin')

@section('conteudo')
    <div class="max-w-7xl mx-auto">
        <!-- Cabeçalho e Navegação do Mês -->
        <div class="flex flex-wrap justify-between items-center mb-8 gap-4 bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-amber-400">Painel de Controlo • Oficina</span>
                <h1 class="text-2xl font-black text-white mt-0.5 flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Calendário de Serviços
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">Visão mensal dos serviços marcados pelos clientes</p>
            </div>

            <!-- Navegação de Mês -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.calendario', ['ano' => $mesAnterior->year, 'mes' => $mesAnterior->month]) }}" 
                   class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl border border-slate-700 text-xs font-bold transition flex items-center gap-1">
                    &larr; {{ $mesAnterior->translatedFormat('M') }}
                </a>

                <div class="px-4 py-2 bg-slate-950 rounded-xl border border-slate-700 text-center">
                    <span class="text-base font-black text-amber-400 uppercase tracking-wide">
                        {{ $dataAtual->translatedFormat('F Y') }}
                    </span>
                </div>

                <a href="{{ route('admin.calendario', ['ano' => $mesSeguinte->year, 'mes' => $mesSeguinte->month]) }}" 
                   class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl border border-slate-700 text-xs font-bold transition flex items-center gap-1">
                    {{ $mesSeguinte->translatedFormat('M') }} &rarr;
                </a>

                <a href="{{ route('admin.calendario') }}" 
                   class="px-3 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-black transition shadow-sm">
                    Hoje
                </a>
            </div>
        </div>

        <!-- Estatísticas Rápidas do Mês -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-md">
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Total no Mês</span>
                <span class="text-2xl font-black text-white mt-1 block">{{ $stats['total'] }}</span>
            </div>
            <div class="bg-slate-900 p-4 rounded-2xl border border-amber-500/20 shadow-md">
                <span class="text-[11px] font-semibold text-amber-400 uppercase tracking-wider block">Pendentes</span>
                <span class="text-2xl font-black text-amber-400 mt-1 block">{{ $stats['pendentes'] }}</span>
            </div>
            <div class="bg-slate-900 p-4 rounded-2xl border border-emerald-500/20 shadow-md">
                <span class="text-[11px] font-semibold text-emerald-400 uppercase tracking-wider block">Confirmados</span>
                <span class="text-2xl font-black text-emerald-400 mt-1 block">{{ $stats['confirmados'] }}</span>
            </div>
            <div class="bg-slate-900 p-4 rounded-2xl border border-sky-500/20 shadow-md">
                <span class="text-[11px] font-semibold text-sky-400 uppercase tracking-wider block">Concluídos</span>
                <span class="text-2xl font-black text-sky-400 mt-1 block">{{ $stats['concluidos'] }}</span>
            </div>
        </div>

        <!-- Grelha do Calendário Mensal -->
        <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden mb-10">
            <!-- Cabeçalho dos Dias da Semana -->
            <div class="grid grid-cols-7 bg-slate-950 border-b border-slate-800 text-center py-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                <span>Seg</span>
                <span>Ter</span>
                <span>Qua</span>
                <span>Qui</span>
                <span>Sex</span>
                <span class="text-amber-500/80">Sáb</span>
                <span class="text-red-400/80">Dom</span>
            </div>

            <!-- Células dos Dias -->
            <div class="grid grid-cols-7 auto-rows-fr gap-px bg-slate-800">
                {{-- Células vazias antes do primeiro dia do mês --}}
                @for ($i = 1; $i < $primeiroDiaSemana; $i++)
                    <div class="min-h-[110px] sm:min-h-[130px] p-2 bg-slate-950/60 opacity-30"></div>
                @endfor

                {{-- Dias do mês --}}
                @for ($dia = 1; $dia <= $totalDiasMes; $dia++)
                    @php
                        $dataDiaFormatada = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);
                        $agendamentosDoDia = $agendamentosPorDia->get($dataDiaFormatada, collect());
                        $ehHoje = $dataDiaFormatada === date('Y-m-d');
                    @endphp

                    <div class="min-h-[110px] sm:min-h-[130px] p-2 bg-slate-900 flex flex-col justify-between hover:bg-slate-850 transition relative group">
                        <!-- Topo da célula: Número do dia e contador -->
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold {{ $ehHoje ? 'bg-amber-500 text-slate-950 font-black shadow-md' : 'text-slate-300' }}">
                                {{ $dia }}
                            </span>
                            @if($agendamentosDoDia->isNotEmpty())
                                <span class="text-[10px] px-1.5 py-0.2 rounded-full font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                    {{ $agendamentosDoDia->count() }}
                                </span>
                            @endif
                        </div>

                        <!-- Lista de Marcações neste dia -->
                        <div class="space-y-1 overflow-y-auto max-h-[85px] pr-0.5">
                            @foreach($agendamentosDoDia as $item)
                                <button type="button" 
                                        onclick="abrirModalDetalhes({{ json_encode([
                                            'id' => $item->id,
                                            'cliente' => $item->user->name,
                                            'email' => $item->user->email,
                                            'servico' => $item->servico->nome,
                                            'preco' => number_format($item->servico->preco, 2, ',', ' ') . ' €',
                                            'duracao' => $item->servico->duracao_minutos . ' min',
                                            'data_hora' => $item->data_hora->format('d/m/Y \à\s H:i\h'),
                                            'veiculo' => $item->veiculo ?? 'Não especificado',
                                            'observacoes' => $item->observacoes ?? 'Sem notas adicionais.',
                                            'notas_admin' => $item->notas_admin ?? '',
                                            'estado' => $item->estado,
                                            'estado_label' => $item->estado_label,
                                            'update_url' => route('admin.agendamentos.estado', $item)
                                        ]) }})"
                                        class="w-full text-left p-1 rounded-md text-[11px] font-semibold transition truncate block border cursor-pointer {{ $item->estado === 'confirmado' ? 'bg-emerald-950/70 border-emerald-500/40 text-emerald-300 hover:bg-emerald-900/80' : ($item->estado === 'concluido' ? 'bg-sky-950/70 border-sky-500/40 text-sky-300 hover:bg-sky-900/80' : ($item->estado === 'cancelado' ? 'bg-red-950/70 border-red-500/40 text-red-300 hover:bg-red-900/80' : 'bg-amber-950/70 border-amber-500/40 text-amber-300 hover:bg-amber-900/80')) }}">
                                    <span class="font-bold opacity-80">{{ $item->data_hora->format('H:i') }}</span>
                                    {{ $item->user->name }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Espaço base invisível para alinhamento -->
                        <div class="h-0.5"></div>
                    </div>
                @endfor

                {{-- Células vazias após o último dia do mês para completar a grelha --}}
                @for ($j = 0; $j < $diasRestantes; $j++)
                    <div class="min-h-[110px] sm:min-h-[130px] p-2 bg-slate-950/60 opacity-30"></div>
                @endfor
            </div>
        </div>

        <!-- Lista Resumida de Marcações deste Mês -->
        <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 sm:p-8 shadow-xl">
            <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <span class="w-2.5 h-5 bg-amber-500 rounded-full"></span>
                Lista Completa de Marcações em {{ $dataAtual->translatedFormat('F Y') }} ({{ $agendamentos->count() }})
            </h2>

            @if($agendamentos->isEmpty())
                <p class="text-sm text-slate-400">Não existem agendamentos para este mês.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-950 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-800">
                            <tr>
                                <th class="p-3">Data / Hora</th>
                                <th class="p-3">Cliente</th>
                                <th class="p-3">Serviço</th>
                                <th class="p-3">Veículo</th>
                                <th class="p-3">Estado</th>
                                <th class="p-3 text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($agendamentos as $item)
                                <tr class="hover:bg-slate-850/60 transition">
                                    <td class="p-3 font-semibold text-white">
                                        {{ $item->data_hora->format('d/m/Y') }} às {{ $item->data_hora->format('H:i') }}h
                                    </td>
                                    <td class="p-3">
                                        <div class="font-bold text-slate-200">{{ $item->user->name }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $item->user->email }}</div>
                                    </td>
                                    <td class="p-3">
                                        <span class="font-medium text-amber-400">{{ $item->servico->nome }}</span>
                                    </td>
                                    <td class="p-3 text-slate-400">
                                        {{ $item->veiculo ?? '—' }}
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->estado_badge_class }}">
                                            {{ $item->estado_label }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <button type="button" 
                                                onclick="abrirModalDetalhes({{ json_encode([
                                                    'id' => $item->id,
                                                    'cliente' => $item->user->name,
                                                    'email' => $item->user->email,
                                                    'servico' => $item->servico->nome,
                                                    'preco' => number_format($item->servico->preco, 2, ',', ' ') . ' €',
                                                    'duracao' => $item->servico->duracao_minutos . ' min',
                                                    'data_hora' => $item->data_hora->format('d/m/Y \à\s H:i\h'),
                                                    'veiculo' => $item->veiculo ?? 'Não especificado',
                                                    'observacoes' => $item->observacoes ?? 'Sem notas adicionais.',
                                                    'notas_admin' => $item->notas_admin ?? '',
                                                    'estado' => $item->estado,
                                                    'estado_label' => $item->estado_label,
                                                    'update_url' => route('admin.agendamentos.estado', $item)
                                                ]) }})"
                                                class="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 rounded-lg text-xs font-semibold transition cursor-pointer">
                                            Gerir
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Gestão de Agendamento -->
    <div id="modalDetalhes" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative">
            <button type="button" onclick="fecharModalDetalhes()" class="absolute top-5 right-5 text-slate-400 hover:text-white transition text-xl cursor-pointer">
                &times;
            </button>

            <div class="mb-5">
                <span id="modalEstadoBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2"></span>
                <h3 id="modalServicoNome" class="text-xl font-black text-white"></h3>
                <p id="modalDataHora" class="text-xs text-amber-400 font-semibold mt-0.5"></p>
            </div>

            <div class="space-y-3 p-4 bg-slate-950 rounded-2xl border border-slate-800 text-xs mb-6">
                <div>
                    <span class="text-slate-500 block uppercase font-bold text-[10px]">Cliente</span>
                    <span id="modalClienteNome" class="font-bold text-white text-sm"></span> 
                    <span id="modalClienteEmail" class="text-slate-400"></span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-800/80">
                    <div>
                        <span class="text-slate-500 block uppercase font-bold text-[10px]">Preço / Duração</span>
                        <span id="modalPrecoDuracao" class="text-white font-semibold"></span>
                    </div>
                    <div>
                        <span class="text-slate-500 block uppercase font-bold text-[10px]">Veículo</span>
                        <span id="modalVeiculo" class="text-white font-semibold"></span>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-800/80">
                    <span class="text-slate-500 block uppercase font-bold text-[10px]">Notas do Cliente</span>
                    <p id="modalObservacoes" class="text-slate-300 italic mt-0.5"></p>
                </div>
            </div>

            <!-- Formulário de Atualização de Estado -->
            <form id="formAtualizarEstado" method="POST" action="">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                        Alterar Estado:
                    </label>
                    <div class="grid grid-cols-4 gap-2">
                        <label class="cursor-pointer text-center">
                            <input type="radio" name="estado" value="pendente" class="sr-only peer">
                            <span class="block py-2 px-1 text-[11px] font-bold rounded-xl border border-amber-500/40 text-amber-400 bg-amber-500/10 peer-checked:bg-amber-500 peer-checked:text-slate-950 transition">
                                Pendente
                            </span>
                        </label>
                        <label class="cursor-pointer text-center">
                            <input type="radio" name="estado" value="confirmado" class="sr-only peer">
                            <span class="block py-2 px-1 text-[11px] font-bold rounded-xl border border-emerald-500/40 text-emerald-400 bg-emerald-500/10 peer-checked:bg-emerald-500 peer-checked:text-slate-950 transition">
                                Confirmar
                            </span>
                        </label>
                        <label class="cursor-pointer text-center">
                            <input type="radio" name="estado" value="concluido" class="sr-only peer">
                            <span class="block py-2 px-1 text-[11px] font-bold rounded-xl border border-sky-500/40 text-sky-400 bg-sky-500/10 peer-checked:bg-sky-500 peer-checked:text-slate-950 transition">
                                Concluir
                            </span>
                        </label>
                        <label class="cursor-pointer text-center">
                            <input type="radio" name="estado" value="cancelado" class="sr-only peer">
                            <span class="block py-2 px-1 text-[11px] font-bold rounded-xl border border-red-500/40 text-red-400 bg-red-500/10 peer-checked:bg-red-500 peer-checked:text-white transition">
                                Cancelar
                            </span>
                        </label>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="modalNotasAdmin" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                        Nota da Oficina (visível para o cliente)
                    </label>
                    <textarea name="notas_admin" id="modalNotasAdmin" rows="2" placeholder="Ex: Peças já reservadas. Por favor chegar 10 min antes." class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-3.5 py-2 text-xs focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="fecharModalDetalhes()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition cursor-pointer">
                        Fechar
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition shadow-md cursor-pointer">
                        Guardar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalDetalhes(data) {
            document.getElementById('modalServicoNome').textContent = data.servico;
            document.getElementById('modalDataHora').textContent = data.data_hora;
            document.getElementById('modalClienteNome').textContent = data.cliente;
            document.getElementById('modalClienteEmail').textContent = '(' + data.email + ')';
            document.getElementById('modalPrecoDuracao').textContent = data.preco + ' • ' + data.duracao;
            document.getElementById('modalVeiculo').textContent = data.veiculo;
            document.getElementById('modalObservacoes').textContent = data.observacoes;
            document.getElementById('modalNotasAdmin').value = data.notas_admin;

            const badge = document.getElementById('modalEstadoBadge');
            badge.textContent = data.estado_label;
            badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2 ';
            if (data.estado === 'confirmado') {
                badge.className += 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/40';
            } else if (data.estado === 'concluido') {
                badge.className += 'bg-sky-500/20 text-sky-400 border border-sky-500/40';
            } else if (data.estado === 'cancelado') {
                badge.className += 'bg-red-500/20 text-red-400 border border-red-500/40';
            } else {
                badge.className += 'bg-amber-500/20 text-amber-400 border border-amber-500/40';
            }

            // Selecionar radio button correspondente
            const radios = document.getElementsByName('estado');
            for (let r of radios) {
                r.checked = (r.value === data.estado);
            }

            // Atualizar action da form
            document.getElementById('formAtualizarEstado').action = data.update_url;

            const modal = document.getElementById('modalDetalhes');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function fecharModalDetalhes() {
            const modal = document.getElementById('modalDetalhes');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Fechar ao clicar fora
        document.getElementById('modalDetalhes').addEventListener('click', function(e) {
            if (e.target === this) {
                fecharModalDetalhes();
            }
        });
    </script>
@endsection
