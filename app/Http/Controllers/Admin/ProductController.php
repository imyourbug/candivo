<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $query = Product::query()->with('category');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%")
                    ->orWhere('product_id', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $stats = [
            'active' => Product::where('status', 'active')->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
            'draft' => Product::where('status', 'draft')->count(),
        ];

        return view('admin.product.list', compact('products', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['product_id'] = $validated['product_id'] ?? 'PRD-' . strtoupper(Str::slug($validated['name'], '_'));

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        $slugRule = ['nullable', 'string', 'max:255'];
        if ($product) {
            $slugRule[] = 'unique:products,slug,' . $product->id;
        } else {
            $slugRule[] = 'unique:products,slug';
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => $slugRule,
            'product_id' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:active,inactive,draft'],
            'value_status' => ['nullable', 'string', 'max:255'],
            'is_free' => ['nullable', 'boolean'],
            'is_basic' => ['nullable', 'integer', 'in:0,1'],
            'is_professional' => ['nullable', 'integer', 'in:0,1'],
            'is_premium' => ['nullable', 'integer', 'in:0,1'],
            'duration_1' => ['nullable', 'integer', 'min:0'],
            'price_duration_1' => ['nullable', 'numeric', 'min:0'],
            'duration_2' => ['nullable', 'integer', 'min:0'],
            'price_duration_2' => ['nullable', 'numeric', 'min:0'],
            'duration_3' => ['nullable', 'integer', 'min:0'],
            'price_duration_3' => ['nullable', 'numeric', 'min:0'],
            'avatar' => ['nullable', 'string'],
            'video' => ['nullable', 'string'],
            'images' => ['nullable', 'string'],
            'cat_set' => ['nullable', 'string', 'max:255'],
            'stand_set' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Product name is required.',
            'slug.unique' => 'This URL slug is already in use.',
            'status.required' => 'Please select a status.',
        ]);
    }
}
