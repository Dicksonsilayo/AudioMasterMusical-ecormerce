@extends('layouts.app')

@section('title', 'Manage Products | Audio Master Music Store')

@section('content')
<div class="mx-auto max-w-7xl">

    {{-- Page heading --}}
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-orange-600">
                Administration
            </p>

            <h1 class="mt-2 text-3xl font-extrabold text-gray-900">
                Manage Products
            </h1>

            <p class="mt-2 text-gray-600">
                Add, edit, search, and manage your musical instruments.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.bookings.index') }}"
               class="rounded-lg border border-gray-300 px-5 py-3 font-semibold text-gray-700 transition hover:bg-gray-100">
                Manage Bookings
            </a>

            <a href="{{ route('admin.products.create') }}"
               class="rounded-lg bg-orange-500 px-5 py-3 font-semibold text-white shadow transition hover:bg-orange-600">
                + Add Product
            </a>
        </div>
    </div>

    {{-- Success message --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search form --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <form action="{{ route('admin.products.index') }}"
              method="GET"
              class="flex flex-col gap-3 sm:flex-row">

            <div class="flex-1">
                <label for="search" class="sr-only">Search products</label>

                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by product name or slug..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                >
            </div>

            <button
                type="submit"
                class="rounded-lg bg-gray-950 px-6 py-3 font-semibold text-white transition hover:bg-gray-800"
            >
                Search
            </button>

            @if (request()->filled('search'))
                <a href="{{ route('admin.products.index') }}"
                   class="rounded-lg border border-gray-300 px-6 py-3 text-center font-semibold text-gray-700 transition hover:bg-gray-100">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Products table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="text-lg font-bold text-gray-900">
                Product Inventory
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                {{ $products->total() }} product(s) found.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">

                <thead class="bg-gray-100 text-xs uppercase tracking-wider text-gray-600">
                    <tr>
                        <th class="px-5 py-4">Image</th>
                        <th class="px-5 py-4">Product</th>
                        <th class="px-5 py-4">Category</th>
                        <th class="px-5 py-4">Price</th>
                        <th class="px-5 py-4">Stock</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($products as $product)
                        <tr class="transition hover:bg-gray-50">

                            {{-- Product image --}}
                            <td class="px-5 py-4">
                                @if ($product->image_path)
                                    <img
                                        src="{{ asset('storage/' . $product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        class="h-16 w-16 rounded-lg border border-gray-200 object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="flex h-16 w-16 items-center justify-center rounded-lg bg-gray-100 text-2xl">
                                        🎸
                                    </div>
                                @endif
                            </td>

                            {{-- Product details --}}
                            <td class="px-5 py-4">
                                <p class="font-bold text-gray-900">
                                    {{ $product->name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $product->slug }}
                                </p>
                            </td>

                            {{-- Category --}}
                            <td class="px-5 py-4 text-gray-700">
                                {{ $product->category?->name ?? 'No category' }}
                            </td>

                            {{-- Price --}}
                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-gray-900">
                                TSh {{ number_format((float) $product->price, 2) }}
                            </td>

                            {{-- Stock --}}
                            <td class="px-5 py-4">
                                @if ($product->stock_quantity > 0)
                                    <span class="font-semibold text-green-700">
                                        {{ $product->stock_quantity }}
                                    </span>
                                @else
                                    <span class="font-semibold text-red-600">
                                        Out of stock
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                @if ($product->is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">

                                    <a
                                        href="{{ route('admin.products.edit', $product) }}"
                                        class="font-semibold text-blue-600 hover:text-blue-800"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product? Products with booking history will be deactivated instead.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="font-semibold text-red-600 hover:text-red-800"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="text-4xl">🎵</div>

                                <h3 class="mt-4 text-lg font-bold text-gray-900">
                                    No products found
                                </h3>

                                <p class="mt-2 text-gray-600">
                                    Add your first product or change your search.
                                </p>

                                <a
                                    href="{{ route('admin.products.create') }}"
                                    class="mt-5 inline-block rounded-lg bg-orange-500 px-5 py-3 font-semibold text-white hover:bg-orange-600"
                                >
                                    Add Your First Product
                                </a>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="border-t border-gray-200 px-5 py-4">
                {{ $products->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
