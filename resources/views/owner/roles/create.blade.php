@extends('owner.layouts.app')

@section('title', 'Yeni vəzifə')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-black text-slate-900">Yeni vəzifə</h1>
        <p class="text-sm text-slate-500 mt-1">Vəzifənin giriş tipini və icazələrini seçin</p>
    </div>

    <form method="POST" action="{{ route('owner.staff.roles.store') }}" class="space-y-6">
        @csrf

        <div class="bg-white border border-slate-200 rounded-3xl p-6 space-y-6">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Vəzifə adı
                </label>

                <input type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Məsələn: Kassir, Offisiant, Maliyyəçi"
                    class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                @error('name')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3">
                    Giriş tipi
                </label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <label class="relative cursor-pointer">
                        <input type="radio"
                            name="login_type"
                            value="pos"
                            class="peer sr-only"
                            {{ old('login_type', 'pos') === 'pos' ? 'checked' : '' }}>

                        <div class="rounded-3xl border-2 border-slate-200 p-5 transition peer-checked:border-[#2f3f7a] peer-checked:bg-[#2f3f7a]/5 hover:bg-slate-50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M4 5h16v14H4z" />
                                        <path d="M8 9h8M8 13h4" />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="font-black text-slate-900">POS ekranı</h3>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Kassir, offisiant, administrator üçün 4 rəqəmli giriş.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input type="radio"
                            name="login_type"
                            value="panel"
                            class="peer sr-only"
                            {{ old('login_type') === 'panel' ? 'checked' : '' }}>

                        <div class="rounded-3xl border-2 border-slate-200 p-5 transition peer-checked:border-[#2f3f7a] peer-checked:bg-[#2f3f7a]/5 hover:bg-slate-50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M4 4h16v16H4z" />
                                        <path d="M8 8h8M8 12h8M8 16h4" />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="font-black text-slate-900">Owner panel</h3>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Maliyyəçi, filial meneceri, anbar məsulu üçün 8 simvollu giriş.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </label>

                </div>

                @error('login_type')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-3">
                <input type="checkbox"
                    name="is_active"
                    value="1"
                    checked
                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                <span class="text-sm font-semibold text-slate-700">
                    Aktiv vəzifə
                </span>
            </label>

        </div>

        @foreach($permissions as $type => $groups)
        <div class="permission-block bg-white border border-slate-200 rounded-3xl overflow-hidden"
            data-type="{{ $type }}">

            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="font-black text-slate-900">
                    {{ $type === 'panel' ? 'Owner Panel icazələri' : 'POS icazələri' }}
                </h2>
            </div>

            <div class="p-6 space-y-6">
                @foreach($groups as $groupName => $items)
                <div>
                    <h3 class="text-sm font-black text-slate-800 mb-3">
                        {{ $groupName }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                        @foreach($items as $permission)
                        <label class="flex items-start gap-3 p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                            <input type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                            <span>
                                <span class="block text-sm font-semibold text-slate-800">
                                    {{ $permission->name }}
                                </span>

                                <span class="block text-xs text-slate-400 mt-1">
                                    {{ $permission->slug }}
                                </span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @endforeach

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('owner.staff.roles.index') }}"
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

<script>
    function syncPermissionBlocks() {
        const selectedType = document.querySelector('input[name="login_type"]:checked')?.value;

        document.querySelectorAll('.permission-block').forEach(block => {
            const blockType = block.dataset.type;
            const checkboxes = block.querySelectorAll('input[type="checkbox"]');

            if (blockType === selectedType) {
                block.style.display = 'block';
                checkboxes.forEach(input => input.disabled = false);
            } else {
                block.style.display = 'none';
                checkboxes.forEach(input => {
                    input.checked = false;
                    input.disabled = true;
                });
            }
        });
    }

    document.querySelectorAll('input[name="login_type"]').forEach(input => {
        input.addEventListener('change', syncPermissionBlocks);
    });

    syncPermissionBlocks();
</script>

@endsection