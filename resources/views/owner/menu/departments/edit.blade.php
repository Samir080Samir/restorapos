@extends('owner.layouts.app')

@section('title', 'Şöbə düzəlişi')

@section('content')

<div class="max-w-[900px] mx-auto">

    <form method="POST"
        action="{{ route('owner.menu.departments.update', $department->id) }}"
        class="space-y-5">

        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-slate-200 p-6">

            <div class="mb-6">

                <h1 class="text-2xl font-black text-slate-900">
                    Şöbə düzəlişi
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Şöbə məlumatlarını yeniləyin.
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
                        value="{{ old('name', $department->name) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">

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
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold outline-none focus:border-indigo-500 resize-none">{{ old('description', $department->description) }}</textarea>

                </div>

                {{-- Color --}}
                <div>

                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Rəng
                    </label>

                    <input type="color"
                        name="color"
                        value="{{ old('color', $department->color) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-2">

                </div>

                {{-- Status --}}
                <div class="flex items-center">

                    <label class="flex items-center gap-3 mt-7">

                        <input type="checkbox"
                            name="is_active"
                            value="1"
                            {{ $department->is_active ? 'checked' : '' }}
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
                Geri qayıt
            </a>

            <button type="submit"
                class="h-12 px-8 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black">
                Yenilə
            </button>

        </div>

    </form>

</div>

@endsection