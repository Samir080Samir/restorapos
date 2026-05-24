@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Başlıq --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Lisenziyalar
            </h1>

            <p class="text-gray-500 mt-1">
                Restoran lisenziya və abunə idarəetməsi
            </p>
        </div>

        <a href="{{ route('admin.licenses.create') }}"
            class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl transition font-medium shadow-sm text-center">
            Yeni lisenziya
        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>

    @endif

    {{-- Table --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-b border-gray-100">

                    <tr>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Restoran
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Paket
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Ödəniş növü
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Başlama
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Bitmə
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Məbləğ
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Status
                        </th>

                        <th class="text-right px-6 py-4 text-sm font-bold text-gray-700">
                            Əməliyyat
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($licenses as $license)

                    <tr class="hover:bg-gray-50 transition">

                        {{-- Restoran --}}
                        <td class="px-6 py-5">

                            <div>
                                <h3 class="font-bold text-gray-900">
                                    {{ $license->restaurant->name ?? '-' }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    ID: #{{ $license->restaurant->id ?? '-' }}
                                </p>
                            </div>

                        </td>

                        {{-- Paket --}}
                        <td class="px-6 py-5">

                            <div>
                                <h3 class="font-semibold text-gray-800">
                                    {{ $license->plan->name ?? '-' }}
                                </h3>

                                @if(optional($license->plan)->is_popular)

                                <span class="inline-flex mt-2 bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-bold">
                                    Premium paket
                                </span>

                                @endif
                            </div>

                        </td>

                        {{-- Billing --}}
                        <td class="px-6 py-5">

                            @if($license->billing_cycle == 'monthly')

                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                Aylıq
                            </span>

                            @else

                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                İllik
                            </span>

                            @endif

                        </td>

                        {{-- Start --}}
                        <td class="px-6 py-5 text-gray-700 font-medium">
                            {{ \Carbon\Carbon::parse($license->start_date)->format('d.m.Y') }}
                        </td>

                        {{-- End --}}
                        <td class="px-6 py-5">

                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($license->end_date)->format('d.m.Y') }}
                                </p>

                                @php
                                $remaining = now()->diffInDays($license->end_date, false);
                                @endphp

                                @if($remaining >= 0)

                                <p class="text-xs text-green-600 mt-1">
                                    {{ $remaining }} gün qalıb
                                </p>

                                @else

                                <p class="text-xs text-red-600 mt-1">
                                    Müddəti bitib
                                </p>

                                @endif
                            </div>

                        </td>

                        {{-- Amount --}}
                        <td class="px-6 py-5">

                            <span class="font-black text-gray-900 text-lg">
                                ₼{{ number_format($license->amount, 2) }}
                            </span>

                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-5">

                            @if($license->status == 'active')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                Aktiv
                            </span>

                            @elseif($license->status == 'expired')

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                Bitib
                            </span>

                            @elseif($license->status == 'suspended')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                Dayandırılıb
                            </span>

                            @else

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                Ləğv edilib
                            </span>

                            @endif

                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-5">

                            <div class="flex justify-end gap-3">

                                <a href="{{ route('admin.licenses.edit', $license->id) }}"
                                    class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                                    Redaktə et
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.licenses.destroy', $license->id) }}"
                                    onsubmit="return confirm('Lisenziya silinsin?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                                        Sil
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center py-16">

                            <div>
                                <h3 class="text-xl font-bold text-gray-800">
                                    Lisenziya tapılmadı
                                </h3>

                                <p class="text-gray-500 mt-2">
                                    Hələ heç bir lisenziya əlavə edilməyib.
                                </p>
                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection