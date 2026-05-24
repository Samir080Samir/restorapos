@extends('owner.layouts.app')

@section('title', 'Masa idarəetməsi')

@section('content')

<div class="space-y-5">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Masa idarəetməsi</h1>
            <p class="text-sm text-slate-500 mt-1">Zal və masa düzülüşünü buradan idarə edin.</p>
        </div>

        <button type="button"
            onclick="saveTableLayout()"
            class="h-11 px-5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
            Düzülüşü saxla
        </button>
    </div>

    @if(session('success'))
    <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
        {{ $errors->first() }}
    </div>
    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900">Zal yarat</h3>

            <form method="POST" action="{{ route('owner.tables.areas.store') }}" class="mt-4 space-y-3">
                @csrf

                <input type="text" name="name" placeholder="Məs: Əsas zal"
                    class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                <input type="number" name="sort_order" min="0" placeholder="Sıra nömrəsi, məsələn: 1"
                    class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                <button class="w-full h-11 rounded-xl bg-slate-900 text-white text-sm font-semibold">
                    Zal əlavə et
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900">Masa əlavə et</h3>

            <form method="POST" action="{{ route('owner.tables.store') }}" class="mt-4 space-y-3">
                @csrf

                <select name="dining_area_id" class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">
                    <option value="">Zal seçilməyib</option>
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>

                <input type="text" name="name" placeholder="Məs: Masa 1"
                    class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">

                <select name="shape" class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">
                    <option value="square">Kvadrat</option>
                    <option value="circle">Dəyirmi</option>
                    <option value="rectangle">Uzunsov</option>
                </select>

                <input type="number" name="seats" min="1" placeholder="Oturacaq sayını qeyd edin"
                    class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">

                <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-3 py-3 bg-slate-50 cursor-pointer">
                    <input type="checkbox" name="show_seats" value="1" checked
                        class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">

                    <span class="text-sm font-semibold text-slate-700">
                        Staff ekranında oturacaqları göstər
                    </span>
                </label>

                <button class="w-full h-11 rounded-xl bg-emerald-600 text-white text-sm font-semibold">
                    Masa yarat
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900">Zalların sırası</h3>

            <form method="POST" action="{{ route('owner.tables.areas.sort') }}" class="mt-4 space-y-2">
                @csrf

                <div class="max-h-[292px] overflow-y-auto pr-1 space-y-2">
                    @forelse($areas as $area)
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 px-3 py-2 bg-slate-50">
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-bold text-slate-900 truncate">
                                {{ $area->name }}
                            </div>
                        </div>

                        <input type="number"
                            name="areas[{{ $area->id }}]"
                            value="{{ $area->sort_order }}"
                            min="0"
                            class="w-20 h-9 rounded-lg border border-slate-200 px-2 text-sm text-center">
                    </div>
                    @empty
                    <div class="text-sm text-slate-500">Zal yoxdur</div>
                    @endforelse
                </div>

                @if($areas->count())
                <button class="w-full h-10 rounded-xl bg-slate-900 text-white text-sm font-semibold mt-3">
                    Sıralamanı saxla
                </button>
                @endif
            </form>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900">Masa düzülüşü</h3>
                <p class="text-xs text-slate-500 mt-1">
                    Masaları sürüşdürün, seçib klaviatura oxları ilə hərəkət etdirin. Aşağı sağ tutacaqdan dama üzrə böyüdüb-kiçildə bilərsiniz.
                </p>
            </div>
        </div>

        <div class="table-layout-scroll">
            <div id="layoutCanvas" class="table-layout-canvas">

                @forelse($areas as $area)
                @foreach($area->tables as $table)
                @php
                $showSeats = (bool) ($table->show_seats ?? true);
                @endphp

                <div class="table-item table-{{ $table->shape }}"
                    data-id="{{ $table->id }}"
                    data-show-seats="{{ $showSeats ? '1' : '0' }}"
                    style="
                                left: {{ $table->position_x }}px;
                                top: {{ $table->position_y }}px;
                                width: {{ $table->width }}px;
                                height: {{ $table->height }}px;
                            ">

                    <div class="table-actions table-actions-left">
                        <button type="button"
                            title="Redaktə et"
                            onclick="openEditTableModal(
                                        '{{ $table->id }}',
                                        '{{ e($table->name) }}',
                                        '{{ $table->dining_area_id }}',
                                        '{{ $table->shape }}',
                                        '{{ $table->seats }}',
                                        '{{ $showSeats ? 1 : 0 }}'
                                    )">
                            ✎
                        </button>
                    </div>

                    <div class="table-actions table-actions-right">
                        <form method="POST" action="{{ route('owner.tables.destroy', $table->id) }}"
                            onsubmit="return confirm('Bu masanı silmək istəyirsiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Sil">×</button>
                        </form>
                    </div>

                    <div class="table-seats"
                        data-seats="{{ (int) $table->seats }}"
                        data-shape="{{ $table->shape }}"
                        data-show-seats="{{ $showSeats ? '1' : '0' }}">
                    </div>

                    <span>{{ $table->name }}</span>
                    <small>{{ $area->name }}</small>

                    <span class="table-resize-handle" title="Ölçünü dəyiş"></span>
                </div>
                @endforeach
                @empty
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-5">
                    <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-3xl shadow-sm">
                        🍽️
                    </div>

                    <h3 class="mt-4 font-bold text-slate-900">Heç bir masa əlavə edilməyib</h3>
                    <p class="text-sm text-slate-500 mt-1">Yuxarıdan əvvəl zal, sonra masa yaradın.</p>
                </div>
                @endforelse

            </div>
        </div>

    </div>

