@extends('owner.layouts.app')

@section('title', 'Yeni əməkdaş')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-black text-slate-900">Yeni əməkdaş</h1>
        <p class="text-sm text-slate-500 mt-1">Əməkdaş məlumatları, filial, vəzifə və giriş kodu</p>
    </div>

    <form method="POST" action="{{ route('owner.staff.users.store') }}" class="space-y-6">
        @csrf

        <div class="bg-white border border-slate-200 rounded-3xl p-6 space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ad Soyad</label>

                    <input type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm"
                        placeholder="Məsələn: Əli Məmmədov">

                    @error('name')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">E-mail</label>

                    <input type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm"
                        placeholder="İstəyə bağlı">

                    @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Filial
                    </label>

                    <select name="branch_id"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm">

                        <option value="">Ümumi restoran üzrə</option>

                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                        @endforeach
                    </select>

                    <p class="text-xs text-slate-500 mt-1 leading-5">
                        Əməkdaş bütün restoran üzrə işləyəcəksə filial seçməyin.
                        Filial seçilərsə əməkdaş həmin filialın məlumatlarına uyğun işləyəcək.
                    </p>

                    @error('branch_id')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Sistem rolu</label>

                    <select name="system_role"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm">

                        <option value="">Rol seçin</option>

                        <option value="administrator" {{ old('system_role') == 'administrator' ? 'selected' : '' }}>
                            Administrator
                        </option>

                        <option value="cashier" {{ old('system_role') == 'cashier' ? 'selected' : '' }}>
                            Kassir
                        </option>

                        <option value="waiter" {{ old('system_role') == 'waiter' ? 'selected' : '' }}>
                            Offisiant
                        </option>

                        <option value="kitchen" {{ old('system_role') == 'kitchen' ? 'selected' : '' }}>
                            Mətbəx
                        </option>

                        <option value="finance" {{ old('system_role') == 'finance' ? 'selected' : '' }}>
                            Maliyyəçi
                        </option>

                        <option value="branch_manager" {{ old('system_role') == 'branch_manager' ? 'selected' : '' }}>
                            Filial meneceri
                        </option>

                        <option value="warehouse_manager" {{ old('system_role') == 'warehouse_manager' ? 'selected' : '' }}>
                            Anbar məsulu
                        </option>

                        <option value="staff" {{ old('system_role') == 'staff' ? 'selected' : '' }}>
                            Digər əməkdaş
                        </option>

                    </select>

                    @error('system_role')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Vəzifə</label>

                <select id="ownerRoleSelect"
                    name="owner_role_id"
                    class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm">

                    <option value="">Vəzifə seçin</option>

                    @foreach($roles as $role)
                    <option value="{{ $role->id }}"
                        data-login-type="{{ $role->login_type }}"
                        {{ old('owner_role_id') == $role->id ? 'selected' : '' }}>

                        {{ $role->name }} — {{ $role->login_type === 'panel' ? 'Owner panel' : 'POS ekranı' }}

                    </option>
                    @endforeach

                </select>

                @error('owner_role_id')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Giriş kodu
                        </label>

                        <p id="codeHelp" class="text-xs text-slate-500">
                            Vəzifə seçildikdən sonra kod formatı avtomatik dəyişəcək.
                        </p>
                    </div>

                    <button type="button"
                        onclick="generateCode()"
                        class="h-10 px-4 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-100">

                        Kod yarat

                    </button>

                </div>

                <input id="staffCodeInput"
                    type="text"
                    name="staff_code"
                    value="{{ old('staff_code') }}"
                    class="mt-4 w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-bold tracking-widest"
                    placeholder="Kod">

                @error('staff_code')
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
                    Aktiv əməkdaş
                </span>

            </label>

        </div>

        <div class="flex items-center justify-end gap-3">

            <a href="{{ route('owner.staff.users.index') }}"
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
    function selectedLoginType() {
        const select = document.getElementById('ownerRoleSelect');
        const option = select.options[select.selectedIndex];

        return option ? option.dataset.loginType : null;
    }

    function syncCodeHelp() {
        const type = selectedLoginType();
        const input = document.getElementById('staffCodeInput');
        const help = document.getElementById('codeHelp');

        if (type === 'pos') {
            help.textContent = 'POS əməkdaşları üçün 4 rəqəmli kod istifadə olunur.';
            input.maxLength = 4;
            input.placeholder = 'Məsələn: 2580';
        } else if (type === 'panel') {
            help.textContent = 'Owner panel əməkdaşları üçün 8 simvollu kod istifadə olunur.';
            input.maxLength = 8;
            input.placeholder = 'Məsələn: A7K9@P2M';
        } else {
            help.textContent = 'Vəzifə seçildikdən sonra kod formatı avtomatik dəyişəcək.';
            input.removeAttribute('maxLength');
            input.placeholder = 'Kod';
        }
    }

    function generateCode() {
        const type = selectedLoginType();
        const input = document.getElementById('staffCodeInput');

        if (type === 'pos') {
            input.value = Math.floor(1000 + Math.random() * 9000);
            return;
        }

        if (type === 'panel') {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789@#$%*!_-';
            let code = '';

            for (let i = 0; i < 8; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            input.value = code;
        }
    }

    document.getElementById('ownerRoleSelect').addEventListener('change', function() {
        document.getElementById('staffCodeInput').value = '';
        syncCodeHelp();
    });

    document.getElementById('staffCodeInput').addEventListener('input', function() {
        const type = selectedLoginType();

        if (type === 'pos') {
            this.value = this.value.replace(/\D/g, '').slice(0, 4);
        }

        if (type === 'panel') {
            this.value = this.value.slice(0, 8);
        }
    });

    syncCodeHelp();
</script>

@endsection