@extends('admin.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">

    <h1 class="text-3xl font-bold mb-6">
        Yeni kateqoriya əlavə et
    </h1>

    <form method="POST"
        action="{{ route('admin.categories.store') }}">

        @csrf

        <div class="mb-5">
            <label class="block mb-2 font-medium">
                Restoran
            </label>

            <select name="restaurant_id"
                class="w-full border rounded-lg p-3">
                @foreach($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}">
                    {{ $restaurant->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label class="block mb-2 font-medium">
                Kateqoriya adı
            </label>

            <input type="text"
                name="name"
                class="w-full border rounded-lg p-3">
        </div>

        <div class="mb-5">
            <label class="block mb-2 font-medium">
                Status
            </label>

            <select name="status"
                class="w-full border rounded-lg p-3">
                <option value="active">
                    {{ __('messages.active') }}
                </option>

                <option value="inactive">
                    {{ __('messages.inactive') }}
                </option>
            </select>
        </div>

        <button type="submit"
            class="bg-black text-white px-6 py-3 rounded-lg">
            {{ __('messages.save') }}
        </button>

    </form>

</div>

@endsection