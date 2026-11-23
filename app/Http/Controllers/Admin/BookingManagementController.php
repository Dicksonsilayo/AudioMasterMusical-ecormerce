<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingManagementController extends Controller
{
    /**
     * Display all bookings with optional search and status filters.
     */
    public function index(Request $request): View
    {
        $query = Booking::with('user')
            ->withCount('items')
            ->latest();

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());

            $query->where(function ($builder) use ($search) {
                $builder->where('reference', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $bookings = $query->paginate(10)->withQueryString();

        $counts = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts'));
    }

    /**
     * Display a booking and its related details.
     */
    public function show(string $reference): View
    {
        $booking = Booking::with([
            'user',
            'items.product',
            'statusHistories.changedBy',
        ])
            ->where('reference', $reference)
            ->firstOrFail();

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Change a booking's status while recording its history.
     */
    public function updateStatus(
        Request $request,
        string $reference
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:confirmed,rejected,completed',
            ],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($validated, $reference) {
            $booking = Booking::where('reference', $reference)
                ->lockForUpdate()
                ->firstOrFail();

            $oldStatus = $booking->status;
            $newStatus = $validated['status'];

            // A booking cannot be changed to its current status.
            if ($oldStatus === $newStatus) {
                throw ValidationException::withMessages([
                    'status' => 'This booking already has that status.',
                ]);
            }

            // Only pending bookings can be confirmed or rejected.
            if (
                $oldStatus !== 'pending'
                && in_array($newStatus, ['confirmed', 'rejected'], true)
            ) {
                throw ValidationException::withMessages([
                    'status' => 'Only pending bookings can be confirmed or rejected.',
                ]);
            }

            // Only confirmed bookings can be completed.
            if ($newStatus === 'completed' && $oldStatus !== 'confirmed') {
                throw ValidationException::withMessages([
                    'status' => 'Only confirmed bookings can be marked as completed.',
                ]);
            }

            // A rejected booking must not be confirmed or completed later.
            if (in_array($oldStatus, ['rejected', 'completed'], true)) {
                throw ValidationException::withMessages([
                    'status' => 'This booking is already in a final status.',
                ]);
            }

            // Rejected pending bookings release their reserved stock.
            if ($newStatus === 'rejected') {
                $booking->load('items');

                foreach ($booking->items as $item) {
                    $product = \App\Models\Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    // A product may have been removed only if database
                    // constraints or other code permit it.
                    if ($product) {
                        $product->increment('stock_quantity', $item->quantity);
                    }
                }
            }

            $booking->status = $newStatus;

            if ($newStatus === 'confirmed') {
                $booking->confirmed_at = now();
            }

            if ($newStatus === 'completed') {
                $booking->completed_at = now();
            }

$booking->admin_notes = $validated['notes'] ?? $booking->admin_notes;

$booking->save();

BookingStatusHistory::create([
    'booking_id' => $booking->id,
    'changed_by' => auth()->id(),
    'old_status' => $oldStatus,
    'new_status' => $newStatus,
    'notes' => $validated['notes'] ?? null,
]);
        });

        return redirect()
            ->route('admin.bookings.show', $reference)
            ->with('success', 'Booking status updated successfully.');
    }
}