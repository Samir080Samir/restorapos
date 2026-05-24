@extends('owner.layouts.app')

@section('title', 'İstifadəçilər')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">İstifadəçilər</h1>
            <p class="text-sm text-slate-500 mt-1">Əməkdaşlar, filial bağlantısı və giriş tipi</p>
        </div>

        <a href="{{ route('owner.staff.users.create') }}"
            class="h-11 px-5 rounded-2xl bg-[#2f3f7a] text-white text-sm font-semibold flex items-center gap-2 hover:opacity-95 transition">
            <span>+</span>
            <span>Yeni əməkdaş</span>
        </a>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">Əməkdaş</th>
                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">Filial</th>
                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">Vəzifə</th>
                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">Giriş tipi</th>
                        <th class="text-left px-6 py-4 text-xs font-bold uppercase text-slate-500">Status</th>
                        <th class="text-right px-6 py-4 text-xs font-bold uppercase text-slate-500">Əməliyyat</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-5">
                            <p class="font-bold text-slate-900">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $user->email ?? 'E-mail yoxdur' }}</p>
                        </td>

                        <td class="px-6 py-5 text-sm text-slate-700">
                            {{ $user->branch->name ?? 'Təyin edilməyib' }}
                        </td>

                        <td class="px-6 py-5">
                            @forelse($user->ownerRoles as $role)
                            <span class="inline-flex px-3 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">
                                {{ $role->name }}
                            </span>
                            @empty
                            <span class="text-xs text-slate-400">Vəzifə yoxdur</span>
                            @endforelse
                        </td>

                        <td class="px-6 py-5">
                            @if($user->login_type === 'panel')
                            <span class="px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold">
                                Owner panel
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-xl bg-blue-50 text-blue-700 text-xs font-bold">
                                POS ekranı
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            @if($user->is_active)
                            <span class="px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold">
                                Aktiv
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-xl bg-red-50 text-red-700 text-xs font-bold">
                                Passiv
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-5 text-right">
                            <a href="{{ route('owner.staff.users.edit', $user) }}"
                                class="inline-flex items-center px-4 h-10 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                Düzəliş et
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <h3 class="text-lg font-bold text-slate-900">Hələ əməkdaş yaradılmayıb</h3>
                            <p class="text-sm text-slate-500 mt-2">Kassir, offisiant, maliyyəçi və filial meneceri əlavə edin.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection