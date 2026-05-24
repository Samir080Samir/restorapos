@extends('owner.layouts.app')

@section('title', 'Kateqoriyalar')

@section('content')

<div class="max-w-[1400px] mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-black text-slate-900">
                Kateqoriyalar
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                POS və eMenu kateqoriyalarının idarə olunması.
            </p>
        </div>

        <a href="{{ route('owner.menu.categories.create') }}"
            class="h-12 px-6 rounded-2xl bg-indigo-600 hover:bg-indigo-700 transition text-white text-sm font-black flex items-center justify-center gap-2 shadow-sm">
            <span>+</span>
            <span>Kateqoriya yarat</span>
        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

    <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-bold text-green-700">
        {{ session('success') }}
    </div>

    @endif

    {{-- Table --}}
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px]">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            ID
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            Rəng
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            Ad
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            Slug
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            İkon
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-wide text-slate-500">
                            Sıralama
                        </th>

                        <th class="px-5 py-4 text-center text-xs font-black uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-5 py-4 text-right text-xs font-black uppercase tracking-wide text-slate-500">
                            Əməliyyat
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($categories as $category)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- ID --}}
                        <td class="px-5 py-4 text-sm font-black text-slate-600">
                            {{ $category->id }}
                        </td>

                        {{-- Color --}}
                        <td class="px-5 py-4">

                            <div class="w-11 h-11 rounded-2xl border border-slate-200 shadow-sm"
                                style="background-color: {{ $category->color ?? '#4f46e5' }};">
                            </div>

                        </td>

                        {{-- Name --}}
                        <td class="px-5 py-4">

                            <div class="text-sm font-black text-slate-800">
                                {{ $category->name }}
                            </div>

                        </td>

                        {{-- Slug --}}
                        <td class="px-5 py-4 text-sm font-bold text-slate-500">
                            {{ $category->slug }}
                        </td>

                        {{-- Icon --}}
                        <td class="px-5 py-4">

                            <div class="w-11 h-11 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-lg">
                                {{ $category->icon ?? '🍽️' }}
                            </div>

                        </td>

                        {{-- Sort --}}
                        <td class="px-5 py-4 text-sm font-black text-slate-700">
                            {{ $category->sort_order }}
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4 text-center">

                            @if($category->is_active)

                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-black">
                                Aktiv
                            </span>

                            @else

                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-black">
                                Passiv
                            </span>

                            @endif

                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center justify-end gap-2">

                                <a href="{{ route('owner.menu.categories.edit', $category->id) }}"
                                    class="h-10 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-slate-700 text-xs font-black flex items-center justify-center">
                                    Düzəliş
                                </a>

                                <form method="POST"
                                    action="{{ route('owner.menu.categories.destroy', $category->id) }}"
                                    onsubmit="return confirm('Kateqoriya silinsin?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="h-10 px-4 rounded-xl bg-red-50 hover:bg-red-100 transition text-red-600 text-xs font-black">
                                        Sil
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="py-24 text-center">

                            <div class="max-w-md mx-auto">

                                <div class="text-5xl mb-4">
                                    📂
                                </div>

                                <h3 class="text-xl font-black text-slate-800">
                                    Hələ kateqoriya yoxdur
                                </h3>

                                <p class="text-sm text-slate-500 mt-2 leading-6">
                                    İlk kateqoriyanızı yaradaraq POS menyusunu hazırlamağa başlayın.
                                </p>

                                <a href="{{ route('owner.menu.categories.create') }}"
                                    class="mt-6 inline-flex h-11 px-6 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black items-center justify-center">
                                    Kateqoriya yarat
                                </a>

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