</div>


<div id="editTableModal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-5">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-slate-900">Masa redaktəsi</h3>

            <button type="button"
                onclick="closeEditTableModal()"
                class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600">
                ×
            </button>
        </div>

        <form id="editTableForm" method="POST" class="mt-4 space-y-3">
            @csrf
            @method('PUT')

            <select id="editDiningAreaId"
                name="dining_area_id"
                class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">
                <option value="">Zal seçilməyib</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>

            <input id="editTableName"
                type="text"
                name="name"
                class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">

            <select id="editTableShape"
                name="shape"
                class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">
                <option value="square">Kvadrat</option>
                <option value="circle">Dəyirmi</option>
                <option value="rectangle">Uzunsov</option>
            </select>

            <input id="editTableSeats"
                type="number"
                name="seats"
                min="1"
                placeholder="Oturacaq sayını qeyd edin"
                class="w-full h-11 rounded-xl border border-slate-200 px-4 text-sm">

            <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-3 py-3 bg-slate-50 cursor-pointer">
                <input id="editShowSeats"
                    type="checkbox"
                    name="show_seats"
                    value="1"
                    class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">

                <span class="text-sm font-semibold text-slate-700">
                    Staff ekranında oturacaqları göstər
                </span>
            </label>

            <button class="w-full h-11 rounded-xl bg-emerald-600 text-white text-sm font-semibold">
                Yadda saxla
            </button>
        </form>
    </div>
</div>

