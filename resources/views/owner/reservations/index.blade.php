@extends('owner.layouts.app')

@section('title', 'Rezervasiyalar')

@section('content')

<div class="space-y-5">

    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Rezervasiyalar</h1>
            <p class="text-sm text-slate-500 mt-1">Masalar üzrə yaradılmış rezervlərin idarə edilməsi.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-2">

            <a href="{{ route('owner.reservations.create') }}"
                class="h-11 px-5 rounded-xl bg-emerald-600 text-white text-sm font-bold flex items-center justify-center gap-2">
                <span class="text-lg leading-none">+</span>
                Yeni rezerv
            </a>

            <form method="GET"
                action="{{ route('owner.reservations.index') }}"
                class="flex flex-col sm:flex-row gap-2">

                <input type="date"
                    name="date"
                    value="{{ $selectedDate ?? request('date') ?? now()->toDateString() }}"
                    class="reservation-filter-input">

                <div class="relative">
                    <select name="status"
                        style="-webkit-appearance:none; -moz-appearance:none; appearance:none; background-image:none;"
                        class="reservation-filter-input pr-10">
                        <option value="">Bütün statuslar</option>
                        <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>Rezerv</option>
                        <option value="arrived" {{ request('status') === 'arrived' ? 'selected' : '' }}>Gəldi</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Ləğv edildi</option>
                    </select>

                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </div>

                <button type="submit"
                    class="h-11 px-5 rounded-xl bg-slate-900 text-white text-sm font-bold">
                    Filtrlə
                </button>

                <a href="{{ route('owner.reservations.index') }}"
                    class="h-11 px-5 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm font-bold flex items-center justify-center">
                    Sıfırla
                </a>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="reservation-stat-card">
            <span>Aktiv rezerv</span>
            <strong>{{ $stats['active'] ?? 0 }}</strong>
            <small>Seçilmiş tarix üzrə</small>
        </div>

        <div class="reservation-stat-card">
            <span>Ümumi rezerv</span>
            <strong>{{ $stats['total'] ?? 0 }}</strong>
            <small>Seçilmiş tarix üzrə</small>
        </div>

        <div class="reservation-stat-card">
            <span>Tamamlanan</span>
            <strong>{{ $stats['completed'] ?? 0 }}</strong>
            <small>Seçilmiş tarix üzrə</small>
        </div>

        <div class="reservation-stat-card">
            <span>Ləğv edilən</span>
            <strong>{{ $stats['cancelled'] ?? 0 }}</strong>
            <small>Seçilmiş tarix üzrə</small>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="hidden lg:grid grid-cols-[1.2fr_1fr_1fr_.7fr_1fr_1fr] gap-4 px-5 py-4 border-b border-slate-100 bg-slate-50 text-xs font-bold text-slate-500 uppercase">
            <div>Müştəri</div>
            <div>Masa</div>
            <div>Tarix / Saat</div>
            <div>Qonaq</div>
            <div>Status</div>
            <div class="text-right">Əməliyyat</div>
        </div>

        @forelse($reservations as $reservation)

        @php
        $statusText = match($reservation->status) {
        'reserved' => 'Rezerv',
        'arrived' => 'Gəldi',
        'completed' => 'Tamamlandı',
        'cancelled' => 'Ləğv edildi',
        default => $reservation->status,
        };

        $statusClass = match($reservation->status) {
        'reserved' => 'bg-sky-50 text-sky-700 border-sky-200',
        'arrived' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
        default => 'bg-slate-50 text-slate-700 border-slate-200',
        };
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr_1fr_.7fr_1fr_1fr] gap-4 px-5 py-4 border-b border-slate-100 last:border-b-0 items-center">

            <div>
                <div class="text-sm font-bold text-slate-900">
                    {{ $reservation->customer_name }}
                </div>

                <div class="text-xs text-slate-500 mt-1">
                    {{ $reservation->customer_phone ?: 'Telefon qeyd edilməyib' }}
                </div>

                @if($reservation->note)
                <div class="text-xs text-slate-400 mt-1 line-clamp-1">
                    {{ $reservation->note }}
                </div>
                @endif
            </div>

            <div>
                <div class="lg:hidden text-xs font-bold text-slate-400 mb-1">Masa</div>
                <div class="text-sm font-bold text-slate-800">
                    {{ $reservation->table?->name ?? 'Masa silinib' }}
                </div>
                <div class="text-xs text-slate-500 mt-1">
                    {{ $reservation->branch?->name ?? 'Ümumi restoran' }}
                </div>
            </div>

            <div>
                <div class="lg:hidden text-xs font-bold text-slate-400 mb-1">Tarix / Saat</div>
                <div class="text-sm font-bold text-slate-800">
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y') }}
                </div>
                <div class="text-xs text-slate-500 mt-1">
                    {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                </div>
            </div>

            <div>
                <div class="lg:hidden text-xs font-bold text-slate-400 mb-1">Qonaq</div>
                <span class="inline-flex h-8 px-3 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold items-center">
                    {{ $reservation->guest_count }} nəfər
                </span>
            </div>

            <div>
                <div class="lg:hidden text-xs font-bold text-slate-400 mb-1">Status</div>
                <span class="inline-flex h-8 px-3 rounded-xl border text-xs font-bold items-center {{ $statusClass }}">
                    {{ $statusText }}
                </span>
            </div>

            <div class="flex lg:justify-end gap-2 flex-wrap">
                @if($reservation->status === 'reserved')
                <form method="POST" action="{{ route('owner.reservations.complete', $reservation->id) }}">
                    @csrf
                    <button class="h-9 px-3 rounded-xl bg-emerald-600 text-white text-xs font-bold">
                        Tamamlandı
                    </button>
                </form>

                <form method="POST"
                    action="{{ route('owner.reservations.cancel', $reservation->id) }}"
                    onsubmit="return confirm('Bu rezervi ləğv etmək istəyirsiniz?')">
                    @csrf
                    <button class="h-9 px-3 rounded-xl bg-red-50 text-red-600 border border-red-200 text-xs font-bold">
                        Ləğv et
                    </button>
                </form>
                @else
                <span class="text-xs font-semibold text-slate-400">—</span>
                @endif
            </div>
        </div>

        @empty
        <div class="p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-3xl">
                🗓️
            </div>

            <h3 class="mt-4 text-lg font-bold text-slate-900">
                Rezerv tapılmadı
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Seçilmiş filterlərə uyğun rezervasiya yoxdur.
            </p>
        </div>
        @endforelse

        @if($reservations->count())
        <div class="flex items-center justify-between px-5 py-4 bg-slate-50 border-t border-slate-100">
            <span class="text-xs font-semibold text-slate-500">
                Cəmi {{ $reservations->total() }} rezervasiya
            </span>

            <div>{{ $reservations->links() }}</div>
        </div>
        @endif
    </div>
</div>

<style>
    .reservation-filter-input {
        height: 44px;
        min-width: 170px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding-left: 16px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        outline: none;
    }

    .reservation-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        padding: 18px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .045);
    }

    .reservation-stat-card span {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: #64748b;
    }

    .reservation-stat-card strong {
        display: block;
        margin-top: 4px;
        font-size: 26px;
        line-height: 1;
        font-weight: 900;
        color: #0f172a;
    }

    .reservation-stat-card small {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }
</style>

@endsection