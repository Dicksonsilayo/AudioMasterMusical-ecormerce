@extends('layouts.app')

@section('title', 'Home | Audio Master Music Store')

@section('content')

    {{-- Hero Section --}}
    <section class="mb-14 overflow-hidden rounded-2xl bg-gray-900 px-8 py-16 text-white md:px-14">

        <div class="max-w-2xl">

            <p class="mb-3 font-semibold uppercase tracking-[0.25em] text-orange-400">
                Welcome to Audio Master
            </p>

            <h1 class="mb-6 text-4xl font-extrabold leading-tight md:text-6xl">
                Find Your Sound.
                <span class="text-orange-400">Play Your Passion.</span>
            </h1>

            <p class="mb-8 max-w-xl text-lg leading-8 text-gray-300">
                Discover guitars, speakers, keyboards, and musical accessories
                for practice, recording, and live performances.
            </p><a href="#products"
   class="inline-block rounded-lg bg-orange-500 px-6 py-3 font-bold text-white transition hover:bg-orange-600">
    Explore Products
</a>

        </div>

    </section>


    {{-- Categories Section --}}
    <section id="categories" class="mb-16 scroll-mt-24">

        <div class="mb-6">

            <h2 class="text-3xl font-bold">
                Shop by Category
            </h2>

            <p class="mt-2 text-gray-600">
                Explore our musical equipment collections.
            </p>

        </div>

        @if ($categories->isNotEmpty())

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($categories as $category)

                    <a href="#products"
                       class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-orange-400 hover:shadow-md">

                        <h3 class="text-xl font-bold">
                            {{ $category->name }}
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            {{ $category->description ?: 'Explore our ' . strtolower($category->name) . ' collection.' }}
                        </p>

                    </a>

                @endforeach

            </div>

        @else

            <div class="rounded-xl border border-gray-200 bg-white p-6">

                <p class="text-gray-600">
                    No categories are available yet.
                </p>

            </div>

        @endif

    </section>


    {{-- Products Section --}}
    <section id="products" class="scroll-mt-24">

        <div class="mb-8">

            <h2 class="text-3xl font-bold">
                Featured Products
            </h2>

            <p class="mt-2 text-gray-600">
                Explore our latest musical equipment.
            </p>

        </div>
        <form method="GET" action="{{ route('store.index') }}"
      class="mb-6 flex flex-col gap-4 rounded-xl bg-white p-4 shadow-sm sm:flex-row sm:items-end">

    <div class="flex-1">
        <label for="search" class="mb-2 block text-sm font-semibold text-gray-700">
            Search products
        </label>

        <input
            type="search"
            name="search"
            id="search"
            value="{{ $search }}"
            placeholder="Search guitars, speakers..."
            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none"
        >
    </div>

    <div class="flex-1">
        <label for="category" class="mb-2 block text-sm font-semibold text-gray-700">
            Category
        </label>

        <select
            name="category"
            id="category"
            class="w-full rounded-lg border border-gray-300 px-4 py-3"
        >
            <option value="">All categories</option>

            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected((string) $categoryId === (string) $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex-1">
        <label for="availability" class="mb-2 block text-sm font-semibold text-gray-700">
            Availability
        </label>

        <select
            name="availability"
            id="availability"
            class="w-full rounded-lg border border-gray-300 px-4 py-3"
        >
            <option value="">All products</option>
            <option value="in_stock" @selected($availability === 'in_stock')>
                In stock
            </option>
            <option value="out_of_stock" @selected($availability === 'out_of_stock')>
                Out of stock
            </option>
        </select>
    </div>

    <div class="flex-1">
        <label for="sort" class="mb-2 block text-sm font-semibold text-gray-700">
            Sort by
        </label>

        <select
            name="sort"
            id="sort"
            class="w-full rounded-lg border border-gray-300 px-4 py-3"
        >
            <option value="newest" @selected($sort === 'newest')>
                Newest arrivals
            </option>
            <option value="price_asc" @selected($sort === 'price_asc')>
                Price: low to high
            </option>
            <option value="price_desc" @selected($sort === 'price_desc')>
                Price: high to low
            </option>
        </select>
    </div>

    <div class="flex gap-2">
        <button
            type="submit"
            class="rounded-lg bg-orange-500 px-5 py-3 font-bold text-white hover:bg-orange-600"
        >
            Apply
        </button>

        <a
            href="{{ route('store.index') }}"
            class="rounded-lg border border-gray-300 px-5 py-3 font-semibold text-gray-700 hover:bg-gray-100"
        >
            Reset
        </a>
    </div>

</form>
        
        {{-- Product Search and Filters --}}
        <form action="{{ route('store.index') }}"
              method="GET"
              class="mb-8 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

                {{-- Search Input --}}
                <div class="md:col-span-2">

                    <label for="search"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Search Products
                    </label>

                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search guitars, speakers, keyboards..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-3
                               text-gray-900 outline-none transition
                               focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                    >

                </div>

                {{-- Category Filter --}}
                <div>

                    <label for="category"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Category
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="w-full rounded-lg border border-gray-300 bg-white
                               px-4 py-3 text-gray-900 outline-none transition
                               focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                    >

                        <option value="">All Categories</option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected((string) $categoryId === (string) $category->id)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Availability Filter --}}
                <div>

                    <label for="availability"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Availability
                    </label>

                    <select
                        id="availability"
                        name="availability"
                        class="w-full rounded-lg border border-gray-300 bg-white
                               px-4 py-3 text-gray-900 outline-none transition
                               focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                    >

                        <option value="">All Products</option>

                        <option value="in_stock"
                            @selected($availability === 'in_stock')>
                            In Stock
                        </option>

                        <option value="out_of_stock"
                            @selected($availability === 'out_of_stock')>
                            Out of Stock
                        </option>

                    </select>

                </div>

            </div>

            {{-- Form Buttons --}}
            <div class="mt-5 flex flex-wrap gap-3">

                <button
                    type="submit"
                    class="rounded-lg bg-orange-500 px-6 py-3 font-semibold
                           text-white transition hover:bg-orange-600"
                >
                    Search Products
                </button>

                <a
                    href="{{ route('store.index') }}#products"
                    class="rounded-lg border border-gray-300 px-6 py-3
                           font-semibold text-gray-700 transition
                           hover:bg-gray-100"
                >
                    Clear Filters
                </a>

            </div>

        </form>

        {{-- Search Results Summary --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">

            <p class="text-sm text-gray-600">
                Found
                <span class="font-bold text-gray-900">
                    {{ $products->total() }}
                </span>
                {{ $products->total() === 1 ? 'product' : 'products' }}.
            </p>

            @if ($search !== '' || $categoryId || $availability !== '')

                <span class="rounded-full bg-orange-100 px-3 py-1
                             text-xs font-semibold text-orange-700">
                    Filters applied
                </span>

            @endif

        </div>


        @if ($products->isNotEmpty())

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                @foreach ($products as $product)

                    {{-- Individual Product Card --}}
                    <article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                        {{-- Product Image --}}
                        <div class="flex h-52 items-center justify-center bg-gray-100">

                            @if ($product->image_path)

                                <img
                                    src="{{ asset('storage/' . $product->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                >

                            @else

                                <div class="text-center text-gray-400">

                                    <span class="text-5xl">♫</span>

                                    <p class="mt-2 text-sm">
                                        Product image coming soon
                                    </p>

                                </div>

                            @endif

                        </div>


                        {{-- Product Information --}}
                        <div class="p-5">

                            {{-- Category Name --}}
                            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-orange-600">
                                {{ $product->category->name ?? 'Musical Equipment' }}
                            </p>

                            {{-- Product Name --}}
                            <h3 class="text-lg font-bold">
                                {{ $product->name }}
                            </h3>

                            {{-- Product Description --}}
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-600">
                                {{ $product->description ?: 'Contact us to learn more about this product.' }}
                            </p>


                            {{-- Price and Stock --}}
                            <div class="mt-4 flex items-center justify-between gap-3">

                                <p class="text-lg font-extrabold text-gray-900">
                                    TZS {{ number_format((float) $product->price, 0) }}
                                </p>

                                @if ($product->stock_quantity > 0)

                                    <span class="text-xs font-semibold text-green-700">
                                        In stock
                                    </span>

                                @else

                                    <span class="text-xs font-semibold text-red-600">
                                        Out of stock
                                    </span>

                                @endif

                            </div>


                            {{-- View Product Details --}}
                            <a href="{{ route('store.show', $product->slug) }}"
                               class="mt-5 block rounded-lg bg-gray-900 px-4 py-3 text-center font-semibold text-white transition hover:bg-orange-500">

                                View Details

                            </a>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- Product Pagination --}}
            <div class="mt-10">

                {{ $products->links() }}

            </div>

        @else

            {{-- No Products Available --}}
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">

                <h3 class="text-xl font-bold">
                    No Products Available
                </h3>

                <p class="mt-3 text-gray-600">
                    Products will appear here once they have been added to the store.
                </p>

            </div>

        @endif

    </section>
        {{-- Contact Us Section --}}
    <section id="contact" class="mt-20 scroll-mt-24">

        {{-- Section Heading --}}
        <div class="mb-10 text-center">

            <p class="mb-3 font-semibold uppercase tracking-[0.2em] text-orange-600">
                We're Here to Help
            </p>

            <h2 class="text-3xl font-extrabold text-gray-900 md:text-4xl">
                Contact Audio Master Music
            </h2>

            <p class="mx-auto mt-4 max-w-2xl leading-7 text-gray-600">
                Have questions about our guitars, speakers, keyboards, or
                other musical equipment? Contact us or visit our store.
                We're happy to help you find your sound.
            </p>

        </div>

        {{-- Contact Cards --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            {{-- WhatsApp --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-8
                        text-center shadow-sm transition hover:-translate-y-1
                        hover:shadow-lg">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-green-100">

                    <span class="text-3xl" aria-hidden="true">💬</span>

                </div>

                <h3 class="mt-5 text-xl font-bold text-gray-900">
                    WhatsApp
                </h3>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Ask about product availability, prices, or your booking.
                    Chat directly with our team.
                </p>

                <a href="https://wa.me/255XXXXXXXXX"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="mt-6 inline-block rounded-lg bg-green-600
                          px-6 py-3 font-semibold text-white
                          transition hover:bg-green-700">

                    Chat on WhatsApp

                </a>

            </div>


            {{-- Instagram --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-8
                        text-center shadow-sm transition hover:-translate-y-1
                        hover:shadow-lg">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-pink-100">

                    <span class="text-3xl" aria-hidden="true">📸</span>

                </div>

                <h3 class="mt-5 text-xl font-bold text-gray-900">
                    Instagram
                </h3>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Follow our store for musical equipment, product updates,
                    and news from Audio Master Music.
                </p>

                <a href="https://www.instagram.com/YOUR_USERNAME/"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="mt-6 inline-block rounded-lg bg-pink-600
                          px-6 py-3 font-semibold text-white
                          transition hover:bg-pink-700">

                    Visit Instagram

                </a>

            </div>


            {{-- Store Location --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-8
                        text-center shadow-sm transition hover:-translate-y-1
                        hover:shadow-lg">

                <div class="mx-auto flex h-16 w-16 items-center
                            justify-center rounded-full bg-orange-100">

                    <span class="text-3xl" aria-hidden="true">📍</span>

                </div>

                <h3 class="mt-5 text-xl font-bold text-gray-900">
                    Our Location
                </h3>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    [Your Store Address, Dar es Salaam, Tanzania]
                </p>

                <a href="https://www.google.com/maps/search/?api=1&query=YOUR_STORE_LOCATION"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="mt-6 inline-block rounded-lg bg-gray-900
                          px-6 py-3 font-semibold text-white
                          transition hover:bg-orange-500">

                    Find Our Store

                </a>

            </div>

        </div>

        {{-- Closing Message --}}
        <div class="mt-10 rounded-2xl bg-gray-900 px-6 py-10
                    text-center text-white md:px-12">

            <h3 class="text-2xl font-bold">
                Let's Make Music Together
            </h3>

            <p class="mx-auto mt-3 max-w-2xl leading-7 text-gray-300">
                Whether you're a beginner, a music enthusiast, or a
                professional performer, Audio Master Music is here to
                help you find the equipment you need.
            </p>

        </div>

    </section>

@endsection