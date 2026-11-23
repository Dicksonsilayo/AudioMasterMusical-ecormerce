@extends('layouts.app')

@section('title', $product->name . ' | Audio master Music Store')

@section('content')

    <div class="mb-8">
        <a href="{{ route('store.index') }}"
           class="font-semibold text-orange-600 hover:text-orange-700">
            &larr; Back to Store
        </a>
    </div>

    <div class="grid grid-cols-1 gap-10 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm md:grid-cols-2 md:p-10">

        {{-- Product image --}}
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

        {{-- Product information --}}
        <div class="flex flex-col justify-center">

            <p class="mb-3 text-sm font-bold uppercase tracking-widest text-orange-600">
                {{ $product->category->name }}
            </p>

            <h1 class="text-3xl font-extrabold md:text-4xl">
                {{ $product->name }}
            </h1>

            <p class="mt-5 text-3xl font-extrabold text-gray-900">
                TZS {{ number_format((float) $product->price, 0) }}
            </p>

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

            <div class="mt-8">
                <h2 class="text-xl font-bold">Product Description</h2>

                <p class="mt-3 whitespace-pre-line leading-8 text-gray-600">
                    {{ $product->description ?: 'No description is available for this product yet.' }}
                </p>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-6">

                <p class="text-sm text-gray-500">
                    Product reference: {{ $product->slug }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    Category: {{ $product->category->name }}
                </p>

            </div>

            {{-- Booking functionality will be added in a later lesson. --}}
            <div class="mt-8">
                <button
                    type="button"
                    disabled
                    class="w-full cursor-not-allowed rounded-lg bg-gray-300 px-6 py-4 font-bold text-gray-600"
                >
                    Booking functionality coming soon
                </button>

                <p class="mt-3 text-sm text-gray-500">
                    Product booking will become available when we implement customer accounts and bookings.
                </p>
            </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    hello
    
</body>
</html>
        </div>

    </div>

@endsection