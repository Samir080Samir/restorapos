@extends('owner.layouts.app')

@section('title', 'Statistikalar')

@section('content')

<div class="space-y-5">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Statistikalar</h1>
            <p class="text-sm text-slate-500 mt-1">Restoran fəaliyyətinin ümumi göstəriciləri</p>
        </div>

        <div class="relative w-full sm:w-auto">
            <select
                style="-webkit-appearance:none; -moz-appearance:none; appearance:none; background-image:none;"
                class="w-full sm:w-32 h-10 rounded-xl border border-slate-200 bg-white pl-4 pr-9 text-sm text-slate-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Bu gün</option>
                <option>Bu həftə</option>
                <option>Bu ay</option>
                <option>Bu il</option>
            </select>

            <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 9l6 6 6-6" />
            </svg>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">Bugünkü satış</p>
                    <h3 class="text-2xl font-bold mt-3 text-slate-900">1,245.50 ₼</h3>
                    <p class="text-xs text-emerald-600 mt-4">↑ 12% dünənə görə</p>
                </div>

                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M4 19V5" />
                        <path d="M4 19h16" />
                        <path d="M8 15l3-3 3 2 5-7" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">Aktiv sifarişlər</p>
                    <h3 class="text-2xl font-bold mt-3 text-slate-900">38</h3>
                    <p class="text-xs text-blue-600 mt-4">● İşlənir</p>
                </div>

                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M6 7h12l-1 13H7L6 7z" />
                        <path d="M9 7a3 3 0 0 1 6 0" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">Aktiv masalar</p>
                    <h3 class="text-2xl font-bold mt-3 text-slate-900">14</h3>
                    <p class="text-xs text-orange-600 mt-4">● 6 masa boşdur</p>
                </div>

                <div class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M5 10h14" />
                        <path d="M7 10v8M17 10v8" />
                        <path d="M9 18h6" />
                        <path d="M8 6h8" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">QR Menu baxışı</p>
                    <h3 class="text-2xl font-bold mt-3 text-slate-900">286</h3>
                    <p class="text-xs text-violet-600 mt-4">● Bu gün</p>
                </div>

                <div class="w-10 h-10 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4z" />
                        <path d="M14 14h2M18 14h2M14 18h6" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Satış analitikası</h3>
                    <p class="text-xs text-slate-500 mt-1">Günlük, həftəlik və aylıq göstəricilər</p>
                </div>

                <div class="relative w-full sm:w-auto">
                    <select
                        style="-webkit-appearance:none; -moz-appearance:none; appearance:none; background-image:none;"
                        class="appearance-none w-full sm:w-28 h-10 rounded-xl border border-slate-200 bg-slate-50 pl-3 pr-9 text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>Bu gün</option>
                        <option>Bu həftə</option>
                        <option>Bu ay</option>
                    </select>

                    <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </div>
            </div>

            <div class="h-64 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 text-sm">
                Satış qrafiki burada olacaq
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base">Sürətli əməliyyatlar</h3>
            <p class="text-xs text-slate-500 mt-1 mb-4">Əsas funksiyalara sürətli keçid</p>

            <div class="space-y-3">
                <a href="#" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 hover:bg-blue-50 transition">
                    <span class="text-sm font-medium">Yeni sifariş</span>
                    <span class="text-blue-600">→</span>
                </a>

                <a href="#" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 hover:bg-emerald-50 transition">
                    <span class="text-sm font-medium">Məhsul əlavə et</span>
                    <span class="text-emerald-600">→</span>
                </a>

                <a href="#" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 hover:bg-orange-50 transition">
                    <span class="text-sm font-medium">Kampaniya yarat</span>
                    <span class="text-orange-600">→</span>
                </a>

                <a href="#" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 hover:bg-violet-50 transition">
                    <span class="text-sm font-medium">QR Menu aç</span>
                    <span class="text-violet-600">→</span>
                </a>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base">Restoran</h3>
            <p class="text-xs text-slate-500 mt-1">Restoranın cari iş vəziyyəti</p>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Status</span>
                    <span class="font-medium text-emerald-600">Aktiv</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Aktiv filiallar</span>
                    <span class="font-medium text-slate-900">3</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Aktiv masalar</span>
                    <span class="font-medium text-slate-900">14</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base">Hesabat</h3>
            <p class="text-xs text-slate-500 mt-1">Gündəlik restoran hesabatları</p>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Nağd satış</span>
                    <span class="font-medium text-slate-900">520 ₼</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Kart satış</span>
                    <span class="font-medium text-slate-900">725.50 ₼</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Ümumi</span>
                    <span class="font-bold text-blue-600">1,245.50 ₼</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base">Satış</h3>
            <p class="text-xs text-slate-500 mt-1">Satış üzrə əsas nəticələr</p>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Sifariş sayı</span>
                    <span class="font-medium text-slate-900">38</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Ortalama çek</span>
                    <span class="font-medium text-slate-900">32.77 ₼</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Ən çox satış</span>
                    <span class="font-medium text-slate-900">Masa 5</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base">Statistika</h3>
            <p class="text-xs text-slate-500 mt-1">Restoran performans göstəriciləri</p>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Artım</span>
                    <span class="font-medium text-emerald-600">+12%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">QR baxış</span>
                    <span class="font-medium text-slate-900">286</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Aktivlik</span>
                    <span class="font-medium text-blue-600">Yüksək</span>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Son sifarişlər</h3>
                <p class="text-xs text-slate-500 mt-1">Ən son restoran əməliyyatları</p>
            </div>

            <a href="#" class="text-sm text-blue-600 font-medium hover:underline">
                Hamısına bax →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Sifariş</th>
                        <th class="text-left px-4 py-3 font-medium">Masa</th>
                        <th class="text-left px-4 py-3 font-medium">Məbləğ</th>
                        <th class="text-left px-4 py-3 font-medium">Status</th>
                        <th class="text-left px-4 py-3 font-medium">Tarix</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach([
                    ['id' => '#ORD-1005', 'table' => 'Masa 5', 'amount' => '45.00 ₼', 'status' => 'Tamamlandı', 'color' => 'emerald', 'date' => '14.05.2025 14:35'],
                    ['id' => '#ORD-1004', 'table' => 'Masa 3', 'amount' => '32.50 ₼', 'status' => 'Tamamlandı', 'color' => 'emerald', 'date' => '14.05.2025 14:20'],
                    ['id' => '#ORD-1003', 'table' => 'Masa 8', 'amount' => '28.00 ₼', 'status' => 'Hazırlanır', 'color' => 'orange', 'date' => '14.05.2025 14:10'],
                    ['id' => '#ORD-1002', 'table' => 'Masa 2', 'amount' => '67.00 ₼', 'status' => 'Servisdə', 'color' => 'blue', 'date' => '14.05.2025 13:55'],
                    ] as $order)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium">{{ $order['id'] }}</td>
                        <td class="px-4 py-3">{{ $order['table'] }}</td>
                        <td class="px-4 py-3">{{ $order['amount'] }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full bg-{{ $order['color'] }}-50 text-{{ $order['color'] }}-600 text-xs font-medium">
                                {{ $order['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $order['date'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection