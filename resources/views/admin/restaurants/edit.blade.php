@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Restoranı redaktə et
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Restoran məlumatlarını yeniləyin
            </p>
        </div>

        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center shadow-lg shadow-orange-500/20">
            <svg class="w-7 h-7 text-white"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11 5h2M12 7v10m-7 0h14M5 17l1.5-9h11L19 17" />
            </svg>
        </div>

    </div>

    <form method="POST"
        action="{{ route('admin.restaurants.update', $restaurant) }}"
        enctype="multipart/form-data"
        autocomplete="off">

        @csrf
        @method('PUT')

        {{-- Fake autofill blocker --}}
        <input type="text" name="fakeusernameremembered" style="display:none">
        <input type="password" name="fakepasswordremembered" style="display:none">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Restoran adı --}}
            <div class="md:col-span-2">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    {{ __('messages.name') }}
                </label>

                <input type="text"
                    name="name"
                    value="{{ old('name', $restaurant->name) }}"
                    autocomplete="off"
                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                @error('name')
                <p class="text-red-500 text-xs mt-1">
                    {{ $message }}
                </p>
                @enderror

            </div>

            {{-- Sahib --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    {{ __('messages.owner_name') }}
                </label>

                <input type="text"
                    name="owner_name"
                    value="{{ old('owner_name', $restaurant->owner_name) }}"
                    autocomplete="off"
                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            {{-- Telefon --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    {{ __('messages.phone') }}
                </label>

                <input type="text"
                    name="phone"
                    value="{{ old('phone', $restaurant->phone) }}"
                    autocomplete="off"
                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

            {{-- Email --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    {{ __('messages.email') }}
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $restaurant->email) }}"

                    autocomplete="off"
                    autocorrect="off"
                    autocapitalize="off"
                    spellcheck="false"

                    readonly
                    onfocus="this.removeAttribute('readonly');"

                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                @error('email')
                <p class="text-red-500 text-xs mt-1">
                    {{ $message }}
                </p>
                @enderror

            </div>

            {{-- Owner parolu --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Yeni owner parolu
                </label>

                <input
                    type="password"
                    name="owner_password"
                    value=""
                    placeholder="Boş buraxsan dəyişməyəcək"

                    autocomplete="new-password"
                    autocorrect="off"
                    autocapitalize="off"
                    spellcheck="false"

                    readonly
                    onfocus="this.removeAttribute('readonly');"

                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <p class="text-xs text-gray-400 mt-2">
                    Minimum 8 simvol,
                    böyük hərf,
                    kiçik hərf,
                    rəqəm və simvol olmalıdır.
                </p>

                @error('owner_password')
                <p class="text-red-500 text-xs mt-1">
                    {{ $message }}
                </p>
                @enderror

            </div>

            {{-- Logo --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Restoran loqosu
                </label>

                <input type="file"
                    name="logo"
                    class="w-full border border-gray-200 rounded-2xl p-3 bg-white">

                @if($restaurant->logo)

                <div class="mt-4 flex items-center gap-4">

                    <img src="{{ asset('storage/' . $restaurant->logo) }}"
                        class="w-20 h-20 rounded-2xl object-cover border border-gray-200 shadow-sm">

                    <button type="submit"
                        name="remove_logo"
                        value="1"
                        class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-semibold transition">

                        Loqonu sil

                    </button>

                </div>

                @endif

            </div>

            {{-- Paket --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Paket seçimi
                </label>

                <select name="plan_id"
                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    <option value="">
                        Paket seçin
                    </option>

                    @foreach($plans as $plan)

                    <option value="{{ $plan->id }}"
                        {{ old('plan_id', $restaurant->plan_id) == $plan->id ? 'selected' : '' }}>

                        {{ $plan->name }}

                    </option>

                    @endforeach

                </select>

            </div>

            {{-- Status --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    {{ __('messages.status') }}
                </label>

                <select name="status"
                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    <option value="active"
                        {{ old('status', $restaurant->status) == 'active' ? 'selected' : '' }}>

                        {{ __('messages.active') }}

                    </option>

                    <option value="inactive"
                        {{ old('status', $restaurant->status) == 'inactive' ? 'selected' : '' }}>

                        {{ __('messages.inactive') }}

                    </option>

                </select>

            </div>

            {{-- Bitmə tarixi --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    {{ __('messages.subscription_end') }}
                </label>

                <input type="date"
                    name="subscription_ends_at"
                    value="{{ old('subscription_ends_at', optional($restaurant->subscription_ends_at)->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            </div>

        </div>

        {{-- Buttonlar --}}
        <div class="flex items-center gap-3 mt-8">

            <button type="submit"
                class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl text-sm font-semibold transition">

                {{ __('messages.save') }}

            </button>

            <a href="{{ route('admin.restaurants.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl text-sm font-semibold transition">

                Geri qayıt

            </a>

        </div>

    </form>

</div>

@endsection