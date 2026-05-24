@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            İstifadəçilər
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Restoran, filial və əməkdaş rollarının idarə edilməsi
        </p>
    </div>

    <a href="{{ route('admin.users.create') }}"
        class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-sm transition">
        Yeni istifadəçi əlavə et
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Ümumi istifadəçi</p>
        <h2 class="text-2xl font-bold mt-2">{{ $totalUsers }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Aktiv hesab</p>
        <h2 class="text-2xl font-bold mt-2 text-green-600">{{ $activeUsers }}</h2>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Restoran adminləri</p>
        <h2 class="text-2xl font-bold mt-2 text-blue-600">{{ $restaurantAdmins }}</h2>
    </div>

    <div class="bg-gradient-to-br from-blue-600 to-cyan-500 p-4 rounded-2xl shadow-sm text-white">
        <p class="text-sm text-blue-100">Əməkdaş istifadəçilər</p>
        <h2 class="text-2xl font-bold mt-2">{{ $staffUsers }}</h2>
    </div>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">İstifadəçi</th>
                <th class="px-4 py-3 text-left">Restoran</th>
                <th class="px-4 py-3 text-left">Filial</th>
                <th class="px-4 py-3 text-left">Rol</th>
                <th class="px-4 py-3 text-left">Qeydiyyat</th>
                <th class="px-4 py-3 text-right">Əməliyyatlar</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @foreach($users as $user)

            <tr class="hover:bg-gray-50 transition">

                <td class="px-4 py-4">
                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $user->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $user->email }}
                            </p>
                        </div>

                    </div>
                </td>

                <td class="px-4 py-4 text-gray-700">
                    {{ $user->restaurant->name ?? '-' }}
                </td>

                <td class="px-4 py-4 text-gray-700">
                    {{ $user->branch->name ?? '-' }}
                </td>

                <td class="px-4 py-4">
                    @if($user->role == 'super_admin')
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Super Admin
                    </span>
                    @elseif($user->role == 'restaurant_admin')
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Restoran Admin
                    </span>
                    @elseif($user->role == 'branch_manager')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Filial Meneceri
                    </span>
                    @elseif($user->role == 'cashier')
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Kassir
                    </span>
                    @elseif($user->role == 'waiter')
                    <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Ofisiant
                    </span>
                    @elseif($user->role == 'kitchen')
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                        Mətbəx
                    </span>
                    @else
                    <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">
                        {{ $user->role }}
                    </span>
                    @endif
                </td>

                <td class="px-4 py-4 text-gray-700">
                    {{ $user->created_at?->format('d.m.Y') }}
                </td>

                <td class="px-4 py-4">
                    <div class="flex justify-end gap-2">

                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-2 rounded-xl text-xs font-semibold transition">
                            Düzəliş
                        </a>

                        <form action="{{ route('admin.users.destroy', $user) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                onclick="return confirm('İstifadəçi silinsin?')"
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