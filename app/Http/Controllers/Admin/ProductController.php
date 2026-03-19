<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pricing;
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

        $pricingTiers = $validated['pricing_tiers'] ?? [];
        unset($validated['pricing_tiers']);

        $product = Product::create($validated);
        $this->syncProductPricing($product, $pricingTiers);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $product->load(['pricing']);
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

        $pricingTiers = $validated['pricing_tiers'] ?? [];
        unset($validated['pricing_tiers']);

        $product->update($validated);
        $this->syncProductPricing($product, $pricingTiers);

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
            'pricing_tiers' => ['nullable', 'array'],
            'pricing_tiers.*.duration_months' => ['nullable', 'integer', 'min:0'],
            'pricing_tiers.*.price' => ['nullable', 'numeric', 'min:0'],
            'pricing_tiers.*.currency' => ['nullable', 'string', 'max:10'],
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

    /**
     * Replace product pricing rows and mirror first three tiers onto legacy duration_* columns.
     *
     * @param  array<int, array<string, mixed>>|null  $tiers
     */
    private function syncProductPricing(Product $product, ?array $tiers): void
    {
        $product->pricing()->delete();

        $rows = [];
        foreach ($tiers ?? [] as $row) {
            $months = isset($row['duration_months']) && $row['duration_months'] !== '' && $row['duration_months'] !== null
                ? (int) $row['duration_months']
                : null;
            $priceRaw = $row['price'] ?? null;
            $price = $priceRaw !== null && $priceRaw !== '' ? (float) $priceRaw : null;
            $currency = isset($row['currency']) && is_string($row['currency']) && $row['currency'] !== ''
                ? $row['currency']
                : 'EUR';

            if ($months === null || $months < 0) {
                continue;
            }
            if ($price === null || $price < 0) {
                continue;
            }

            $rows[$months] = [
                'duration_months' => $months,
                'price' => $price,
                'currency' => $currency,
            ];
        }

        $sorted = array_values($rows);
        usort($sorted, fn ($a, $b) => $a['duration_months'] <=> $b['duration_months']);

        foreach ($sorted as $r) {
            Pricing::create([
                'entity_id' => $product->id,
                'entity_type' => 'product',
                'duration_months' => $r['duration_months'],
                'price' => $r['price'],
                'currency' => $r['currency'],
            ]);
        }

        $product->forceFill([
            'duration_1' => $sorted[0]['duration_months'] ?? null,
            'price_duration_1' => isset($sorted[0]) ? $sorted[0]['price'] : null,
            'duration_2' => $sorted[1]['duration_months'] ?? null,
            'price_duration_2' => isset($sorted[1]) ? $sorted[1]['price'] : null,
            'duration_3' => $sorted[2]['duration_months'] ?? null,
            'price_duration_3' => isset($sorted[2]) ? $sorted[2]['price'] : null,
        ])->save();
    }
}
