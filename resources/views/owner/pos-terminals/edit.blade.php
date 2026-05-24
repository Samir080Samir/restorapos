@extends('owner.layouts.app')

@section('title', 'Terminal düzəlişi')

@section('content')
<div class="max-w-2xl">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 sm:p-6">

        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-900">
                Terminal düzəlişi
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Terminal məlumatlarını yeniləyin.
            </p>
        </div>

        <form method="POST" action="{{ route('owner.pos-terminals.update', $terminal) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Aktivasiya kodu
                </label>

                <div class="h-11 flex items-center rounded-xl border border-slate-200 bg-slate-50 px-4 font-mono text-sm font-bold text-slate-800">
                    {{ $terminal->activation_code }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Terminal adı
                </label>

                <input type="text"
                    name="name"
                    value="{{ old('name', $terminal->name) }}"
                    class="w-full h-11 rounded-xl border-slate-200 bg-white text-sm focus:border-[#2f3f7a] focus:ring-[#2f3f7a]">

                @error('name')
                <p class="text-sm text-red-600 mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Filial
                </label>

                <select name="branch_id"
                    class="w-full h-11 rounded-xl border-slate-200 bg-white text-sm focus:border-[#2f3f7a] focus:ring-[#2f3f7a]">

                    <option value="">
                        Ümumi restoran
                    </option>

                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" @selected(old('branch_id', $terminal->branch_id) == $branch->id)>
                        {{ $branch->name }}
                    </option>
                    @endforeach

                </select>

                @error('branch_id')
                <p class="text-sm text-red-600 mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">

                <a href="{{ route('owner.pos-terminals.index') }}"
                    class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200 transition">
                    Geri
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#2f3f7a] text-white text-sm font-semibold hover:bg-[#263466] transition">
                    Yadda saxla
                </button>

            </div>

        </form>

    </div>

</div>
@endsection