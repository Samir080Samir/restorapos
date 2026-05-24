@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Audit tarixçəsi
        </h1>

        <p class="text-gray-500 mt-1">
            Sistem daxilində edilən bütün əməliyyatların izlənməsi
        </p>
    </div>

    <form method="GET"
        action="{{ route('admin.audit-logs.index') }}"
        class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <select name="module"
                class="border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                <option value="">
                    Bütün modullar
                </option>

                @foreach($modules as $module)
                <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $module)) }}
                </option>
                @endforeach

            </select>

            <select name="action"
                class="border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                <option value="">
                    Bütün əməliyyatlar
                </option>

                @foreach($actions as $action)
                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                    {{ ucfirst($action) }}
                </option>
                @endforeach

            </select>

            <input type="date"
                name="date_from"
                value="{{ request('date_from') }}"
                class="border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

            <input type="date"
                name="date_to"
                value="{{ request('date_to') }}"
                class="border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

            <button type="submit"
                class="bg-black hover:bg-gray-800 text-white rounded-2xl font-bold transition">
                Filterlə
            </button>

        </div>

    </form>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Tarix
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            İstifadəçi
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Restoran
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Modul
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Əməliyyat
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            Açıqlama
                        </th>

                        <th class="text-left px-6 py-4 text-sm font-bold text-gray-700">
                            IP
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($logs as $log)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-5 whitespace-nowrap">
                            <p class="font-semibold text-gray-900">
                                {{ $log->created_at->format('d.m.Y') }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ $log->created_at->format('H:i:s') }}
                            </p>
                        </td>

                        <td class="px-6 py-5">
                            <p class="font-semibold text-gray-900">
                                {{ $log->user->name ?? 'Sistem' }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ $log->user->email ?? '-' }}
                            </p>
                        </td>

                        <td class="px-6 py-5">
                            <p class="font-semibold text-gray-900">
                                {{ $log->restaurant->name ?? '-' }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ $log->branch->name ?? '' }}
                            </p>
                        </td>

                        <td class="px-6 py-5">
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                {{ ucfirst(str_replace('_', ' ', $log->module)) }}
                            </span>
                        </td>

                        <td class="px-6 py-5">
                            @if($log->action == 'created')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                Yaradıldı
                            </span>
                            @elseif($log->action == 'updated')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                Yeniləndi
                            </span>
                            @elseif($log->action == 'deleted')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                Silindi
                            </span>
                            @elseif($log->action == 'login')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                Giriş
                            </span>
                            @elseif($log->action == 'logout')
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                Çıxış
                            </span>
                            @else
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                {{ ucfirst($log->action) }}
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-5 max-w-md">
                            <p class="text-sm text-gray-700">
                                {{ $log->description ?? $log->event_key }}
                            </p>

                            @if($log->auditable_type && $log->auditable_id)
                            <p class="text-xs text-gray-400 mt-1">
                                Model: {{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}
                            </p>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            <p class="text-sm text-gray-700">
                                {{ $log->ip_address ?? '-' }}
                            </p>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-16">
                            <h3 class="text-xl font-bold text-gray-800">
                                Audit məlumatı tapılmadı
                            </h3>

                            <p class="text-gray-500 mt-2">
                                Hələ sistemdə audit qeydi yoxdur.
                            </p>
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>

</div>

@endsection