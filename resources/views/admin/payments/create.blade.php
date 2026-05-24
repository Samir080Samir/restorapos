@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Yeni ödəniş
            </h1>

            <p class="text-gray-500 mt-1">
                Restoran üçün yeni ödəniş əlavə et
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
        action="{{ route('admin.payments.store') }}">

        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Sol hissə --}}
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6">
                        Ödəniş məlumatları
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Restaurant --}}
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

                                <option value="{{ $restaurant->id }}">
                                    {{ $restaurant->name }}
                                </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- License --}}
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

                                <option value="{{ $license->id }}">

                                    #{{ $license->id }}
                                    —
                                    {{ $license->restaurant->name ?? '-' }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Plan --}}
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

                                <option value="{{ $plan->id }}">
                                    {{ $plan->name }}
                                </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Amount --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Məbləğ
                            </label>

                            <input type="number"
                                step="0.01"
                                name="amount"
                                placeholder="0.00"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Billing --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Ödəniş növü
                            </label>

                            <select name="billing_cycle"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="monthly">
                                    Aylıq
                                </option>

                                <option value="yearly">
                                    İllik
                                </option>

                            </select>

                        </div>

                        {{-- Method --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Ödəniş üsulu
                            </label>

                            <select name="payment_method"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="cash">
                                    Nağd
                                </option>

                                <option value="bank_transfer">
                                    Bank transferi
                                </option>

                                <option value="card">
                                    Kart
                                </option>

                                <option value="online">
                                    Online
                                </option>

                                <option value="manual">
                                    Manual
                                </option>

                            </select>

                        </div>

                        {{-- Status --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Status
                            </label>

                            <select name="status"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="paid">
                                    Ödənilib
                                </option>

                                <option value="pending">
                                    Gözləyir
                                </option>

                                <option value="failed">
                                    Uğursuz
                                </option>

                                <option value="refunded">
                                    Geri qaytarılıb
                                </option>

                                <option value="cancelled">
                                    Ləğv edilib
                                </option>

                            </select>

                        </div>

                        {{-- Payment Date --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Ödəniş tarixi
                            </label>

                            <input type="date"
                                name="payment_date"
                                value="{{ now()->format('Y-m-d') }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Transaction --}}
                        <div class="md:col-span-2">

                            <label class="block mb-2 font-semibold text-gray-700">
                                Transaction ID
                            </label>

                            <input type="text"
                                name="transaction_id"
                                placeholder="TRX-0001"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Promo Code --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Promo kod
                            </label>

                            <input type="text"
                                name="promo_code"
                                placeholder="NOVA50"
                                class="w-full uppercase border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Discount Preview --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Endirim məlumatı
                            </label>

                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-100 rounded-2xl p-4">

                                <p class="text-sm text-gray-600">
                                    Aktiv promo kod daxil etdikdə sistem avtomatik endirimi hesablayacaq.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Note --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Qeyd
                    </h2>

                    <textarea name="note"
                        rows="5"
                        placeholder="Ödəniş haqqında qeyd..."
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none"></textarea>

                </div>

            </div>

            {{-- Sağ hissə --}}
            <div class="space-y-6">

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h3 class="font-bold text-gray-900 mb-4">
                        Billing məlumatı
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Sistem tipi
                            </span>

                            <span class="font-semibold text-gray-900">
                                SaaS Billing
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Lisans yenilənməsi
                            </span>

                            <span class="font-semibold text-green-600">
                                Avtomatik
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Promo Engine
                            </span>

                            <span class="font-semibold text-purple-600">
                                Aktiv
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Ödəniş nəzarəti
                            </span>

                            <span class="font-semibold text-gray-900">
                                Real-time
                            </span>
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Ödənişi əlavə et
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection