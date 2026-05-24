@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Yeni istifadəçi əlavə et
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Sistem istifadəçisi, rol və icazə idarəetməsi
        </p>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        <ul class="list-disc pl-5 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Ad Soyad</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border border-gray-200 rounded-2xl p-3" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border border-gray-200 rounded-2xl p-3" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Şifrə</label>
                <input type="password" name="password"
                    class="w-full border border-gray-200 rounded-2xl p-3" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Rol</label>
                <select name="role" class="w-full border border-gray-200 rounded-2xl p-3" required>
                    <option value="super_admin">Super Admin</option>
                    <option value="restaurant_admin">Restoran Admin</option>
                    <option value="restaurant_manager">Restoran Meneceri</option>
                    <option value="branch_manager">Filial Meneceri</option>
                    <option value="cashier">Kassir</option>
                    <option value="waiter">Ofisiant</option>
                    <option value="kitchen">Mətbəx</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Restoran</label>
                <select name="restaurant_id" class="w-full border border-gray-200 rounded-2xl p-3">
                    <option value="">Seçin</option>
                    @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Filial</label>
                <select name="branch_id" class="w-full border border-gray-200 rounded-2xl p-3">
                    <option value="">Seçin</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">
                        {{ $branch->name }} — {{ $branch->restaurant->name ?? '' }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                İcazələr
            </h2>

            <div class="space-y-5">
                @foreach($permissions->groupBy('group') as $group => $groupPermissions)

                <div class="border border-gray-100 rounded-2xl p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 capitalize">
                        {{ $group }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                        @foreach($groupPermissions as $permission)

                        <label class="flex items-center gap-3 bg-gray-50 hover:bg-gray-100 rounded-xl px-4 py-3 cursor-pointer">
                            <input type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                class="rounded border-gray-300">

                            <span class="text-sm text-gray-700">
                                {{ $permission->name }}
                            </span>
                        </label>

                        @endforeach
                    </div>
                </div>

                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-3 mt-8">

            <button type="submit"
                class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-2xl text-sm font-semibold transition">
                Yadda saxla
            </button>

            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl text-sm font-semibold transition">
                Geri qayıt
            </a>

        </div>

    </form>

</div>

@endsection