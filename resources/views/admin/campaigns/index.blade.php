@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Endirimlər və Kampaniyalar
            </h1>

            <p class="text-gray-500 mt-1">
                Promo kodlar, referal endirimləri və plan kampaniyaları
            </p>
        </div>

        <a href="{{ route('admin.campaigns.create') }}"
            class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl transition font-medium shadow-sm text-center">
            Yeni kampaniya
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-gray-500 text-sm mb-2">Ümumi kampaniya</p>
            <h2 class="text-3xl font-black text-gray-900">
                {{ $campaigns->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-gray-500 text-sm mb-2">Aktiv</p>
            <h2 class="text-3xl font-black text-green-600">
                {{ $campaigns->where('is_active', true)->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-gray-500 text-sm mb-2">Promo kod</p>
            <h2 class="text-3xl font-black text-blue-600">
                {{ $campaigns->where('type', 'promo_code')->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <p class="text-gray-500 text-sm mb-2">İstifadə sayı</p>
            <h2 class="text-3xl font-black text-purple-600">
                {{ $campaigns->sum('used_count') }}
            </h2>
        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

        @forelse($campaigns as $campaign)

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 hover:shadow-xl transition">

            <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-5">

                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $campaign->title }}
                        </h2>

                        @if($campaign->is_active)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                            Aktiv
                        </span>
                        @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                            Passiv
                        </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-400 mt-1">
                        Kampaniya ID: #{{ $campaign->id }}
                    </p>
                </div>

                <div class="text-left md:text-right">
                    <p class="text-sm text-gray-500">
                        Endirim
                    </p>

                    <h3 class="text-3xl font-black text-gray-900">
                        {{ $campaign->discountLabel() }}
                    </h3>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Tip</p>
                    <p class="font-bold text-gray-900">
                        @switch($campaign->type)
                        @case('discount')
                        Endirim
                        @break
                        @case('promo_code')
                        Promo kod
                        @break
                        @case('referral')
                        Referal
                        @break
                        @case('trial')
                        Trial
                        @break
                        @case('plan_upgrade')
                        Plan upgrade
                        @break
                        @case('seasonal')
                        Mövsümi
                        @break
                        @default
                        -
                        @endswitch
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Paket</p>
                    <p class="font-bold text-gray-900">
                        {{ $campaign->plan->name ?? 'Bütün paketlər' }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Promo kod</p>
                    @if($campaign->promo_code)
                    <span class="inline-flex bg-black text-white px-3 py-1 rounded-xl text-xs font-bold tracking-wider">
                        {{ $campaign->promo_code }}
                    </span>
                    @else
                    <p class="font-bold text-gray-400">Yoxdur</p>
                    @endif
                </div>

            </div>

            <div class="space-y-3 mb-5">

                <div class="flex justify-between items-center">
                    <span class="text-gray-500">
                        Başlama tarixi
                    </span>

                    <span class="font-semibold text-gray-900">
                        {{ optional($campaign->start_date)->format('d.m.Y') ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500">
                        Bitmə tarixi
                    </span>

                    <span class="font-semibold text-gray-900">
                        {{ optional($campaign->end_date)->format('d.m.Y') ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500">
                        İstifadə limiti
                    </span>

                    <span class="font-semibold text-gray-900">
                        {{ $campaign->used_count }}
                        /
                        {{ $campaign->usage_limit ?? 'Limitsiz' }}
                    </span>
                </div>

            </div>

            <div class="flex flex-wrap gap-2 mb-6">

                @if($campaign->applies_to_monthly)
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                    Aylıq plana tətbiq olunur
                </span>
                @endif

                @if($campaign->applies_to_yearly)
                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                    İllik plana tətbiq olunur
                </span>
                @endif

            </div>

            <div class="flex gap-3 pt-5 border-t border-gray-100">

                <a href="{{ route('admin.campaigns.edit', $campaign->id) }}"
                    class="flex-1 bg-gray-900 hover:bg-black text-white text-center py-3 rounded-2xl transition font-semibold">
                    Redaktə et
                </a>

                <form method="POST"
                    action="{{ route('admin.campaigns.destroy', $campaign->id) }}"
                    class="flex-1"
                    onsubmit="return confirm('Kampaniya silinsin?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-2xl transition font-semibold">
                        Sil
                    </button>
                </form>

            </div>

        </div>

        @empty

        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-12 text-center">
            <h3 class="text-xl font-bold text-gray-800">
                Kampaniya tapılmadı
            </h3>

            <p class="text-gray-500 mt-2">
                Hələ heç bir endirim və ya kampaniya əlavə edilməyib.
            </p>
        </div>

        @endforelse

    </div>

</div>

@endsection