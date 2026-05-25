@extends('owner.layouts.app')

@section('title', 'Məhsul yarat')

@section('content')

<div class="max-w-[1180px] mx-auto">

    <form method="POST"
        action="{{ route('owner.menu.products.store') }}"
        enctype="multipart/form-data"
        class="space-y-5">

        @csrf

        <div class="bg-white rounded-3xl border border-slate-200 p-5 shadow-sm">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h1 class="text-xl font-black text-slate-900">
                        Məhsul yarat
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        POS və eMenu üçün məhsul məlumatlarını əlavə edin.
                    </p>
                </div>

                <a href="{{ route('owner.menu.products.index') }}"
                    class="h-11 px-5 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold flex items-center">
                    Geri qayıt
                </a>
            </div>

            <div class="flex gap-2 border-b border-slate-200 mb-6">
                <button type="button"
                    data-product-tab="general"
                    onclick="switchProductTab('general')"
                    class="product-tab-btn px-5 py-3 border-b-2 border-indigo-600 text-indigo-600 font-black text-sm">
                    General
                </button>

                <button type="button"
                    data-product-tab="modifications"
                    onclick="switchProductTab('modifications')"
                    class="product-tab-btn px-5 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm">
                    Modifications
                </button>

                <button type="button"
                    data-product-tab="emenu"
                    onclick="switchProductTab('emenu')"
                    class="product-tab-btn px-5 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm">
                    eMenu
                </button>
            </div>

            <div id="productTabGeneral" class="product-tab-content">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="lg:col-span-2 space-y-5">

                        <div>
                            <label class="block text-sm font-black text-slate-700 mb-2">
                                Ad <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500"
                                placeholder="Məhsul adı">
                            @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-black text-slate-700 mb-2">
                                Barkod
                            </label>
                            <input type="text"
                                name="barcode"
                                value="{{ old('barcode') }}"
                                class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500"
                                placeholder="Barkod">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm font-black text-slate-700 mb-2">
                                    Kateqoriya
                                </label>
                                <select name="menu_category_id"
                                    class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">
                                    <option value="">Seçilməyib</option>

                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('menu_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-slate-700 mb-2">
                                    Şöbə
                                </label>
                                <select name="menu_department_id"
                                    class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">
                                    <option value="">Seçilməyib</option>

                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('menu_department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div>
                            <label class="block text-sm font-black text-slate-700 mb-2">
                                Açıqlama
                            </label>
                            <textarea name="description"
                                rows="4"
                                class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold outline-none focus:border-indigo-500"
                                placeholder="Məhsul haqqında qısa məlumat">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm font-black text-slate-700 mb-2">
                                    Maya dəyəri
                                </label>
                                <input type="number"
                                    step="0.01"
                                    name="cost_price"
                                    value="{{ old('cost_price', 0) }}"
                                    class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-black text-slate-700 mb-2">
                                    Qiymət <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                    step="0.01"
                                    name="sale_price"
                                    value="{{ old('sale_price') }}"
                                    class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">
                                @error('sale_price')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="space-y-5">

                        <div class="rounded-3xl border border-slate-200 p-4">
                            <label class="block text-sm font-black text-slate-700 mb-3">
                                Şəkil və ya rəng
                            </label>

                            <input type="color"
                                name="color"
                                value="{{ old('color', '#4f46e5') }}"
                                class="w-full h-12 rounded-2xl border border-slate-200">

                            <div class="mt-4">
                                <input type="file"
                                    name="image"
                                    accept="image/*"
                                    class="w-full rounded-2xl border border-slate-200 px-3 py-3 text-sm">
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 p-4 space-y-4">

                            <label class="flex items-center justify-between gap-3">
                                <span class="font-bold text-sm text-slate-700">Gizli</span>
                                <input type="checkbox" name="is_hidden" value="1" class="w-5 h-5" {{ old('is_hidden') ? 'checked' : '' }}>
                            </label>

                            <label class="flex items-center justify-between gap-3">
                                <span class="font-bold text-sm text-slate-700">İkram</span>
                                <input type="checkbox" name="is_gift" value="1" class="w-5 h-5" {{ old('is_gift') ? 'checked' : '' }}>
                            </label>

                            <label class="flex items-center justify-between gap-3">
                                <span class="font-bold text-sm text-slate-700">Endirimə icazə vermə</span>
                                <input type="checkbox" name="disable_discount" value="1" class="w-5 h-5" {{ old('disable_discount') ? 'checked' : '' }}>
                            </label>

                            <label class="flex items-center justify-between gap-3">
                                <span class="font-bold text-sm text-slate-700">Çəki ilə satılır</span>
                                <input type="checkbox" name="sold_by_weight" value="1" class="w-5 h-5" {{ old('sold_by_weight') ? 'checked' : '' }}>
                            </label>

                        </div>

                    </div>

                </div>

            </div>

            <div id="productTabModifications" class="product-tab-content hidden">

                <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-6">
                    <h3 class="text-base font-black text-slate-900">
                        Modifications
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Modifikatorlar növbəti mərhələdə aktivləşdiriləcək.
                    </p>
                </div>

            </div>

            <div id="productTabEmenu" class="product-tab-content hidden">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="lg:col-span-2 space-y-5">

                        <div class="rounded-3xl border border-slate-200 p-5 bg-white">

                            <div class="flex items-start justify-between gap-4">

                                <div>
                                    <h3 class="text-base font-black text-slate-900">
                                        QR menyuda göstər
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Bu seçim aktiv olduqda məhsul müştərinin QR menyusunda görünəcək.
                                    </p>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                        name="show_in_qr_menu"
                                        value="1"
                                        class="sr-only peer"
                                        {{ old('show_in_qr_menu') ? 'checked' : '' }}>

                                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:bg-emerald-600 after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:after:translate-x-6"></div>
                                </label>

                            </div>

                            <div class="mt-5 rounded-2xl bg-emerald-50 border border-emerald-100 p-4">

                                <p class="text-sm text-emerald-800 font-bold">
                                    Qayda:
                                </p>

                                <p class="text-sm text-emerald-700 mt-1 leading-6">
                                    Məhsul QR menyuda görünməsi üçün həm bu seçim aktiv olmalı, həm məhsul aktiv olmalı, həm də “Gizli” olmamalıdır.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="rounded-3xl border border-slate-200 p-5 bg-slate-50">

                        <h3 class="text-sm font-black text-slate-900">
                            QR Menu önizləmə
                        </h3>

                        <div class="mt-4 rounded-3xl bg-white border border-slate-200 p-4 shadow-sm">

                            <div class="h-28 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-400 text-sm font-bold">
                                Məhsul şəkli
                            </div>

                            <div class="mt-4">

                                <div class="text-base font-black text-slate-900">
                                    Məhsul adı
                                </div>

                                <div class="text-xs text-slate-500 mt-1">
                                    Məhsul açıqlaması
                                </div>

                                <div class="text-lg font-black text-emerald-600 mt-3">
                                    0.00 ₼
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('owner.menu.products.index') }}"
                class="h-12 px-6 rounded-2xl bg-slate-100 text-slate-700 font-black flex items-center">
                Ləğv et
            </a>

            <button type="submit"
                class="h-12 px-8 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black">
                Yadda saxla
            </button>
        </div>

    </form>

</div>

<script>
    function switchProductTab(tab) {
        const buttons = document.querySelectorAll('.product-tab-btn');

        const general = document.getElementById('productTabGeneral');
        const modifications = document.getElementById('productTabModifications');
        const emenu = document.getElementById('productTabEmenu');

        buttons.forEach(function(button) {
            const isActive = button.dataset.productTab === tab;

            button.classList.toggle('border-indigo-600', isActive);
            button.classList.toggle('text-indigo-600', isActive);
            button.classList.toggle('font-black', isActive);

            button.classList.toggle('border-transparent', !isActive);
            button.classList.toggle('text-slate-400', !isActive);
            button.classList.toggle('font-bold', !isActive);
        });

        general.classList.toggle('hidden', tab !== 'general');
        modifications.classList.toggle('hidden', tab !== 'modifications');
        emenu.classList.toggle('hidden', tab !== 'emenu');
    }
</script>

@endsection