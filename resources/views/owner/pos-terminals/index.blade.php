@extends('owner.layouts.app')

@section('title', 'Terminallar')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">

    <div class="flex items-center justify-between gap-4 mb-5">
        <div>
            <h1 class="text-xl font-bold text-slate-900">
                Terminallar
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                POS üçün istifadə olunacaq cihazları buradan idarə edin.
            </p>
        </div>

        <a href="{{ route('owner.pos-terminals.create') }}"
            class="px-4 py-2.5 rounded-xl bg-[#2f3f7a] text-white text-sm font-semibold hover:bg-[#263466] transition">
            Yeni terminal
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500">
                    <th class="py-3 text-left font-semibold">Ad</th>
                    <th class="py-3 text-left font-semibold">Filial</th>
                    <th class="py-3 text-left font-semibold">Kod</th>
                    <th class="py-3 text-left font-semibold">Status</th>
                    <th class="py-3 text-right font-semibold">Əməliyyat</th>
                </tr>
            </thead>

            <tbody>
                @forelse($terminals as $terminal)
                <tr class="border-b border-slate-100">
                    <td class="py-4 font-semibold text-slate-800">
                        {{ $terminal->name }}
                    </td>

                    <td class="py-4 text-slate-600">
                        {{ $terminal->branch->name ?? 'Ümumi' }}
                    </td>

                    <td class="py-4">
                        <span class="px-3 py-1 rounded-lg bg-slate-100 font-mono text-xs font-bold">
                            {{ $terminal->activation_code }}
                        </span>
                    </td>

                    <td class="py-4">
                        @if($terminal->is_active)
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold">
                            Aktiv
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold">
                            Passiv
                        </span>
                        @endif
                    </td>

                    <td class="py-4 text-right">
                        <a href="{{ route('owner.pos-terminals.edit', $terminal) }}"
                            class="text-[#2f3f7a] font-semibold hover:underline">
                            Düzəlt
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-slate-500">
                        Hələ terminal əlavə edilməyib.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection