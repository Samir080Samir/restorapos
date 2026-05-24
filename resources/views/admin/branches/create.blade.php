@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Yeni filial əlavə et
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Filialın SaaS idarəetmə məlumatlarını daxil edin
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
        action="{{ route('admin.branches.store') }}"
        enctype="multipart/form-data">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Restoran --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Restoran
                </label>

                <select name="restaurant_id"
                    class="w-full border border-gray-200 rounded-2xl p-3">

                    @foreach($restaurants as $restaurant)

                    <option value="{{ $restaurant->id }}">
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

            </div>

            {{-- Telefon --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Telefon
                </label>

                <input type="text"
                    name="phone"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Şəhər --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Şəhər
                </label>

                <input type="text"
                    name="city"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Ünvan --}}
            <div class="md:col-span-2">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Ünvan
                </label>

                <input type="text"
                    name="address"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Status --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Status
                </label>

                <select name="status"
                    class="w-full border border-gray-200 rounded-2xl p-3">

                    <option value="active">
                        Aktiv
                    </option>

                    <option value="inactive">
                        Deaktiv
                    </option>

                </select>

            </div>

            {{-- Live Status --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Live status
                </label>

                <select name="live_status"
                    class="w-full border border-gray-200 rounded-2xl p-3">

                    <option value="offline">
                        Offline
                    </option>

                    <option value="online">
                        Online
                    </option>

                </select>

            </div>

            <input type="hidden"
                name="branch_type"
                value="standard">

            {{-- POS --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    POS sayı
                </label>

                <input type="number"
                    name="pos_terminals_count"
                    value="0"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- KDS --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    KDS sayı
                </label>

                <input type="number"
                    name="kds_count"
                    value="0"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Printer --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Printer sayı
                </label>

                <input type="number"
                    name="printer_count"
                    value="0"
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- QR Menu --}}
            <div class="flex items-center gap-3 mt-8">

                <input type="checkbox"
                    name="qr_menu_enabled"
                    value="1">

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
                    class="w-full border border-gray-200 rounded-2xl p-3">

            </div>

            {{-- Bağlanış --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Bağlanış saatı
                </label>

                <input type="time"
                    name="closes_at"
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