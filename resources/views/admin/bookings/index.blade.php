
<x-layout title="Admin - Manage Bookings">

    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-sm text-gray-500 mb-1">Audio Master Music Store</p>
                <h1 class="text-3xl font-bold text-gray-900">Booking Management</h1>
                <p class="text-gray-600 mt-2">
                    Monitor customer bookings and manage their status.
                </p>
            </div>

            <a href="{{ route('store.index') }}"
               class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-5 py-3 font-semibold text-white hover:bg-orange-700">
                View Store
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation and query errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Statistics --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

            <a href="{{ route('admin.bookings.index') }}"
               class="block rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:border-orange-400">
                <p class="text-sm text-gray-500">All Bookings</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $counts['all'] }}</p>
            </a>

            <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}"
               class="block rounded-xl border border-yellow-200 bg-yellow-50 p-5 hover:border-yellow-400">
                <p class="text-sm text-yellow-800">Pending</p>
                <p class="mt-2 text-3xl font-bold text-yellow-900">{{ $counts['pending'] }}</p>
            </a>

            <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}"
               class="block rounded-xl border border-blue-200 bg-blue-50 p-5 hover:border-blue-400">
                <p class="text-sm text-blue-800">Confirmed</p>
                <p class="mt-2 text-3xl font-bold text-blue-900">{{ $counts['confirmed'] }}</p>
            </a>

            <a href="{{ route('admin.bookings.index', ['status' => 'rejected']) }}"
               class="block rounded-xl border border-red-200 bg-red-50 p-5 hover:border-red-400">
                <p class="text-sm text-red-800">Rejected</p>
                <p class="mt-2 text-3xl font-bold text-red-900">{{ $counts['rejected'] }}</p>
            </a>

            <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}"
               class="block rounded-xl border border-green-200 bg-green-50 p-5 hover:border-green-400">
                <p class="text-sm text-green-800">Completed</p>
                <p class="mt-2 text-3xl font-bold text-green-900">{{ $counts['completed'] }}</p>
            </a>

        </div>

        {{-- Search and filters --}}
        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm mb-6">

            <h2 class="text-lg font-bold text-gray-900 mb-4">
                Find Bookings
            </h2>

            <form action="{{ route('admin.bookings.index') }}"
                  method="GET"
                  class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Search
                    </label>

                    <input type="text"
                           name="search"
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Reference, customer, or email"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Booking Status
                    </label>

                    <select name="status"
                            id="status"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">

                        <option value="">All statuses</option>

                        <option value="pending" @selected(request('status') === 'pending')>
                            Pending
                        </option>

                        <option value="confirmed" @selected(request('status') === 'confirmed')>
                            Confirmed
                        </option>

                        <option value="rejected" @selected(request('status') === 'rejected')>
                            Rejected
                        </option>

                        <option value="completed" @selected(request('status') === 'completed')>
                            Completed
                        </option>

                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit"
                            class="flex-1 rounded-lg bg-gray-900 px-4 py-2.5 font-semibold text-white hover:bg-gray-700">
                        Search
                    </button>

                    <a href="{{ route('admin.bookings.index') }}"
                       class="rounded-lg border border-gray-300 px-4 py-2.5 font-semibold text-gray-700 hover:bg-gray-100">
                        Reset
                    </a>
                </div>

            </form>
        </section>

        {{-- Bookings table --}}
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-5 py-4">
                <h2 class="text-lg font-bold text-gray-900">
                    Booking Records
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Showing {{ $bookings->firstItem() ?? 0 }}
                    to {{ $bookings->lastItem() ?? 0 }}
                    of {{ $bookings->total() }} bookings.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Booking
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Customer
                            </th>

                            <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Items
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Total
                            </th>

                            <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Date
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse ($bookings as $booking)

                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                ];

                                $statusClass = $statusClasses[$booking->status]
                                    ?? 'bg-gray-100 text-gray-800';
                            @endphp

                            <tr class="hover:bg-gray-50">

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-gray-900">
                                        {{ $booking->reference }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        ID: {{ $booking->id }}
                                    </p>
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">
                                        {{ $booking->user?->name ?? 'Unknown customer' }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $booking->user?->email ?? 'No email available' }}
                                    </p>
                                </td>

                                <td class="px-5 py-4 text-center text-gray-700">
                                    {{ $booking->items_count }}
                                </td>

                                <td class="px-5 py-4 text-right font-semibold text-gray-900 whitespace-nowrap">
                                    TZS {{ number_format((float) $booking->total_amount, 2) }}
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    {{ $booking->created_at?->format('d M Y, H:i') ?? 'N/A' }}
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.bookings.show', $booking->reference) }}"
                                       class="inline-flex items-center rounded-lg bg-orange-600 px-3 py-2 text-sm font-semibold text-white hover:bg-orange-700">
                                        View
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center">
                                    <p class="text-lg font-semibold text-gray-800">
                                        No bookings found
                                    </p>

                                    <p class="text-sm text-gray-500 mt-2">
                                        Try changing your search or status filter.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            @if ($bookings->hasPages())
                <div class="border-t border-gray-200 px-5 py-4">
                    {{ $bookings->links() }}
                </div>
            @endif

        </section>

    </div>

</x-layout>
