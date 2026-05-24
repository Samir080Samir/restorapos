@extends('owner.layouts.app')

@section('title', 'Filiallar')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-black text-slate-900">
                Filiallar
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Super admin tərəfindən yaradılmış filiallar
            </p>
        </div>

    </div>

    @if(session('success'))

    <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">
        {{ session('success') }}
    </div>

    @endif

    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">
                            Filial
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">
                            Telefon
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">
                            Ünvan
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">
                            Status
                        </th>

                        <th class="text-right px-6 py-4 text-xs font-bold uppercase text-slate-500">
                            Əməliyyat
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($branches as $branch)

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-11 h-11 rounded-2xl bg-[#2f3f7a]/10 flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-[#2f3f7a]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M15 9h.01M9 13h.01M15 13h.01M9 17h.01M15 17h.01" />

                                    </svg>

                                </div>

                                <div>

                                    <p class="font-bold text-slate-900">
                                        {{ $branch->name }}
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        ID: #{{ $branch->id }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5 text-sm text-slate-700">
                            {{ $branch->phone ?: '-' }}
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-700">
                            {{ $branch->address ?: '-' }}
                        </td>

                        <td class="px-6 py-5">

                            @if($branch->status === 'active')

                            <span class="inline-flex px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold">
                                Aktiv
                            </span>

                            @else

                            <span class="inline-flex px-3 py-1 rounded-xl bg-red-50 text-red-700 text-xs font-bold">
                                Passiv
                            </span>

                            @endif

                        </td>

                        <td class="px-6 py-5 text-right">

                            <div class="flex items-center justify-end gap-2">

                                <form method="POST"
                                    action="{{ route('owner.branches.switch') }}">

                                    @csrf

                                    <input type="hidden"
                                        name="branch_id"
                                        value="{{ $branch->id }}">

                                    <button type="submit"
                                        class="h-10 px-4 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">

                                        Filiala keç

                                    </button>

                                </form>

                                <a href="{{ route('owner.branches.edit', $branch) }}"
                                    class="h-10 px-4 rounded-xl bg-[#2f3f7a] text-white text-sm font-semibold flex items-center hover:opacity-95 transition">

                                    Redaktə et

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="px-6 py-16 text-center">

                            <h3 class="text-lg font-bold text-slate-900">
                                Filial tapılmadı
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Filiallar super admin panelindən yaradılır.
                            </p>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection