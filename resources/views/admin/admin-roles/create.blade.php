@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Yeni admin rolu
            </h1>

            <p class="text-gray-500 mt-1">
                Sistem üçün yeni admin rolu və icazələr yarat
            </p>
        </div>

        <a href="{{ route('admin.admin-roles.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl transition font-medium text-center">
            Geri qayıt
        </a>

    </div>

    @if ($errors->any())

    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">

        <ul class="space-y-1">

            @foreach ($errors->all() as $error)

            <li>• {{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <form method="POST"
        action="{{ route('admin.admin-roles.store') }}">

        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Sol hissə --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Əsas məlumatlar --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6">
                        Rol məlumatları
                    </h2>

                    <div class="space-y-5">

                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Rol adı
                            </label>

                            <input type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Məs: Maliyyə Admini"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">

                        </div>

                        <div>

                            <label class="block mb-2 font-semibold text-gray-700">
                                Açıqlama
                            </label>

                            <textarea name="description"
                                rows="5"
                                placeholder="Rol haqqında qısa məlumat..."
                                class="w-full border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-black focus:border-black resize-none">{{ old('description') }}</textarea>

                        </div>

                    </div>

                </div>

                {{-- Permission Matrix --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h2 class="text-xl font-bold text-gray-900">
                                Modul icazələri
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Rolun hansı modullara giriş edə biləcəyini seç
                            </p>
                        </div>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="border-b border-gray-100">

                                    <th class="text-left py-4 text-sm font-bold text-gray-700">
                                        Modul
                                    </th>

                                    <th class="text-center py-4 text-sm font-bold text-blue-600">
                                        View
                                    </th>

                                    <th class="text-center py-4 text-sm font-bold text-green-600">
                                        Create
                                    </th>

                                    <th class="text-center py-4 text-sm font-bold text-yellow-600">
                                        Update
                                    </th>

                                    <th class="text-center py-4 text-sm font-bold text-red-600">
                                        Delete
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($modules as $key => $module)

                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">

                                    <td class="py-4">

                                        <div>

                                            <p class="font-semibold text-gray-800">
                                                {{ $module }}
                                            </p>

                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $key }}
                                            </p>

                                        </div>

                                    </td>

                                    {{-- VIEW --}}
                                    <td class="text-center">

                                        <input type="checkbox"
                                            name="permissions[{{ $key }}][view]"
                                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                                    </td>

                                    {{-- CREATE --}}
                                    <td class="text-center">

                                        <input type="checkbox"
                                            name="permissions[{{ $key }}][create]"
                                            class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500">

                                    </td>

                                    {{-- UPDATE --}}
                                    <td class="text-center">

                                        <input type="checkbox"
                                            name="permissions[{{ $key }}][update]"
                                            class="w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">

                                    </td>

                                    {{-- DELETE --}}
                                    <td class="text-center">

                                        <input type="checkbox"
                                            name="permissions[{{ $key }}][delete]"
                                            class="w-5 h-5 rounded border-gray-300 text-red-600 focus:ring-red-500">

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            {{-- Sağ hissə --}}
            <div class="space-y-6">

                {{-- Status --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <h3 class="font-bold text-gray-900 mb-5">
                        Rol ayarları
                    </h3>

                    <div class="space-y-4">

                        <label class="flex items-center gap-3">

                            <input type="checkbox"
                                name="is_active"
                                checked
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">

                            <span class="text-gray-700 font-medium">
                                Rol aktiv olsun
                            </span>

                        </label>

                    </div>

                </div>

                {{-- Info --}}
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white">

                    <h3 class="text-lg font-bold mb-4">
                        Permission System
                    </h3>

                    <div class="space-y-3 text-sm text-slate-300">

                        <div class="flex justify-between">
                            <span>Security Layer</span>
                            <span class="font-semibold text-green-400">
                                Active
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>Module Protection</span>
                            <span class="font-semibold text-blue-400">
                                Enabled
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>Role Management</span>
                            <span class="font-semibold text-purple-400">
                                SaaS Ready
                            </span>
                        </div>

                    </div>

                </div>

                {{-- Submit --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Admin rolunu yarat
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection