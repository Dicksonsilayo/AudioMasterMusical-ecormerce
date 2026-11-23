<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    /**
     * Display the store homepage with product search and filters.
     */
   public function index(Request $request): View
{
    $search = trim((string) $request->query('search', ''));
    $categoryId = $request->query('category');
    $availability = $request->query('availability', '');
    $sort = $request->query('sort', 'newest');

    $allowedSorts = ['newest', 'price_asc', 'price_desc'];

    if (!in_array($sort, $allowedSorts, true)) {
        $sort = 'newest';
    }

    $query = Product::with('category')
        ->where('is_active', true);

    // Search by product name, description, or category.
    if ($search !== '') {
        $query->where(function ($builder) use ($search) {
            $builder->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhereHas('category', function ($categoryQuery) use ($search) {
                    $categoryQuery->where('name', 'like', '%' . $search . '%');
                });
        });
    }

    // Filter by category.
    if (
        $categoryId !== null &&
        filter_var($categoryId, FILTER_VALIDATE_INT) !== false &&
        (int) $categoryId > 0
    ) {
        $query->whereHas('category', function ($categoryQuery) use ($categoryId) {
            $categoryQuery->where('categories.id', (int) $categoryId)
                ->where('categories.is_active', true);
        });
    }

    // Filter by stock availability.
    if ($availability === 'in_stock') {
        $query->where('stock_quantity', '>', 0);
    } elseif ($availability === 'out_of_stock') {
        $query->where('stock_quantity', '<=', 0);
    }

    // Apply the selected sorting option.
    switch ($sort) {
        case 'price_asc':
            $query->orderBy('price', 'asc')
                ->orderBy('id', 'desc');
            break;

        case 'price_desc':
            $query->orderBy('price', 'desc')
                ->orderBy('id', 'desc');
            break;

        default:
            $query->latest('created_at')
                ->latest('id');
            break;
    }

    $products = $query->paginate(12)->withQueryString();

    $categories = Category::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('store.index', compact(
        'products',
        'categories',
        'search',
        'categoryId',
        'availability',
        'sort'
    ));
}
    /**
     * Display a single active product.
     */
    public function show(string $slug): View
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('store.show', compact('product'));
    }
}
