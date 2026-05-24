@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Başlıq --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Lisenziyanı redaktə et
            </h1>

            <p class="text-gray-500 mt-1">
                Restoran lisenziya məlumatlarını yenilə
            </p>
        </div>

        <a href="{{ route('admin.licenses.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl transition font-medium text-center">
            Geri qayıt
        </a>

    </div>

    {{-- Errors --}}
    @if ($errors->any())

    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">

        <ul class="space-y-1">

            @foreach ($errors->all() as $error)

            <li>• {{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    {{-- Form --}}
    <form method="POST"
        action="{{ route('admin.licenses.update', $license->id) }}">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Sol hissə --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Əsas məlumatlar --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6">
                        Lisenziya məlumatları
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Restoran --}}
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
                                    {{ old('restaurant_id', $license->restaurant_id) == $restaurant->id ? 'selected' : '' }}>

                                    {{ $restaurant->name }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Paket --}}
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
                                    {{ old('plan_id', $license->plan_id) == $plan->id ? 'selected' : '' }}>

                                    {{ $plan->name }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Billing --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Ödəniş növü
                            </label>

                            <select name="billing_cycle"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="monthly"
                                    {{ old('billing_cycle', $license->billing_cycle) == 'monthly' ? 'selected' : '' }}>
                                    Aylıq
                                </option>

                                <option value="yearly"
                                    {{ old('billing_cycle', $license->billing_cycle) == 'yearly' ? 'selected' : '' }}>
                                    İllik
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

                                <option value="active"
                                    {{ old('status', $license->status) == 'active' ? 'selected' : '' }}>
                                    Aktiv
                                </option>

                                <option value="expired"
                                    {{ old('status', $license->status) == 'expired' ? 'selected' : '' }}>
                                    Müddəti bitmiş
                                </option>

                                <option value="suspended"
                                    {{ old('status', $license->status) == 'suspended' ? 'selected' : '' }}>
                                    Dayandırılmış
                                </option>

                                <option value="cancelled"
                                    {{ old('status', $license->status) == 'cancelled' ? 'selected' : '' }}>
                                    Ləğv edilmiş
                                </option>

                            </select>

                        </div>

                        {{-- Start Date --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Başlama tarixi
                            </label>

                            <input type="date"
                                name="start_date"
                                value="{{ old('start_date', optional($license->start_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- End Date --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Bitmə tarixi
                            </label>

                            <input type="date"
                                name="end_date"
                                value="{{ old('end_date', optional($license->end_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Amount --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Məbləğ
                            </label>

                            <input type="number"
                                step="0.01"
                                name="amount"
                                value="{{ old('amount', $license->amount) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Last Payment --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Son ödəniş tarixi
                            </label>

                            <input type="date"
                                name="last_payment_date"
                                value="{{ old('last_payment_date', optional($license->last_payment_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Next Payment --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Növbəti ödəniş tarixi
                            </label>

                            <input type="date"
                                name="next_payment_date"
                                value="{{ old('next_payment_date', optional($license->next_payment_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                    </div>

                </div>

                {{-- Qeyd --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Qeyd
                    </h2>

                    <textarea name="note"
                        rows="5"
                        placeholder="Lisenziya ilə bağlı qeyd..."
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('note', $license->note) }}</textarea>

                </div>

            </div>

            {{-- Sağ hissə --}}
            <div class="space-y-6">

                {{-- Status card --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h3 class="font-bold text-gray-900 mb-4">
                        Lisenziya vəziyyəti
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Hazırkı status
                            </span>

                            @if($license->status == 'active')

                            <span class="font-bold text-green-600">
                                Aktiv
                            </span>

                            @elseif($license->status == 'expired')

                            <span class="font-bold text-red-600">
                                Bitib
                            </span>

                            @elseif($license->status == 'suspended')

                            <span class="font-bold text-yellow-600">
                                Dayandırılıb
                            </span>

                            @else

                            <span class="font-bold text-gray-600">
                                Ləğv edilib
                            </span>

                            @endif
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Qalan gün
                            </span>

                            @php
                            $remaining = now()->diffInDays($license->end_date, false);
                            @endphp

                            @if($remaining >= 0)

                            <span class="font-bold text-green-600">
                                {{ $remaining }} gün
                            </span>

                            @else

                            <span class="font-bold text-red-600">
                                Müddəti bitib
                            </span>

                            @endif
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Məbləğ
                            </span>

                            <span class="font-bold text-gray-900">
                                ₼{{ number_format($license->amount, 2) }}
                            </span>
                        </div>

                    </div>

                </div>

                {{-- Auto suspend --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-5">

                    <label class="flex items-start gap-4 cursor-pointer">

                        <input type="checkbox"
                            name="auto_suspend"
                            value="1"
                            {{ old('auto_suspend', $license->auto_suspend) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 mt-1">

                        <div>

                            <h3 class="font-bold text-gray-900">
                                Avtomatik dayandırma
                            </h3>

                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                Lisenziya bitdikdə restoran sistemi avtomatik bloklansın.
                            </p>

                        </div>

                    </label>

                </div>

                {{-- Submit --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Lisenziyanı yenilə
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection