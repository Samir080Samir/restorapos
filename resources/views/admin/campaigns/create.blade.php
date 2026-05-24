@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Yeni kampaniya
            </h1>

            <p class="text-gray-500 mt-1">
                Endirim və promo kampaniya əlavə et
            </p>
        </div>

        <a href="{{ route('admin.campaigns.index') }}"
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
        action="{{ route('admin.campaigns.store') }}">

        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Sol hissə --}}
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6">
                        Kampaniya məlumatları
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Başlıq --}}
                        <div class="md:col-span-2">

                            <label class="block mb-2 font-semibold text-gray-700">
                                Kampaniya adı
                            </label>

                            <input type="text"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Məs: Dostunu gətir 50% endirim"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Tip --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Kampaniya tipi
                            </label>

                            <select name="type"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="discount">
                                    Endirim
                                </option>

                                <option value="promo_code">
                                    Promo kod
                                </option>

                                <option value="referral">
                                    Referal
                                </option>

                                <option value="trial">
                                    Trial
                                </option>

                                <option value="plan_upgrade">
                                    Plan upgrade
                                </option>

                                <option value="seasonal">
                                    Mövsümi
                                </option>

                            </select>

                        </div>

                        {{-- Endirim tipi --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Endirim tipi
                            </label>

                            <select name="discount_type"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="percentage">
                                    Faiz (%)
                                </option>

                                <option value="fixed">
                                    Sabit məbləğ
                                </option>

                                <option value="free_month">
                                    Pulsuz ay
                                </option>

                            </select>

                        </div>

                        {{-- Endirim dəyəri --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Endirim dəyəri
                            </label>

                            <input type="number"
                                step="0.01"
                                name="discount_value"
                                value="{{ old('discount_value') }}"
                                placeholder="50"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Promo kod --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Promo kod
                            </label>

                            <input type="text"
                                name="promo_code"
                                value="{{ old('promo_code') }}"
                                placeholder="NOVA50"
                                class="w-full uppercase border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Paket --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Paket
                            </label>

                            <select name="plan_id"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                                <option value="">
                                    Bütün paketlər
                                </option>

                                @foreach($plans as $plan)

                                <option value="{{ $plan->id }}">
                                    {{ $plan->name }}
                                </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Başlama --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Başlama tarixi
                            </label>

                            <input type="date"
                                name="start_date"
                                value="{{ old('start_date') }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Bitmə --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Bitmə tarixi
                            </label>

                            <input type="date"
                                name="end_date"
                                value="{{ old('end_date') }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Limit --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                İstifadə limiti
                            </label>

                            <input type="number"
                                name="usage_limit"
                                value="{{ old('usage_limit') }}"
                                placeholder="100"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                    </div>

                </div>

                {{-- Təsvir --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Kampaniya təsviri
                    </h2>

                    <textarea name="description"
                        rows="5"
                        placeholder="Kampaniya haqqında məlumat..."
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('description') }}</textarea>

                </div>

                {{-- Şərtlər --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Şərtlər və qaydalar
                    </h2>

                    <textarea name="terms"
                        rows="5"
                        placeholder="İstifadə şərtləri..."
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('terms') }}</textarea>

                </div>

            </div>

            {{-- Sağ hissə --}}
            <div class="space-y-6">

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h3 class="font-bold text-gray-900 mb-5">
                        Kampaniya ayarları
                    </h3>

                    <div class="space-y-4">

                        <label class="flex items-center gap-3">

                            <input type="checkbox"
                                name="applies_to_monthly"
                                checked
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">

                            <span class="text-gray-700 font-medium">
                                Aylıq plana tətbiq olunsun
                            </span>

                        </label>

                        <label class="flex items-center gap-3">

                            <input type="checkbox"
                                name="applies_to_yearly"
                                checked
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">

                            <span class="text-gray-700 font-medium">
                                İllik plana tətbiq olunsun
                            </span>

                        </label>

                        <label class="flex items-center gap-3">

                            <input type="checkbox"
                                name="is_active"
                                checked
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">

                            <span class="text-gray-700 font-medium">
                                Kampaniya aktiv olsun
                            </span>

                        </label>

                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Kampaniyanı əlavə et
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection