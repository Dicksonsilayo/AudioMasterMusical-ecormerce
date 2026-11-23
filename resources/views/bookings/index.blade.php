<x-layout title="My Bookings - Audio Master Music">

    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page heading --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        My Bookings
                    </h1>

                    <p class="text-gray-600 mt-2">
                        Track your musical instrument bookings and their status.
                    </p>
                </div>

                <a href="{{ route('store.index') }}"
                   class="inline-flex items-center justify-center px-5 py-3
                          rounded-lg bg-orange-600 text-white font-semibold
                          hover:bg-orange-700 transition">

                    Browse Instruments
                </a>

            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error messages --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Booking summary --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Total Bookings</p>

                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $bookings->total() }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Pending</p>

                    <p class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ $bookings->getCollection()->where('status', 'pending')->count() }}
                    </p>

                    <p class="text-xs text-gray-500 mt-2">
                        On this page
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Confirmed</p>

                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $bookings->getCollection()->where('status', 'confirmed')->count() }}
                    </p>

                    <p class="text-xs text-gray-500 mt-2">
                        On this page
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500">Completed</p>

                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $bookings->getCollection()->where('status', 'completed')->count() }}
                    </p>

                    <p class="text-xs text-gray-500 mt-2">
                        On this page
                    </p>
                </div>

            </div>

            {{-- Booking list --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">
                        Booking History
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Review your recent and previous bookings.
                    </p>
                </div>

                @if ($bookings->isEmpty())

                    {{-- Empty state --}}
                    <div class="px-6 py-16 text-center">

                        <div class="text-5xl mb-4">
                            🎸
                        </div>

                        <h3 class="text-xl font-semibold text-gray-900">
                            You have no bookings yet
                        </h3>

                        <p class="text-gray-600 mt-2 mb-6">
                            Explore our musical instruments and submit your first booking.
                        </p>

                        <a href="{{ route('store.index') }}"
                           class="inline-flex items-center justify-center
                                  px-6 py-3 rounded-lg bg-orange-600
                                  text-white font-semibold hover:bg-orange-700">

                            Browse Instruments
                        </a>

                    </div>

                @else

                    {{-- Desktop table --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Booking Reference
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Products
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Total Amount
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Booking Date
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">
                                        Action
                                    </th>
                                </tr>

                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @foreach ($bookings as $booking)

                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'completed' => 'bg-blue-100 text-blue-800',
                                        ];

                                        $badgeClass = $statusClasses[$booking->status]
                                            ?? 'bg-gray-100 text-gray-800';
                                    @endphp

                                    <tr class="hover:bg-gray-50">

                                        {{-- Reference --}}
                                        <td class="px-6 py-5 whitespace-nowrap">

                                            <p class="font-semibold text-gray-900">
                                                {{ $booking->reference }}
                                            </p>

                                            <p class="text-xs text-gray-500 mt-1">
                                                Booking ID: {{ $booking->id }}
                                            </p>

                                        </td>

                                        {{-- Product count --}}
                                        <td class="px-6 py-5 whitespace-nowrap">

                                            <span class="text-gray-900 font-medium">
                                                {{ $booking->items->sum('quantity') }}
                                            </span>

                                            <span class="text-gray-500 text-sm">
                                                item(s)
                                            </span>

                                        </td>

                                        {{-- Total --}}
                                        <td class="px-6 py-5 whitespace-nowrap">

                                            <span class="font-semibold text-gray-900">
                                                TZS {{ number_format((float) $booking->total_amount, 2) }}
                                            </span>

                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-5 whitespace-nowrap">

                                            <span class="inline-flex items-center px-3 py-1
                                                         rounded-full text-xs font-semibold
                                                         {{ $badgeClass }}">

                                                {{ ucfirst($booking->status) }}

                                            </span>

                                        </td>

                                        {{-- Date --}}
                                        <td class="px-6 py-5 whitespace-nowrap">

                                            <p class="text-gray-900">
                                                {{ $booking->created_at->format('d M Y') }}
                                            </p>

                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $booking->created_at->format('h:i A') }}
                                            </p>

                                        </td>

                                        {{-- Details button --}}
                                        <td class="px-6 py-5 whitespace-nowrap text-right">

                                            <a href="{{ route('bookings.show', $booking->reference) }}"
                                               class="inline-flex items-center justify-center
                                                      px-4 py-2 rounded-lg border border-orange-600
                                                      text-orange-600 font-semibold text-sm
                                                      hover:bg-orange-600 hover:text-white transition">

                                                View Details
                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    {{-- Pagination --}}
                    @if ($bookings->hasPages())

                        <div class="px-6 py-5 border-t border-gray-200">
                            {{ $bookings->links() }}
                        </div>

                    @endif

                @endif

            </div>

            {{-- Booking status guide --}}
            <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">

                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    Understanding Booking Statuses
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full
                                     text-xs font-semibold bg-yellow-100 text-yellow-800">
                            Pending
                        </span>

                        <p class="text-sm text-gray-600 mt-2">
                            Your booking is awaiting review.
                        </p>
                    </div>

                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full
                                     text-xs font-semibold bg-green-100 text-green-800">
                            Confirmed
                        </span>

                        <p class="text-sm text-gray-600 mt-2">
                            Your booking has been accepted.
                        </p>
                    </div>

                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full
                                     text-xs font-semibold bg-red-100 text-red-800">
                            Rejected
                        </span>

                        <p class="text-sm text-gray-600 mt-2">
                            Your booking was not accepted.
                        </p>
                    </div>

                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full
                                     text-xs font-semibold bg-blue-100 text-blue-800">
                            Completed
                        </span>

                        <p class="text-sm text-gray-600 mt-2">
                            Your booking process is complete.
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-layout>