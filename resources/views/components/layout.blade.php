<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'audio master Music Store' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 text-gray-900">

    {{-- Navigation --}}
    <header class="bg-gray-900 text-white shadow-md">
        <nav class="max-w-7xl mx-auto px-6 py-4">

            <div class="flex items-center justify-between gap-6">

                <a href="{{ route('store.index') }}"
                   class="text-xl md:text-2xl font-bold tracking-wide">
                    Audio Master <span class="text-yellow-400">Music Store</span>
                </a>

                <div class="flex items-center gap-5">

                    <a href="{{ route('store.index') }}"
                       class="text-sm hover:text-yellow-400 transition">
                        Home
                    </a>

                    <a href="{{ route('store.index') }}#products"
                       class="text-sm hover:text-yellow-400 transition">
                        Products
                    </a>

                </div>

            </div>

        </nav>
    </header>

    {{-- Main page content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 mt-12">

        <div class="max-w-7xl mx-auto px-6 py-8">

            <div class="text-center">

                <h2 class="text-lg font-bold text-white mb-2">
                    Audio master Music Store
                </h2>

                <p class="text-sm">
                    Your destination for musical instruments and accessories.
                </p>

                <p class="text-xs text-gray-500 mt-4">
                    &copy; {{ date('Y') }} D-Beat Music Store.
                    All rights reserved.
                </p>

            </div>

        </div>

    </footer>

</body>
</html>
