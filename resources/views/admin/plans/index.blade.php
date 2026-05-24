@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Paketlər
            </h1>

            <p class="text-gray-500 mt-1">
                NovaPos SaaS paket idarəetməsi
            </p>
        </div>

        <a href="{{ route('admin.plans.create') }}"
            class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl transition text-center font-medium shadow-sm">
            Yeni paket əlavə et
        </a>

    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-5">

        @forelse($plans as $plan)

        <div class="relative bg-white rounded-3xl p-5 transition duration-300 hover:-translate-y-1 hover:shadow-xl flex flex-col min-h-[560px]
                {{ $plan->is_popular
                    ? 'border-2 border-yellow-400 shadow-yellow-100 shadow-lg'
                    : 'border border-gray-100 shadow-sm'
                }}">

            {{-- Popular Badge --}}
            @if($plan->is_popular)

            <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
                <div class="bg-yellow-400 text-black px-5 py-1.5 rounded-full text-xs font-bold shadow-lg">
                    Ən çox seçilən
                </div>
            </div>

            @endif

            {{-- Başlıq --}}
            <div class="flex justify-between items-start gap-4 mb-5">

                <div>
                    <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                        {{ $plan->name }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        Paket ID: #{{ $plan->id }}
                    </p>
                </div>

                @if($plan->status == 'active')

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                    Aktiv
                </span>

                @else

                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                    Deaktiv
                </span>

                @endif

            </div>

            {{-- Qiymətlər --}}
            <div class="grid grid-cols-2 gap-3 mb-5">

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">

                    <p class="text-gray-500 text-sm mb-1">
                        Aylıq
                    </p>

                    <h3 class="text-3xl font-black text-black">
                        ₼{{ number_format($plan->monthly_price, 0) }}
                    </h3>

                </div>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">

                    <p class="text-gray-500 text-sm mb-1">
                        İllik
                    </p>

                    <h3 class="text-3xl font-black text-black">
                        ₼{{ number_format($plan->yearly_price, 0) }}
                    </h3>

                </div>

            </div>

            {{-- Limitlər --}}
            <div class="space-y-3 mb-5">

                <div class="flex justify-between items-center">
                    <span class="text-gray-500">
                        Filial limiti
                    </span>

                    <span class="font-bold text-gray-900">
                        {{ $plan->max_branches }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500">
                        İstifadəçi limiti
                    </span>

                    <span class="font-bold text-gray-900">
                        {{ $plan->max_users }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500">
                        Masa limiti
                    </span>

                    <span class="font-bold text-gray-900">
                        {{ $plan->max_tables }}
                    </span>
                </div>

            </div>

            {{-- Modullar --}}
            <div class="border-t border-gray-100 pt-4 mb-5">

                <h3 class="font-bold text-gray-800 mb-4">
                    Modul icazələri
                </h3>

                <div class="space-y-2 text-sm max-h-40 overflow-y-auto pr-1">

                    @php
                    $modules = [
                    'QR Menu' => $plan->qr_menu,
                    'Ofisiant tətbiqi' => $plan->waiter_app,
                    'Mətbəx ekranı' => $plan->kitchen_display,
                    'Kiosk' => $plan->kiosk,
                    'Anbar' => $plan->inventory,
                    'Hesabatlar' => $plan->reports,
                    'Multi filial' => $plan->multi_branch,
                    ];
                    @endphp

                    @foreach($modules as $moduleName => $enabled)

                    <div class="flex justify-between items-center bg-gray-50 rounded-xl px-3 py-2">

                        <span class="text-gray-700 text-sm">
                            {{ $moduleName }}
                        </span>

                        @if($enabled)

                        <span class="w-6 h-6 flex items-center justify-center rounded-lg bg-green-100 text-green-700 font-bold text-sm">
                            ✓
                        </span>

                        @else

                        <span class="w-6 h-6 flex items-center justify-center rounded-lg bg-red-100 text-red-600 font-bold text-sm">
                            ✕
                        </span>

                        @endif

                    </div>

                    @endforeach

                </div>

            </div>

            {{-- Düymələr --}}
            <div class="flex gap-3 mt-auto pt-4 border-t border-gray-100">

                <a href="{{ route('admin.plans.edit', $plan->id) }}"
                    class="flex-1 bg-gray-900 hover:bg-black text-white text-center py-3 rounded-2xl transition font-semibold">
                    Redaktə et
                </a>

                <form method="POST"
                    action="{{ route('admin.plans.destroy', $plan->id) }}"
                    class="flex-1"
                    onsubmit="return confirm('Paket silinsin?')">

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

        <div class="col-span-full bg-white border border-gray-100 rounded-3xl p-10 text-center">

            <h3 class="text-xl font-bold text-gray-800">
                Paket tapılmadı
            </h3>

            <p class="text-gray-500 mt-2">
                Hələ heç bir paket əlavə edilməyib.
            </p>

        </div>

        @endforelse

    </div>

</div>

@endsection