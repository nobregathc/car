@if(isset($servicoDestaque) && $servicoDestaque)
    <div class="bg-gradient-to-r from-slate-900 via-slate-900 to-slate-850 text-white rounded-2xl overflow-hidden mb-10 border border-slate-800 shadow-xl grid grid-cols-1 md:grid-cols-3">
        <div class="h-48 md:h-auto relative overflow-hidden">
            <img src="{{ $servicoDestaque->imagem_url ?? 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?w=800' }}" 
                 alt="{{ $servicoDestaque->nome }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-slate-900/60 to-transparent"></div>
        </div>
        <div class="p-6 md:col-span-2 flex flex-col justify-between">
            <div>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/20 text-amber-400 border border-amber-500/30">
                    ★ Destaque • {{ $servicoDestaque->categoria->nome ?? '' }}
                </span>
                <h2 class="text-2xl font-bold mt-2 text-white">{{ $servicoDestaque->nome }}</h2>
                <p class="text-slate-300 text-sm mt-2 line-clamp-2 leading-relaxed">{{ $servicoDestaque->descricao }}</p>
            </div>
            <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-800">
                <div class="text-sm">
                    <span class="text-2xl font-extrabold text-amber-400">{{ number_format($servicoDestaque->preco, 2, ',', ' ') }} €</span>
                    <span class="text-slate-400 text-xs ml-2">• Duração: {{ $servicoDestaque->duracao_minutos }} min</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('servicos.show', $servicoDestaque) }}" 
                       class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl border border-slate-700 transition">
                        Ver Detalhes
                    </a>
                    @if(!auth()->user()?->is_admin)
                        <a href="{{ route('agendamentos.create', ['servico' => $servicoDestaque->id]) }}" 
                           class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs rounded-xl transition shadow-md">
                            Agendar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
