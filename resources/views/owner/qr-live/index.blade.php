@extends('owner.layouts.app')

@section('title', 'QR Live Monitor')

@section('content')
<div class="p-4 md:p-6">
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-gray-900">QR Live Monitor</h1>
        <p class="text-sm text-gray-500 mt-1">QR menyudan gələn sifarişlər və hesab sorğuları canlı izlənir.</p>
    </div>

    <div id="qrLiveList" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border text-gray-500">
            Yüklənir...
        </div>
    </div>
</div>

<script>
    function loadQrLive() {
        fetch("{{ route('qr-live.data') }}").then(res => res.json())
            .then(data => {
                const box = document.getElementById('qrLiveList');

                if (!data.orders || data.orders.length === 0) {
                    box.innerHTML = `
                    <div class="bg-white rounded-2xl p-5 shadow-sm border text-gray-500">
                        Hazırda açıq QR sifariş yoxdur.
                    </div>
                `;
                    return;
                }

                box.innerHTML = data.orders.map(order => `
                <div class="bg-white rounded-2xl p-5 shadow-sm border">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">${order.table}</h3>
                            <p class="text-xs text-gray-500">Sifariş #${order.id}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold text-emerald-700">${order.total} ₼</div>
                        </div>
                    </div>

                    ${order.note ? `
                        <div class="mb-3 rounded-xl bg-amber-50 text-amber-700 px-3 py-2 text-sm font-semibold">
                            ${order.note}
                        </div>
                    ` : ''}

                    <div class="space-y-2">
                        ${order.items.map(item => `
                            <div class="flex justify-between text-sm border-b pb-2">
                                <span>${item.qty} × ${item.name}</span>
                                <strong>${item.total} ₼</strong>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `).join('');
            });
    }

    loadQrLive();
    setInterval(loadQrLive, 5000);
</script>
@endsection