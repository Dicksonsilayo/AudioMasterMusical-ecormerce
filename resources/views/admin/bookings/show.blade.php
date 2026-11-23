
<x-layout title="Admin - Booking Details">

    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        {{-- Page header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-sm text-gray-500 mb-1">
                    Admin / Bookings / Details
                </p>

                <h1 class="text-3xl font-bold text-gray-900">
                    Booking Details
                </h1>

                <p class="text-gray-600 mt-2">
                    Reference:
                    <span class="font-semibold text-gray-900">
                        {{ $booking->reference }}
                    </span>
                </p>
            </div>

            <a href="{{ route('admin.bookings.index') }}"
               class="inline-flex justify-center items-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100">
                &larr; Back to Bookings
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800">
                <p class="font-semibold mb-2">
                    Please correct the following:
                </p>

                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

        {{-- Booking summary --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500 mb-2">
                    Booking Status
                </p>

                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500 mb-2">
                    Total Amount
                </p>

                <p class="text-2xl font-bold text-gray-900">
                    TZS {{ number_format((float) $booking->total_amount, 2) }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500 mb-2">
                    Booking Date
                </p>

                <p class="font-semibold text-gray-900">
                    {{ $booking->created_at?->format('d M Y, H:i') ?? 'Not available' }}
                </p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main content --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Customer information --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Customer Information
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <p class="text-sm text-gray-500">
                                Full Name
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $booking->user?->name ?? 'Unknown customer' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Email Address
                            </p>

                            <p class="font-semibold text-gray-900 mt-1 break-words">
                                {{ $booking->user?->email ?? 'Not available' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Phone Number
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $booking->user?->phone ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Customer ID
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $booking->user_id }}
                            </p>
                        </div>

                    </div>
                </section>

                {{-- Products --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Booked Products
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Product
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                        Unit Price
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-gray-500">
                                        Quantity
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @forelse ($booking->items as $item)
                                    <tr>
                                        <td class="px-4 py-4">
                                            <p class="font-medium text-gray-900">
                                                {{ $item->product?->name ?? 'Product unavailable' }}
                                            </p>
                                        </td>

                                        <td class="px-4 py-4 text-right whitespace-nowrap">
                                            TZS {{ number_format((float) $item->unit_price, 2) }}
                                        </td>

                                        <td class="px-4 py-4 text-center">
                                            {{ $item->quantity }}
                                        </td>

                                        <td class="px-4 py-4 text-right font-semibold whitespace-nowrap">
                                            TZS {{ number_format((float) $item->subtotal, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                            No products were found for this booking.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-900">
                                        Total
                                    </td>

                                    <td class="px-4 py-4 text-right font-bold text-gray-900 whitespace-nowrap">
                                        TZS {{ number_format((float) $booking->total_amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </section>

                {{-- Customer notes --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        Customer Notes
                    </h2>

                    @if ($booking->customer_notes)
                        <p class="text-gray-700 whitespace-pre-line">{{ $booking->customer_notes }}</p>
                    @else
                        <p class="text-gray-500 italic">
                            The customer did not provide any notes.
                        </p>
                    @endif
                </section>

                {{-- Administrator notes --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        Administrator Notes
                    </h2>

                    @if ($booking->admin_notes)
                        <p class="text-gray-700 whitespace-pre-line">{{ $booking->admin_notes }}</p>
                    @else
                        <p class="text-gray-500 italic">
                            No administrator notes have been recorded.
                        </p>
                    @endif
                </section>

                {{-- Status history --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">
                        Booking Status History
                    </h2>

                    @forelse ($booking->statusHistories->sortByDesc('created_at') as $history)
                        <div class="border-l-2 border-gray-200 pl-4 pb-6 last:pb-0 mb-2">

                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold text-gray-900">
                                    {{ ucfirst($history->old_status ?? 'Created') }}
                                </span>

                                <span class="text-gray-400">&rarr;</span>

                                <span class="font-semibold text-gray-900">
                                    {{ ucfirst($history->new_status) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $history->created_at?->format('d M Y, H:i') ?? 'Time unavailable' }}
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                Changed by:
                                <span class="font-medium">
                                    {{ $history->changedBy?->name ?? 'System or deleted user' }}
                                </span>
                            </p>

                            @if ($history->notes)
                                <p class="mt-2 text-sm text-gray-700 whitespace-pre-line">
                                    {{ $history->notes }}
                                </p>
                            @endif

                        </div>
                    @empty
                        <p class="text-gray-500 italic">
                            No status history is available for this booking.
                        </p>
                    @endforelse
                </section>

            </div>

            {{-- Status management sidebar --}}
            <aside class="space-y-6">

                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        Manage Booking
                    </h2>

                    <p class="text-sm text-gray-600 mb-5">
                        Update the booking status and record an administrative note.
                    </p>

                    @if (in_array($booking->status, ['pending', 'confirmed'], true))

                        <form action="{{ route('admin.bookings.update-status', $booking->reference) }}"
                              method="POST"
                              class="space-y-5">

                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    New Status
                                </label>

                                <select name="status"
                                        id="status"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">

                                    @if ($booking->status === 'pending')
                                        <option value="confirmed" @selected(old('status') === 'confirmed')>
                                            Confirm Booking
                                        </option>

                                        <option value="rejected" @selected(old('status') === 'rejected')>
                                            Reject Booking
                                        </option>
                                    @elseif ($booking->status === 'confirmed')
                                        <option value="completed" @selected(old('status') === 'completed')>
                                            Mark as Completed
                                        </option>
                                    @endif

                                </select>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Administrator Note
                                </label>

                                <textarea name="notes"
                                          id="notes"
                                          rows="4"
                                          maxlength="2000"
                                          placeholder="Enter the reason for this status change..."
                                          class="w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">{{ old('notes') }}</textarea>

                                <p class="text-xs text-gray-500 mt-1">
                                    Maximum 2,000 characters.
                                </p>
                            </div>

                            <button type="submit"
                                    class="w-full rounded-lg bg-orange-600 px-5 py-3 font-semibold text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">
                                Update Booking
                            </button>

                        </form>

                    @else

                        <div class="rounded-lg bg-gray-50 border border-gray-200 p-4">
                            <p class="font-semibold text-gray-800">
                                This booking is {{ $booking->status }}.
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                No further status changes are available.
                            </p>
                        </div>

                    @endif

                </section>

                {{-- Timestamps --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                        Important Dates
                    </h2>

                    <div class="space-y-4">

                        <div>
                            <p class="text-sm text-gray-500">
                                Created
                            </p>

                            <p class="text-sm font-medium text-gray-900 mt-1">
                                {{ $booking->created_at?->format('d M Y, H:i') ?? 'Not available' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Confirmed
                            </p>

                            <p class="text-sm font-medium text-gray-900 mt-1">
                                {{ $booking->confirmed_at?->format('d M Y, H:i') ?? 'Not confirmed' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Completed
                            </p>

                            <p class="text-sm font-medium text-gray-900 mt-1">
                                {{ $booking->completed_at?->format('d M Y, H:i') ?? 'Not completed' }}
                            </p>
                        </div>

                    </div>
                </section>

            </aside>

        </div>

    </div>

</x-layout>
