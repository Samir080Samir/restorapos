@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Super Admin Dashboard
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            NovaPos SaaS sisteminin ümumi idarəetmə paneli
        </p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('admin.restaurants.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm transition">
            Yeni restoran
        </a>

        <a href="{{ route('admin.plans.create') }}"
            class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-sm transition">
            Yeni paket
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Ümumi restoran</p>
        <h2 class="text-2xl font-bold mt-2">{{ $totalRestaurants }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Aktiv restoran</p>
        <h2 class="text-2xl font-bold mt-2 text-green-600">{{ $activeRestaurants }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Bu ay yeni restoran</p>
        <h2 class="text-2xl font-bold mt-2 text-blue-600">{{ $newRestaurantsThisMonth }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Bitmək üzrə lisenziya</p>
        <h2 class="text-2xl font-bold mt-2 text-orange-500">{{ $expiringCount }}</h2>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Deaktiv restoran</p>
        <h2 class="text-2xl font-bold mt-2 text-red-600">{{ $inactiveRestaurants }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Ümumi paket</p>
        <h2 class="text-2xl font-bold mt-2">{{ $totalPlans }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Aktiv paket</p>
        <h2 class="text-2xl font-bold mt-2 text-green-600">{{ $activePlans }}</h2>
    </div>

    <div class="bg-gradient-to-br from-blue-600 to-cyan-500 p-4 rounded-2xl shadow-sm text-white">
        <p class="text-sm text-blue-100">
            Premium restoranlar
        </p>

        <h2 class="text-2xl font-bold mt-2">
            {{ $activeRestaurants }}
        </h2>

        <p class="text-xs text-blue-100 mt-1">
            Aktiv premium abunəlik
        </p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h2 class="text-lg font-bold mb-4">
            Son əlavə olunan restoranlar
        </h2>

        @forelse($latestRestaurants as $restaurant)
        <div class="flex justify-between items-center py-2.5 border-b last:border-b-0">
            <div>
                <p class="font-semibold text-sm">
                    {{ $restaurant->name }}
                </p>

                <p class="text-xs text-gray-500">
                    {{ $restaurant->owner_name }}
                </p>
            </div>

            <span class="text-xs px-3 py-1 rounded-full {{ $restaurant->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $restaurant->status == 'active' ? 'Aktiv' : 'Deaktiv' }}
            </span>
        </div>
        @empty
        <p class="text-sm text-gray-500">
            Hələ restoran əlavə edilməyib.
        </p>
        @endforelse
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h2 class="text-lg font-bold mb-4">
            Lisenziyası bitmək üzrə olanlar
        </h2>

        @forelse($expiringRestaurants as $restaurant)
        <div class="flex justify-between items-center py-2.5 border-b last:border-b-0">
            <div>
                <p class="font-semibold text-sm">
                    {{ $restaurant->name }}
                </p>

                <p class="text-xs text-gray-500">
                    Bitmə tarixi: {{ $restaurant->subscription_ends_at }}
                </p>
            </div>

            <span class="text-xs bg-orange-100 text-orange-700 px-3 py-1 rounded-full">
                Yaxınlaşır
            </span>
        </div>
        @empty
        <p class="text-sm text-gray-500">
            Yaxın 7 günə bitən lisenziya yoxdur.
        </p>
        @endforelse
    </div>
</div>

@endsection