<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Discover guitars, speakers, keyboards, and musical accessories at Audio Master Music Store.">

    <title>@yield('title', 'Audio Master Music Store')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 text-gray-900">

    {{-- Header and Navigation --}}
    <header class="sticky top-0 z-50 bg-gray-950 text-white shadow-lg">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">

            {{-- Store Logo --}}
            <a href="{{ route('store.index') }}"
               class="text-2xl font-extrabold tracking-wide">
                Audio Master <span class="text-orange-400">Music</span>
            </a>

            {{-- Navigation Menu --}}
         
{{-- Navigation Menu --}}
<nav class="flex flex-wrap items-center gap-4 text-sm font-medium md:gap-6">

    {{-- Public Links --}}
    <a href="{{ route('store.index') }}"
       class="transition hover:text-orange-400">
        Home
    </a>

    <a href="{{ route('store.index') }}#products"
       class="transition hover:text-orange-400">
        Products
    </a>

    <a href="{{ route('store.index') }}#categories"
       class="transition hover:text-orange-400">
        Categories
    </a>

    <a href="{{ route('store.index') }}#location"
       class="transition hover:text-orange-400">
        Location
    </a>

    <a href="{{ route('store.index') }}#contact"
       class="rounded-lg bg-orange-500 px-4 py-2 font-semibold text-white transition hover:bg-orange-600">
        Contact Us
    </a>

    {{-- Links for Guests --}}
    @guest
        <a href="{{ route('login') }}"
           class="rounded-lg border border-gray-500 px-4 py-2 transition hover:border-orange-400 hover:text-orange-400">
            Login
        </a>

        <a href="{{ route('register') }}"
           class="rounded-lg bg-white px-4 py-2 font-semibold text-gray-950 transition hover:bg-orange-400">
            Register
        </a>
    @endguest

    {{-- Links for Authenticated Users --}}
    @auth
        <a href="{{ route('bookings.index') }}"
           class="transition hover:text-orange-400">
            My Bookings
        </a>

        {{-- Administrator Links --}}
      @if (auth()->user()->role === 'admin')

    <a href="{{ route('admin.products.index') }}"
       class="rounded-lg bg-orange-500 px-4 py-2 font-semibold text-white transition hover:bg-orange-600">
        Admin Products
    </a>

    <a href="{{ route('admin.bookings.index') }}"
       class="rounded-lg border border-orange-400 px-4 py-2 font-semibold text-orange-300 transition hover:bg-orange-500 hover:text-white">
        Admin Bookings
    </a>

@endif

        {{-- Logout --}}
        <form action="{{ route('logout') }}"
              method="POST"
              class="inline">
            @csrf

            <button type="submit"
                    class="rounded-lg border border-red-400 px-4 py-2 text-red-300 transition hover:bg-red-500 hover:text-white">
                Logout
            </button>
        </form>
    @endauth

