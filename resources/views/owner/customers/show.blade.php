@extends('owner.layouts.app')

@section('title', 'Müştəri detalları')

@section('content')

<div class="max-w-6xl mx-auto space-y-5">

    {{-- Başlıq --}}
    <div class="flex items-center justify-between gap-3">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Müştəri detalları
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Restoran idarəetmə paneli
            </p>
        </div>

        <div class="flex items-center gap-2">

            <a href="{{ route('owner.customers.index') }}"
                class="h-11 px-5 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 text-sm font-bold text-gray-700 flex items-center justify-center transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>

                Geri qayıt

            </a>

        </div>

    </div>

    {{-- Müştəri kartı --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

        <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-5">

            <div class="flex-1 min-w-0">

                <div class="flex flex-wrap items-center gap-3">

                    <h2 class="text-3xl font-bold text-gray-900 break-words">
                        {{ $customer->full_name }}
                    </h2>

                    @if($customer->status === 'active')

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                        Aktiv
                    </span>

                    @else

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700">
                        Passiv
                    </span>

                    @endif

                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 px-4 py-3">

                        <div class="text-xs uppercase tracking-wide text-gray-400 font-semibold">
                            Telefon
                        </div>

                        <div class="mt-1 text-base font-semibold text-gray-800">
                            {{ $customer->phone ?: 'Telefon qeyd edilməyib' }}
                        </div>

                    </div>

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 px-4 py-3">

                        <div class="text-xs uppercase tracking-wide text-gray-400 font-semibold">
                            Qeyd
                        </div>

                        <div class="mt-1 text-sm text-gray-700">
                            {{ $customer->note ?: 'Qeyd yoxdur' }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Statistikalar --}}
            <div class="grid grid-cols-2 gap-3 w-full xl:w-auto">

                <div class="rounded-3xl bg-emerald-50 px-6 py-5 text-center min-w-[140px]">

                    <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700">
                        Bonus
                    </div>

                    <div class="mt-2 text-3xl font-black text-emerald-700">
                        {{ number_format((float) $customer->bonus_balance, 2) }}
                        <span class="text-xl">₼</span>
                    </div>

                </div>

                <div class="rounded-3xl bg-red-50 px-6 py-5 text-center min-w-[140px]">

                    <div class="text-xs font-semibold uppercase tracking-wide text-red-700">
                        Aktiv borc
                    </div>

                    <div class="mt-2 text-3xl font-black text-red-700">
                        {{ number_format((float) $customer->total_debt, 2) }}
                        <span class="text-xl">₼</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Borc tarixçəsi --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">

            <div>

                <h3 class="text-lg font-bold text-gray-900">
                    Borc tarixçəsi
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Müştərinin bütün borc əməliyyatları
                </p>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr class="text-left text-xs uppercase tracking-wide text-gray-500">

                        <th class="px-5 py-4 font-bold">
                            Çek
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Kassir
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Məbləğ
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Qalıq
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Status
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Tarix
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($customer->debts as $debt)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <div class="font-semibold text-gray-900">
                                {{ optional($debt->order)->order_number ?: '-' }}
                            </div>

                        </td>

                        <td class="px-5 py-4 text-gray-700">

                            {{ optional($debt->staff)->name ?: '-' }}

                        </td>

                        <td class="px-5 py-4">

                            <span class="font-bold text-gray-900">
                                {{ number_format((float) $debt->amount, 2) }} ₼
                            </span>

                        </td>

                        <td class="px-5 py-4">

                            @if($debt->remaining_amount > 0)

                            <span class="font-bold text-red-600">
                                {{ number_format((float) $debt->remaining_amount, 2) }} ₼
                            </span>

                            @else

                            <span class="font-bold text-emerald-600">
                                0.00 ₼
                            </span>

                            @endif

                        </td>

                        <td class="px-5 py-4">

                            @if($debt->status === 'paid')

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                                Ödənilib
                            </span>

                            @elseif($debt->status === 'partial')

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700">
                                Qismən
                            </span>

                            @else

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700">
                                Borclu
                            </span>

                            @endif

                        </td>

                        <td class="px-5 py-4 text-sm text-gray-500 whitespace-nowrap">

                            {{ optional($debt->created_at)->format('d.m.Y H:i') }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="px-5 py-14 text-center">

                            <div class="flex flex-col items-center justify-center">

                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-8 h-8 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 14l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />

                                    </svg>

                                </div>

                                <p class="text-base font-semibold text-gray-600">
                                    Borc tarixçəsi yoxdur.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection