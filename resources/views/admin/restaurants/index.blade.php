@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            {{ __('messages.restaurants') }}
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Restoranların SaaS idarəetmə siyahısı
        </p>
    </div>

    <a href="{{ route('admin.restaurants.create') }}"
        class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-sm transition">
        {{ __('messages.add_restaurant') }}
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Restoran</th>
                <th class="px-4 py-3 text-left">Sahib</th>
                <th class="px-4 py-3 text-left">Telefon</th>
                <th class="px-4 py-3 text-left">Paket</th>
                <th class="px-4 py-3 text-left">Filial</th>
                <th class="px-4 py-3 text-left">Qeydiyyat</th>
                <th class="px-4 py-3 text-left">Bitmə tarixi</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-right">Əməliyyatlar</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @foreach($restaurants as $restaurant)

            <tr class="hover:bg-gray-50 transition">

                {{-- Restoran --}}
                <td class="px-4 py-4">
                    <div class="flex items-center gap-3">

                        @if($restaurant->logo)
                        <img src="{{ asset('storage/' . $restaurant->logo) }}"
                            class="w-9 h-9 rounded-xl object-cover border border-gray-200">
                        @else
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($restaurant->name, 0, 1)) }}
                        </div>
                        @endif

                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $restaurant->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $restaurant->email ?? 'Email yoxdur' }}
                            </p>
                        </div>

                    </div>
                </td>

                {{-- Sahib --}}
                <td class="px-4 py-4 text-gray-700">
                    {{ $restaurant->owner_name ?? '-' }}
                </td>

                {{-- Telefon --}}
                <td class="px-4 py-4 text-gray-700">
                    {{ $restaurant->phone ?? '-' }}
                </td>

                {{-- Paket --}}
                <td class="px-4 py-4">
                    @if($restaurant->plan)
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $restaurant->plan->name }}
                    </span>
                    @else
                    <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">
                        Paket yoxdur
                    </span>
                    @endif
                </td>

                {{-- Filial sayı --}}
                <td class="px-4 py-4 text-gray-700">
                    {{ $restaurant->branches->count() }}
                </td>

                {{-- Qeydiyyat tarixi --}}
                <td class="px-4 py-4 text-gray-700">
                    {{ $restaurant->created_at?->format('d.m.Y') }}
                </td>

                {{-- Bitmə tarixi --}}
                <td class="px-4 py-4">
                    @if($restaurant->subscription_ends_at)
                    <span class="text-gray-700">
                        {{ \Carbon\Carbon::parse($restaurant->subscription_ends_at)->format('d.m.Y') }}
                    </span>
                    @else
                    <span class="text-gray-400">
                        -
                    </span>
                    @endif
                </td>

                {{-- Status --}}
                <td class="px-4 py-4">
                    @if($restaurant->status == 'active')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ __('messages.active') }}
                    </span>
                    @else
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ __('messages.inactive') }}
                    </span>
                    @endif
                </td>

                {{-- Əməliyyatlar --}}
                <td class="px-4 py-4">
                    <div class="flex justify-end gap-2">

                        <a href="{{ route('admin.restaurants.edit', $restaurant) }}"
                            class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-2 rounded-xl text-xs font-semibold transition">
                            Düzəliş
                        </a>

                        <form action="{{ route('admin.restaurants.destroy', $restaurant) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                onclick="return confirm('Restoran silinsin?')"
                                class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-xl text-xs font-semibold transition">
                                Sil
                            </button>

                        </form>

                    </div>
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection