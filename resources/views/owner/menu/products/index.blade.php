@extends('owner.layouts.app')

@section('title', 'Məhsullar')

@section('content')

<div class="max-w-[1500px] mx-auto space-y-5">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-black text-slate-900">
                Məhsullar
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                POS və eMenu məhsullarının idarə olunması.
            </p>
        </div>

        <a href="{{ route('owner.menu.products.create') }}"
            class="h-12 px-6 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-sm flex items-center justify-center gap-2">
            + Məhsul yarat
        </a>

    </div>

    @if(session('success'))
    <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-bold text-green-700">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1450px]">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-black uppercase text-slate-500">ID</th>
                        <th class="px-4 py-4 text-left text-xs font-black uppercase text-slate-500">Şəkil</th>
                        <th class="px-4 py-4 text-left text-xs font-black uppercase text-slate-500">Ad</th>
                        <th class="px-4 py-4 text-center text-xs font-black uppercase text-slate-500">Status</th>
                        <th class="px-4 py-4 text-center text-xs font-black uppercase text-slate-500">İkram</th>
                        <th class="px-4 py-4 text-left text-xs font-black uppercase text-slate-500">Növ</th>
                        <th class="px-4 py-4 text-left text-xs font-black uppercase text-slate-500">Kateqoriya</th>
                        <th class="px-4 py-4 text-left text-xs font-black uppercase text-slate-500">Şöbə</th>
                        <th class="px-4 py-4 text-left text-xs font-black uppercase text-slate-500">Vergi</th>
                        <th class="px-4 py-4 text-right text-xs font-black uppercase text-slate-500">Maya dəyəri</th>
                        <th class="px-4 py-4 text-right text-xs font-black uppercase text-slate-500">Qiymət</th>
                        <th class="px-4 py-4 text-right text-xs font-black uppercase text-slate-500">Ticarət əlavəsi</th>
                        <th class="px-4 py-4 text-right text-xs font-black uppercase text-slate-500">Marja dəyəri</th>
                        <th class="px-4 py-4 text-right text-xs font-black uppercase text-slate-500">Əməliyyat</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($products as $product)

                    @php
                    $cost = (float) ($product->cost_price ?? 0);
                    $price = (float) ($product->sale_price ?? 0);
                    $profit = $price - $cost;

                    $tradeMarkup = $cost > 0
                    ? ($profit / $cost) * 100
                    : 0;

                    $margin = $price > 0
                    ? ($profit / $price) * 100
                    : 0;
                    @endphp

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-4 py-3 text-sm font-bold text-slate-600">
                            {{ $product->id }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="w-12 h-9 rounded-lg overflow-hidden border border-slate-200 flex items-center justify-center bg-slate-100">

                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full"
                                    style="background: {{ $product->color ?? '#334155' }}">
                                </div>
                                @endif

                            </div>
                        </td>

                        <td class="px-4 py-3">
                            <div class="text-sm font-black text-blue-600">
                                {{ $product->name }}
                            </div>

                            @if($product->barcode)
                            <div class="text-xs text-slate-400 mt-0.5">
                                {{ $product->barcode }}
                            </div>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($product->is_active)
                            <span class="inline-flex w-6 h-6 rounded-full bg-green-100 text-green-600 items-center justify-center font-black">
                                ✓
                            </span>
                            @else
                            <span class="inline-flex w-6 h-6 rounded-full bg-red-100 text-red-600 items-center justify-center font-black">
                                ×
                            </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($product->is_gift)
                            <span class="inline-flex w-6 h-6 rounded-full bg-green-100 text-green-600 items-center justify-center font-black">
                                ✓
                            </span>
                            @else
                            <span class="inline-flex w-6 h-6 rounded-full bg-red-100 text-red-500 items-center justify-center font-black">
                                ×
                            </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm font-bold text-slate-600">
                            Tək karta
                        </td>

                        <td class="px-4 py-3 text-sm font-bold text-slate-600">
                            {{ $product->menuCategory->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm font-bold text-slate-600">
                            {{ $product->menuDepartment->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm font-bold text-slate-500">
                            -
                        </td>

                        <td class="px-4 py-3 text-right text-sm font-black text-slate-700">
                            {{ number_format($cost, 2) }}
                        </td>

                        <td class="px-4 py-3 text-right text-sm font-black text-slate-900">
                            {{ number_format($price, 2) }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            <span class="text-sm font-black {{ $tradeMarkup >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($tradeMarkup, 2) }} %
                            </span>
                        </td>

                        <td class="px-4 py-3 text-right">
                            <span class="text-sm font-black {{ $margin >= 0 ? 'text-indigo-600' : 'text-red-600' }}">
                                {{ number_format($margin, 2) }} %
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('owner.menu.products.edit', $product) }}"
                                    class="h-9 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-black flex items-center">
                                    Düzəliş
                                </a>

                                <a href="#"
                                    class="h-9 px-3 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 text-xs font-black flex items-center">
                                    Sil
                                </a>
                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="14" class="py-24 text-center">

                            <h3 class="text-lg font-black text-slate-800">
                                Hələ məhsul yoxdur
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                İlk məhsulunuzu yaradaraq başlayın.
                            </p>

                            <a href="{{ route('owner.menu.products.create') }}"
                                class="mt-6 inline-flex h-11 px-6 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black items-center">
                                Məhsul yarat
                            </a>

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection