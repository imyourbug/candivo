<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageController extends Controller
{
    public function detail(Package $package)
    {
        $item = 'https://res.cloudinary.com/dkjfmxxom/image/upload/v1765015546/main_m50fl1.png';
        // dd(str_starts_with($item, '/') ? $item : '/' . $item, str_starts_with($item, '/'));
        $package->load(['products.pricing', 'pricing', 'type']);

        return view('detail-package', compact('package'));
    }
}
