<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaPos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex">

        <aside class="w-64 min-h-screen shrink-0 bg-[#0F172A]">
            @include('admin.layouts.sidebar')
        </aside>

        <main class="flex-1 min-w-0 min-h-screen overflow-y-auto">

            @include('admin.layouts.navbar')

            <div class="p-4 md:p-6 lg:p-8">
                @yield('content')
            </div>

        </main>

    </div>

    <script>
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');

            if (!link) return;

            const href = link.getAttribute('href');

            if (!href || href === '#' || href.startsWith('javascript:')) {
                return;
            }

            if (link.target === '_blank') {
                return;
            }

            e.preventDefault();
            window.location.href = href;
        }, true);
    </script>

</body>

</html>