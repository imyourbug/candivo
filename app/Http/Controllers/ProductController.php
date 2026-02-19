<?php

namespace App\Http\Controllers;

class ProductController extends Controller
{
    public function detail()
    {
        return view('detail-product', []);
    }
}
