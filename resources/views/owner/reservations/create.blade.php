@extends('owner.layouts.app')

@section('title', 'Yeni rezerv')

@section('content')

<div class="max-w-[900px] mx-auto space-y-5">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Yeni rezerv</h1>
            <p class="text-sm text-slate-500 mt-1">Owner paneldən masa üçün rezervasiya yaradın.</p>
        </div>

        <a href="{{ route('owner.reservations.index') }}"
            class="h-11 px-5 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm font-bold flex items-center justify-center">
            Geri qayıt
        </a>
    </div>

    @if(session('error'))
    <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
        Məlumatları düzgün doldurun.
    </div>
    @endif

    <form method="POST"
        action="{{ route('owner.reservations.store') }}"
        class="bg-white border border-slate-200 rounded-3xl shadow-sm p-5 space-y-5">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="md:col-span-2">
                <label class="reservation-label">Masa</label>

                <div class="relative">
                    <select name="table_id"
                        style="-webkit-appearance:none; -moz-appearance:none; appearance:none; background-image:none;"
                        class="reservation-input pr-10">
                        <option value="">Masa seçin</option>

                        @foreach($tables as $table)
                        <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                            {{ $table->diningArea?->name ?? 'Zal' }} — {{ $table->name }} / {{ $table->seats }} nəfər
                        </option>
                        @endforeach
                    </select>

                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </div>

                @error('table_id')
                <p class="reservation-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="reservation-label">Müştəri adı</label>

                <input type="text"
                    name="customer_name"
                    value="{{ old('customer_name') }}"
                    placeholder="Məs: Samir Abdullayev"
                    class="reservation-input">

                @error('customer_name')
                <p class="reservation-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="reservation-label">Telefon</label>

                <input type="text"
                    name="customer_phone"
                    value="{{ old('customer_phone') }}"
                    placeholder="+994..."
                    class="reservation-input">

                @error('customer_phone')
                <p class="reservation-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="reservation-label">Tarix</label>

                <input type="date"
                    name="reservation_date"
                    value="{{ old('reservation_date', now()->toDateString()) }}"
                    class="reservation-input">

                @error('reservation_date')
                <p class="reservation-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="reservation-label">Başlanğıc saatı</label>

                <input type="time"
                    name="start_time"
                    value="{{ old('start_time') }}"
                    class="reservation-input">

                @error('start_time')
                <p class="reservation-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="reservation-label">Qonaq sayı</label>

                <input type="number"
                    name="guest_count"
                    value="{{ old('guest_count', 1) }}"
                    min="1"
                    class="reservation-input">

                @error('guest_count')
                <p class="reservation-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="reservation-label">Qeyd</label>

                <textarea name="note"
                    rows="4"
                    placeholder="Məs: Pəncərə kənarı masa istəyir."
                    class="reservation-input min-h-[110px] py-3 resize-none">{{ old('note') }}</textarea>

                @error('note')
                <p class="reservation-error">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="flex flex-col sm:flex-row sm:justify-end gap-2 pt-2">
            <a href="{{ route('owner.reservations.index') }}"
                class="h-11 px-5 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm font-bold flex items-center justify-center">
                Ləğv et
            </a>

            <button class="h-11 px-6 rounded-xl bg-slate-900 text-white text-sm font-bold">
                Rezerv yarat
            </button>
        </div>
    </form>
</div>

<style>
    .reservation-label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 800;
        color: #334155;
    }

    .reservation-input {
        width: 100%;
        min-height: 46px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding-left: 16px;
        padding-right: 16px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        outline: none;
    }

    .reservation-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, .12);
    }

    .reservation-error {
        margin-top: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #dc2626;
    }
</style>

@endsection