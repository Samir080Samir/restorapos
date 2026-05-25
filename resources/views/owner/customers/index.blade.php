@extends('owner.layouts.app')

@section('title', 'Müştərilər')

@section('content')

<div class="max-w-7xl mx-auto space-y-5">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Müştərilər</h1>
            <p class="text-sm text-gray-500 mt-1">Müştəri məlumatları, bonus və borc vəziyyəti</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-2">
            <form method="GET" action="{{ route('owner.customers.index') }}" class="flex gap-2">
                <input type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Ad və ya telefon axtar"
                    class="w-full sm:w-80 h-11 rounded-2xl border-gray-200 text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500">

                <button type="submit"
                    class="h-11 px-5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold">
                    Axtar
                </button>
            </form>

            <button type="button"
                onclick="openCreateCustomerModal()"
                class="h-11 px-5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold whitespace-nowrap">
                + Müştəri əlavə et
            </button>
        </div>
    </div>

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

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Müştəri</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Telefon</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Bonus</th>
                        <th class="text-left px-5 py-4 font-bold whitespace-nowrap">Aktiv borc</th>
                        <th class="text-right px-5 py-4 font-bold whitespace-nowrap">Əməliyyat</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($customers as $customer)
                    @php
                    $activeDebt = (float) ($customer->active_debt_sum ?? $customer->total_debt ?? 0);
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $customer->full_name }}</div>

                            @if($customer->note)
                            <div class="text-xs text-gray-500 mt-1 max-w-[260px] truncate">
                                {{ $customer->note }}
                            </div>
                            @endif
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap text-gray-600">
                            {{ $customer->phone ?: '-' }}
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap text-gray-600">
                            {{ number_format((float) $customer->bonus_balance, 2) }} ₼
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-black {{ $activeDebt > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ number_format($activeDebt, 2) }} ₼
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('owner.customers.show', $customer) }}"
                                class="inline-flex items-center justify-center h-9 px-4 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-sm font-black">
                                Bax
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3M13 7a4 4 0 11-8 0 4 4 0 018 0zM3 21a6 6 0 0112 0" />
                                    </svg>
                                </div>

                                <p class="text-base font-bold text-gray-600">Müştəri tapılmadı.</p>

                                <button type="button"
                                    onclick="openCreateCustomerModal()"
                                    class="mt-4 h-10 px-5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold">
                                    İlk müştərini əlavə et
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $customers->links() }}
    </div>

</div>

<div id="createCustomerModal"
    class="fixed inset-0 z-[9999] hidden bg-slate-900/50">

    <div class="w-full h-full overflow-y-auto">
        <div class="min-h-full flex items-center justify-center px-4 py-10">

            <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl border border-gray-100 overflow-hidden">

                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">
                            Yeni müştəri əlavə et
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Owner paneldən müştəri məlumatı yarat
                        </p>
                    </div>

                    <button type="button"
                        onclick="closeCreateCustomerModal()"
                        class="w-10 h-10 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xl font-black">
                        ×
                    </button>
                </div>

                <form method="POST"
                    action="{{ route('owner.customers.store') }}"
                    class="p-5 space-y-4">

                    @csrf

                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wide mb-2">
                            Müştəri adı
                        </label>

                        <input type="text"
                            name="full_name"
                            required
                            value="{{ old('full_name') }}"
                            placeholder="Məs: Samir Abdullayev"
                            class="w-full h-12 rounded-2xl border-gray-200 text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wide mb-2">
                            Telefon
                        </label>

                        <input type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Məs: 0501234567"
                            class="w-full h-12 rounded-2xl border-gray-200 text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-wide mb-2">
                            Qeyd
                        </label>

                        <textarea name="note"
                            rows="4"
                            placeholder="Müştəri haqqında qeyd"
                            class="w-full rounded-2xl border-gray-200 text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500">{{ old('note') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <button type="button"
                            onclick="closeCreateCustomerModal()"
                            class="h-12 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-black">
                            Bağla
                        </button>

                        <button type="submit"
                            class="h-12 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-black">
                            Yadda saxla
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('createCustomerModal');

        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
    });

    function openCreateCustomerModal() {
        const modal = document.getElementById('createCustomerModal');

        if (!modal) return;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCreateCustomerModal() {
        const modal = document.getElementById('createCustomerModal');

        if (!modal) return;

        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
</script>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        openCreateCustomerModal();
    });
</script>
@endif

@if($errors->any())
<script>
    openCreateCustomerModal();
</script>
@endif

@endsection