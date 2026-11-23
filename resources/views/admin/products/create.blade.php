@extends('layouts.app')

@section('title', 'Add Product | Audio Master Music Store')

@section('content')
<div class="mx-auto max-w-3xl">

    {{-- Heading --}}
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}"
           class="text-sm font-semibold text-orange-600 hover:text-orange-700">
            ← Back to Products
        </a>

        <h1 class="mt-4 text-3xl font-extrabold text-gray-900">
            Add New Product
        </h1>

        <p class="mt-2 text-gray-600">
            Enter the product details and upload an optional image.
        </p>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-5 text-red-800">
            <h2 class="font-bold">Please correct the following errors:</h2>

            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Product form --}}
    <form
        action="{{ route('admin.products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8"
    >
        @csrf

        {{-- Product name --}}
        <div>
            <label for="name" class="mb-2 block font-semibold text-gray-800">
                Product Name <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                maxlength="150"
                required
                placeholder="e.g. Yamaha Acoustic Guitar"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
            >

            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category_id" class="mb-2 block font-semibold text-gray-800">
                Category <span class="text-red-500">*</span>
            </label>

            <select
                id="category_id"
                name="category_id"
                required
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
            >
                <option value="">-- Select a category --</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @if ($categories->isEmpty())
                <p class="mt-2 text-sm text-red-600">
                    No active categories are available. Create or activate a category first.
                </p>
            @endif

            @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="mb-2 block font-semibold text-gray-800">
                Product Description
            </label>

            <textarea
                id="description"
                name="description"
                rows="5"
                placeholder="Describe the product, its features, and condition..."
                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
            >{{ old('description') }}</textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Price and stock --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <div>
                <label for="price" class="mb-2 block font-semibold text-gray-800">
                    Price (TSh) <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price') }}"
                    min="0"
                    step="0.01"
                    required
                    placeholder="150000"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                >

                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock_quantity" class="mb-2 block font-semibold text-gray-800">
                    Stock Quantity <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    id="stock_quantity"
                    name="stock_quantity"
                    value="{{ old('stock_quantity', 0) }}"
                    min="0"
                    step="1"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
                >

                @error('stock_quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Product image --}}
        <div>
            <label for="image" class="mb-2 block font-semibold text-gray-800">
                Product Image
            </label>

            <input
                type="file"
                id="image"
                name="image"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 file:mr-4 file:rounded-lg file:border-0 file:bg-orange-100 file:px-4 file:py-2 file:font-semibold file:text-orange-700"
            >

            <p class="mt-2 text-sm text-gray-500">
                Accepted formats: JPG, JPEG, PNG, WebP. Maximum size: 2 MB.
            </p>

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Active status --}}
        <div class="rounded-lg bg-gray-50 p-4">
            <input type="hidden" name="is_active" value="0">

            <label for="is_active" class="flex cursor-pointer items-center gap-3">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', '1') == '1')
                    class="h-5 w-5 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                >

                <span>
                    <span class="block font-semibold text-gray-900">
                        Active Product
                    </span>

                    <span class="mt-1 block text-sm text-gray-500">
                        Active products can be displayed in the public store.
                    </span>
                </span>
            </label>

            @error('is_active')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row">

            <button
                type="submit"
                class="rounded-lg bg-orange-500 px-6 py-3 font-bold text-white transition hover:bg-orange-600"
            >
                Save Product
            </button>

            <a
                href="{{ route('admin.products.index') }}"
                class="rounded-lg border border-gray-300 px-6 py-3 text-center font-semibold text-gray-700 transition hover:bg-gray-100"
            >
                Cancel
            </a>

        </div>

    </form>

</div>
@endsection
