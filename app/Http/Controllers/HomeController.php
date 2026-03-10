<?php

namespace App\Http\Controllers;

use App\Constants\GlobalConstant;
use App\Models\Type;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', GlobalConstant::TYPE_PACKAGE);
        // $tools = Product::whereNotNull('category_id')->get();
        $allTypes = Type::with(['packages.products.pricing', 'categories.products.pricing'])
            ->get()
            ->sortBy(function ($type) {
                return $type->name === GlobalConstant::TYPE_CORE_FREE ? 1 : 0;
            })
            ->values();

        return view('home', compact('allTypes', 'tab'));
    }

    public function about()
    {
        return view('about', []);
    }
}
