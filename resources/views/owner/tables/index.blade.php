@extends('owner.layouts.app')

@section('title', 'Masalar')

@section('content')

<div class="space-y-5">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Masalar
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Zallar üzrə masaların cari vəziyyətinə baxış.
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">

            <div class="status-pill">
                <span class="status-dot bg-emerald-500"></span>
                <span>Boş</span>
            </div>

            <div class="status-pill">
                <span class="status-dot bg-red-500"></span>
                <span>Dolu</span>
            </div>

            <div class="status-pill">
                <span class="status-dot bg-amber-500"></span>
                <span>Hesab gözləyir</span>
            </div>

            <div class="status-pill">
                <span class="status-dot bg-sky-500"></span>
                <span>Rezerv</span>
            </div>

        </div>

    </div>

    @if($areas->count())

    <div class="flex items-center gap-2 overflow-x-auto scrollbar-hide pb-1">

        <button type="button"
            class="area-filter-btn active"
            data-area="all">
            Bütün masalar
        </button>

        @foreach($areas as $area)
        <button type="button"
            class="area-filter-btn"
            data-area="area-{{ $area->id }}">
            {{ $area->name }}
        </button>
        @endforeach

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="summary-card">
            <span>Ümumi masa</span>
            <strong>{{ $areas->sum(fn($area) => $area->tables->count()) }}</strong>
        </div>

        <div class="summary-card">
            <span>Boş masa</span>
            <strong>{{ $areas->sum(fn($area) => $area->tables->where('status', 'empty')->count()) }}</strong>
        </div>

        <div class="summary-card">
            <span>Dolu masa</span>
            <strong>{{ $areas->sum(fn($area) => $area->tables->where('status', 'busy')->count()) }}</strong>
        </div>

        <div class="summary-card">
            <span>Hesab gözləyir</span>
            <strong>{{ $areas->sum(fn($area) => $area->tables->where('status', 'waiting_payment')->count()) }}</strong>
        </div>

    </div>

    <div class="space-y-5">

        @foreach($areas as $area)

        <div class="table-area-group"
            data-area-group="area-{{ $area->id }}">

            <div class="flex items-center justify-between mb-3">

                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        {{ $area->name }}
                    </h2>

                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ $area->tables->count() }} masa
                    </p>
                </div>

            </div>

            @if($area->tables->count())

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">

                @foreach($area->tables as $table)

                @php
                $status = $table->status ?? 'empty';

                $statusClasses = match($status) {
                'busy' => 'border-red-200 bg-red-50',
                'waiting_payment' => 'border-amber-200 bg-amber-50',
                'reserved' => 'border-sky-200 bg-sky-50',
                default => 'border-emerald-200 bg-emerald-50',
                };

                $statusDot = match($status) {
                'busy' => 'bg-red-500',
                'waiting_payment' => 'bg-amber-500',
                'reserved' => 'bg-sky-500',
                default => 'bg-emerald-500',
                };

                $statusText = match($status) {
                'busy' => 'Dolu',
                'waiting_payment' => 'Hesab gözləyir',
                'reserved' => 'Rezerv',
                default => 'Boş',
                };
                @endphp

                <div class="table-card {{ $statusClasses }}">

                    <div class="flex items-start justify-between gap-2">

                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-slate-900 truncate">
                                {{ $table->name }}
                            </h3>

                            <p class="text-xs text-slate-500 mt-1 truncate">
                                {{ $area->name }}
                            </p>
                        </div>

                        <span class="w-3 h-3 rounded-full {{ $statusDot }} flex-shrink-0"></span>

                    </div>

                    <div class="flex-1 flex items-center justify-center py-5">

                        <div class="table-preview table-preview-{{ $table->shape }}">

                            <div class="table-seats"
                                data-seats="{{ (int) $table->seats }}"
                                data-shape="{{ $table->shape }}"
                                data-show-seats="{{ (bool) ($table->show_seats ?? true) ? '1' : '0' }}">
                            </div>

                            <div class="table-center">
                                <span>{{ $table->name }}</span>
                            </div>

                        </div>

                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-white/60">

                        <div class="flex items-center gap-1">

                            <svg class="w-4 h-4 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M3 10h18M7 15h1m4 0h5" />

                            </svg>

                            <span class="text-xs text-slate-500">
                                {{ $table->seats }} nəfər
                            </span>

                        </div>

                        <span class="text-xs font-semibold text-slate-600">
                            {{ $statusText }}
                        </span>

                    </div>

                </div>

                @endforeach

            </div>

            @else

            <div class="bg-white border border-dashed border-slate-200 rounded-2xl p-6 text-center">
                <p class="text-sm font-semibold text-slate-500">
                    Bu zalda masa yoxdur.
                </p>
            </div>

            @endif

        </div>

        @endforeach

    </div>

    @else

    <div class="bg-white border border-slate-200 rounded-3xl p-10 text-center">

        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-3xl">
            🍽️
        </div>

        <h3 class="mt-4 text-lg font-bold text-slate-900">
            Masa tapılmadı
        </h3>

        <p class="text-sm text-slate-500 mt-1">
            Tənzimləmələr → Masa idarəetməsi bölməsindən masa yaradın.
        </p>

    </div>

    @endif

