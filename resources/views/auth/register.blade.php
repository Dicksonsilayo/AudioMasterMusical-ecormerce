@extends('layouts.app')

@section('title', 'Create Account | Audio Master Music Store')

@section('content')

<div class="mx-auto max-w-xl">

    <div class="mb-8 text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">
            Create Your Account
        </h1>

        <p class="mt-3 text-gray-600">
            Register to book your favourite musical equipment.
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

    <form
        action="{{ route('register.store') }}"
        method="POST"
        class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm md:p-8"
    >
        @csrf

        <div>
            <label for="name" class="mb-2 block font-semibold text-gray-700">
                Full Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autocomplete="name"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
            >
        </div>

        <div>
            <label for="email" class="mb-2 block font-semibold text-gray-700">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
            >
        </div>

        <div>
            <label for="phone" class="mb-2 block font-semibold text-gray-700">
                Phone Number (Optional)
            </label>

            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                autocomplete="tel"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
            >
        </div>

        <div>
            <label for="password" class="mb-2 block font-semibold text-gray-700">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
                minlength="8"
                autocomplete="new-password"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
            >

            <p class="mt-1 text-sm text-gray-500">
                Use at least 8 characters.
            </p>
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block font-semibold text-gray-700">
                Confirm Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                minlength="8"
                autocomplete="new-password"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-orange-500 px-6 py-3 font-bold text-white transition hover:bg-orange-600"
        >
            Create Account
        </button>

        <p class="text-center text-sm text-gray-600">
            Already have an account?

            <a
                href="{{ route('login') }}"
                class="font-semibold text-orange-600 hover:text-orange-700"
            >
                Log in
            </a>
        </p>

    </form>

</div>

@endsection

