@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Başlıq --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Yeni lisenziya
            </h1>

            <p class="text-gray-500 mt-1">
                Restoran üçün yeni SaaS lisenziyası yarat
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
        action="{{ route('admin.licenses.store') }}">

        @csrf

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
                                    {{ old('restaurant_id') == $restaurant->id ? 'selected' : '' }}>

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
                                    {{ old('plan_id') == $plan->id ? 'selected' : '' }}>

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

                                <option value="monthly">
                                    Aylıq
                                </option>

                                <option value="yearly">
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

                                <option value="active">
                                    Aktiv
                                </option>

                                <option value="expired">
                                    Müddəti bitmiş
                                </option>

                                <option value="suspended">
                                    Dayandırılmış
                                </option>

                                <option value="cancelled">
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
                                value="{{ old('start_date', now()->format('Y-m-d')) }}"
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
                                value="{{ old('amount') }}"
                                placeholder="Boş buraxılsa paket qiyməti götürüləcək"
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
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('note') }}</textarea>

                </div>

            </div>

            {{-- Sağ hissə --}}
            <div class="space-y-6">

                {{-- Auto suspend --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-5">

                    <label class="flex items-start gap-4 cursor-pointer">

                        <input type="checkbox"
                            name="auto_suspend"
                            value="1"
                            checked
                            class="w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 mt-1">

                        <div>

                            <h3 class="font-bold text-gray-900">
                                Avtomatik dayandırma
                            </h3>

                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                Lisenziya müddəti bitdikdə restoran sistemi avtomatik bloklanacaq.
                            </p>

                        </div>

                    </label>

                </div>

                {{-- Info Card --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h3 class="font-bold text-gray-900 mb-4">
                        Sistem məlumatı
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Sistem tipi
                            </span>

                            <span class="font-semibold text-gray-900">
                                SaaS
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Aktivasiya
                            </span>

                            <span class="font-semibold text-green-600">
                                Avtomatik
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Lisans nəzarəti
                            </span>

                            <span class="font-semibold text-gray-900">
                                Real-time
                            </span>
                        </div>

                    </div>

                </div>

                {{-- Submit --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Lisenziyanı yarat
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection