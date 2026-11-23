<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);

        $products = Product::with('category')
            ->whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $cartItems = collect($cart)
            ->map(function ($quantity, $productId) use ($products) {
                $product = $products->get((int) $productId);

                if (!$product) {
                    return null;
                }

                $quantity = (int) $quantity;

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => (float) $product->price * $quantity,
                ];
            })
            ->filter()
            ->values();

        // Remove products that are no longer active or available.
        session()->put(
            'cart',
            $cartItems->mapWithKeys(fn ($item) => [
                $item['product']->id => $item['quantity'],
            ])->all()
        );

        $total = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the shopping cart.
     */
    public function add(Request $request, string $slug): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $cart = session()->get('cart', []);

        $productId = $product->id;

        $currentQuantity = (int) ($cart[$productId] ?? 0);
        $newQuantity = $currentQuantity + (int) $validated['quantity'];

        if ($newQuantity > $product->stock_quantity) {
            return back()
                ->withErrors([
                    'quantity' => 'Only ' . $product->stock_quantity
                        . ' item(s) are currently available.',
                ])
                ->withInput();
        }

        $cart[$productId] = $newQuantity;

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', $product->name . ' has been added to your cart.');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, int $productId): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::where('id', $productId)
            ->where('is_active', true)
            ->firstOrFail();

        $quantity = (int) $validated['quantity'];

        if ($quantity > $product->stock_quantity) {
            return back()->withErrors([
                'quantity' => 'Only ' . $product->stock_quantity
                    . ' item(s) are currently available for '
                    . $product->name . '.',
            ]);
        }

        $cart = session()->get('cart', []);

        if (!array_key_exists($productId, $cart)) {
            return redirect()->route('cart.index');
        }

        $cart[$productId] = $quantity;

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart quantity updated successfully.');
    }

    /**
     * Remove a product from the shopping cart.
     */
    public function remove(int $productId): RedirectResponse
    {
        $cart = session()->get('cart', []);

        unset($cart[$productId]);

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product removed from your cart.');
    }
}