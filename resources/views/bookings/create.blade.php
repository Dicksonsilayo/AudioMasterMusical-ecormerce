@extends('layouts.app')

@section('title', 'Book Product | Audio Master Music Store')

@section('content')

<div class="mx-auto max-w-3xl">

    <a
        href="{{ route('store.show', $product->slug) }}"
        class="font-semibold text-orange-600 hover:text-orange-700"
    >
        &larr; Back to Product
    </a>

    <div class="mb-8 mt-6">
        <h1 class="text-3xl font-extrabold text-gray-900">
            Book This Product
        </h1>

        <p class="mt-2 text-gray-600">
            Review your product and submit your booking request.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            <p class="font-bold">Please correct the following errors:</p>

            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="grid grid-cols-1 md:grid-cols-2">

            {{-- Product Image --}}
            <div class="flex min-h-64 items-center justify-center bg-gray-100 p-6">

                @if ($product->image_path)
                    <img
                        src="{{ asset('storage/' . $product->image_path) }}"
                        alt="{{ $product->name }}"
                        class="max-h-72 w-full object-contain"
                    >
                @else
                    <div class="text-center text-gray-400">
                        <span class="text-7xl">♫</span>
                        <p class="mt-3">Product image coming soon</p>
                    </div>
                @endif

            </div>

            {{-- Product Information --}}
            <div class="p-6">

                <p class="text-sm font-semibold uppercase tracking-wide text-orange-600">
                    {{ $product->category->name ?? 'Musical Equipment' }}
                </p>

                <h2 class="mt-3 text-2xl font-bold text-gray-900">
                    {{ $product->name }}
                </h2>

                <p class="mt-4 text-2xl font-extrabold text-gray-900">
                    TZS {{ number_format((float) $product->price, 0) }}
                </p>

                <p class="mt-3 text-sm text-gray-600">
                    Available stock:
                    <strong>{{ $product->stock_quantity }}</strong>
                </p>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    {{ $product->description ?: 'No description is available.' }}
                </p>

            </div>

        </div>

        {{-- Booking Form --}}
        <div class="border-t border-gray-200 p-6 md:p-8">

            @if ($product->stock_quantity > 0)

                <form
                    action="{{ route('bookings.store', $product->slug) }}"
                    method="POST"
                    class="space-y-6"
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
                            Maximum available quantity: {{ $product->stock_quantity }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="customer_notes"
                            class="mb-2 block font-semibold text-gray-700"
                        >
                            Additional Notes (Optional)
                        </label>

                        <textarea
                            id="customer_notes"
                            name="customer_notes"
                            rows="4"
                            maxlength="2000"
                            placeholder="Enter any questions or special requests..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                        >{{ old('customer_notes') }}</textarea>
                    </div>

                    <div class="rounded-lg bg-orange-50 p-4">
                        <p class="font-semibold text-orange-900">
                            Booking information
                        </p>

                        <p class="mt-2 text-sm leading-6 text-orange-800">
                            Your booking will initially have Pending status.
                            Submitting the booking reserves the requested stock.
                            The final amount is calculated securely by the server.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-orange-500 px-6 py-4 font-bold text-white transition hover:bg-orange-600"
                    >
                        Submit Booking
                    </button>

                </form>

            @else

                <div class="rounded-lg bg-red-50 p-5 text-center text-red-700">
                    <p class="font-bold">This product is currently out of stock.</p>

                    <p class="mt-2 text-sm">
                        Please check back later or explore other products.
                    </p>
                </div>

            @endif

        </div>

    </div>

</div>

@endsection