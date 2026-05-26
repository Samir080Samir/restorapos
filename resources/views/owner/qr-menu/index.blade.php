@extends('owner.layouts.app')

@section('title', 'QR Menyu İdarəetməsi')

@section('content')
<div class="space-y-5">

    @if(session('success'))
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700 shadow-sm">
        {{ $errors->first() }}
    </div>
    @endif

    {{-- Header --}}
    <div class="rounded-[28px] bg-slate-950 text-white overflow-hidden shadow-sm border border-slate-900">
        <div class="relative p-5 md:p-6">
            <div class="absolute inset-0 opacity-40"
                style="background: radial-gradient(circle at 15% 20%, rgba(16,185,129,.55), transparent 30%), radial-gradient(circle at 92% 8%, rgba(59,130,246,.30), transparent 26%);"></div>

            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-3 py-1.5 text-xs font-black text-white/85">
                        <span class="w-2 h-2 rounded-full {{ data_get($restaurant, 'qr_is_active', true) ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                        {{ data_get($restaurant, 'qr_is_active', true) ? 'QR menyu aktivdir' : 'QR menyu deaktivdir' }}
                    </div>

                    <h1 class="mt-4 text-2xl md:text-3xl font-black tracking-tight">
                        {{ $restaurant->name }} — QR Menyu İdarəetməsi
                    </h1>

                    <p class="mt-2 text-sm text-white/65 font-semibold max-w-3xl">
                        Masa QR kodları, baxış statistikası, sifariş analitikası və çap əməliyyatlarını buradan idarə edin.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ $restaurantQrUrl }}" target="_blank"
                        class="h-11 px-5 rounded-2xl bg-white text-slate-950 inline-flex items-center justify-center text-sm font-black hover:bg-slate-100 transition">
                        Ümumi menyuya bax
                    </a>

                    <button type="button" onclick="copyText('{{ $restaurantQrUrl }}')"
                        class="h-11 px-5 rounded-2xl bg-emerald-500 text-slate-950 inline-flex items-center justify-center text-sm font-black hover:bg-emerald-400 transition">
                        Linki kopyala
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6 gap-3">

        <div class="rounded-[24px] bg-white border border-slate-100 shadow-sm px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-wider text-slate-400 leading-tight">Ümumi baxış</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <h3 class="text-3xl font-black text-slate-950 leading-none">{{ $totalQrViews ?? 0 }}</h3>
            </div>
        </div>

        <div class="rounded-[24px] bg-white border border-slate-100 shadow-sm px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M4 19V5" />
                        <path d="M4 19h16" />
                        <path d="M8 15l3-3 3 2 5-6" />
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-wider text-slate-400 leading-tight">Bugünkü baxış</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <h3 class="text-3xl font-black text-slate-950 leading-none">{{ $todayQrViews ?? 0 }}</h3>
            </div>
        </div>

        <div class="rounded-[24px] bg-white border border-slate-100 shadow-sm px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M8 6h13" />
                        <path d="M8 12h13" />
                        <path d="M8 18h13" />
                        <path d="M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-wider text-slate-400 leading-tight">Ümumi sifariş</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <h3 class="text-3xl font-black text-slate-950 leading-none">{{ $totalQrOrders ?? 0 }}</h3>
            </div>
        </div>

        <div class="rounded-[24px] bg-white border border-slate-100 shadow-sm px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M13 2 4 14h7l-1 8 9-12h-7l1-8Z" />
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-wider text-slate-400 leading-tight">Bugünkü sifariş</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <h3 class="text-3xl font-black text-slate-950 leading-none">{{ $todayQrOrders ?? 0 }}</h3>
            </div>
        </div>

        <div class="rounded-[24px] bg-white border border-slate-100 shadow-sm px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M7 3h10a2 2 0 0 1 2 2v16l-3-2-3 2-3-2-3 2-3-2V5a2 2 0 0 1 2-2Z" />
                        <path d="M9 8h6" />
                        <path d="M9 12h6" />
                        <path d="M9 16h4" />
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-wider text-slate-400 leading-tight">Açıq QR çek</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <h3 class="text-3xl font-black text-slate-950 leading-none">{{ $openQrOrders ?? 0 }}</h3>
            </div>
        </div>

        <div class="rounded-[24px] bg-gradient-to-br from-slate-950 via-emerald-950 to-emerald-700 border border-emerald-900 shadow-sm px-4 py-4 text-white overflow-hidden relative">
            <div class="absolute right-0 top-0 w-24 h-24 rounded-full bg-white/10 blur-2xl"></div>
            <div class="relative flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-white/10 text-white flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M6 20h12" />
                        <path d="M8 20V10a4 4 0 0 1 8 0v10" />
                        <path d="M10 10h4" />
                        <path d="M12 6v14" />
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-wider text-white/65 leading-tight">QR satış</p>
            </div>
            <div class="relative mt-4 pt-3 border-t border-white/15">
                <h3 class="text-3xl font-black text-white leading-none whitespace-nowrap">
                    {{ number_format((float) ($qrRevenue ?? 0), 2) }} ₼
                </h3>
            </div>
        </div>
    </div>

    {{-- Main QR list --}}
    <div class="rounded-[32px] bg-white border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 md:px-7 py-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-950">Masa QR kodları</h2>
                <p class="text-sm text-slate-500 mt-1 font-semibold">Hər masa üçün ayrıca link, QR kod, baxış sayı və çap əməliyyatları.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 border border-slate-200 px-4 py-3 text-sm font-black text-slate-700 w-fit">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                {{ $tables->count() }} masa
            </div>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($tables as $table)
            @php
            $tableUrl = route('public.qr-menu.show', [$restaurant->slug, $table->code]);
            $qrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=' . urlencode($tableUrl);
            $tableViews = data_get($table, 'qr_views_count', 0);
            $tableTodayViews = data_get($table, 'qr_today_views_count', 0);
            @endphp

            <div class="px-5 md:px-7 py-5 hover:bg-slate-50/70 transition">
                <div class="grid grid-cols-1 xl:grid-cols-[112px_1fr_auto] gap-5 xl:items-center">

                    <div class="flex xl:block items-center gap-4">
                        <img src="{{ $qrImage }}" alt="{{ $table->name }} QR"
                            class="w-24 h-24 xl:w-28 xl:h-28 rounded-[24px] border border-slate-200 bg-white p-2 shadow-sm shrink-0">
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-xl font-black text-slate-950">{{ $table->name }}</h3>

                            <span class="rounded-full bg-slate-100 text-slate-600 px-3 py-1 text-xs font-black">
                                Kod: {{ $table->code }}
                            </span>

                            <span class="rounded-full bg-emerald-50 text-emerald-700 px-3 py-1 text-xs font-black">
                                {{ optional($table->diningArea)->name ?: 'Ümumi zal' }}
                            </span>
                        </div>

                        <div class="mt-3 flex items-center gap-2 min-w-0">
                            <a href="{{ $tableUrl }}" target="_blank"
                                class="block truncate text-base text-emerald-700 font-black max-w-full">
                                {{ $tableUrl }}
                            </a>

                            <a href="{{ $tableUrl }}" target="_blank" class="shrink-0 text-slate-500 hover:text-slate-950">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M14 3h7v7" />
                                    <path d="M10 14 21 3" />
                                    <path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5" />
                                </svg>
                            </a>
                        </div>

                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-xs font-black text-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                Baxış: {{ $tableViews }}
                            </span>

                            <span class="inline-flex items-center gap-2 rounded-2xl bg-blue-50 px-4 py-2 text-xs font-black text-blue-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M4 19V5" />
                                    <path d="M4 19h16" />
                                    <path d="M8 15l3-3 3 2 5-6" />
                                </svg>
                                Bugün: {{ $tableTodayViews }}
                            </span>

                            <button type="button" onclick="copyText('{{ $tableUrl }}')"
                                class="inline-flex items-center gap-2 rounded-2xl bg-slate-950 px-4 py-2 text-xs font-black text-white hover:bg-slate-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M8 8h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2Z" />
                                    <path d="M4 16H3a1 1 0 0 1-1-1V4a2 2 0 0 1 2-2h11a1 1 0 0 1 1 1v1" />
                                </svg>
                                Linki kopyala
                            </button>

                            <a href="{{ $qrImage }}" target="_blank"
                                class="inline-flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-xs font-black text-slate-700 hover:bg-slate-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M4 4h6v6H4z" />
                                    <path d="M14 4h6v6h-6z" />
                                    <path d="M4 14h6v6H4z" />
                                    <path d="M14 14h2v2h-2zM18 14h2v6h-6v-2h4z" />
                                </svg>
                                QR aç
                            </a>

                            <button type="button" onclick="printQr('{{ $qrImage }}', '{{ $table->name }}')"
                                class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-4 py-2 text-xs font-black text-white hover:bg-emerald-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M6 9V2h12v7" />
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                    <path d="M6 14h12v8H6z" />
                                </svg>
                                Çap et
                            </button>
                        </div>
                    </div>

                    <div class="xl:text-right">
                        <form method="POST" action="{{ route('owner.qr-menu.regenerate-table-code', $table->id) }}"
                            onsubmit="return confirm('Bu masa üçün QR link yenilənsin? Köhnə QR artıq işləməyəcək.')">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                class="w-full xl:w-auto h-11 px-5 rounded-2xl bg-amber-50 text-amber-700 text-sm font-black hover:bg-amber-100">
                                Yenilə
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-10 text-center text-slate-500 font-bold">
                Hələ masa yaradılmayıb.
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function copyText(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Link kopyalandı');
        });
    }

    function printQr(src, title) {
        const win = window.open('', '_blank');
        win.document.write(`
        <html>
            <head>
                <title>${title} QR</title>
                <style>
                    body{font-family:Arial,sans-serif;text-align:center;padding:40px;background:#f8fafc;}
                    .box{display:inline-block;border:1px solid #e5e7eb;border-radius:28px;padding:28px;background:#fff;}
                    img{width:280px;height:280px;}
                    h2{margin:18px 0 6px;font-size:26px;}
                    p{color:#64748b;font-weight:bold;}
                </style>
            </head>
            <body>
                <div class="box">
                    <img src="${src}" alt="QR">
                    <h2>${title}</h2>
                    <p>QR menyu</p>a
                </div>
                <script>window.onload=function(){window.print();}<\/script>
            </body>
        </html>`);
        win.document.close();
    }
</script>
@endsection