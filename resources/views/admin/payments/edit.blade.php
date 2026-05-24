@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Ödənişi redaktə et
            </h1>

            <p class="text-gray-500 mt-1">
                Ödəniş məlumatlarını yenilə
            </p>
        </div>

        <a href="{{ route('admin.payments.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl transition font-medium text-center">
            Geri qayıt
        </a>

    </div>

    @if ($errors->any())

    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">

        <ul class="space-y-1">

            @foreach ($errors->all() as $error)

            <li>• {{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <form method="POST"
        action="{{ route('admin.payments.update', $payment->id) }}">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6">
                        Ödəniş məlumatları
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Restoran
                            </label>

                            <select name="restaurant_id"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="">
                                    Restoran seçin
                                </option>

                                @foreach($restaurants as $restaurant)

                                <option value="{{ $restaurant->id }}"
                                    {{ old('restaurant_id', $payment->restaurant_id) == $restaurant->id ? 'selected' : '' }}>
                                    {{ $restaurant->name }}
                                </option>

                                @endforeach

                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Lisenziya
                            </label>

                            <select name="license_id"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="">
                                    Lisenziya seçin
                                </option>

                                @foreach($licenses as $license)

                                <option value="{{ $license->id }}"
                                    {{ old('license_id', $payment->license_id) == $license->id ? 'selected' : '' }}>
                                    #{{ $license->id }} — {{ $license->restaurant->name ?? '-' }}
                                </option>

                                @endforeach

                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Paket
                            </label>

                            <select name="plan_id"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="">
                                    Paket seçin
                                </option>

                                @foreach($plans as $plan)

                                <option value="{{ $plan->id }}"
                                    {{ old('plan_id', $payment->plan_id) == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>

                                @endforeach

                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Məbləğ
                            </label>

                            <input type="number"
                                step="0.01"
                                name="amount"
                                value="{{ old('amount', $payment->amount) }}"
                                placeholder="0.00"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Ödəniş növü
                            </label>

                            <select name="billing_cycle"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="monthly"
                                    {{ old('billing_cycle', $payment->billing_cycle) == 'monthly' ? 'selected' : '' }}>
                                    Aylıq
                                </option>

                                <option value="yearly"
                                    {{ old('billing_cycle', $payment->billing_cycle) == 'yearly' ? 'selected' : '' }}>
                                    İllik
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Ödəniş üsulu
                            </label>

                            <select name="payment_method"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="cash"
                                    {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>
                                    Nağd
                                </option>

                                <option value="bank_transfer"
                                    {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>
                                    Bank transferi
                                </option>

                                <option value="card"
                                    {{ old('payment_method', $payment->payment_method) == 'card' ? 'selected' : '' }}>
                                    Kart
                                </option>

                                <option value="online"
                                    {{ old('payment_method', $payment->payment_method) == 'online' ? 'selected' : '' }}>
                                    Online
                                </option>

                                <option value="manual"
                                    {{ old('payment_method', $payment->payment_method) == 'manual' ? 'selected' : '' }}>
                                    Manual
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Status
                            </label>

                            <select name="status"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="paid"
                                    {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>
                                    Ödənilib
                                </option>

                                <option value="pending"
                                    {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>
                                    Gözləyir
                                </option>

                                <option value="failed"
                                    {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>
                                    Uğursuz
                                </option>

                                <option value="refunded"
                                    {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>
                                    Geri qaytarılıb
                                </option>

                                <option value="cancelled"
                                    {{ old('status', $payment->status) == 'cancelled' ? 'selected' : '' }}>
                                    Ləğv edilib
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Ödəniş tarixi
                            </label>

                            <input type="date"
                                name="payment_date"
                                value="{{ old('payment_date', optional($payment->payment_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 font-semibold text-gray-700">
                                Transaction ID
                            </label>

                            <input type="text"
                                name="transaction_id"
                                value="{{ old('transaction_id', $payment->transaction_id) }}"
                                placeholder="TRX-0001"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Qeyd
                    </h2>

                    <textarea name="note"
                        rows="5"
                        placeholder="Ödəniş haqqında qeyd..."
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('note', $payment->note) }}</textarea>

                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h3 class="font-bold text-gray-900 mb-4">
                        Ödəniş xülasəsi
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">Restoran</span>
                            <span class="font-semibold text-gray-900">
                                {{ $payment->restaurant->name ?? '-' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Paket</span>
                            <span class="font-semibold text-gray-900">
                                {{ $payment->plan->name ?? '-' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Məbləğ</span>
                            <span class="font-bold text-gray-900">
                                ₼{{ number_format($payment->amount, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Status</span>

                            @if($payment->status == 'paid')
                            <span class="font-bold text-green-600">Ödənilib</span>
                            @elseif($payment->status == 'pending')
                            <span class="font-bold text-yellow-600">Gözləyir</span>
                            @elseif($payment->status == 'failed')
                            <span class="font-bold text-red-600">Uğursuz</span>
                            @else
                            <span class="font-bold text-gray-600">Digər</span>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Ödənişi yenilə
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection