@extends('owner.layouts.app')

@section('title', 'Filialı redaktə et')

@section('content')

<div class="space-y-6">

    <div>

        <h1 class="text-2xl font-black text-slate-900">
            Filialı redaktə et
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Filial məlumatlarını yeniləyin
        </p>

    </div>

    <form method="POST"
        action="{{ route('owner.branches.update', $branch) }}"
        class="space-y-6">

        @csrf
        @method('PUT')

        <div class="bg-white border border-slate-200 rounded-3xl p-6 space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Filial adı
                    </label>

                    <input type="text"
                        name="name"
                        value="{{ old('name', $branch->name) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm"
                        placeholder="Filial adı">

                    @error('name')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Telefon
                    </label>

                    <input type="text"
                        name="phone"
                        value="{{ old('phone', $branch->phone) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm"
                        placeholder="Telefon">

                    @error('phone')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>

            <div>

                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Ünvan
                </label>

                <textarea name="address"
                    rows="4"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm resize-none"
                    placeholder="Filial ünvanı">{{ old('address', $branch->address) }}</textarea>

                @error('address')
                <p class="text-sm text-red-600 mt-2">
                    {{ $message }}
                </p>
                @enderror

            </div>

            <div>

                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Status
                </label>

                <select name="status"
                    class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm">

                    <option value="active"
                        {{ old('status', $branch->status) == 'active' ? 'selected' : '' }}>

                        Aktiv

                    </option>

                    <option value="inactive"
                        {{ old('status', $branch->status) == 'inactive' ? 'selected' : '' }}>

                        Passiv

                    </option>

                </select>

                @error('status')
                <p class="text-sm text-red-600 mt-2">
                    {{ $message }}
                </p>
                @enderror

            </div>

        </div>

        <div class="flex items-center justify-end gap-3">

            <a href="{{ route('owner.branches.index') }}"
                class="h-11 px-5 rounded-2xl border border-slate-200 bg-white text-sm font-bold text-slate-700 flex items-center">

                Geri

            </a>

            <button type="submit"
                class="h-11 px-6 rounded-2xl bg-[#2f3f7a] text-white text-sm font-bold hover:opacity-95 transition">

                Yadda saxla

            </button>

        </div>

    </form>

</div>

@endsection