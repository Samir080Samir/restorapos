<nav class="bg-white border-b border-gray-200 px-5 py-2.5 flex items-center justify-between">

    {{-- Sol hissə --}}
    <div>

        <h2 class="text-lg font-bold text-gray-800">
            İdarə paneli
        </h2>

        <p class="text-xs text-gray-500 mt-0.5">
            NovaPos Super Admin
        </p>

    </div>

    {{-- Sağ hissə --}}
    <div class="flex items-center gap-2.5">

        {{-- Dil seçimi --}}
        <div class="bg-gray-100 rounded-xl px-3 h-8 flex items-center">

            <span class="text-xs font-semibold text-gray-700">
                AZ
            </span>

        </div>

        {{-- Bildiriş --}}
        <button class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition relative">

            <svg class="w-4 h-4 text-gray-700"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />

            </svg>

            <span class="w-2 h-2 bg-red-500 rounded-full absolute top-1.5 right-1.5"></span>

        </button>

        {{-- Profil --}}
        <div class="flex items-center gap-2 bg-gray-100 rounded-xl px-2 py-1.5">

            <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold text-[10px] shadow">

                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}

            </div>

            <div class="hidden md:block">

                <p class="font-semibold text-gray-800 text-[11px] leading-none">
                    {{ auth()->user()->name ?? 'Super Admin' }}
                </p>

                <p class="text-[10px] text-gray-500 mt-1">
                    Aktiv
                </p>

            </div>

        </div>

        {{-- Çıxış --}}
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit"
                class="bg-red-50 hover:bg-red-100 text-red-600 px-2.5 py-1.5 rounded-xl text-[11px] font-semibold transition">

                Çıxış

            </button>

        </form>

    </div>

</nav>