<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Product;

class PackageController extends Controller
{
    public function detail(Package $package)
    {
        $package->load(['products.pricing', 'pricing', 'type']);

        $inPackageIds = $package->products->pluck('id')->filter()->values()->all();

        $frequentlyBoughtProducts = Product::query()
            ->with('pricing')
            ->when(count($inPackageIds) > 0, fn ($q) => $q->whereNotIn('id', $inPackageIds))
            ->inRandomOrder()
            ->limit(4)
            ->get();

        if ($frequentlyBoughtProducts->count() < 4) {
            $existingIds = $frequentlyBoughtProducts->pluck('id')->all();
            $more = Product::query()
                ->with('pricing')
                ->whereNotIn('id', $existingIds)
                ->inRandomOrder()
                ->limit(4 - $frequentlyBoughtProducts->count())
                ->get();
            $frequentlyBoughtProducts = $frequentlyBoughtProducts->concat($more);
        }

        return view('detail-package', compact('package', 'frequentlyBoughtProducts'));
    }
}
