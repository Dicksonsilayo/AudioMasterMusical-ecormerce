@extends('layouts.app')

@section('title', 'Edit Product | Audio Master Music Store')

@section('content')
<div class="mx-auto max-w-3xl">

    {{-- Heading --}}
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}"
           class="text-sm font-semibold text-orange-600 hover:text-orange-700">
            ← Back to Products
        </a>

        <h1 class="mt-4 text-3xl font-extrabold text-gray-900">
            Edit Product
        </h1>

        <p class="mt-2 text-gray-600">
            Update the product information, stock, price, or image.
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

    <form
        action="{{ route('admin.products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8"
    >
        @csrf
        @method('PUT')

        {{-- Product name --}}
        <div>
            <label for="name" class="mb-2 block font-semibold text-gray-800">
                Product Name <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $product->name) }}"
                maxlength="150"
                required
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
                        @selected(old('category_id', $product->category_id) == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

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
                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200"
            >{{ old('description', $product->description) }}</textarea>

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
                    value="{{ old('price', $product->price) }}"
                    min="0"
                    step="0.01"
                    required
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
                    value="{{ old('stock_quantity', $product->stock_quantity) }}"
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

        {{-- Existing image --}}
        <div>
            <label class="mb-3 block font-semibold text-gray-800">
                Current Product Image
            </label>

            @if ($product->image_path)
                <img
                    src="{{ asset('storage/' . $product->image_path) }}"
                    alt="{{ $product->name }}"
                    class="mb-4 h-48 w-48 rounded-xl border border-gray-200 object-cover"
                >
            @else
                <div class="mb-4 flex h-40 w-40 items-center justify-center rounded-xl bg-gray-100 text-5xl">
                    🎸
                </div>

                <p class="mb-4 text-sm text-gray-500">
                    No image has been uploaded for this product yet.
                </p>
            @endif
        </div>

        {{-- Replace image --}}
        <div>
            <label for="image" class="mb-2 block font-semibold text-gray-800">
                Replace Product Image
            </label>

            <input
                type="file"
                id="image"
                name="image"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 file:mr-4 file:rounded-lg file:border-0 file:bg-orange-100 file:px-4 file:py-2 file:font-semibold file:text-orange-700"
            >

            <p class="mt-2 text-sm text-gray-500">
                Leave this field empty to keep the current image.
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
                    @checked((string) old('is_active', (int) $product->is_active) === '1')
                    class="h-5 w-5 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                >

                <span>
                    <span class="block font-semibold text-gray-900">
                        Active Product
                    </span>

                    <span class="mt-1 block text-sm text-gray-500">
                        Uncheck this option to hide the product from the public store.
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
                Update Product
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
