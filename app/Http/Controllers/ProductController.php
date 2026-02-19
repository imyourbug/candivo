<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function detail(Product $product)
    {
        return view('detail-product', compact('product'));
    }
}
