@extends('layouts.app')

@section('title', 'Customer Login | Audio Master Music Store')

@section('content')

<div class="mx-auto max-w-lg">

    <div class="mb-8 text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">
            Welcome Back
        </h1>

        <p class="mt-3 text-gray-600">
            Log in to manage your music store bookings.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('login.store') }}"
        method="POST"
        class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm md:p-8"
    >
        @csrf

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
                autofocus
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
                autocomplete="current-password"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
            >
        </div>

        <div class="flex items-center gap-2">
            <input
                type="checkbox"
                id="remember"
                name="remember"
                value="1"
                class="rounded border-gray-300 text-orange-500 focus:ring-orange-500"
            >

            <label for="remember" class="text-sm text-gray-600">
                Remember me
            </label>
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-gray-900 px-6 py-3 font-bold text-white transition hover:bg-orange-500"
        >
            Log In
        </button>

        <p class="text-center text-sm text-gray-600">
            Don't have an account?

            <a
                href="{{ route('register') }}"
                class="font-semibold text-orange-600 hover:text-orange-700"
            >
                Create one
            </a>
        </p>

    </form>

</div>

@endsection