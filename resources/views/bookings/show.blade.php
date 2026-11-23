<x-layout title="Booking Details - Audio Master Music">

    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Navigation --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Booking Details
                    </h1>

                    <p class="text-gray-600 mt-2">
                        Review your order and track its progress.
                    </p>
                </div>

                <a href="{{ route('bookings.index') }}"
                   class="px-5 py-3 rounded-lg border border-gray-300
                          text-gray-700 font-semibold hover:bg-gray-100">
                    ← Back to My Bookings
                </a>
            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200
                            bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Booking reference and status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200
                        p-6 mb-6">

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

                <div class="flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-5">

                    <div>
                        <p class="text-sm text-gray-500">
                            Booking Reference
                        </p>

                        <h2 class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $booking->reference }}
                        </h2>

                        <p class="text-sm text-gray-500 mt-2">
                            Submitted on
                            {{ $booking->created_at->format('d M Y, h:i A') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-2">
                            Current Status
                        </p>

                        <span class="inline-flex rounded-full px-4 py-2
                                     text-sm font-semibold {{ $badgeClass }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- Rejection notice --}}
            @if ($booking->status === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-xl
                            p-5 mb-6">

                    <h3 class="font-bold text-red-800">
                        Booking Not Accepted
                    </h3>

                    <p class="text-sm text-red-700 mt-2">
                        Unfortunately, this booking was rejected.
                        Please review the booking history below for any
                        information provided by the store administrator.
                    </p>

                </div>
            @endif

            {{-- Completed notice --}}
            @if ($booking->status === 'completed')
                <div class="bg-blue-50 border border-blue-200 rounded-xl
                            p-5 mb-6">

                    <h3 class="font-bold text-blue-800">
                        Booking Completed
                    </h3>

                    <p class="text-sm text-blue-700 mt-2">
                        This booking has been marked as completed.
                        Thank you for choosing Audio Master Music.
                    </p>

                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main column --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Products --}}
                    <div class="bg-white rounded-xl shadow-sm
                                border border-gray-200 overflow-hidden">

                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900">
                                Booked Instruments
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Products included in this booking.
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">

                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left
                                                   text-xs font-semibold
                                                   text-gray-500 uppercase">
                                            Product
                                        </th>

                                        <th class="px-6 py-4 text-right
                                                   text-xs font-semibold
                                                   text-gray-500 uppercase">
                                            Unit Price
                                        </th>

                                        <th class="px-6 py-4 text-center
                                                   text-xs font-semibold
                                                   text-gray-500 uppercase">
                                            Quantity
                                        </th>

                                        <th class="px-6 py-4 text-right
                                                   text-xs font-semibold
                                                   text-gray-500 uppercase">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">

                                    @forelse ($booking->items as $item)
                                        <tr>
                                            <td class="px-6 py-5">
                                                <p class="font-semibold
                                                          text-gray-900">
                                                    {{ $item->product?->name
                                                        ?? 'Product no longer available' }}
                                                </p>
                                            </td>

                                            <td class="px-6 py-5 text-right
                                                       whitespace-nowrap">
                                                TZS {{ number_format(
                                                    (float) $item->unit_price, 2
                                                ) }}
                                            </td>

                                            <td class="px-6 py-5 text-center">
                                                {{ $item->quantity }}
                                            </td>

                                            <td class="px-6 py-5 text-right
                                                       whitespace-nowrap
                                                       font-semibold">
                                                TZS {{ number_format(
                                                    (float) $item->subtotal, 2
                                                ) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-6 py-8 text-center
                                                       text-gray-500">
                                                No booking items were found.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>

                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-5 text-right
                                                   font-bold text-gray-900">
                                            Booking Total
                                        </td>

                                        <td class="px-6 py-5 text-right
                                                   font-bold text-orange-600
                                                   whitespace-nowrap">
                                            TZS {{ number_format(
                                                (float) $booking->total_amount, 2
                                            ) }}
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>

                    </div>

                    {{-- Customer notes --}}
                    <div class="bg-white rounded-xl shadow-sm
                                border border-gray-200 p-6">

                        <h2 class="text-xl font-bold text-gray-900">
                            Your Notes
                        </h2>

                        @if ($booking->customer_notes)
                            <p class="mt-3 text-gray-700 whitespace-pre-line">
                                {{ $booking->customer_notes }}
                            </p>
                        @else
                            <p class="mt-3 text-gray-500">
                                You did not provide any additional notes.
                            </p>
                        @endif

                    </div>

                    {{-- Booking history --}}
                    <div class="bg-white rounded-xl shadow-sm
                                border border-gray-200 p-6">

                        <h2 class="text-xl font-bold text-gray-900">
                            Booking Status History
                        </h2>

                        <p class="text-sm text-gray-500 mt-1 mb-6">
                            Follow the recorded changes to your booking.
                        </p>

                        @forelse (
                            $booking->statusHistories->sortByDesc('created_at')
                            as $history
                        )
                            @php
                                $historyStatusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                ];

                                $historyBadge = $historyStatusClasses[
                                    $history->new_status
                                ] ?? 'bg-gray-100 text-gray-800';
                            @endphp

                            <div class="relative pl-7 pb-7
                                        border-l-2 border-gray-200 last:border-0
                                        last:pb-0">

                                <div class="absolute -left-2 top-1
                                            w-4 h-4 rounded-full
                                            border-2 border-white
                                            bg-orange-500">
                                </div>

                                <div class="flex flex-wrap items-center gap-3">

                                    @if ($history->old_status)
                                        <span class="text-sm text-gray-500">
                                            {{ ucfirst($history->old_status) }}
                                        </span>

                                        <span class="text-gray-400">→</span>
                                    @endif

                                    <span class="inline-flex rounded-full px-3 py-1
                                                 text-xs font-semibold
                                                 {{ $historyBadge }}">
                                        {{ ucfirst($history->new_status) }}
                                    </span>

                                </div>

                                <p class="text-sm text-gray-500 mt-2">
                                    {{ $history->created_at->format(
                                        'd M Y, h:i A'
                                    ) }}
                                </p>

                                @if ($history->notes)
                                    <p class="text-gray-700 mt-2 whitespace-pre-line">
                                        {{ $history->notes }}
                                    </p>
                                @endif

                            </div>

                        @empty
                            <p class="text-gray-500">
                                No status history is available yet.
                            </p>
                        @endforelse

                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Current status information --}}
                    <div class="bg-white rounded-xl shadow-sm
                                border border-gray-200 p-6">

                        <h2 class="text-lg font-bold text-gray-900">
                            What Happens Next?
                        </h2>

                        @if ($booking->status === 'pending')
                            <p class="text-gray-600 text-sm mt-3">
                                Your booking is waiting for the store
                                administrator to review it.
                            </p>

                        @elseif ($booking->status === 'confirmed')
                            <p class="text-gray-600 text-sm mt-3">
                                Your booking has been confirmed.
                                Follow any instructions provided by the store.
                            </p>

                        @elseif ($booking->status === 'rejected')
                            <p class="text-gray-600 text-sm mt-3">
                                This booking has been rejected.
                                Contact the store if you need clarification.
                            </p>

                        @elseif ($booking->status === 'completed')
                            <p class="text-gray-600 text-sm mt-3">
                                Your booking is marked as completed.
                                Thank you for your business.
                            </p>
                        @endif

                    </div>

                    {{-- Important dates --}}
                    <div class="bg-white rounded-xl shadow-sm
                                border border-gray-200 p-6">

                        <h2 class="text-lg font-bold text-gray-900 mb-4">
                            Important Dates
                        </h2>

                        <div class="space-y-4">

                            <div>
                                <p class="text-xs text-gray-500 uppercase">
                                    Submitted
                                </p>

                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    {{ $booking->created_at->format(
                                        'd M Y, h:i A'
                                    ) }}
                                </p>
                            </div>

                            @if ($booking->confirmed_at)
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">
                                        Confirmed
                                    </p>

                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                        {{ $booking->confirmed_at->format(
                                            'd M Y, h:i A'
                                        ) }}
                                    </p>
                                </div>
                            @endif

                            @if ($booking->completed_at)
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">
                                        Completed
                                    </p>

                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                        {{ $booking->completed_at->format(
                                            'd M Y, h:i A'
                                        ) }}
                                    </p>
                                </div>
                            @endif

                        </div>

                    </div>

                    {{-- Navigation --}}
                    <div class="bg-orange-50 rounded-xl
                                border border-orange-200 p-6">

                        <h2 class="text-lg font-bold text-gray-900">
                            Need Another Instrument?
                        </h2>

                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Explore our available instruments and submit
                            another booking.
                        </p>

                        <a href="{{ route('store.index') }}"
                           class="block text-center px-5 py-3 rounded-lg
                                  bg-orange-600 text-white font-semibold
                                  hover:bg-orange-700">
                            Browse Instruments
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-layout>