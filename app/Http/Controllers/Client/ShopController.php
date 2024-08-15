<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $perPage = 9;
        $categories = DB::table('categories')
            ->select('categories.*', DB::raw('COUNT(products.id) as total_product'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->where('categories.status', 1)
            ->groupBy('categories.id')
            ->orderByDesc('categories.id')->get();
        $query = DB::table('products');
        $category_id = $request->category_id;
        if ($category_id) {
            $query->where('category_id', $category_id);
        }
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        if ($minPrice == true) {
            $query->orderBy('price_sale', 'ASC');
        }
        if ($maxPrice == true) {
            $query->orderByDesc('price_sale');
        }
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');
        if ($min_price && $max_price) {
            $query->whereBetween('price_sale', [$min_price, $max_price]);
        }
        $products = $query->paginate($perPage);
        return view('client.shop', compact('categories', 'products', 'category_id','min_price','max_price','minPrice', 'maxPrice'));
    }
}
