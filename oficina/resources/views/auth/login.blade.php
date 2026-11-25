<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-white">Iniciar Sessão</h1>
        <p class="text-xs text-slate-400 mt-1">Aceda à plataforma AutoFix como Administrador ou Utilizador</p>
    </div>

    <!-- Acesso Rápido para Testes -->
    <div class="mb-6 p-3 bg-slate-950/80 border border-slate-800 rounded-xl">
        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Acesso Rápido (1 Clique):</p>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="preencherLogin('admin@oficina.pt', 'admin123')" class="p-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-medium text-left transition border border-amber-500/30 hover:border-amber-500 flex flex-col cursor-pointer shadow-sm">
                <span class="font-bold text-amber-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                    Administrador
                </span>
                <span class="text-[10px] text-slate-400 mt-0.5">admin@oficina.pt</span>
            </button>

            <button type="button" onclick="preencherLogin('test@example.com', 'password')" class="p-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-medium text-left transition border border-slate-700 hover:border-slate-500 flex flex-col cursor-pointer shadow-sm">
                <span class="font-bold text-slate-200 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                    Utilizador / Cliente
                </span>
                <span class="text-[10px] text-slate-400 mt-0.5">test@example.com</span>
            </button>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-medium text-slate-300 mb-1">Email</label>
            <input id="email" class="block w-full rounded-lg bg-slate-950 border border-slate-800 text-white px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-medium text-slate-300 mb-1">Palavra-passe</label>
            <input id="password" class="block w-full rounded-lg bg-slate-950 border border-slate-800 text-white px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-950 text-amber-500 shadow-sm focus:ring-amber-500" name="remember">
                <span class="ms-2 text-xs text-slate-400">Lembrar-me</span>
            </label>
        </div>

        <div class="flex items-center justify-between pt-2">
            @if (Route::has('register'))
                <a class="text-xs text-slate-400 hover:text-amber-400 transition" href="{{ route('register') }}">
                    Criar nova conta
                </a>
            @else
                <span></span>
            @endif

            <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-lg text-sm shadow-md transition cursor-pointer">
                Entrar
            </button>
        </div>
    </form>

    <script>
        function preencherLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
