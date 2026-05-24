@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Filiallar
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Restoran filiallarının SaaS idarəetmə siyahısı
        </p>
    </div>

    <a href="{{ route('admin.branches.create') }}"
        class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-sm transition">
        Yeni filial əlavə et
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Ümumi filial</p>
        <h2 class="text-2xl font-bold mt-2">{{ $totalBranches }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Aktiv filial</p>
        <h2 class="text-2xl font-bold mt-2 text-green-600">{{ $activeBranches }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Deaktiv filial</p>
        <h2 class="text-2xl font-bold mt-2 text-red-600">{{ $inactiveBranches }}</h2>
    </div>

    <div class="bg-gradient-to-br from-blue-600 to-cyan-500 p-4 rounded-2xl shadow-sm text-white">
        <p class="text-sm text-blue-100">Online filial</p>
        <h2 class="text-2xl font-bold mt-2">{{ $onlineBranches }}</h2>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Filial</th>
                <th class="px-4 py-3 text-left">Restoran</th>
                <th class="px-4 py-3 text-left">Şəhər</th>
                <th class="px-4 py-3 text-left">Telefon</th>
                <th class="px-4 py-3 text-left">Paket</th>
                <th class="px-4 py-3 text-left">Live</th>
                <th class="px-4 py-3 text-left">Avadanlıq</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-right">Əməliyyatlar</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @foreach($branches as $branch)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-4">
                    <div class="flex items-center gap-3">
                        @if($branch->logo)
                        <img src="{{ asset('storage/' . $branch->logo) }}"
                            class="w-12 h-12 rounded-2xl object-cover border border-gray-200 shadow-sm">
                        @else
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ strtoupper(substr($branch->name, 0, 1)) }}
                        </div>
                        @endif

                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $branch->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $branch->address ?? 'Ünvan yoxdur' }}
                            </p>
                        </div>
                    </div>
                </td>

                <td class="px-4 py-4 text-gray-700">
                    {{ $branch->restaurant->name ?? '-' }}
                </td>

                <td class="px-4 py-4 text-gray-700">
                    {{ $branch->city ?? '-' }}
                </td>

                <td class="px-4 py-4 text-gray-700">
                    {{ $branch->phone ?? '-' }}
                </td>

                <td class="px-4 py-4">
                    @if($branch->restaurant?->plan)
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $branch->restaurant->plan->name }}
                    </span>
                    @else
                    <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">
                        Paket yoxdur
                    </span>
                    @endif
                </td>

                <td class="px-4 py-4">
                    @if($branch->live_status == 'online')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Online
                    </span>
                    @else
                    <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">
                        Offline
                    </span>
                    @endif
                </td>

                <td class="px-4 py-4 text-gray-700">
                    <div class="text-xs space-y-1">
                        <p>POS: {{ $branch->pos_terminals_count }}</p>
                        <p>KDS: {{ $branch->kds_count }}</p>
                        <p>Printer: {{ $branch->printer_count }}</p>
                    </div>
                </td>

                <td class="px-4 py-4">
                    @if($branch->status == 'active')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Aktiv
                    </span>
                    @else
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Deaktiv
                    </span>
                    @endif
                </td>

                <td class="px-4 py-4">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.branches.edit', $branch) }}"
                            class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-2 rounded-xl text-xs font-semibold transition">
                            Düzəliş
                        </a>

                        <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                onclick="return confirm('Filial silinsin?')"
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