<aside class="w-64 h-screen bg-[#0F172A] text-white p-5 border-r border-slate-800 overflow-y-auto overflow-x-hidden scrollbar-hide">

    <div class="mb-9">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m3 0h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-black tracking-tight leading-none">
                    NovaPos
                </h1>

                <p class="text-slate-400 text-xs mt-1 tracking-wide">
                    SaaS Super Admin Panel
                </p>
            </div>
        </div>
    </div>

    <nav class="space-y-7">

        <div>
            <p class="text-[11px] uppercase text-slate-500 font-bold mb-3 tracking-wider">
                Əsas
            </p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 bg-gradient-to-r from-blue-600 to-blue-500 px-3 py-2.5 rounded-2xl shadow-lg shadow-blue-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5M9 21v-6h6v6" />
                </svg>

                <span class="font-semibold text-sm">
                    İdarə paneli
                </span>
            </a>
        </div>

        <div>
            <p class="text-[11px] uppercase text-slate-500 font-bold mb-3 tracking-wider">
                Restoran idarəetməsi
            </p>

            <div class="space-y-1.5">

                <a href="{{ route('admin.restaurants.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 21h16M6 21V5a2 2 0 012-2h8a2 2 0 012 2v16M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1" />
                    </svg>

                    <span class="text-sm">
                        Restoranlar
                    </span>
                </a>

                <a href="{{ route('admin.branches.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M8 10h1M15 10h1" />
                    </svg>

                    <span class="text-sm">
                        Filiallar
                    </span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 21a8 8 0 0116 0" />
                    </svg>

                    <span class="text-sm">
                        İstifadəçilər
                    </span>
                </a>

            </div>
        </div>

        <div>
            <p class="text-[11px] uppercase text-slate-500 font-bold mb-3 tracking-wider">
                Tariflər və lisenziya
            </p>

            <div class="space-y-1.5">

                <a href="{{ route('admin.plans.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3l7 4v10l-7 4-7-4V7l7-4zM8 9h8M8 13h8M8 17h5" />
                    </svg>

                    <span class="text-sm">
                        Paketlər
                    </span>
                </a>

                <a href="{{ route('admin.licenses.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 7a4 4 0 11-7.5 2M14 14l7 7M17 17l2-2M19 19l2-2" />
                    </svg>

                    <span class="text-sm">
                        Lisenziyalar
                    </span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 3h6v6H9zM4 15h6v6H4zM14 15h6v6h-6zM12 9v3M7 15v-3h10v3" />
                    </svg>

                    <span class="text-sm">
                        Modul icazələri
                    </span>
                </a>

            </div>
        </div>

        <div>
            <p class="text-[11px] uppercase text-slate-500 font-bold mb-3 tracking-wider">
                Maliyyə
            </p>

            <div class="space-y-1.5">

                <a href="{{ route('admin.payments.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8h18v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8zM3 8l2-4h14l2 4M7 14h4" />
                    </svg>

                    <span class="text-sm">
                        Ödənişlər
                    </span>
                </a>

                <a href="{{ route('admin.campaigns.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v13M12 8a4 4 0 100-8 4 4 0 000 8zM5 13h14M5 13a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2M19 13V8a2 2 0 00-2-2h-1" />
                    </svg>

                    <span class="text-sm whitespace-nowrap">
                        Endirimlər və Kampaniyalar
                    </span>
                </a>

            </div>
        </div>

        <div>
            <p class="text-[11px] uppercase text-slate-500 font-bold mb-3 tracking-wider">
                Təhlükəsizlik
            </p>

            <div class="space-y-1.5">

                <a href="{{ route('admin.admin-roles.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 21a8 8 0 0116 0" />
                    </svg>

                    <span class="text-sm">
                        Admin rolları
                    </span>
                </a>

                <a href="{{ route('admin.audit-logs.index') }}"
                    class="flex items-center gap-3 text-slate-300 hover:bg-slate-800 px-3 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4zM9 12l2 2 4-4" />
                    </svg>

                    <span class="text-sm">
                        Audit tarixçəsi
                    </span>
                </a>

            </div>
        </div>

    </nav>

</aside>