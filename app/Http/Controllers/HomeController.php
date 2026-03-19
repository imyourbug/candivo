<?php

namespace App\Http\Controllers;

use App\Constants\GlobalConstant;
use App\Models\Post;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', GlobalConstant::TYPE_PACKAGE);
        $allTypes = Type::with(['packages.products.pricing', 'categories.products.pricing'])
            ->get()
            ->sortBy(function ($type) {
                return $type->name === GlobalConstant::TYPE_CORE_FREE ? 1 : 0;
            })
            ->values();
        $allTools = Product::with('pricing')->get();

        $homePosts = Post::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        $homePostsCommunity = $homePosts->take(3);
        $homePostsStories = $homePosts->slice(3, 3)->values();

        return view('home', compact(
            'allTypes',
            'tab',
            'allTools',
            'homePostsCommunity',
            'homePostsStories'
        ));
    }

    public function about()
    {
        return view('about', []);
    }
}
