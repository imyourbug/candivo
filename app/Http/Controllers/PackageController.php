<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageController extends Controller
{
    public function detail(Package $package)
    {
        $package->load(['products.pricing', 'pricing', 'type']);

        return view('detail-package', compact('package'));
    }
}
