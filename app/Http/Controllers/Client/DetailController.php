<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function detail(int $id)
    {
        $product = DB::table('products')->find($id);
        $categoryName = DB::table('categories')
            ->where('id', $product->category_id)
            ->value('name');
        $ProductView = DB::table('products')
            ->orderByDesc('view')
            ->limit(10)->get();
        return view('client.detail', compact('product', 'ProductView', 'categoryName'));
    }
}