</nav>

        </div>
    </header>

    {{-- Main Page Content --}}
    <main class="mx-auto min-h-[70vh] max-w-7xl px-6 py-10">
        @yield('content')
    </main>

    {{-- Store Location Section --}}
    <section id="location" class="scroll-mt-24 bg-white py-16">

        <div class="mx-auto max-w-7xl px-6">

            {{-- Section Heading --}}
            <div class="mb-10 text-center">

                <p class="font-semibold uppercase tracking-widest text-orange-600">
                    Visit Our Store
                </p>

                <h2 class="mt-3 text-3xl font-extrabold md:text-4xl">
                    Find Audio Master Music Store
                </h2>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-600">
                    Visit us to explore our musical instruments and accessories.
                    We are here to help you find the right equipment for your
                    musical journey.
                </p>

            </div>

            {{-- Location Information and Map --}}
            <div class="grid grid-cols-1 gap-8 overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 shadow-sm md:grid-cols-2">

                {{-- Address --}}
                <div class="flex flex-col justify-center p-6 md:p-10">

                    <div class="mb-5 text-4xl">
                        📍
                    </div>

                    <h3 class="text-2xl font-bold">
                        Our Location
                    </h3>

                    {{-- Replace with your actual address --}}
                    <address class="mt-4 not-italic leading-7 text-gray-600">
                        YOUR STREET OR AREA<br>
                        YOUR CITY, TANZANIA
                    </address>

                    <p class="mt-4 text-sm leading-6 text-gray-500">
                        Visit our store or contact us for directions and
                        information about product availability.
                    </p>

                    {{-- Replace with your actual Google Maps link --}}
                    <a
                        href="https://www.google.com/maps"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-6 inline-flex w-fit items-center justify-center rounded-lg bg-gray-950 px-6 py-3 font-semibold text-white transition hover:bg-orange-500"
                    >
                        Get Directions
                        <span class="ml-2">↗</span>
                    </a>

                </div>

                {{-- Google Maps Embed --}}
                <div class="min-h-80 overflow-hidden rounded-xl bg-gray-200">

                    {{--
                        Replace the iframe src with your Google Maps embed URL.
                        Until then, this placeholder is displayed.
                    --}}

                    <div class="flex min-h-80 items-center justify-center p-8 text-center">

                        <div>
                            <span class="text-5xl">🗺️</span>

                            <h3 class="mt-4 text-xl font-bold text-gray-800">
                                Find Us on the Map
                            </h3>

                            <p class="mt-3 leading-6 text-gray-600">
                                Our Google Maps location will appear here
                                after you add your map embed link.
                            </p>

                        </div>

                    </div>

                    {{--
                        When you have your Google Maps embed URL, replace the
                        placeholder div above with the iframe below.

                        <iframe
                            src="YOUR_GOOGLE_MAPS_EMBED_LINK"
                            width="100%"
                            height="100%"
                            style="border: 0; min-height: 320px;"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Audio Master Music Store Location">
                        </iframe>
                    --}}

                </div>

            </div>

        </div>

    </section>

    {{-- Contact Us Section --}}
    <section id="contact" class="scroll-mt-24 bg-gray-950 py-16 text-white">

        <div class="mx-auto max-w-7xl px-6">

            {{-- Section Heading --}}
            <div class="mb-12 text-center">

                <p class="font-semibold uppercase tracking-widest text-orange-400">
                    Get In Touch
                </p>

                <h2 class="mt-3 text-3xl font-extrabold md:text-4xl">
                    Contact Us
                </h2>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-300">
                    Do you have questions about our guitars, speakers,
                    keyboards, or other musical accessories?
                    Contact us or follow our social media pages.
                </p>

            </div>

            {{-- Contact Cards --}}
            <div class="mx-auto grid max-w-4xl grid-cols-1 gap-8 md:grid-cols-2">

                {{-- WhatsApp --}}
                <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8 text-center transition hover:-translate-y-1 hover:border-green-500">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl">
                        💬
                    </div>

                    <h3 class="mt-5 text-2xl font-bold">
                        WhatsApp
                    </h3>

                    <p class="mt-3 leading-7 text-gray-300">
                        Chat with us to ask about prices, product availability,
                        and other enquiries.
                    </p>

                    {{-- Replace 255XXXXXXXXX with your WhatsApp number --}}
                    <a
                        href="https://wa.me/25571500000?text=Hello%20Audio%20Master%20Music%20Store%2C%20I%20would%20like%20to%20make%20an%20enquiry."
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-6 inline-flex items-center justify-center rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700"
                    >
                        Chat on WhatsApp
                        <span class="ml-2">↗</span>
                    </a>

                </div>

                {{-- Instagram --}}
                <div class="rounded-2xl border border-gray-800 bg-gray-900 p-8 text-center transition hover:-translate-y-1 hover:border-pink-500">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-pink-100 text-3xl">
                        📸
                    </div>

                    <h3 class="mt-5 text-2xl font-bold">
                        Instagram
                    </h3>

                    <p class="mt-3 leading-7 text-gray-300">
                        Follow us to discover new instruments, product updates,
                        announcements, and offers.
                    </p>

                    {{-- Replace YOUR_INSTAGRAM_USERNAME with your username --}}
                    <a
                        href="https://www.instagram.com/dickson83544/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-6 inline-flex items-center justify-center rounded-lg bg-pink-600 px-6 py-3 font-semibold text-white transition hover:bg-pink-700"
                    >
                        Follow on Instagram
                        <span class="ml-2">↗</span>
                    </a>

                    <a href="{{ route('store.index') }}#contact"
   class="transition hover:text-orange-500">
    Contact
</a>

                </div>

            </div>

            <div class="mt