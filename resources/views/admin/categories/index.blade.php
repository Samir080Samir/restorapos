@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">
        {{ __('messages.categories') }}
    </h1>

    <a href="{{ route('admin.categories.create') }}"
        class="bg-black text-white px-5 py-2 rounded-lg">
        Yeni kateqoriya əlavə et
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">Kateqoriya adı</th>
                <th class="p-4 text-left">Restoran</th>
                <th class="p-4 text-left">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($categories as $category)
            <tr class="border-t">
                <td class="p-4">
                    {{ $category->name }}
                </td>

                <td class="p-4">
                    {{ $category->restaurant->name ?? '-' }}
                </td>

                <td class="p-4">
                    @if($category->status == 'active')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                        {{ __('messages.active') }}
                    </span>
                    @else
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                        {{ __('messages.inactive') }}
                    </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection