@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Admin rolları
            </h1>

            <p class="text-gray-500 mt-1">
                Sistem rolları və icazə idarəetməsi
            </p>
        </div>

        <a href="{{ route('admin.admin-roles.create') }}"
            class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl transition font-medium shadow-sm text-center">
            Yeni rol
        </a>

    </div>

    @if(session('success'))

    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>

    @endif

    @if(session('error'))

    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">
        {{ session('error') }}
    </div>

    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

            <p class="text-gray-500 text-sm mb-2">
                Ümumi rol
            </p>

            <h2 class="text-3xl font-black text-gray-900">
                {{ $roles->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

            <p class="text-gray-500 text-sm mb-2">
                Aktiv rollar
            </p>

            <h2 class="text-3xl font-black text-green-600">
                {{ $roles->where('is_active', true)->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

            <p class="text-gray-500 text-sm mb-2">
                Sistem rolları
            </p>

            <h2 class="text-3xl font-black text-blue-600">
                {{ $roles->where('is_system', true)->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

            <p class="text-gray-500 text-sm mb-2">
                İstifadəçi sayı
            </p>

            <h2 class="text-3xl font-black text-purple-600">
                {{ $roles->sum('users_count') }}
            </h2>

        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

        @forelse($roles as $role)

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-start gap-4 mb-6">

                <div>

                    <div class="flex items-center gap-3 flex-wrap">

                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $role->name }}
                        </h2>

                        @if($role->is_active)

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                            Aktiv
                        </span>

                        @else

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                            Passiv
                        </span>

                        @endif

                        @if($role->is_system)

                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                            Sistem rolu
                        </span>

                        @endif

                    </div>

                    <p class="text-gray-500 text-sm mt-2">
                        {{ $role->description ?: 'Açıqlama yoxdur.' }}
                    </p>

                </div>

                <div class="text-right">

                    <p class="text-xs text-gray-500 mb-1">
                        İstifadəçilər
                    </p>

                    <h3 class="text-3xl font-black text-gray-900">
                        {{ $role->users_count }}
                    </h3>

                </div>

            </div>

            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 mb-6">

                <div class="flex items-center justify-between mb-4">

                    <h3 class="font-bold text-gray-900">
                        Modul icazələri
                    </h3>

                    <span class="text-xs text-gray-400">
                        {{ $role->permissions->count() }} modul
                    </span>

                </div>

                <div class="space-y-3 max-h-72 overflow-y-auto pr-2">

                    @foreach($role->permissions as $permission)

                    <div class="flex justify-between items-center bg-white border border-gray-100 rounded-xl px-4 py-3">

                        <div>
                            <p class="font-semibold text-gray-800 text-sm">
                                {{ ucfirst(str_replace('_', ' ', $permission->module)) }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2 justify-end">

                            @if($permission->can_view)
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-[10px] font-bold">
                                VIEW
                            </span>
                            @endif

                            @if($permission->can_create)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-[10px] font-bold">
                                CREATE
                            </span>
                            @endif

                            @if($permission->can_update)
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-lg text-[10px] font-bold">
                                UPDATE
                            </span>
                            @endif

                            @if($permission->can_delete)
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-lg text-[10px] font-bold">
                                DELETE
                            </span>
                            @endif

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

            <div class="flex gap-3">

                <a href="{{ route('admin.admin-roles.edit', $role->id) }}"
                    class="flex-1 bg-black hover:bg-gray-800 text-white text-center py-3 rounded-2xl transition font-semibold">
                    Redaktə et
                </a>

                @if(!$role->is_system)

                <form action="{{ route('admin.admin-roles.destroy', $role->id) }}"
                    method="POST"
                    class="flex-1"
                    onsubmit="return confirm('Rol silinsin?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-2xl transition font-semibold">
                        Sil
                    </button>

                </form>

                @endif

            </div>

        </div>

        @empty

        <div class="xl:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">

            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Rol tapılmadı
            </h2>

            <p class="text-gray-500">
                Hələ heç bir admin rolu yaradılmayıb.
            </p>

        </div>

        @endforelse

    </div>

</div>

@endsection