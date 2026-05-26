@extends('owner.layouts.app')

@section('title', 'QR Menyu Məlumat Dəyişikliyi')

@section('content')
<div class="max-w-[980px] mx-auto space-y-5">

    @if(session('success'))
    <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-bold text-red-700 shadow-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="rounded-[32px] bg-white border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-950">QR Menyu Məlumat Dəyişikliyi</h1>
                    <p class="text-sm text-slate-500 mt-1 font-semibold">
                        QR menyuda görünən welcome yazısı, restoran haqqında məlumat, əlaqə, ünvan, sosial linklər və slug buradan idarə olunur.
                    </p>
                </div>

                <a href="{{ route('public.qr-menu.restaurant', $restaurant->slug) }}" target="_blank"
                    class="inline-flex items-center justify-center h-11 px-5 rounded-2xl bg-slate-950 text-white text-sm font-black hover:bg-emerald-700 transition">
                    QR menyuya bax
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('owner.qr-menu.settings.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="qr_is_active" value="1" class="rounded" {{ data_get($restaurant, 'qr_is_active', true) ? 'checked' : '' }}>
                    <span class="text-sm font-black text-slate-700">QR menyu aktiv olsun</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Restoran slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $restaurant->slug) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                        placeholder="dost-qapisi">
                    <p class="mt-2 text-xs font-semibold text-slate-400">QR linkdə görünən ad. Məsələn: /menu/dost-qapisi</p>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Welcome yazısı</label>
                    <input type="text" name="qr_welcome_text" value="{{ old('qr_welcome_text', data_get($restaurant, 'qr_welcome_text')) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                        placeholder="Xoş gəldiniz! Nəfis təamlarımızdan dadın.">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Əlaqə nömrəsi</label>
                    <input type="text" name="qr_contact_phone" value="{{ old('qr_contact_phone', data_get($restaurant, 'qr_contact_phone')) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                        placeholder="+994 XX XXX XX XX">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Ünvan</label>
                    <input type="text" name="qr_address" value="{{ old('qr_address', data_get($restaurant, 'qr_address')) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                        placeholder="Restoranın yerləşdiyi ünvan">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Haqqımızda başlığı</label>
                    <input type="text" name="qr_about_title" value="{{ old('qr_about_title', data_get($restaurant, 'qr_about_title')) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                        placeholder="Restoran haqqında">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">QR menyu arxa fon şəkli</label>
                    <input type="file" name="qr_background_image" accept="image/*"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Haqqımızda mətni</label>
                <textarea name="qr_about_description" rows="6"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                    placeholder="Restoran haqqında qısa məlumat...">{{ old('qr_about_description', data_get($restaurant, 'qr_about_description')) }}</textarea>
            </div>

            <div class="rounded-[28px] bg-slate-50 border border-slate-200 p-5">
                <h2 class="text-lg font-black text-slate-950">Sosial şəbəkələr</h2>
                <p class="text-sm text-slate-500 mt-1 font-semibold">Bu linklər QR menyunun məlumat bölməsində göstəriləcək.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Instagram</label>
                        <input type="url" name="qr_instagram" value="{{ old('qr_instagram', data_get($restaurant, 'qr_instagram')) }}"
                            class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                            placeholder="https://instagram.com/...">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">TikTok</label>
                        <input type="url" name="qr_tiktok" value="{{ old('qr_tiktok', data_get($restaurant, 'qr_tiktok')) }}"
                            class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                            placeholder="https://tiktok.com/@...">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Facebook</label>
                        <input type="url" name="qr_facebook" value="{{ old('qr_facebook', data_get($restaurant, 'qr_facebook')) }}"
                            class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                            placeholder="https://facebook.com/...">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Website</label>
                        <input type="url" name="qr_website" value="{{ old('qr_website', data_get($restaurant, 'qr_website')) }}"
                            class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                            placeholder="https://site.az">
                    </div>
                </div>
            </div>

            @if(data_get($restaurant, 'qr_background_image'))
            <div>
                <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-wider">Hazırkı fon şəkli</label>
                <img src="{{ asset('storage/' . data_get($restaurant, 'qr_background_image')) }}" class="w-full h-56 object-cover rounded-3xl border border-slate-200" alt="QR fon">
            </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between pt-2">
                <a href="{{ route('owner.qr-menu.index') }}" class="inline-flex items-center justify-center h-12 px-5 rounded-2xl bg-slate-100 text-slate-700 text-sm font-black hover:bg-slate-200 transition">
                    Geri qayıt
                </a>

                <button type="submit" class="inline-flex items-center justify-center h-12 px-7 rounded-2xl bg-slate-950 text-white text-sm font-black hover:bg-emerald-700 transition">
                    Yadda saxla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection