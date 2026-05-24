@extends('owner.layouts.app')

@section('title', 'Yeni terminal')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 sm:p-6">

        <h1 class="text-xl font-bold text-slate-900">Yeni terminal</h1>
        <p class="text-sm text-slate-500 mt-1 mb-6">
            POS üçün istifadə olunacaq terminal yaradın.
        </p>

        <form method="POST" action="{{ route('owner.pos-terminals.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Restoran
                </label>

                <div class="h-11 flex items-center rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700">
                    {{ $restaurant->name }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Terminal adı
                </label>

                <input type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Məsələn: Kassa 1"
                    class="w-full h-11 rounded-xl border-slate-200 text-sm focus:border-[#2f3f7a] focus:ring-[#2f3f7a]">

                @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Filial
                </label>

                <select name="branch_id"
                    class="w-full h-11 rounded-xl border-slate-200 text-sm focus:border-[#2f3f7a] focus:ring-[#2f3f7a]">
                    <option value="">Ümumi restoran</option>

                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" @selected(old('branch_id')==$branch->id)>
                        {{ $branch->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('owner.pos-terminals.index') }}"
                    class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold">
                    Geri
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#2f3f7a] text-white text-sm font-semibold">
                    Terminal yarat
                </button>
            </div>
        </form>

    </div>
</div>
@endsection