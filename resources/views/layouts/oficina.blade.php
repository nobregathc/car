<!DOCTYPE html>
<html lang="pt-PT" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'AutoFix - Oficina Mecânica')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 flex flex-col min-h-screen selection:bg-amber-500 selection:text-slate-900">

    <nav class="bg-slate-900 border-b border-slate-800 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3.5 flex flex-wrap justify-between items-center gap-4">
            <a href="{{ route('inicio') }}" class="text-2xl font-black text-amber-500 tracking-wider flex items-center gap-2">
                <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                AutoFix
            </a>

            <!-- Links de Navegação -->
            <div class="flex flex-wrap items-center space-x-1 sm:space-x-3 text-sm">
                <a href="{{ route('inicio') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('inicio') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    Início
                </a>
                <a href="{{ route('servicos.index') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('servicos.*') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    Serviços
                </a>
                <a href="{{ route('categorias.index') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('categorias.*') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    Categorias
                </a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.calendario') }}" class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('admin.calendario') ? 'bg-amber-500 text-slate-900 font-extrabold' : 'text-amber-400 hover:bg-slate-800/80 font-semibold' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Calendário
                        </a>
                    @else
                        <a href="{{ route('agendamentos.create') }}" class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5 {{ request()->routeIs('agendamentos.create') ? 'bg-amber-500 text-slate-900 font-bold' : 'text-amber-400 hover:bg-slate-800 font-semibold' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Agendar Serviço
                        </a>
                        <a href="{{ route('agendamentos.meus') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('agendamentos.meus') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                            Meus Agendamentos
                        </a>
                    @endif
                @else
                    <a href="{{ route('agendamentos.create') }}" class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5 text-amber-400 hover:bg-slate-800 font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Agendar Serviço
                    </a>
                @endauth

                <a href="{{ route('contacto') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('contacto') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    Contacto
                </a>
            </div>

            <!-- Área de Utilizador / Canto do Ecrã -->
            <div class="flex flex-wrap items-center gap-3 text-sm">
                @guest
                    <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="px-3 py-1.5 rounded-lg bg-amber-500 text-slate-900 font-bold hover:bg-amber-400 transition">
                        Criar conta
                    </a>
                @else
                    @if(auth()->user()->is_admin)
                        <div class="hidden sm:flex items-center gap-1.5">
                            <a href="{{ route('servicos.create') }}" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold flex items-center gap-1 shadow-sm transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                + Serviço
                            </a>
                            <a href="{{ route('categorias.create') }}" class="px-2.5 py-1.5 rounded-lg bg-sky-600 hover:bg-sky-500 text-white text-xs font-semibold flex items-center gap-1 shadow-sm transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                + Categoria
                            </a>
                        </div>
                    @endif

                    <!-- Bloco Identificador: Email + Papel (Admin/User) + Botão Sair -->
                    <div class="flex items-center gap-3 pl-3 border-l border-slate-800">
                        <div class="text-right leading-tight">
                            <span class="block text-xs font-semibold text-slate-200">{{ auth()->user()->email }}</span>
                            @if(auth()->user()->is_admin)
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider bg-amber-500/20 text-amber-400 border border-amber-500/40">
                                    ADMIN
                                </span>
                            @else
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-300 border border-slate-700">
                                    USER
                                </span>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600/80 hover:bg-red-600 text-white text-xs font-bold transition shadow-sm cursor-pointer">
                                Sair
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    @if(session('sucesso'))
        <div class="max-w-7xl mx-auto w-full px-4 mt-6">
            <div class="bg-emerald-950/70 border border-emerald-500/50 text-emerald-300 px-4 py-3 rounded-xl text-sm flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>{{ session('sucesso') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if(session('erro'))
        <div class="max-w-7xl mx-auto w-full px-4 mt-6">
            <div class="bg-red-950/70 border border-red-500/50 text-red-300 px-4 py-3 rounded-xl text-sm flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <span>{{ session('erro') }}</span>
                </div>
            </div>
        </div>
    @endif

    <main class="flex-grow max-w-7xl mx-auto w-full px-4 py-8">
        @yield('conteudo')
    </main>

    <footer class="bg-slate-900 border-t border-slate-800 text-slate-400 text-xs py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="font-bold text-amber-500">AutoFix</span>
                <span>• Oficina Mecânica Especializada</span>
            </div>
            <div>
                © {{ date('Y') }} AutoFix. Modo Escuro Ativo.
            </div>
        </div>
    </footer>

</body>
</html>
