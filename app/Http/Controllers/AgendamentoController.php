<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AgendamentoController extends Controller
{
    /**
     * Formulário para cliente agendar serviço.
     */
    public function create(Request $request)
    {
        $servicos = Servico::with('categoria')->orderBy('nome')->get();
        $servicoSelecionadoId = $request->query('servico');

        return view('agendamentos.create', compact('servicos', 'servicoSelecionadoId'));
    }

    /**
     * Guarda o agendamento criado pelo cliente.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'servico_id' => ['required', 'exists:servicos,id'],
            'data' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required', 'string'],
            'veiculo' => ['nullable', 'string', 'max:150'],
            'observacoes' => ['nullable', 'string', 'max:1000'],
        ], [
            'servico_id.required' => 'Por favor selecione o serviço pretendido.',
            'servico_id.exists' => 'O serviço selecionado não é válido.',
            'data.required' => 'A data do agendamento é obrigatória.',
            'data.after_or_equal' => 'A data do agendamento não pode ser anterior a hoje.',
            'hora.required' => 'A hora do agendamento é obrigatória.',
        ]);

        try {
            $dataHora = Carbon::createFromFormat('Y-m-d H:i', $dados['data'] . ' ' . $dados['hora']);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['hora' => 'Formato de data ou hora inválido.']);
        }

        if ($dataHora->isPast()) {
            return back()->withInput()->withErrors(['hora' => 'A data e hora do agendamento têm de ser no futuro.']);
        }

        Agendamento::create([
            'user_id' => auth()->id(),
            'servico_id' => $dados['servico_id'],
            'data_hora' => $dataHora,
            'veiculo' => $dados['veiculo'],
            'estado' => 'pendente',
            'observacoes' => $dados['observacoes'],
        ]);

        return redirect()
            ->route('agendamentos.meus')
            ->with('sucesso', 'Agendamento registado com sucesso! A oficina irá confirmar em breve.');
    }

    /**
     * Lista de agendamentos do cliente autenticado.
     */
    public function meusAgendamentos()
    {
        $agendamentos = Agendamento::with('servico')
            ->where('user_id', auth()->id())
            ->orderBy('data_hora', 'desc')
            ->paginate(10);

        return view('agendamentos.meus', compact('agendamentos'));
    }

    /**
     * Cliente ou Admin cancela um agendamento.
     */
    public function cancelar(Agendamento $agendamento)
    {
        if (!auth()->user()->is_admin && auth()->id() !== $agendamento->user_id) {
            abort(403, 'Não tem permissão para cancelar este agendamento.');
        }

        $agendamento->update(['estado' => 'cancelado']);

        return back()->with('sucesso', 'Agendamento cancelado com sucesso.');
    }

    /**
     * Calendário de agendamentos para o Administrador.
     */
    public function calendario(Request $request)
    {
        $ano = (int) $request->input('ano', Carbon::now()->year);
        $mes = (int) $request->input('mes', Carbon::now()->month);

        if ($mes < 1) {
            $mes = 12;
            $ano--;
        } elseif ($mes > 12) {
            $mes = 1;
            $ano++;
        }

        $dataAtual = Carbon::createFromDate($ano, $mes, 1);
        $inicioMes = $dataAtual->copy()->startOfMonth();
        $fimMes = $dataAtual->copy()->endOfMonth();

        // Agendamentos deste mês
        $agendamentos = Agendamento::with(['user', 'servico'])
            ->whereBetween('data_hora', [$inicioMes->copy()->startOfDay(), $fimMes->copy()->endOfDay()])
            ->orderBy('data_hora')
            ->get();

        // Agrupar por data (YYYY-MM-DD)
        $agendamentosPorDia = $agendamentos->groupBy(fn($item) => $item->data_hora->format('Y-m-d'));

        // Informações para desenhar a grelha do calendário
        // 1 (Segunda) a 7 (Domingo) em ISO
        $primeiroDiaSemana = $inicioMes->isoWeekday(); // 1 = Seg, 7 = Dom
        $totalDiasMes = $inicioMes->daysInMonth;
        $ultimoDiaSemana = $fimMes->isoWeekday();
        $diasRestantes = 7 - $ultimoDiaSemana;

        $mesAnterior = $dataAtual->copy()->subMonth();
        $mesSeguinte = $dataAtual->copy()->addMonth();

        $stats = [
            'total' => $agendamentos->count(),
            'pendentes' => $agendamentos->where('estado', 'pendente')->count(),
            'confirmados' => $agendamentos->where('estado', 'confirmado')->count(),
            'concluidos' => $agendamentos->where('estado', 'concluido')->count(),
        ];

        return view('admin.calendario', compact(
            'ano',
            'mes',
            'dataAtual',
            'agendamentos',
            'agendamentosPorDia',
            'primeiroDiaSemana',
            'totalDiasMes',
            'diasRestantes',
            'mesAnterior',
            'mesSeguinte',
            'stats'
        ));
    }

    /**
     * Admin atualiza o estado do agendamento (Confirmar / Concluir / Cancelar).
     */
    public function atualizarEstado(Request $request, Agendamento $agendamento)
    {
        $dados = $request->validate([
            'estado' => ['required', 'in:pendente,confirmado,concluido,cancelado'],
            'notas_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $agendamento->update($dados);

        return back()->with('sucesso', 'Estado do agendamento atualizado para: ' . $agendamento->estado_label);
    }
}
