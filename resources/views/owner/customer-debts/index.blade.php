@extends('owner.layouts.app')

@section('title', 'Müştəri borcları')

@section('content')

<div class="max-w-7xl mx-auto space-y-5">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Müştəri borcları
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kassir tərəfindən POS-da yaradılmış borc qeydləri və ödəniş tarixçəsi
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <a href="{{ route('owner.customers.index') }}"
                class="h-11 px-5 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 text-sm font-bold text-gray-700 flex items-center justify-center transition">
                Müştərilər
            </a>

        </div>

    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">
        {{ $errors->first() }}
    </div>
    @endif

    {{-- Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold uppercase tracking-wide text-gray-400">
                Ümumi borc
            </div>
            <div class="mt-2 text-2xl font-black text-gray-900">
                {{ number_format((float) $summary->total_amount, 2) }} ₼
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold uppercase tracking-wide text-gray-400">
                Ödənilən
            </div>
            <div class="mt-2 text-2xl font-black text-emerald-600">
                {{ number_format((float) $summary->total_paid, 2) }} ₼
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold uppercase tracking-wide text-gray-400">
                Qalıq
            </div>
            <div class="mt-2 text-2xl font-black text-red-600">
                {{ number_format((float) $summary->total_remaining, 2) }} ₼
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold uppercase tracking-wide text-gray-400">
                Aktiv borc sayı
            </div>
            <div class="mt-2 text-2xl font-black text-amber-600">
                {{ $activeDebtsCount ?? 0 }}
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold uppercase tracking-wide text-gray-400">
                Bağlanan borc
            </div>
            <div class="mt-2 text-2xl font-black text-slate-700">
                {{ $paidDebtsCount ?? 0 }}
            </div>
        </div>

    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-4">

        <form method="GET" action="{{ route('owner.customer-debts.index') }}"
            class="grid grid-cols-1 md:grid-cols-[1fr_180px_auto] gap-3">

            <input type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Müştəri adı, telefon və ya çek nömrəsi ilə axtar..."
                class="h-11 rounded-2xl border-gray-200 text-sm font-semibold">

            <select name="status"
                class="h-11 rounded-2xl border-gray-200 text-sm font-semibold">

                <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>
                    Bütün statuslar
                </option>

                <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>
                    Borcludur
                </option>

                <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>
                    Qismən ödənib
                </option>

                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>
                    Ödənilib
                </option>

            </select>

            <div class="flex gap-2">

                <button type="submit"
                    class="h-11 px-5 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    Axtar
                </button>

                <a href="{{ route('owner.customer-debts.index') }}"
                    class="h-11 px-5 rounded-2xl border border-gray-200 bg-white text-gray-700 text-sm font-bold flex items-center">
                    Sıfırla
                </a>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Borc siyahısı</h2>
            <p class="text-sm text-gray-500 mt-1">
                Qismən və ya tam ödəniş qeyd edə bilərsən. Borc silinmir, tarixçə kimi qalır.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Müştəri</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Çek</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Kassir</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Borc</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Ödənilib</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Qalıq</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Status</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Tarix</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap w-[260px]">Əməliyyat</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($debts as $debt)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900">
                                {{ optional($debt->customer)->full_name ?: '-' }}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                {{ optional($debt->customer)->phone ?: 'Telefon yoxdur' }}
                            </div>

                            @if($debt->customer_id)
                            <a href="{{ route('owner.customers.show', $debt->customer_id) }}"
                                class="inline-flex mt-2 text-xs font-bold text-indigo-600 hover:text-indigo-800 whitespace-nowrap">
                                Müştəriyə bax
                            </a>
                            @endif
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap font-bold text-gray-800">
                            #{{ $debt->order_id ?: '-' }}
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap text-gray-700">
                            {{ optional($debt->staff)->name ? explode(' ', trim(optional($debt->staff)->name))[0] : '-' }}
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-black text-gray-900">
                                {{ number_format((float) $debt->amount, 2) }} ₼
                            </span>
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-bold text-emerald-600">
                                {{ number_format((float) $debt->paid_amount, 2) }} ₼
                            </span>
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            @if((float) $debt->remaining_amount > 0)
                            <span class="font-black text-red-600">
                                {{ number_format((float) $debt->remaining_amount, 2) }} ₼
                            </span>
                            @else
                            <span class="font-black text-emerald-600">
                                0.00 ₼
                            </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($debt->status === 'paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Ödənilib
                            </span>
                            @elseif($debt->status === 'partial')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-amber-50 text-amber-700 border border-amber-100">
                                Qismən
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-red-50 text-red-700 border border-red-100">
                                Borcludur
                            </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ optional($debt->created_at)->timezone('Asia/Baku')->format('d.m.Y') }}</div>
                            <div class="mt-1">{{ optional($debt->created_at)->timezone('Asia/Baku')->format('H:i') }}</div>
                        </td>

                        <td class="px-5 py-4 w-[260px]">
                            @if($debt->status !== 'paid' && (float) $debt->remaining_amount > 0)

                            <div class="space-y-2 w-[170px]">

                                <form method="POST"
                                    action="{{ route('owner.customer-debts.pay', $debt) }}"
                                    class="grid grid-cols-[90px_70px] gap-2 items-center">

                                    @csrf

                                    <input type="number"
                                        step="0.01"
                                        min="0.01"
                                        max="{{ number_format((float) $debt->remaining_amount, 2, '.', '') }}"
                                        name="paid_amount"
                                        placeholder="Məbləğ"
                                        required
                                        class="h-10 rounded-xl border-gray-200 text-sm font-bold">

                                    <button type="submit"
                                        class="h-10 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black">
                                        Ödə
                                    </button>
                                </form>

                                <form method="POST"
                                    action="{{ route('owner.customer-debts.close', $debt) }}"
                                    onsubmit="return confirm('Bu borc tam bağlansın?');">
                                    @csrf

                                    <button type="submit"
                                        class="h-10 w-full rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-black whitespace-nowrap">
                                        Tam bağla ({{ number_format((float) $debt->remaining_amount, 2) }} ₼)
                                    </button>
                                </form>

                            </div>

                            @else

                            <div class="rounded-2xl bg-emerald-50 border border-emerald-100 px-4 py-3 text-center w-[170px]">
                                <div class="text-sm font-black text-emerald-700">
                                    Bağlanıb
                                </div>
                                <div class="text-xs text-emerald-600 mt-1">
                                    {{ optional($debt->paid_at)->timezone('Asia/Baku')->format('d.m.Y H:i') ?: 'Tam ödənib' }}
                                </div>
                            </div>

                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-5 py-14 text-center text-gray-500">
                            Borc tapılmadı.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $debts->links() }}
    </div>

</div>

@endsection