</div>

<style>
    .status-pill {
        height: 40px;
        padding: 0 12px;
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        display: inline-block;
    }

    .area-filter-btn {
        height: 38px;
        padding: 0 16px;
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
        transition: .2s;
    }

    .area-filter-btn.active {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .summary-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 16px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .045);
    }

    .summary-card span {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .summary-card strong {
        display: block;
        margin-top: 7px;
        font-size: 24px;
        line-height: 1;
        font-weight: 800;
        color: #0f172a;
    }

    .table-card {
        border-width: 1px;
        border-radius: 24px;
        padding: 16px;
        min-height: 240px;
        display: flex;
        flex-direction: column;
        transition: .2s;
    }

    .table-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(15, 23, 42, .08);
    }

    .table-preview {
        position: relative;
    }

    .table-preview-square,
    .table-preview-circle {
        width: 92px;
        height: 92px;
    }

    .table-preview-rectangle {
        width: 130px;
        height: 92px;
    }

    .table-center {
        position: absolute;
        inset: 0;
        background: #ffffff;
        border: 2px solid #dbe4ee;
        box-shadow: 0 10px 22px rgba(15, 23, 42, .06);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-preview-square .table-center {
        border-radius: 18px;
    }

    .table-preview-circle .table-center {
        border-radius: 999px;
    }

    .table-preview-rectangle .table-center {
        border-radius: 18px;
    }

    .table-center span {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
        max-width: 80%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .table-seats {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }

    .seat {
        position: absolute;
        width: 18px;
        height: 18px;
    }

    .seat-back {
        position: absolute;
        left: 2px;
        top: 2px;
        width: 14px;
        height: 7px;
        border-radius: 999px;
        background: #10b981;
        box-shadow:
            0 3px 8px rgba(16, 185, 129, .28),
            inset 0 1px 1px rgba(255, 255, 255, .35);
    }
</style>

<script>
    function renderSeats() {

        document.querySelectorAll('.table-seats').forEach(function(container) {

            const table = container.closest('.table-preview');
            const totalSeats = parseInt(container.dataset.seats || 0);
            const showSeats = container.dataset.showSeats !== '0';

            container.innerHTML = '';

            if (!table || totalSeats <= 0 || !showSeats) {
                return;
            }

            let top = 0;
            let right = 0;
            let bottom = 0;
            let left = 0;

            if (totalSeats <= 4) {
                top = totalSeats >= 1 ? 1 : 0;
                right = totalSeats >= 2 ? 1 : 0;
                bottom = totalSeats >= 3 ? 1 : 0;
                left = totalSeats >= 4 ? 1 : 0;
            } else {
                const base = Math.floor(totalSeats / 4);
                const remainder = totalSeats % 4;

                top = base;
                right = base;
                bottom = base;
                left = base;

                if (remainder >= 1) top++;
                if (remainder >= 2) bottom++;
                if (remainder >= 3) right++;
            }

            function createSeat(side, index, count) {
                const seat = document.createElement('span');
                seat.className = 'seat';

                const back = document.createElement('span');
                back.className = 'seat-back';

                seat.appendChild(back);

                const gap = 100 / (count + 1);
                const percent = gap * (index + 1);

                if (side === 'top') {
                    seat.style.top = '-8px';
                    seat.style.left = percent + '%';
                    seat.style.transform = 'translateX(-50%)';
                }

                if (side === 'right') {
                    seat.style.right = '-8px';
                    seat.style.top = percent + '%';
                    seat.style.transform = 'translateY(-50%) rotate(90deg)';
                }

                if (side === 'bottom') {
                    seat.style.bottom = '-8px';
                    seat.style.left = percent + '%';
                    seat.style.transform = 'translateX(-50%) rotate(180deg)';
                }

                if (side === 'left') {
                    seat.style.left = '-8px';
                    seat.style.top = percent + '%';
                    seat.style.transform = 'translateY(-50%) rotate(-90deg)';
                }

                container.appendChild(seat);
            }

            for (let i = 0; i < top; i++) createSeat('top', i, top);
            for (let i = 0; i < right; i++) createSeat('right', i, right);
            for (let i = 0; i < bottom; i++) createSeat('bottom', i, bottom);
            for (let i = 0; i < left; i++) createSeat('left', i, left);
        });
    }

    document.querySelectorAll('.area-filter-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.querySelectorAll('.area-filter-btn').forEach(function(btn) {
                btn.classList.remove('active');
            });

            button.classList.add('active');

            const area = button.dataset.area;

            document.querySelectorAll('.table-area-group').forEach(function(group) {
                group.style.display = area === 'all' || group.dataset.areaGroup === area ?
                    'block' :
                    'none';
            });
        });
    });

    renderSeats();
</script>

@endsection