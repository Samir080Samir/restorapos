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
                    class="px-5 py-3 border-b-2 border-indigo-600 text-indigo-600 font-black text-sm">
                    General
                </button>

                <button type="button"
                    class="px-5 py-3 text-slate-400 font-bold text-sm">
                    Modifications
                </button>

                <button type="button"
                    class="px-5 py-3 text-slate-400 font-bold text-sm">
                    eMenu
                </button>
            </div>

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
                                <option value="{{ $category->id }}">
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
                                <option value="{{ $department->id }}">
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
                            <input type="checkbox" name="is_hidden" value="1" class="w-5 h-5">
                        </label>

                        <label class="flex items-center justify-between gap-3">
                            <span class="font-bold text-sm text-slate-700">İkram</span>
                            <input type="checkbox" name="is_gift" value="1" class="w-5 h-5">
                        </label>

                        <label class="flex items-center justify-between gap-3">
                            <span class="font-bold text-sm text-slate-700">Endirimə icazə vermə</span>
                            <input type="checkbox" name="disable_discount" value="1" class="w-5 h-5">
                        </label>

                        <label class="flex items-center justify-between gap-3">
                            <span class="font-bold text-sm text-slate-700">Çəki ilə satılır</span>
                            <input type="checkbox" name="sold_by_weight" value="1" class="w-5 h-5">
                        </label>

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

@endsection