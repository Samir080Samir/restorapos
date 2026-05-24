@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Paketi redaktə et
            </h1>

            <p class="text-gray-500 mt-1">
                NovaPos SaaS paket məlumatlarını yenilə
            </p>
        </div>

        <a href="{{ route('admin.plans.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl transition text-center font-medium">
            Geri qayıt
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">
        <ul class="space-y-1">
            @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.plans.update', $plan->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-900">
                        Paket məlumatları
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Paket adı
                            </label>

                            <input type="text"
                                name="name"
                                value="{{ old('name', $plan->name) }}"
                                placeholder="Məsələn: Business Pro"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Status
                            </label>

                            <select name="status"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                                <option value="active" {{ old('status', $plan->status) == 'active' ? 'selected' : '' }}>
                                    Aktiv
                                </option>

                                <option value="inactive" {{ old('status', $plan->status) == 'inactive' ? 'selected' : '' }}>
                                    Deaktiv
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Aylıq qiymət
                            </label>

                            <input type="number"
                                step="0.01"
                                name="monthly_price"
                                value="{{ old('monthly_price', $plan->monthly_price) }}"
                                placeholder="0.00"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                İllik qiymət
                            </label>

                            <input type="number"
                                step="0.01"
                                name="yearly_price"
                                value="{{ old('yearly_price', $plan->yearly_price) }}"
                                placeholder="0.00"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-900">
                        Limitlər
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Maksimum filial
                            </label>

                            <input type="number"
                                name="max_branches"
                                value="{{ old('max_branches', $plan->max_branches) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Maksimum istifadəçi
                            </label>

                            <input type="number"
                                name="max_users"
                                value="{{ old('max_users', $plan->max_users) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                Maksimum masa
                            </label>

                            <input type="number"
                                name="max_tables"
                                value="{{ old('max_tables', $plan->max_tables) }}"
                                class="w-full border border-gray-200 rounded-2xl p-3 focus:ring-2 focus:ring-black focus:border-black">
                        </div>

                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-5">
                    <label class="flex items-center gap-4 cursor-pointer">
                        <input type="checkbox"
                            name="is_popular"
                            value="1"
                            {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">

                        <div>
                            <p class="font-bold text-gray-900">
                                Ən çox seçilən paket
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Bu paket siyahıda premium qızılı badge ilə göstəriləcək.
                            </p>
                        </div>
                    </label>
                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-900">
                        Modul icazələri
                    </h2>

                    @php
                    $modules = [
                    'qr_menu' => 'QR Menu',
                    'waiter_app' => 'Ofisiant tətbiqi',
                    'kitchen_display' => 'Mətbəx ekranı',
                    'kiosk' => 'Kiosk',
                    'inventory' => 'Anbar sistemi',
                    'reports' => 'Hesabatlar',
                    'multi_branch' => 'Multi filial',
                    ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($modules as $key => $label)
                        <label class="flex items-center justify-between bg-gray-50 hover:bg-gray-100 p-4 rounded-2xl cursor-pointer transition">
                            <span class="font-semibold text-gray-700">
                                {{ $label }}
                            </span>

                            <input type="checkbox"
                                name="{{ $key }}"
                                value="1"
                                {{ old($key, $plan->$key) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <button type="submit"
                        class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition">
                        Məlumatları yenilə
                    </button>
                </div>

            </div>

        </div>
    </form>

</div>

@endsection