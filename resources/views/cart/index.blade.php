@extends('layouts.app')

@section('title', 'Shopping Cart | Audio Master Music Store')

@section('content')

<div class="mx-auto max-w-6xl">

    {{-- Page Heading --}}
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">

        <div>
            <p class="font-semibold uppercase tracking-widest text-orange-600">
                Your Selection
            </p>

            <h1 class="mt-2 text-3xl font-extrabold text-gray-900">
                Shopping Cart
            </h1>

            <p class="mt-2 text-gray-600">
                Review your selected musical instruments and accessories.
            </p>
        </div>

        <a href="{{ route('store.index') }}#products"
           class="rounded-lg border border-gray-300 px-5 py-3 font-semibold text-gray-700 transition hover:bg-gray-100">
            Continue Shopping
        </a>

    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">

            <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    @if ($cartItems->isNotEmpty())

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Cart Products --}}
            <div class="space-y-5 lg:col-span-2">

                @foreach ($cartItems as $item)

                    @php
                        $product = $item['product'];
                    @endphp

                    <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        <div class="grid grid-cols-1 sm:grid-cols-3">

                            {{-- Product Image --}}
                            <div class="flex min-h-48 items-center justify-center bg-gray-100 p-5">

                                @if ($product->image_path)

                                    <img
                                        src="{{ asset('storage/' . $product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        class="max-h-44 w-full object-contain"
                                    >

                                @else

                                    <span class="text-6xl text-gray-400">♫</span>

                                @endif

                            </div>

                            {{-- Product Information --}}
                            <div class="p-5 sm:col-span-2">

                                <p class="text-xs font-bold uppercase tracking-widest text-orange-600">
                                    {{ $product->category->name ?? 'Musical Equipment' }}
                                </p>

                                <h2 class="mt-2 text-xl font-bold text-gray-900">
                                    {{ $product->name }}
                                </h2>

                                <p class="mt-3 text-lg font-extrabold text-gray-900">
                                    TZS {{ number_format((float) $product->price, 0) }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Available stock: {{ $product->stock_quantity }}
                                </p>

                                <div class="mt-5 flex flex-wrap items-end justify-between gap-4">

                                    {{-- Update Quantity --}}
                                    <form
                                        action="{{ route('cart.update', $product->id) }}"
                                        method="POST"
                                        class="flex items-end gap-2"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <div>
                                            <label
                                                for="quantity-{{ $product->id }}"
                                                class="mb-1 block text-xs font-semibold text-gray-600"
                                            >
                                                Quantity
                                            </label>

                                            <input
                                                type="number"
                                                id="quantity-{{ $product->id }}"
                                                name="quantity"
                                                min="1"
                                                max="{{ $product->stock_quantity }}"
                                                value="{{ $item['quantity'] }}"
                                                required
                                                class="w-24 rounded-lg border border-gray-300 px-3 py-2"
                                            >
                                        </div>

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-500"
                                        >
                                            Update
                                        </button>

                                    </form>

                                    {{-- Remove Product --}}
                                    <form
                                        action="{{ route('cart.remove', $product->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="font-semibold text-red-600 transition hover:text-red-800"
                                        >
                                            Remove
                                        </button>

                                    </form>

                                </div>

                                <div class="mt-5 border-t border-gray-100 pt-4">

                                    <p class="text-sm text-gray-600">
                                        Item subtotal:
                                        <strong class="text-lg text-gray-900">
                                            TZS {{ number_format($item['subtotal'], 0) }}
                                        </strong>
                                    </p>

                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

            {{-- Order Summary --}}
            <aside class="h-fit rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <h2 class="text-xl font-extrabold text-gray-900">
                    Order Summary
                </h2>

                <div class="mt-6 flex justify-between border-b border-gray-200 pb-4">

                    <span class="text-gray-600">
                        Products
                    </span>

                    <span class="font-semibold text-gray-900">
                        {{ $cartItems->sum('quantity') }}
                    </span>

                </div>

                <div class="mt-4 flex justify-between border-b border-gray-200 pb-4">

                    <span class="text-gray-600">
                        Different items
                    </span>

                    <span class="font-semibold text-gray-900">
                        {{ $cartItems->count() }}
                    </span>

                </div>

                <div class="mt-5 flex items-center justify-between">

                    <span class="font-bold text-gray-900">
                        Total
                    </span>

                    <span class="text-xl font-extrabold text-orange-600">
                        TZS {{ number_format($total, 0) }}
                    </span>

                </div>

                <div class="mt-6 rounded-lg bg-orange-50 p-4">

                    <p class="text-sm leading-6 text-orange-800">
                        Your cart does not reserve stock. Product availability
                        and prices will be checked again during checkout.
                    </p>

                </div>

                <button
                    type="button"
                    disabled
                    class="mt-6 w-full cursor-not-allowed rounded-lg bg-gray-300 px-6 py-4 font-bold text-gray-600"
                >
                    Checkout Coming Next
                </button>

                <p class="mt-3 text-center text-xs text-gray-500">
                    We will enable secure multi-product checkout in the next step.
                </p>

            </aside>

        </div>

    @else

        {{-- Empty Cart --}}
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

            <div class="text-7xl text-gray-300">
                🛒
            </div>

            <h2 class="mt-6 text-2xl font-extrabold text-gray-900">
                Your cart is empty
            </h2>

            <p class="mx-auto mt-3 max-w-md leading-7 text-gray-600">
                You haven't added any musical instruments or accessories yet.
                Explore our collection and find something you love.
            </p>

            <a
                href="{{ route('store.index') }}#products"
                class="mt-7 inline-block rounded-lg bg-orange-500 px-7 py-3 font-bold text-white transition hover:bg-orange-600"
            >
                Explore Products
            </a>

        </div>

    @endif

</div>

@endsection
