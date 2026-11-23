@extends('layouts.app')

@section('title', $product->name . ' | Audio Master Music Store')

@section('content')

<div class="mx-auto max-w-6xl">

    {{-- Back to Store --}}
    <div class="mb-8">
        <a href="{{ route('store.index') }}"
           class="font-semibold text-orange-600 transition hover:text-orange-700">
            &larr; Back to Store
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 gap-10 overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm md:grid-cols-2 md:p-10">

        {{-- Product Image --}}
        <div class="flex min-h-80 items-center justify-center overflow-hidden rounded-xl bg-gray-100">

            @if ($product->image_path)

                <img
                    src="{{ asset('storage/' . $product->image_path) }}"
                    alt="{{ $product->name }}"
                    class="max-h-[500px] w-full object-contain"
                >

            @else

                <div class="text-center text-gray-400">
                    <span class="text-7xl">♫</span>
                    <p class="mt-4">Product image coming soon</p>
                </div>

            @endif

        </div>

        {{-- Product Information --}}
        <div class="flex flex-col justify-center">

            <p class="mb-3 text-sm font-bold uppercase tracking-widest text-orange-600">
                {{ $product->category->name ?? 'Musical Equipment' }}
            </p>

            <h1 class="text-3xl font-extrabold text-gray-900 md:text-4xl">
                {{ $product->name }}
            </h1>

            <p class="mt-5 text-3xl font-extrabold text-gray-900">
                TZS {{ number_format((float) $product->price, 0) }}
            </p>

            {{-- Stock Status --}}
            <div class="mt-5">

                @if ($product->stock_quantity > 0)

                    <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-800">
                        In stock: {{ $product->stock_quantity }}
                    </span>

                @else

                    <span class="rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-800">
                        Currently out of stock
                    </span>

                @endif

            </div>

            {{-- Description --}}
            <div class="mt-8">

                <h2 class="text-xl font-bold text-gray-900">
                    Product Description
                </h2>

                <p class="mt-3 whitespace-pre-line leading-8 text-gray-600">
                    {{ $product->description ?: 'No description is available for this product yet.' }}
                </p>

            </div>

            {{-- Product Details --}}
            <div class="mt-8 border-t border-gray-200 pt-6">

                <p class="text-sm text-gray-500">
                    Product reference: {{ $product->slug }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    Category: {{ $product->category->name ?? 'Musical Equipment' }}
                </p>

            </div>

            {{-- Add to Cart --}}
            <div class="mt-8">

                @if ($product->stock_quantity > 0)

                    <form
                        action="{{ route('cart.add', $product->slug) }}"
                        method="POST"
                        class="space-y-4"
                    >
                        @csrf

                        <div>
                            <label
                                for="quantity"
                                class="mb-2 block font-semibold text-gray-700"
                            >
                                Quantity
                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                min="1"
                                max="{{ $product->stock_quantity }}"
                                value="{{ old('quantity', 1) }}"
                                required
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            >

                            <p class="mt-2 text-sm text-gray-500">
                                Maximum available: {{ $product->stock_quantity }}
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-orange-500 px-6 py-4 font-bold text-white transition hover:bg-orange-600"
                        >
                            🛒 Add to Cart
                        </button>

                    </form>

                    {{-- Existing Direct Booking --}}
                    @auth

                        <a
                            href="{{ route('bookings.create', $product->slug) }}"
                            class="mt-4 block w-full rounded-lg border border-gray-300 px-6 py-3 text-center font-semibold text-gray-700 transition hover:bg-gray-100"
                        >
                            Book This Product Directly
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="mt-4 block w-full rounded-lg border border-gray-300 px-6 py-3 text-center font-semibold text-gray-700 transition hover:bg-gray-100"
                        >
                            Login for Direct Booking
                        </a>

                    @endauth

                @else

                    <button
                        type="button"
                        disabled
                        class="w-full cursor-not-allowed rounded-lg bg-gray-300 px-6 py-4 font-bold text-gray-600"
                    >
                        Currently Unavailable
                    </button>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection