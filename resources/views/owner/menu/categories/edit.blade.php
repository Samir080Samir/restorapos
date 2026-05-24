@extends('owner.layouts.app')

@section('title', 'Kateqoriya düzəlişi')

@section('content')

<div class="max-w-[900px] mx-auto">

    <form method="POST"
        action="{{ route('owner.menu.categories.update', $category->id) }}"
        class="space-y-5">

        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-slate-200 p-6">

            <div class="mb-6">
                <h1 class="text-2xl font-black text-slate-900">
                    Kateqoriya düzəlişi
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Kateqoriya məlumatlarını yeniləyin.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="md:col-span-2">
                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Kateqoriya adı
                    </label>

                    <input type="text"
                        name="name"
                        value="{{ old('name', $category->name) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">

                    @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative">
                    <label class="block text-sm font-black text-slate-700 mb-2">
                        İkon
                    </label>

                    <div class="flex gap-2">
                        <input type="text"
                            id="categoryIconInput"
                            name="icon"
                            value="{{ old('icon', $category->icon) }}"
                            class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">

                        <button type="button"
                            onclick="toggleIconPicker()"
                            class="w-12 h-12 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center shadow-sm transition"
                            title="İkon seç">

                            <svg class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M8 3h8a5 5 0 0 1 5 5v4a5 5 0 0 1-5 5h-3l-4 4v-4H8a5 5 0 0 1-5-5V8a5 5 0 0 1 5-5Z" />
                                <path d="M8 10h.01M12 10h.01M16 10h.01" />
                            </svg>
                        </button>
                    </div>

                    <div id="iconPicker"
                        class="hidden absolute left-0 right-0 top-[82px] z-50 bg-white border border-slate-200 rounded-3xl shadow-2xl p-4">

                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-sm font-black text-slate-900">
                                    Yemək ikonları
                                </p>

                                <p class="text-xs text-slate-500 mt-0.5">
                                    Kateqoriya üçün uyğun ikon seçin.
                                </p>
                            </div>

                            <button type="button"
                                onclick="toggleIconPicker()"
                                class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-black">
                                ×
                            </button>
                        </div>

                        <div class="grid grid-cols-8 sm:grid-cols-10 gap-2 max-h-[260px] overflow-y-auto pr-1">

                            @foreach([
                            '🍔','🍕','🌭','🥪','🌮','🌯','🥙','🍟','🍗','🍖',
                            '🥩','🍢','🍤','🍣','🍱','🍜','🍝','🍛','🍲','🥘',
                            '🥗','🥣','🍚','🍙','🥟','🥞','🧇','🍳','🥓','🧀',
                            '🥐','🥖','🍞','🥨','🥯','🍰','🎂','🧁','🍩','🍪',
                            '🍫','🍬','🍭','🍮','🍯','🍦','🍨','🍧','🥤','🧃',
                            '🧋','☕','🍵','🫖','🥛','🍺','🍻','🍷','🍹','🍸',
                            '🍋','🍊','🍎','🍏','🍓','🍒','🍉','🍇','🍌','🥭',
                            '🍍','🥥','🥑','🥦','🥬','🥒','🌶️','🫑','🥕','🧄',
                            '🧅','🥔','🍄','🫘','🥜','🌰'
                            ] as $emoji)

                            <button type="button"
                                onclick="selectCategoryIcon('{{ $emoji }}')"
                                class="h-10 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-300 text-xl flex items-center justify-center transition">
                                {{ $emoji }}
                            </button>

                            @endforeach

                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Rəng
                    </label>

                    <input type="color"
                        name="color"
                        value="{{ old('color', $category->color) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-2">
                </div>

                <div>
                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Sıralama
                    </label>

                    <input type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $category->sort_order) }}"
                        class="w-full h-12 rounded-2xl border border-slate-200 px-4 text-sm font-semibold outline-none focus:border-indigo-500">
                </div>

                <div class="flex items-center">
                    <label class="flex items-center gap-3 mt-7">
                        <input type="checkbox"
                            name="is_active"
                            value="1"
                            {{ $category->is_active ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-slate-300 text-indigo-600">

                        <span class="text-sm font-black text-slate-700">
                            Aktiv kateqoriya
                        </span>
                    </label>
                </div>

            </div>

        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('owner.menu.categories.index') }}"
                class="h-12 px-6 rounded-2xl bg-slate-100 text-slate-700 font-black flex items-center">
                Geri qayıt
            </a>

            <button type="submit"
                class="h-12 px-8 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black">
                Yenilə
            </button>
        </div>

    </form>

</div>

<script>
    function toggleIconPicker() {
        const picker = document.getElementById('iconPicker');
        picker.classList.toggle('hidden');
    }

    function selectCategoryIcon(icon) {
        const input = document.getElementById('categoryIconInput');
        const picker = document.getElementById('iconPicker');

        input.value = icon;
        picker.classList.add('hidden');
    }

    document.addEventListener('click', function(event) {
        const picker = document.getElementById('iconPicker');
        const input = document.getElementById('categoryIconInput');

        if (!picker || !input) return;

        const clickedInsidePicker = picker.contains(event.target);
        const clickedInput = input.contains(event.target);
        const clickedButton = event.target.closest('button[title="İkon seç"]');

        if (!clickedInsidePicker && !clickedInput && !clickedButton) {
            picker.classList.add('hidden');
        }
    });
</script>

@endsection