<style>
    .table-layout-scroll {
        height: 504px;
        overflow: auto;
        background: #f8fafc;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .table-layout-scroll::-webkit-scrollbar {
        display: none;
    }

    .table-layout-canvas {
        position: relative;
        width: 1464px;
        height: 504px;
        background-color: #f8fafc;
        background-image:
            linear-gradient(#e2e8f0 1px, transparent 1px),
            linear-gradient(90deg, #e2e8f0 1px, transparent 1px);
        background-size: 24px 24px;
    }

    .table-item {
        position: absolute;
        background: #ffffff;
        border: 2px solid #dfe7f2;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
        cursor: move;
        user-select: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .table-item.is-dragging,
    .table-item.is-resizing {
        z-index: 50;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .16);
        border-color: #10b981;
    }

    .table-item.is-selected {
        z-index: 45;
        border-color: #2563eb;
        box-shadow: 0 18px 40px rgba(37, 99, 235, .18);
    }

    .table-item span:not(.seat):not(.seat-back):not(.seat-base):not(.table-resize-handle) {
        font-size: 13px;
        font-weight: 700;
        color: #071143;
    }

    .table-item small {
        font-size: 10px;
        color: #64748b;
        margin-top: 3px;
    }

    .table-square {
        border-radius: 16px;
    }

    .table-circle {
        border-radius: 999px;
    }

    .table-rectangle {
        border-radius: 18px;
    }

    .table-actions {
        position: absolute;
        top: -14px;
        display: none;
        align-items: center;
        z-index: 25;
    }

    .table-actions-left {
        left: -14px;
    }

    .table-actions-right {
        right: -14px;
    }

    .table-item:hover .table-actions {
        display: flex;
    }

    .table-actions button {
        width: 25px;
        height: 25px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #dfe7f2;
        color: #071143;
        font-size: 13px;
        font-weight: 800;
        box-shadow: 0 6px 14px rgba(15, 23, 42, .14);
        cursor: pointer;
    }

    .table-actions form button {
        color: #ef4444;
    }

    .table-resize-handle {
        position: absolute;
        right: -7px;
        bottom: -7px;
        width: 18px;
        height: 18px;
        border-radius: 999px;
        background: #10b981;
        border: 3px solid #ffffff;
        box-shadow: 0 7px 16px rgba(15, 23, 42, .22);
        cursor: nwse-resize;
        z-index: 24;
    }

    .table-resize-handle::after {
        content: "";
        position: absolute;
        right: 3px;
        bottom: 3px;
        width: 6px;
        height: 6px;
        border-right: 2px solid #ffffff;
        border-bottom: 2px solid #ffffff;
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
        background: transparent;
        border: none;
        box-shadow: none;
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
    const gridSize = 24;

    let draggedTable = null;
    let resizingTable = null;
    let selectedTable = null;

    let offsetX = 0;
    let offsetY = 0;

    let resizeStartX = 0;
    let resizeStartY = 0;
    let resizeStartWidth = 0;
    let resizeStartHeight = 0;

    function snapToGrid(value) {
        return Math.round(value / gridSize) * gridSize;
    }

    function normalizeTablesToGrid() {
        const canvas = document.getElementById('layoutCanvas');

        document.querySelectorAll('.table-item').forEach(function(table) {
            let x = parseInt(table.style.left) || 0;
            let y = parseInt(table.style.top) || 0;

            x = snapToGrid(x);
            y = snapToGrid(y);

            x = Math.max(0, Math.min(x, canvas.clientWidth - table.offsetWidth));
            y = Math.max(0, Math.min(y, canvas.clientHeight - table.offsetHeight));

            table.style.left = x + 'px';
            table.style.top = y + 'px';

            table.style.width = snapToGrid(table.offsetWidth) + 'px';
            table.style.height = snapToGrid(table.offsetHeight) + 'px';
        });
    }

    function selectTable(table) {
        selectedTable = table;

        document.querySelectorAll('.table-item').forEach(function(item) {
            item.classList.remove('is-selected');
        });

        if (table) {
            table.classList.add('is-selected');
        }
    }

    function bindTableEvents() {
        document.querySelectorAll('.table-item').forEach(function(table) {
            table.addEventListener('mousedown', function(event) {
                if (
                    event.target.closest('.table-actions') ||
                    event.target.closest('.table-resize-handle')
                ) {
                    return;
                }

                event.preventDefault();

                selectTable(table);

                draggedTable = table;

                const tableRect = table.getBoundingClientRect();

                offsetX = event.clientX - tableRect.left;
                offsetY = event.clientY - tableRect.top;

                table.classList.add('is-dragging');
            });

            const resizeHandle = table.querySelector('.table-resize-handle');

            if (resizeHandle) {
                resizeHandle.addEventListener('mousedown', function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    selectTable(table);

                    resizingTable = table;

                    resizeStartX = event.clientX;
                    resizeStartY = event.clientY;

                    resizeStartWidth = table.offsetWidth;
                    resizeStartHeight = table.offsetHeight;

                    table.classList.add('is-resizing');
                });
            }
        });
    }

    document.addEventListener('mousemove', function(event) {
        const canvas = document.getElementById('layoutCanvas');

        if (draggedTable) {
            const rect = canvas.getBoundingClientRect();

            let x = event.clientX - rect.left - offsetX;
            let y = event.clientY - rect.top - offsetY;

            x = snapToGrid(x);
            y = snapToGrid(y);

            x = Math.max(0, Math.min(x, canvas.clientWidth - draggedTable.offsetWidth));
            y = Math.max(0, Math.min(y, canvas.clientHeight - draggedTable.offsetHeight));

            draggedTable.style.left = x + 'px';
            draggedTable.style.top = y + 'px';
        }

        if (resizingTable) {
            let width = resizeStartWidth + (event.clientX - resizeStartX);
            let height = resizeStartHeight + (event.clientY - resizeStartY);

            width = Math.max(gridSize * 3, snapToGrid(width));
            height = Math.max(gridSize * 3, snapToGrid(height));

            width = Math.min(width, canvas.clientWidth - (parseInt(resizingTable.style.left) || 0));
            height = Math.min(height, canvas.clientHeight - (parseInt(resizingTable.style.top) || 0));

            resizingTable.style.width = width + 'px';
            resizingTable.style.height = height + 'px';

            renderSeats();
        }
    });

    document.addEventListener('mouseup', function() {
        if (draggedTable) {
            draggedTable.classList.remove('is-dragging');
        }

        if (resizingTable) {
            resizingTable.classList.remove('is-resizing');
        }

        draggedTable = null;
        resizingTable = null;
    });

    document.addEventListener('keydown', function(event) {
        if (!selectedTable) {
            return;
        }

        if (
            event.target && ['INPUT', 'TEXTAREA', 'SELECT'].includes(event.target.tagName)
        ) {
            return;
        }

        const canvas = document.getElementById('layoutCanvas');

        let x = parseInt(selectedTable.style.left) || 0;
        let y = parseInt(selectedTable.style.top) || 0;

        let handled = false;

        if (event.key === 'ArrowLeft') {
            x -= gridSize;
            handled = true;
        }

        if (event.key === 'ArrowRight') {
            x += gridSize;
            handled = true;
        }

        if (event.key === 'ArrowUp') {
            y -= gridSize;
            handled = true;
        }

        if (event.key === 'ArrowDown') {
            y += gridSize;
            handled = true;
        }

        if (!handled) {
            return;
        }

        event.preventDefault();

        x = Math.max(0, Math.min(x, canvas.clientWidth - selectedTable.offsetWidth));
        y = Math.max(0, Math.min(y, canvas.clientHeight - selectedTable.offsetHeight));

        selectedTable.style.left = x + 'px';
        selectedTable.style.top = y + 'px';
    });

    function renderSeats() {
        document.querySelectorAll('.table-seats').forEach(function(container) {
            const table = container.closest('.table-item');
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
                const distance = '-5px';

                if (side === 'top') {
                    seat.style.top = distance;
                    seat.style.left = percent + '%';
                    seat.style.transform = 'translateX(-50%)';
                }

                if (side === 'right') {
                    seat.style.right = distance;
                    seat.style.top = percent + '%';
                    seat.style.transform = 'translateY(-50%) rotate(90deg)';
                }

                if (side === 'bottom') {
                    seat.style.bottom = distance;
                    seat.style.left = percent + '%';
                    seat.style.transform = 'translateX(-50%) rotate(180deg)';
                }

                if (side === 'left') {
                    seat.style.left = distance;
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

    function saveTableLayout() {
        normalizeTablesToGrid();

        const tables = [];

        document.querySelectorAll('.table-item').forEach(function(table) {
            tables.push({
                id: table.dataset.id,
                x: parseInt(table.style.left) || 0,
                y: parseInt(table.style.top) || 0,
                width: table.offsetWidth,
                height: table.offsetHeight
            });
        });

        fetch("{{ route('owner.tables.layout.save') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    tables: tables
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Düzülüş saxlanıldı');
                    return;
                }

                alert('Düzülüş saxlanılmadı');
            })
            .catch(() => {
                alert('Düzülüş saxlanılmadı. Route və ya controller yoxlanmalıdır.');
            });
    }

    function openEditTableModal(id, name, areaId, shape, seats, showSeats) {
        const modal = document.getElementById('editTableModal');
        const form = document.getElementById('editTableForm');

        form.action = "{{ url('/owner/tables') }}/" + id;

        document.getElementById('editTableName').value = name;
        document.getElementById('editDiningAreaId').value = areaId;
        document.getElementById('editTableShape').value = shape;
        document.getElementById('editTableSeats').value = seats;
        document.getElementById('editShowSeats').checked = String(showSeats) === '1';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditTableModal() {
        const modal = document.getElementById('editTableModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    renderSeats();
    normalizeTablesToGrid();
    bindTableEvents();
</script>

@endsection