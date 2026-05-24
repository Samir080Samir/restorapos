@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Filialı redaktə et
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Filialın SaaS idarəetmə məlumatlarını yeniləyin
            </p>

        </div>

        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/20">

            <svg class="w-7 h-7 text-white"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4" />

            </svg>

        </div>

    </div>

    <form method="POST"
        action="{{ route('admin.branches.update', $branch) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')
        <input type="hidden" name="branch_type" value="{{ $branch->branch_type ?? 'standard' }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Restoran --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Restoran
                </label>

                <select name="restaurant_id"
                    class="w-full border border-gray-200 rounded-2xl p-3">

                    @foreach($restaurants as $restaurant)

                    <option value="{{ $restaurant->id }}"
                        {{ $branch->restaurant_id == $restaurant->id ? 'selected' : '' }}>

                        {{ $restaurant->name }}

                    </option>

                    @endforeach

                </select>

            </div>

            {{-- Filial adı --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Filial adı
                </label>

                <input type="text"
                    name="name"
                    value="{{ $branch->name }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Logo --}}
            <div class="md:col-span-2">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Filial loqosu
                </label>

                <input type="file"
                    name="logo"
                    class="w-full border border-gray-200 rounded-2xl p-3 bg-white">

                @if($branch->logo)

                <div class="mt-5 flex items-center gap-4">

                    <img src="{{ asset('storage/' . $branch->logo) }}"
                        class="w-24 h-24 rounded-2xl object-cover border border-gray-200 shadow-sm">

                    <button type="submit"
                        name="remove_logo"
                        value="1"
                        class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-semibold transition">

                        Loqonu sil

                    </button>

                </div>

                @endif

            </div>

            {{-- Telefon --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Telefon
                </label>

                <input type="text"
                    name="phone"
                    value="{{ $branch->phone }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Şəhər --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Şəhər
                </label>

                <input type="text"
                    name="city"
                    value="{{ $branch->city }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Ünvan --}}
            <div class="md:col-span-2">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Ünvan
                </label>

                <input type="text"
                    name="address"
                    value="{{ $branch->address }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Status --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Status
                </label>

                <select name="status"
                    class="w-full border border-gray-200 rounded-2xl p-3">

                    <option value="active"
                        {{ $branch->status == 'active' ? 'selected' : '' }}>
                        Aktiv
                    </option>

                    <option value="inactive"
                        {{ $branch->status == 'inactive' ? 'selected' : '' }}>
                        Deaktiv
                    </option>

                </select>

            </div>

            {{-- Live status --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Live status
                </label>

                <select name="live_status"
                    class="w-full border border-gray-200 rounded-2xl p-3">

                    <option value="online"
                        {{ $branch->live_status == 'online' ? 'selected' : '' }}>
                        Online
                    </option>

                    <option value="offline"
                        {{ $branch->live_status == 'offline' ? 'selected' : '' }}>
                        Offline
                    </option>

                </select>

            </div>

            {{-- POS --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    POS sayı
                </label>

                <input type="number"
                    name="pos_terminals_count"
                    value="{{ $branch->pos_terminals_count }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- KDS --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    KDS sayı
                </label>

                <input type="number"
                    name="kds_count"
                    value="{{ $branch->kds_count }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Printer --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Printer sayı
                </label>

                <input type="number"
                    name="printer_count"
                    value="{{ $branch->printer_count }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- QR Menu --}}
            <div class="flex items-center gap-3 mt-8">

                <input type="checkbox"
                    name="qr_menu_enabled"
                    value="1"
                    {{ $branch->qr_menu_enabled ? 'checked' : '' }}>

                <span class="text-sm font-medium text-gray-700">
                    QR Menu aktivdir
                </span>

            </div>

            {{-- Açılış --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Açılış saatı
                </label>

                <input type="time"
                    name="opens_at"
                    value="{{ $branch->opens_at }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Bağlanış --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Bağlanış saatı
                </label>

                <input type="time"
                    name="closes_at"
                    value="{{ $branch->closes_at }}"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

        </div>

        <div class="flex items-center gap-3 mt-8">

            <button type="submit"
                class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl text-sm font-semibold transition">

                Yadda saxla

            </button>

            <a href="{{ route('admin.branches.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl text-sm font-semibold transition">

                Geri qayıt

            </a>

        </div>

    </form>

</div>

@endsection