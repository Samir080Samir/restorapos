<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'NovaPOS') }} - Owner Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased overflow-hidden">

    @php
    $navbarBranches = collect();
    $restaurant = null;

    if (session('owner_restaurant_id')) {
    $restaurant = \App\Models\Restaurant::find(session('owner_restaurant_id'));

    $navbarBranches = \App\Models\Branch::where('restaurant_id', session('owner_restaurant_id'))
    ->where('status', 'active')
    ->orderBy('name')
    ->get();
    }

    $selectedBranchId = session('owner_selected_branch_id');
    $selectedBranchName = session('owner_selected_branch_name');
    $userType = session('owner_user_type');

    $restaurantName = session('owner_restaurant_name') ?: optional($restaurant)->name ?: 'Restoran';
    $restaurantOwnerName = optional($restaurant)->owner_name ?: $restaurantName;

    $currentPanelUser = null;

    if ($userType === 'staff' && session('owner_user_id')) {
    $currentPanelUser = \App\Models\User::find(session('owner_user_id'));
    }

    $canSwitchBranch = $userType === 'owner';

    $displayUserName = $currentPanelUser ? $currentPanelUser->name : $restaurantOwnerName;
    $displayUserRole = $currentPanelUser ? 'Panel əməkdaşı' : 'Restoran sahibi';

    $activeViewName = $selectedBranchName ?: $restaurantName;

    $menus = [
    [
    'label' => 'Statistikalar',
    'route' => 'owner.dashboard',
    'icon' => 'dashboard',
    'children' => [],
    ],
    [
    'label' => 'Satış',
    'route' => null,
    'icon' => 'sales',
    'children' => [
    ['label' => 'Çeklər', 'route' => null],
    ['label' => 'Sifariş Bildirişləri', 'route' => null],
    ['label' => 'Geri qaytarılma', 'route' => null],
    ['label' => 'Ödəmə üsulları', 'route' => null],
    ['label' => 'Satış üsulları', 'route' => null],
    ],
    ],
    [
    'label' => 'Maliyyə',
    'route' => null,
    'icon' => 'finance',
    'children' => [
    ['label' => 'Hesabatlar', 'route' => null],
    ['label' => 'Kateqoriyalar', 'route' => null],
    ['label' => 'Əməliyyatlar', 'route' => null],
    ['label' => 'Əməkhaqqı', 'route' => null],
    ['label' => 'Pul axını', 'route' => null],
    ['label' => 'Mənfəət və Zərər', 'route' => null],
    ],
    ],
    [
    'label' => 'Masalar',
    'route' => null,
    'icon' => 'tables',
    'children' => [
    ['label' => 'Masa siyahısı', 'route' => 'owner.tables.index'],
    ['label' => 'Rezervasiyalar', 'route' => 'owner.reservations.index'],
    ],
    ],
    [
    'label' => 'Menyu',
    'route' => null,
    'icon' => 'menu',
    'children' => [
    ['label' => 'Məhsullar', 'route' => 'owner.menu.products.index'],
    ['label' => 'Yarımfabrikat', 'route' => null],
    ['label' => 'İnqrediyent', 'route' => null],
    ['label' => 'Kateqoriyalar', 'route' => 'owner.menu.categories.index'],
    ['label' => 'Şöbələr', 'route' => 'owner.menu.departments.index'],
    ['label' => 'Menyu quruluşu', 'route' => null],
    ['label' => 'Modifaktorlar', 'route' => null],
    ],
    ],
    [
    'label' => 'İnventar',
    'route' => null,
    'icon' => 'inventory',
    'children' => [
    ['label' => 'Ehtiyat', 'route' => null],
    ['label' => 'Tədarüklər', 'route' => null],
    ['label' => 'Tədarüklərin geri qaytarılması', 'route' => null],
    ['label' => 'Köçürmələr', 'route' => null],
    ['label' => 'Tullantı / İsraf', 'route' => null],
    ['label' => 'Hərəkət Hesabatları', 'route' => null],
    ['label' => 'Məhsul Hərəkətləri', 'route' => null],
    ['label' => 'İnventarlaşdırma', 'route' => null],
    ['label' => 'Anbar', 'route' => null],
    ['label' => 'Qablaşdırmalar', 'route' => null],
    ['label' => 'Tədarükçülər', 'route' => null],
    ['label' => 'İstehsalat', 'route' => null],
    ],
    ],
    [
    'label' => 'QR Menu',
    'route' => null,
    'icon' => 'qr',
    'children' => [
    ['label' => 'İdarəçilik', 'route' => 'owner.qr-menu.index'],
    ['label' => 'Canlı izləmə', 'route' => 'owner.qr-live.index'],
    ['label' => 'Məlumat dəyişikliyi', 'route' => 'owner.qr-menu.settings'],
    ],
    ],
    [
    'label' => 'Marketinq',
    'route' => null,
    'icon' => 'marketing',
    'children' => [
    ['label' => 'Müştərilər', 'route' => 'owner.customers.index'],
    ['label' => 'Müştəri Borcları', 'route' => 'owner.customer-debts.index'],
    ],
    ],
    [
    'label' => 'Kampaniyalar',
    'route' => null,
    'icon' => 'campaign',
    'children' => [],
    ],
    [
    'label' => 'Filiallar',
    'route' => 'owner.branches.index',
    'icon' => 'branches',
    'children' => [],
    ],
    [
    'label' => 'Əməkdaşlar',
    'route' => null,
    'icon' => 'staff',
    'children' => [
    ['label' => 'İstifadəçilər', 'route' => 'owner.staff.users.index'],
    ['label' => 'Vəzifələr', 'route' => 'owner.staff.roles.index'],
    ],
    ],
    [
    'label' => 'Cihazlarım',
    'route' => null,
    'icon' => 'devices',
    'children' => [
    ['label' => 'Terminallar', 'route' => 'owner.pos-terminals.index'],
    ],
    ],
    [
    'label' => 'Tənzimləmələr',
    'route' => null,
    'icon' => 'settings',
    'children' => [
    ['label' => 'Ümumi', 'route' => null],
    ['label' => 'Terminal', 'route' => null],
    ['label' => 'Vergilər', 'route' => null],
    ['label' => 'Çeklər', 'route' => null],
    ['label' => 'Abunəliklər', 'route' => null],
    ['label' => 'Masa idarəetməsi', 'route' => 'owner.tables.manage'],
    ['label' => 'Etiket Meneceri', 'route' => null],
    ],
    ],
    ];

    function owner_sidebar_icon_svg($icon) {
    $icons = [
    'dashboard' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M4 4h7v7H4V4Z" />
        <path d="M13 4h7v7h-7V4Z" />
        <path d="M4 13h7v7H4v-7Z" />
        <path d="M13 13h7v7h-7v-7Z" />
    </svg>',
    'sales' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M6.5 8h13l-1.2 7.2a2 2 0 0 1-2 1.7H9.1a2 2 0 0 1-2-1.6L5.7 5.8H3.8" />
        <path d="M9 21h.01M17 21h.01" stroke-width="3" stroke-linecap="round" />
    </svg>',
    'finance' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M4 19V5" />
        <path d="M4 19h16" />
        <path d="M8 16v-5" />
        <path d="M12 16V8" />
        <path d="M16 16v-8" />
    </svg>',
    'tables' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M5 7h14" />
        <path d="M8 7v12" />
        <path d="M16 7v12" />
        <path d="M7 19h10" />
        <path d="M9 4h6" />
    </svg>',
    'menu' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M7 4h10v16H7V4Z" />
        <path d="M10 8h4" />
        <path d="M10 12h4" />
        <path d="M10 16h3" />
    </svg>',
    'inventory' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z" />
        <path d="m4.5 8 7.5 4 7.5-4" />
        <path d="M12 12v9" />
    </svg>',
    'qr' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M4 4h6v6H4V4Z" />
        <path d="M14 4h6v6h-6V4Z" />
        <path d="M4 14h6v6H4v-6Z" />
        <path d="M14 14h2" />
        <path d="M18 14h2" />
        <path d="M14 18h6" />
        <path d="M18 16v4" />
    </svg>',
    'marketing' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <circle cx="12" cy="7" r="3.2" />
        <circle cx="6" cy="10" r="2.6" />
        <circle cx="18" cy="10" r="2.6" />
        <path d="M7.5 20a4.8 4.8 0 0 1 9 0" />
        <path d="M2.8 20a4.4 4.4 0 0 1 6.1-3.9" />
        <path d="M15.1 16.1A4.4 4.4 0 0 1 21.2 20" />
    </svg>',
    'campaign' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M4 13v-2l13-5v12L4 13Z" />
        <path d="M7 13l2 6" />
        <path d="M18 9h3" />
        <path d="M18 15h3" />
    </svg>',
    'branches' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
        <path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1" />
    </svg>',
    'staff' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M20 21a8 8 0 0 0-16 0" />
        <circle cx="12" cy="7" r="4" />
    </svg>',
    'devices' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M4 5h16v11H4V5Z" />
        <path d="M8 21h8" />
        <path d="M12 16v5" />
    </svg>',
    'settings' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
        <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
        <path d="M19.4 15a1.8 1.8 0 0 0 .36 1.98l.06.06a2.1 2.1 0 0 1-2.97 2.97l-.06-.06a1.8 1.8 0 0 0-1.98-.36 1.8 1.8 0 0 0-1.1 1.66V21a2.1 2.1 0 0 1-4.2 0v-.09a1.8 1.8 0 0 0-1.1-1.66 1.8 1.8 0 0 0-1.98.36l-.06.06a2.1 2.1 0 0 1-2.97-2.97l.06-.06A1.8 1.8 0 0 0 4.6 15a1.8 1.8 0 0 0-1.66-1.1H3a2.1 2.1 0 0 1 0-4.2h.09A1.8 1.8 0 0 0 4.75 8.6a1.8 1.8 0 0 0-.36-1.98l-.06-.06a2.1 2.1 0 0 1 2.97-2.97l.06.06A1.8 1.8 0 0 0 9.35 4a1.8 1.8 0 0 0 1.1-1.66V2a2.1 2.1 0 0 1 4.2 0v.09A1.8 1.8 0 0 0 15.75 4a1.8 1.8 0 0 0 1.98-.36l.06-.06a2.1 2.1 0 0 1 2.97 2.97l-.06.06A1.8 1.8 0 0 0 19.4 8.6a1.8 1.8 0 0 0 1.66 1.1H21a2.1 2.1 0 0 1 0 4.2h-.09A1.8 1.8 0 0 0 19.4 15Z" />
    </svg>',
    ];

    return $icons[$icon] ?? $icons['dashboard'];
    }
    @endphp

    <div class="h-screen flex overflow-hidden">

        <div id="ownerSidebarOverlay"
            onclick="closeOwnerSidebar()"
            class="hidden fixed inset-0 z-40 bg-black/40 lg:hidden">
        </div>

        <aside id="ownerSidebar"
            style="background: radial-gradient(circle at top right, rgba(72, 187, 120, .28), transparent 34%), linear-gradient(135deg, #063b31, #083326 60%, #0b4d3d);"
            class="fixed lg:relative inset-y-0 left-0 z-50 w-64 h-screen text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shrink-0 shadow-2xl shadow-emerald-950/30">

            <div class="h-16 flex items-center justify-between px-5 border-b border-white/10 shrink-0">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/95 flex items-center justify-center shadow-sm">
                        <span class="text-[#063b31] font-black text-lg">N</span>
                    </div>

                    <div>
                        <h1 class="font-black text-lg leading-none tracking-tight">NovaPOS</h1>
                        <p class="text-xs text-white/55 mt-1 font-semibold">Owner Panel</p>
                    </div>
                </div>

                <button type="button"
                    onclick="closeOwnerSidebar()"
                    class="lg:hidden w-9 h-9 rounded-xl bg-white/10 text-white/80 flex items-center justify-center hover:bg-white/15 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>

            </div>

            <nav class="flex-1 min-h-0 px-3 py-2 space-y-0 overflow-y-auto scrollbar-hide">

                @foreach($menus as $menu)

                @php
                $hasChildren = count($menu['children']) > 0;
                $menuRouteExists = ! empty($menu['route']) && Route::has($menu['route']);
                $menuHref = $menuRouteExists ? route($menu['route']) : 'javascript:void(0)';

                $isSingleActive = false;
                $isChildActiveGroup = false;

                if (! $hasChildren && $menuRouteExists && request()->routeIs($menu['route'])) {
                $isSingleActive = true;
                }

                foreach ($menu['children'] as $childCheck) {
                if (! empty($childCheck['route']) && Route::has($childCheck['route']) && request()->routeIs($childCheck['route'])) {
                $isChildActiveGroup = true;
                }
                }

                $isGroupOpen = $isChildActiveGroup;
                @endphp

                @if($hasChildren)

                <div class="sidebar-group">

                    <button type="button"
                        onclick="toggleSidebarMenu(this)"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition
                            {{ $isChildActiveGroup ? 'bg-white/12 text-white shadow-sm ring-1 ring-white/10' : 'text-white/82 hover:bg-white/10 hover:text-white' }}">

                        <span class="w-5 h-5 flex items-center justify-center shrink-0 text-emerald-100/90">
                            {!! owner_sidebar_icon_svg($menu['icon']) !!}
                        </span>

                        <span class="truncate flex-1 text-left">
                            {{ __($menu['label']) }}
                        </span>

                    </button>

                    <div class="{{ $isGroupOpen ? 'block' : 'hidden' }} sidebar-children mt-1 mb-2 ml-5 pl-3 border-l border-white/10 space-y-1">

                        @foreach($menu['children'] as $child)

                        @php
                        $childRouteExists = ! empty($child['route']) && Route::has($child['route']);
                        $childHref = $childRouteExists ? route($child['route']) : 'javascript:void(0)';
                        $isChildActive = $childRouteExists && request()->routeIs($child['route']);
                        @endphp

                        <a href="{{ $childHref }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs transition
                                {{ $isChildActive
                                    ? 'bg-white/15 text-white font-black shadow-sm'
                                    : 'text-white/58 hover:bg-white/10 hover:text-white font-semibold' }}">

                            <span class="w-1.5 h-1.5 rounded-full {{ $isChildActive ? 'bg-emerald-300' : 'bg-white/35' }} shrink-0"></span>

                            <span class="truncate">
                                {{ __($child['label']) }}
                            </span>

                        </a>

                        @endforeach

                    </div>

                </div>

                @else

                <a href="{{ $menuHref }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition
                        {{ $isSingleActive
                            ? 'bg-white/12 text-white shadow-sm ring-1 ring-white/10'
                            : 'text-white/82 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-5 h-5 flex items-center justify-center shrink-0 text-emerald-100/90">
                        {!! owner_sidebar_icon_svg($menu['icon']) !!}
                    </span>

                    <span class="truncate">
                        {{ __($menu['label']) }}
                    </span>

                </a>

                @endif

                @endforeach

            </nav>

            <div class="px-3 pb-5 pt-2 shrink-0">

                <div class="flex items-center gap-3 bg-white/10 rounded-2xl px-3 py-3 ring-1 ring-white/10">

                    <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white/85" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M20 21a8 8 0 0 0-16 0" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold truncate">
                            {{ $displayUserName }}
                        </p>

                        <p class="text-xs text-white/55 truncate font-semibold">
                            {{ $displayUserRole }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('owner.logout') }}" class="shrink-0">
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

        <div class="flex-1 min-w-0 h-screen flex flex-col overflow-hidden">

            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 shrink-0">

                <div class="flex items-center gap-3">

                    <button type="button"
                        onclick="openOwnerSidebar()"
                        class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                    </button>

                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            @yield('title', 'Statistikalar')
                        </h2>

                        <p class="hidden sm:block text-xs text-slate-500 mt-0.5">
                            Restoran idarəetmə paneli
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-2">

                    <div class="hidden md:flex items-center gap-3">

                        <div class="hidden lg:flex items-center gap-2 px-3 h-10 rounded-xl bg-slate-100 border border-slate-200">

                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                            <span class="text-xs font-semibold text-slate-500">
                                Baxış:
                            </span>

                            <span class="text-sm font-bold text-slate-800 whitespace-nowrap">
                                {{ $canSwitchBranch ? $activeViewName : $restaurantName }}
                            </span>

                        </div>

                        @if($canSwitchBranch)

                        <form method="POST" action="{{ route('owner.branches.switch') }}" id="ownerBranchSwitchForm">
                            @csrf

                            <div class="relative">

                                <select name="branch_id"
                                    onchange="submitOwnerBranchSwitch(this)"
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
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>

                            </div>

                        </form>

                        @endif

                    </div>

                    <div class="relative">

                        <select
                            style="-webkit-appearance:none; -moz-appearance:none; appearance:none; background-image:none;"
                            class="h-10 rounded-xl border border-slate-200 bg-slate-50 pl-4 pr-9 text-sm text-slate-700">

                            <option>AZ</option>
                            <option>EN</option>
                            <option>RU</option>

                        </select>

                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 9l6 6 6-6" />
                        </svg>

                    </div>

                </div>

            </header>

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
        function openOwnerSidebar() {
            const sidebar = document.getElementById('ownerSidebar');
            const overlay = document.getElementById('ownerSidebarOverlay');

            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');

            overlay.classList.remove('hidden');
        }

        function closeOwnerSidebar() {
            const sidebar = document.getElementById('ownerSidebar');
            const overlay = document.getElementById('ownerSidebarOverlay');

            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');

            overlay.classList.add('hidden');
        }

        function toggleSidebarMenu(button) {
            const group = button.closest('.sidebar-group');
            const children = group.querySelector('.sidebar-children');

            if (!children) {
                return;
            }

            const isHidden = children.classList.contains('hidden');

            document.querySelectorAll('.sidebar-children').forEach(function(item) {
                if (item !== children) {
                    item.classList.add('hidden');
                }
            });

            if (isHidden) {
                children.classList.remove('hidden');
            } else {
                children.classList.add('hidden');
            }
        }

        let branchSwitchRunning = false;

        function submitOwnerBranchSwitch(selectElement) {
            if (branchSwitchRunning) {
                return;
            }

            branchSwitchRunning = true;
            selectElement.disabled = true;

            const form = document.getElementById('ownerBranchSwitchForm');

            if (form) {
                form.submit();
            }
        }

        let ownerIdleTimer;

        function ownerAutoLogout() {
            const form = document.createElement('form');

            form.method = 'POST';
            form.action = "{{ route('owner.logout') }}";

            const csrf = document.createElement('input');

            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        }

        function resetOwnerIdleTimer() {
            clearTimeout(ownerIdleTimer);

            ownerIdleTimer = setTimeout(function() {
                ownerAutoLogout();
            }, 10 * 60 * 1000);
        }

        ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(function(event) {
            document.addEventListener(event, resetOwnerIdleTimer, true);
        });

        resetOwnerIdleTimer();
    </script>

</body>

</html>