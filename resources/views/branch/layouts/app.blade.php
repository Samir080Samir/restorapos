<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ config('app.name', 'NovaPOS') }} - Branch Panel
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased overflow-hidden">

    @php

    $navbarBranches = collect();

    $restaurant = null;

    if (session('owner_restaurant_id')) {

    $restaurant = \App\Models\Restaurant::find(
    session('owner_restaurant_id')
    );

    $navbarBranches = \App\Models\Branch::where(
    'restaurant_id',
    session('owner_restaurant_id')
    )
    ->where('status', 'active')
    ->orderBy('name')
    ->get();

    }

    $userType = session('owner_user_type');

    $restaurantName =
    session('owner_restaurant_name')
    ?: optional($restaurant)->name
    ?: 'Restoran';

    $restaurantOwnerName =
    optional($restaurant)->owner_name
    ?: $restaurantName;

    $currentPanelUser = null;

    if (
    $userType === 'staff'
    && session('owner_user_id')
    ) {

    $currentPanelUser = \App\Models\User::with('branch')
    ->find(session('owner_user_id'));

    }

    $selectedBranchId =
    session('owner_selected_branch_id')
    ?: session('owner_branch_id');

    $currentBranch = null;

    if ($selectedBranchId) {

    $currentBranch = \App\Models\Branch::where(
    'restaurant_id',
    session('owner_restaurant_id')
    )
    ->where('id', $selectedBranchId)
    ->first();

    }

    $selectedBranchName =
    optional($currentBranch)->name
    ?: session('owner_selected_branch_name')
    ?: 'Filial';

    $isOwnerPreview = $userType === 'owner';

    $displayUserName = $currentPanelUser
    ? $currentPanelUser->name
    : $restaurantOwnerName;

    $displayUserRole = $currentPanelUser
    ? 'Filial əməkdaşı'
    : 'Restoran sahibi';

    @endphp

    <div class="h-screen flex overflow-hidden">

        {{-- Mobile overlay --}}
        <div id="branchSidebarOverlay"
            onclick="closeBranchSidebar()"
            class="hidden fixed inset-0 z-40 bg-black/40 lg:hidden">
        </div>

        {{-- Sidebar --}}
        <aside id="branchSidebar"
            class="fixed lg:relative inset-y-0 left-0 z-50 w-64 h-screen bg-[#2f3f7a] text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shrink-0">

            {{-- Logo --}}
            <div class="h-16 flex items-center justify-between px-5 border-b border-white/10 shrink-0">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                        <span class="text-[#2f3f7a] font-black text-lg">
                            N
                        </span>
                    </div>

                    <div>
                        <h1 class="font-bold text-lg leading-none">
                            NovaPOS
                        </h1>

                        <p class="text-xs text-white/60 mt-1">
                            Branch Panel
                        </p>
                    </div>

                </div>

                <button type="button"
                    onclick="closeBranchSidebar()"
                    class="lg:hidden w-9 h-9 rounded-xl bg-white/10 text-white/80 flex items-center justify-center hover:bg-white/15 transition">

                    <svg class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">

                        <path d="M6 6l12 12M18 6L6 18" />

                    </svg>

                </button>

            </div>

            {{-- Sidebar menu --}}
            <nav class="flex-1 min-h-0 px-3 py-2 space-y-0 overflow-y-auto scrollbar-hide">

                @php

                $menus = [

                [
                'label' => 'Statistikalar',
                'route' => 'branch.dashboard',
                'icon' => 'dashboard',
                'children' => []
                ],

                [
                'label' => 'Satış',
                'route' => 'branch.sales.index',
                'icon' => 'sales',
                'children' => [

                [
                'label' => 'Çeklər',
                'route' => 'branch.sales.receipts.index'
                ],

                [
                'label' => 'Sifariş Bildirişləri',
                'route' => 'branch.sales.notifications.index'
                ],

                [
                'label' => 'Geri qaytarılma',
                'route' => 'branch.sales.refunds.index'
                ],

                [
                'label' => 'Ödəmə üsulları',
                'route' => 'branch.sales.payment-methods.index'
                ],

                [
                'label' => 'Satış üsulları',
                'route' => 'branch.sales.methods.index'
                ],

                ]
                ],

                [
                'label' => 'Maliyyə',
                'route' => 'branch.finance.index',
                'icon' => 'finance',
                'children' => [

                [
                'label' => 'Hesabatlar',
                'route' => 'branch.finance.reports.index'
                ],

                [
                'label' => 'Kateqoriyalar',
                'route' => 'branch.finance.categories.index'
                ],

                [
                'label' => 'Əməliyyatlar',
                'route' => 'branch.finance.transactions.index'
                ],

                [
                'label' => 'Əməkhaqqı',
                'route' => 'branch.finance.payroll.index'
                ],

                [
                'label' => 'Pul axını',
                'route' => 'branch.finance.cashflow.index'
                ],

                [
                'label' => 'Mənfəət və Zərər',
                'route' => 'branch.finance.profit-loss.index'
                ],

                ]
                ],

                [
                'label' => 'Masalar',
                'route' => 'branch.tables.index',
                'icon' => 'tables',
                'children' => []
                ],

                [
                'label' => 'Menyu',
                'route' => 'branch.menu.index',
                'icon' => 'menu',
                'children' => [

                [
                'label' => 'Məhsullar',
                'route' => 'branch.menu.products.index'
                ],

                [
                'label' => 'Yarımfabrikat',
                'route' => 'branch.menu.semi-products.index'
                ],

                [
                'label' => 'İnqrediyent',
                'route' => 'branch.menu.ingredients.index'
                ],

                [
                'label' => 'Kateqoriyalar',
                'route' => 'branch.menu.categories.index'
                ],

                [
                'label' => 'Şöbələr',
                'route' => 'branch.menu.departments.index'
                ],

                [
                'label' => 'Menyu quruluşu',
                'route' => 'branch.menu.structure.index'
                ],

                [
                'label' => 'Modifaktorlar',
                'route' => 'branch.menu.modifiers.index'
                ],

                ]
                ],

                [
                'label' => 'İnventar',
                'route' => 'branch.inventory.index',
                'icon' => 'inventory',
                'children' => [

                [
                'label' => 'Ehtiyat',
                'route' => 'branch.inventory.stock.index'
                ],

                [
                'label' => 'Tədarüklər',
                'route' => 'branch.inventory.supplies.index'
                ],

                [
                'label' => 'Tədarüklərin geri qaytarılması',
                'route' => 'branch.inventory.returns.index'
                ],

                [
                'label' => 'Köçürmələr',
                'route' => 'branch.inventory.transfers.index'
                ],

                [
                'label' => 'Tullantı / İsraf',
                'route' => 'branch.inventory.waste.index'
                ],

                [
                'label' => 'Hərəkət Hesabatları',
                'route' => 'branch.inventory.reports.index'
                ],

                [
                'label' => 'Məhsul Hərəkətləri',
                'route' => 'branch.inventory.movements.index'
                ],

                [
                'label' => 'İnventarlaşdırma',
                'route' => 'branch.inventory.counting.index'
                ],

                [
                'label' => 'Anbar',
                'route' => 'branch.inventory.warehouses.index'
                ],

                [
                'label' => 'Qablaşdırmalar',
                'route' => 'branch.inventory.packages.index'
                ],

                [
                'label' => 'Tədarükçülər',
                'route' => 'branch.inventory.suppliers.index'
                ],

                [
                'label' => 'İstehsalat',
                'route' => 'branch.inventory.production.index'
                ],

                ]
                ],

                [
                'label' => 'QR Menu',
                'route' => 'branch.qr.index',
                'icon' => 'qr',
                'children' => []
                ],

                [
                'label' => 'Kampaniyalar',
                'route' => 'branch.campaigns.index',
                'icon' => 'campaign',
                'children' => []
                ],

                [
                'label' => 'Tənzimləmələr',
                'route' => 'branch.settings.index',
                'icon' => 'settings',
                'children' => [

                [
                'label' => 'Ümumi',
                'route' => 'branch.settings.general.index'
                ],

                [
                'label' => 'Terminal',
                'route' => 'branch.settings.terminal.index'
                ],

                [
                'label' => 'Vergilər',
                'route' => 'branch.settings.taxes.index'
                ],

                [
                'label' => 'Çeklər',
                'route' => 'branch.settings.receipts.index'
                ],

                [
                'label' => 'Abunəliklər',
                'route' => 'branch.settings.subscriptions.index'
                ],

                [
                'label' => 'Masa idarəetməsi',
                'route' => 'branch.settings.tables.index'
                ],

                [
                'label' => 'Etiket Meneceri',
                'route' => 'branch.settings.labels.index'
                ],

                ]
                ],

                ];

                @endphp

                @foreach($menus as $menu)

                @php
                $hasChildren = count($menu['children']) > 0;
                @endphp

                @if($hasChildren)

                <details class="group">

                    <summary class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium cursor-pointer list-none transition text-white/80 hover:bg-white/10 hover:text-white">

                        <span class="w-5 h-5 flex items-center justify-center shrink-0">

                            @include('owner.partials.sidebar-icon', [
                            'icon' => $menu['icon']
                            ])

                        </span>

                        <span class="truncate">
                            {{ __($menu['label']) }}
                        </span>

                    </summary>

                    <div class="mt-1 mb-2 ml-5 pl-3 border-l border-white/10 space-y-1">

                        @foreach($menu['children'] as $child)

                        <a href="{{ Route::has($child['route']) ? route($child['route']) : '#' }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs text-white/60 hover:bg-white/10 hover:text-white transition">

                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60 shrink-0"></span>

                            <span class="truncate">
                                {{ __($child['label']) }}
                            </span>

                        </a>

                        @endforeach

                    </div>

                </details>

                @else

                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition">

                    <span class="w-5 h-5 flex items-center justify-center shrink-0">

                        @include('owner.partials.sidebar-icon', [
                        'icon' => $menu['icon']
                        ])

                    </span>

                    <span class="truncate">
                        {{ __($menu['label']) }}
                    </span>

                </a>

                @endif

                @endforeach

            </nav>

            {{-- User --}}
            <div class="px-3 pb-5 pt-2 shrink-0">

                <div class="flex items-center gap-3 bg-white/10 rounded-2xl px-3 py-3">

                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">

                        <svg class="w-5 h-5 text-white/85"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24">

                            <path d="M20 21a8 8 0 0 0-16 0" />
                            <circle cx="12" cy="7" r="4" />

                        </svg>

                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-sm font-semibold truncate">
                            {{ $displayUserName }}
                        </p>

                        <p class="text-xs text-white/60 truncate">
                            {{ $displayUserRole }}
                        </p>

                    </div>

                    <form method="POST"
                        action="{{ route('branch.logout') }}"
                        class="shrink-0">

                        @csrf

                        <button type="submit"
                            title="Çıxış et"
                            class="w-9 h-9 rounded-xl bg-white/10 hover:bg-red-500/80 text-white/80 hover:text-white flex items-center justify-center transition">

                            <svg class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M12 3v10" />
                                <path d="M6.3 6.3a8 8 0 1 0 11.4 0" />

                            </svg>

                        </button>

                    </form>

                </div>

            </div>

        </aside>

        {{-- Main --}}
        <div class="flex-1 min-w-0 h-screen flex flex-col overflow-hidden">

            {{-- Header --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 shrink-0">

                <div class="flex items-center gap-3">

                    <button type="button"
                        onclick="openBranchSidebar()"
                        class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center">

                        <svg class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                    </button>

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            @yield('title', 'Statistikalar')
                        </h2>

                        <p class="hidden sm:block text-xs text-slate-500 mt-0.5">
                            Filial idarəetmə paneli
                        </p>

                    </div>

                </div>

                <div class="flex items-center gap-2">

                    @if($isOwnerPreview)

                    <div class="hidden md:flex items-center gap-2">

                        <div class="flex items-center gap-2 px-3 h-10 rounded-xl bg-slate-100 border border-slate-200">

                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                            <span class="text-xs font-semibold text-slate-500">
                                Baxış:
                            </span>

                            <span class="text-sm font-bold text-slate-800 whitespace-nowrap">
                                {{ $selectedBranchName }}
                            </span>

                        </div>

                        <form method="POST"
                            action="{{ route('owner.branches.switch') }}">

                            @csrf

                            <div class="relative">

                                <select name="branch_id"
                                    onchange="this.form.submit()"
                                    style="-webkit-appearance:none; -moz-appearance:none; appearance:none; background-image:none;"
                                    class="h-10 rounded-xl border border-slate-200 bg-slate-50 pl-4 pr-10 text-sm font-medium text-slate-700 min-w-[220px]">

                                    <option value="">
                                        {{ $restaurantName }}
                                    </option>

                                    @foreach($navbarBranches as $branch)

                                    <option value="{{ $branch->id }}"
                                        {{ $selectedBranchId == $branch->id ? 'selected' : '' }}>

                                        {{ $branch->name }}

                                    </option>

                                    @endforeach

                                </select>

                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path d="M6 9l6 6 6-6" />

                                </svg>

                            </div>

                        </form>

                    </div>

                    @else

                    <div class="hidden sm:flex items-center gap-2 px-3 h-10 rounded-xl bg-slate-100 border border-slate-200">

                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                        <span class="text-xs font-semibold text-slate-500">
                            Baxış:
                        </span>

                        <span class="text-sm font-bold text-slate-800 whitespace-nowrap">
                            {{ $selectedBranchName }}
                        </span>

                    </div>

                    @endif

                    {{-- Language --}}
                    <div class="relative">

                        <select
                            style="-webkit-appearance:none; -moz-appearance:none; appearance:none; background-image:none;"
                            class="h-10 rounded-xl border border-slate-200 bg-slate-50 pl-4 pr-9 text-sm text-slate-700">

                            <option>AZ</option>
                            <option>EN</option>
                            <option>RU</option>

                        </select>

                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path d="M6 9l6 6 6-6" />

                        </svg>

                    </div>

                </div>

            </header>

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto overflow-x-hidden">

                <div class="max-w-[1180px] mx-auto p-3 sm:p-4">

                    <div class="scale-[0.90] origin-top">

                        @yield('content')

                    </div>

                </div>

            </main>

        </div>

    </div>

    <script>
        function openBranchSidebar() {

            const sidebar =
                document.getElementById('branchSidebar');

            const overlay =
                document.getElementById('branchSidebarOverlay');

            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');

            overlay.classList.remove('hidden');

        }

        function closeBranchSidebar() {

            const sidebar =
                document.getElementById('branchSidebar');

            const overlay =
                document.getElementById('branchSidebarOverlay');

            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');

            overlay.classList.add('hidden');

        }
    </script>

</body>

</html>