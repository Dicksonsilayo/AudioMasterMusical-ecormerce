<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display the booking form for a product.
     */
    public function create(string $slug): View
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('bookings.create', compact('product'));
    }

    /**
     * Create a booking and reserve the requested stock.
     */
    public function store(Request $request, string $slug): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'customer_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $booking = DB::transaction(function () use ($validated, $slug) {
            /*
             * Lock the product row while checking and reserving stock.
             * This helps prevent concurrent bookings from overselling.
             */
            $product = Product::where('slug', $slug)
                ->where('is_active', true)
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            if ($product->stock_quantity < $quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'The requested quantity is not available. '
                        . 'Only ' . $product->stock_quantity . ' item(s) remain.',
                ]);
            }

            // Calculate the price using the database value.
            $unitPrice = (float) $product->price;
            $subtotal = round($unitPrice * $quantity, 2);

            // Create the booking.
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'reference' => 'AMB-' . Str::upper(Str::random(12)),
                'status' => 'pending',
                'total_amount' => $subtotal,
                'customer_notes' => $validated['customer_notes'] ?? null,
            ]);

            // Save the booked product.
            $booking->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);

            // Reserve the stock.
            $product->decrement('stock_quantity', $quantity);

            // Record the initial booking status.
            BookingStatusHistory::create([
                'booking_id' => $booking->id,
                'changed_by' => Auth::id(),
                'old_status' => null,
                'new_status' => 'pending',
                'notes' => 'Booking submitted by customer.',
            ]);

            return $booking;
        });

        return redirect()
            ->route('bookings.show', $booking->reference)
            ->with('success', 'Your booking has been submitted successfully.');
    }

    /**
     * Display the authenticated customer's bookings.
     */
    public function index(): View
    {
        $bookings = Booking::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Display one booking belonging to the authenticated customer.
     */
    public function show(string $reference): View
    {
        $booking = Booking::with([
            'items.product',
            'statusHistories.changedBy',
        ])
            ->where('reference', $reference)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('bookings.show', compact('booking'));
    }
}