@extends('owner.layouts.app')

@section('title', 'Vəzifələr')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-black text-slate-900">
                Vəzifələr
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Əməkdaş rolları və səlahiyyətləri
            </p>
        </div>

        <a href="{{ route('owner.staff.roles.create') }}"
            class="h-11 px-5 rounded-2xl bg-[#2f3f7a] text-white text-sm font-semibold flex items-center gap-2 hover:opacity-95 transition">

            <svg class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path d="M12 5v14M5 12h14" />

            </svg>

            <span>
                Yeni vəzifə
            </span>

        </a>

    </div>

    {{-- Success --}}
    @if(session('success'))

    <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">

        {{ session('success') }}

    </div>

    @endif

    {{-- Table --}}
    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Vəzifə
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Səlahiyyət sayı
                        </th>

                        <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Əməliyyat
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($roles as $role)

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-11 h-11 rounded-2xl bg-[#2f3f7a]/10 flex items-center justify-center">

                                    <svg class="w-5 h-5 text-[#2f3f7a]"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24">

                                        <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                                        <circle cx="10" cy="7" r="4" />

                                    </svg>

                                </div>

                                <div>

                                    <p class="font-bold text-slate-900">
                                        {{ $role->name }}
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $role->slug }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5">

                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold">

                                {{ $role->permissions_count }}

                            </div>

                        </td>

                        <td class="px-6 py-5">

                            @if($role->is_active)

                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold">

                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                Aktiv

                            </div>

                            @else

                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-50 text-red-700 text-sm font-semibold">

                                <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                Passiv

                            </div>

                            @endif

                        </td>

                        <td class="px-6 py-5 text-right">

                            <a href="{{ route('owner.staff.roles.edit', $role) }}"
                                class="inline-flex items-center gap-2 px-4 h-10 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">

                                <svg class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4Z" />

                                </svg>

                                Düzəliş et

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="px-6 py-16 text-center">

                            <div class="max-w-sm mx-auto">

                                <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-5">

                                    <svg class="w-9 h-9 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24">

                                        <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                                        <circle cx="10" cy="7" r="4" />

                                    </svg>

                                </div>

                                <h3 class="text-lg font-bold text-slate-900">
                                    Hələ vəzifə yaradılmayıb
                                </h3>

                                <p class="text-sm text-slate-500 mt-2">
                                    Kassir, offisiant, maliyyəçi və digər rolları yaradın.
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