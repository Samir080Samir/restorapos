@extends('owner.layouts.app')

@section('title', 'Şöbə yarat')

@section('content')

<div class="max-w-[900px] mx-auto">

    <form method="POST"
        action="{{ route('owner.menu.departments.store') }}"
        class="space-y-5">

        @csrf

        <div class="bg-white rounded-3xl border border-slate-200 p-6">

            <div class="mb-6">

                <h1 class="text-2xl font-black text-slate-900">
                    Şöbə yarat
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Məhsullar üçün yeni şöbə əlavə edin.
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Name --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Şöbə adı
                    </label>

                    <input type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500"
                        placeholder="Məs: Mətbəx">

                    @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Description --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Açıqlama
                    </label>

                    <textarea name="description"
                        rows="4"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold outline-none focus:border-indigo-500 resize-none"
                        placeholder="Şöbə haqqında qısa məlumat...">{{ old('description') }}</textarea>

                </div>

                {{-- Color --}}
                <div>

                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Rəng
                    </label>

                    <input type="color"
                        name="color"
                        value="{{ old('color', '#334155') }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-2">

                </div>

                {{-- Status --}}
                <div class="flex items-center">

                    <label class="flex items-center gap-3 mt-7">

                        <input type="checkbox"
                            name="is_active"
                            value="1"
                            checked
                            class="w-5 h-5 rounded border-slate-300 text-indigo-600">

                        <span class="text-sm font-black text-slate-700">
                            Aktiv şöbə
                        </span>

                    </label>

                </div>

            </div>

        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-3">

            <a href="{{ route('owner.menu.departments.index') }}"
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