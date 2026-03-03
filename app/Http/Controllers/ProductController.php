<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function detail(Product $product)
    {
        $product->load(['pricing', 'packages.pricing', 'packages.products.pricing', 'category']);

        $includedTools = $product->packages
            ->flatMap(function ($package) use ($product) {
                return $package->products->where('id', '!=', $product->id);
            })
            ->unique('id')
            ->values()
            ->take(8);

        $relatedProducts = Product::with('pricing')
            ->where('id', '!=', $product->id)
            ->when($product->category_id, function ($query) use ($product) {
                $query->where('category_id', $product->category_id);
            })
            ->latest('id')
            ->limit(4)
            ->get();

        if ($relatedProducts->count() < 4) {
            $existingIds = $relatedProducts->pluck('id')->push($product->id)->all();
            $fallback = Product::with('pricing')
                ->whereNotIn('id', $existingIds)
                ->latest('id')
                ->limit(4 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($fallback);
        }

        return view('detail-product', compact('product', 'relatedProducts', 'includedTools'));
    }
}
