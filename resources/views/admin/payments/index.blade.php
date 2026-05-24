@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Ödənişlər
            </h1>

            <p class="text-gray-500 mt-1">
                Restoran ödənişləri və SaaS billing tarixçəsi
            </p>
        </div>

        <a href="{{ route('admin.payments.create') }}"
            class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl transition font-medium shadow-sm text-center">
            Yeni ödəniş
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-gray-500 text-sm mb-2">Ümumi gəlir</p>
            <h2 class="text-3xl font-black text-gray-900">
                ₼{{ number_format($payments->where('status', 'paid')->sum('amount'), 2) }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-gray-500 text-sm mb-2">Ödənilmiş</p>
            <h2 class="text-3xl font-black text-green-600">
                {{ $payments->where('status', 'paid')->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-gray-500 text-sm mb-2">Gözləyən</p>
            <h2 class="text-3xl font-black text-yellow-600">
                {{ $payments->where('status', 'pending')->count() }}
            </h2>
        </div>

    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">

            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">Restoran</th>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">Paket</th>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">Lisenziya</th>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">Məbləğ</th>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">Ödəniş növü</th>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">Tarix</th>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">Status</th>
                        <th class="text-right px-6 py-4 text-sm font-bold text-gray-700">Əməliyyat</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($payments as $payment)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-5">
                            <h3 class="font-bold text-gray-900">
                                {{ $payment->restaurant->name ?? '-' }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                ID: #{{ $payment->restaurant->id ?? '-' }}
                            </p>
                        </td>

                        <td class="px-6 py-5">
                            <span class="font-semibold text-gray-800">
                                {{ $payment->plan->name ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-5">
                            @if($payment->license)
                            <span class="text-sm text-gray-700">
                                #{{ $payment->license->id }}
                            </span>
                            @else
                            <span class="text-sm text-gray-400">
                                -
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            <span class="font-black text-gray-900 text-lg">
                                ₼{{ number_format($payment->amount, 2) }}
                            </span>
                        </td>

                        <td class="px-6 py-5">
                            <div class="space-y-1">
                                @if($payment->billing_cycle == 'monthly')
                                <span class="inline-flex bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                    Aylıq
                                </span>
                                @else
                                <span class="inline-flex bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                    İllik
                                </span>
                                @endif

                                <p class="text-xs text-gray-500">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </p>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-gray-700 font-medium">
                            {{ optional($payment->payment_date)->format('d.m.Y') ?? '-' }}
                        </td>

                        <td class="px-6 py-5">
                            @if($payment->status == 'paid')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                Ödənilib
                            </span>
                            @elseif($payment->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                Gözləyir
                            </span>
                            @elseif($payment->status == 'failed')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                Uğursuz
                            </span>
                            @elseif($payment->status == 'refunded')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                Geri qaytarılıb
                            </span>
                            @else
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                Ləğv edilib
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex justify-end gap-3">

                                <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                    class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                                    Redaktə et
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.payments.destroy', $payment->id) }}"
                                    onsubmit="return confirm('Ödəniş silinsin?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                                        Sil
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-16">
                            <h3 class="text-xl font-bold text-gray-800">
                                Ödəniş tapılmadı
                            </h3>

                            <p class="text-gray-500 mt-2">
                                Hələ heç bir ödəniş əlavə edilməyib.
                            </p>
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection