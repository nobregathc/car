@extends('layouts.oficina')

@section('titulo', 'Agendar Serviço - AutoFix')

@section('conteudo')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('servicos.index') }}" class="text-xs font-semibold text-slate-400 hover:text-amber-400 transition flex items-center gap-1.5">
                &larr; Voltar aos Serviços
            </a>
        </div>

        <div class="bg-slate-900 p-6 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-3 h-8 bg-amber-500 rounded-full"></span>
                <div>
                    <h1 class="text-2xl font-black text-white">Marcar Agendamento</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Escolha o serviço, a data e o horário mais conveniente para si</p>
                </div>
            </div>

            <form action="{{ route('agendamentos.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Serviço -->
                <div>
                    <label for="servico_id" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                        Serviço Pretendido *
                    </label>
                    <select name="servico_id" id="servico_id" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-3 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                        <option value="">Selecione o serviço...</option>
                        @foreach($servicos as $servico)
                            <option value="{{ $servico->id }}" {{ (old('servico_id', $servicoSelecionadoId) == $servico->id) ? 'selected' : '' }}>
                                {{ $servico->nome }} ({{ number_format($servico->preco, 2, ',', ' ') }} € • {{ $servico->duracao_minutos }} min) — [{{ $servico->categoria->nome }}]
                            </option>
                        @endforeach
                    </select>
                    @error('servico_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data e Hora -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="data" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                            Data Desejada *
                        </label>
                        <input type="date" 
                               name="data" 
                               id="data" 
                               min="{{ date('Y-m-d') }}" 
                               value="{{ old('data', date('Y-m-d')) }}" 
                               class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" 
                               required>
                        @error('data')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hora" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                            Horário *
                        </label>
                        <select name="hora" id="hora" class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" required>
                            <option value="">Selecione a hora...</option>
                            @php
                                $horas = [
                                    '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                                    '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
                                ];
                            @endphp
                            @foreach($horas as $h)
                                <option value="{{ $h }}" {{ old('hora') == $h ? 'selected' : '' }}>
                                    {{ $h }}h
                                </option>
                            @endforeach
                        </select>
                        @error('hora')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dados do Veículo -->
                <div>
                    <label for="veiculo" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                        Dados do Veículo (Marca, Modelo e Matrícula)
                    </label>
                    <input type="text" 
                           name="veiculo" 
                           id="veiculo" 
                           value="{{ old('veiculo') }}" 
                           placeholder="Ex: Renault Clio 1.2 (00-AA-00)" 
                           class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition">
                    @error('veiculo')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Observações / Notas -->
                <div>
                    <label for="observacoes" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                        Notas ou Sintomas detetados (opcional)
                    </label>
                    <textarea name="observacoes" 
                              id="observacoes" 
                              rows="3" 
                              placeholder="Indique barulhos estranhos, avisos no painel ou pedidos específicos..." 
                              class="block w-full rounded-xl bg-slate-950 border border-slate-700 text-white px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition">{{ old('observacoes') }}</textarea>
                    @error('observacoes')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                    <a href="{{ route('servicos.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-sm font-extrabold shadow-lg shadow-amber-500/20 transition cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Confirmar Agendamento
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
