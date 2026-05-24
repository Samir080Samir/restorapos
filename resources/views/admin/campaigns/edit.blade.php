@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Kampaniyanı redaktə et
            </h1>

            <p class="text-gray-500 mt-1">
                Kampaniya və endirim məlumatlarını yenilə
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
        action="{{ route('admin.campaigns.update', $campaign->id) }}">

        @csrf
        @method('PUT')

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
                                value="{{ old('title', $campaign->title) }}"
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

                                <option value="discount"
                                    {{ old('type', $campaign->type) == 'discount' ? 'selected' : '' }}>
                                    Endirim
                                </option>

                                <option value="promo_code"
                                    {{ old('type', $campaign->type) == 'promo_code' ? 'selected' : '' }}>
                                    Promo kod
                                </option>

                                <option value="referral"
                                    {{ old('type', $campaign->type) == 'referral' ? 'selected' : '' }}>
                                    Referal
                                </option>

                                <option value="trial"
                                    {{ old('type', $campaign->type) == 'trial' ? 'selected' : '' }}>
                                    Trial
                                </option>

                                <option value="plan_upgrade"
                                    {{ old('type', $campaign->type) == 'plan_upgrade' ? 'selected' : '' }}>
                                    Plan upgrade
                                </option>

                                <option value="seasonal"
                                    {{ old('type', $campaign->type) == 'seasonal' ? 'selected' : '' }}>
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

                                <option value="percentage"
                                    {{ old('discount_type', $campaign->discount_type) == 'percentage' ? 'selected' : '' }}>
                                    Faiz (%)
                                </option>

                                <option value="fixed"
                                    {{ old('discount_type', $campaign->discount_type) == 'fixed' ? 'selected' : '' }}>
                                    Sabit məbləğ
                                </option>

                                <option value="free_month"
                                    {{ old('discount_type', $campaign->discount_type) == 'free_month' ? 'selected' : '' }}>
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
                                value="{{ old('discount_value', $campaign->discount_value) }}"
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
                                value="{{ old('promo_code', $campaign->promo_code) }}"
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

                                <option value="{{ $plan->id }}"
                                    {{ old('plan_id', $campaign->plan_id) == $plan->id ? 'selected' : '' }}>
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
                                value="{{ old('start_date', optional($campaign->start_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Bitmə --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Bitmə tarixi
                            </label>

                            <input type="date"
                                name="end_date"
                                value="{{ old('end_date', optional($campaign->end_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- Limit --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                İstifadə limiti
                            </label>

                            <input type="number"
                                name="usage_limit"
                                value="{{ old('usage_limit', $campaign->usage_limit) }}"
                                placeholder="100"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        {{-- İstifadə sayı --}}
                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                İstifadə sayı
                            </label>

                            <input type="number"
                                name="used_count"
                                value="{{ old('used_count', $campaign->used_count) }}"
                                placeholder="0"
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
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('description', $campaign->description) }}</textarea>

                </div>

                {{-- Şərtlər --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Şərtlər və qaydalar
                    </h2>

                    <textarea name="terms"
                        rows="5"
                        placeholder="İstifadə şərtləri..."
                        class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('terms', $campaign->terms) }}</textarea>

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
                                {{ old('applies_to_monthly', $campaign->applies_to_monthly) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">

                            <span class="text-gray-700 font-medium">
                                Aylıq plana tətbiq olunsun
                            </span>

                        </label>

                        <label class="flex items-center gap-3">

                            <input type="checkbox"
                                name="applies_to_yearly"
                                {{ old('applies_to_yearly', $campaign->applies_to_yearly) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">

                            <span class="text-gray-700 font-medium">
                                İllik plana tətbiq olunsun
                            </span>

                        </label>

                        <label class="flex items-center gap-3">

                            <input type="checkbox"
                                name="is_active"
                                {{ old('is_active', $campaign->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">

                            <span class="text-gray-700 font-medium">
                                Kampaniya aktiv olsun
                            </span>

                        </label>

                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <div class="space-y-3 text-sm mb-6">

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Kampaniya ID
                            </span>

                            <span class="font-bold text-gray-900">
                                #{{ $campaign->id }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                İstifadə sayı
                            </span>

                            <span class="font-bold text-gray-900">
                                {{ $campaign->used_count }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Endirim
                            </span>

                            <span class="font-bold text-gray-900">
                                {{ $campaign->discountLabel() }}
                            </span>
                        </div>

                    </div>

                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Kampaniyanı yenilə
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection