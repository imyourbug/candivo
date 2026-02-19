<?php

namespace App\Http\Controllers;

use App\Constants\GlobalConstant;
use App\Models\Package;
use App\Models\Product;
use App\Models\Type;

class HomeController extends Controller
{
    public function index()
    {
        // $tools = Product::whereNotNull('category_id')->get();
        $allTypes = Type::with(['packages.products.pricing', 'categories.products.pricing'])
            ->get();

        return view('home', compact('allTypes'));
    }

    public function about()
    {
        return view('about', []);
    }
}
