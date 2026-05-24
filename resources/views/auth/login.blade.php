<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaPOS | Admin Girişi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white overflow-hidden">

    <div class="relative min-h-screen flex items-center justify-center px-4">

        {{-- Background --}}
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(139,92,246,0.35),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.35),_transparent_35%)]"></div>

        <div class="absolute inset-0 bg-slate-950/70"></div>

        <div class="absolute inset-0 opacity-20"
            style="background-image: linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.06) 1px, transparent 1px); background-size: 42px 42px;">
        </div>

        {{-- Glow Effects --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-purple-600/30 blur-3xl rounded-full"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-600/30 blur-3xl rounded-full"></div>

        {{-- Login Card --}}
        <div class="relative w-full max-w-md">

            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 via-blue-500 to-cyan-400 rounded-[2rem] blur opacity-60"></div>

            <div class="relative bg-slate-900/80 backdrop-blur-2xl border border-white/10 rounded-[2rem] shadow-2xl overflow-hidden">

                {{-- Header --}}
                <div class="px-8 pt-8 pb-6 text-center">

                    <div class="flex justify-center mb-5">

                        <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-600 to-blue-500 flex items-center justify-center shadow-lg shadow-purple-500/30">

                            <span class="text-4xl font-black italic">
                                N
                            </span>

                        </div>

                    </div>

                    <h1 class="text-4xl font-black tracking-tight">
                        NOVA<span class="text-purple-400">POS</span>
                    </h1>

                    <p class="text-slate-400 mt-2">
                        Admin panelə təhlükəsiz daxil olun
                    </p>

                </div>

                {{-- Form --}}
                <div class="px-8 pb-8">

                    @if (session('status'))
                    <div class="mb-5 rounded-2xl border border-green-400/20 bg-green-500/10 text-green-300 px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-400/20 bg-red-500/10 text-red-300 px-4 py-3 text-sm">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <form method="POST"
                        action="{{ route('login') }}"
                        class="space-y-5">

                        @csrf

                        {{-- Email --}}
                        <div>

                            <label for="email"
                                class="block text-sm font-semibold text-slate-300 mb-2">

                                İstifadəçi adı / Email

                            </label>

                            <div class="relative">

                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                                    @
                                </div>

                                <input id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="admin@novapos.az"
                                    class="w-full pl-10 pr-4 py-4 rounded-2xl bg-slate-950/70 border border-white/10 text-white placeholder:text-slate-500 focus:border-purple-400 focus:ring-2 focus:ring-purple-500/30 outline-none transition">

                            </div>

                        </div>

                        {{-- Password --}}
                        <div>

                            <label for="password"
                                class="block text-sm font-semibold text-slate-300 mb-2">

                                Şifrə

                            </label>

                            <div class="relative">

                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                                    🔑
                                </div>

                                <input id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="w-full pl-11 pr-4 py-4 rounded-2xl bg-slate-950/70 border border-white/10 text-white placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-500/30 outline-none transition">

                            </div>

                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center">

                            <label for="remember_me"
                                class="inline-flex items-center gap-2 cursor-pointer">

                                <input id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-white/20 bg-slate-950 text-purple-500 focus:ring-purple-500">

                                <span class="text-sm text-slate-300">
                                    Məni xatırla
                                </span>

                            </label>

                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-500 hover:to-blue-400 font-bold shadow-lg shadow-purple-500/25 transition">

                            Daxil ol

                        </button>

                    </form>

                    {{-- Footer --}}
                    <div class="mt-6 text-center">

                        <p class="text-xs text-slate-500">
                            © {{ date('Y') }} NovaPOS SaaS Platform
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>