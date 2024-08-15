<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class HomeController extends Controller
{
    public function home()
    {
        // Banner
        $topBanners = $this->Banner('top-banner');
        $middleBanners = $this->Banner('middle-banner');
        // Category
        $categories = DB::table('categories')
            ->select('categories.*', DB::raw('COUNT(products.id) as total_product'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->where('categories.status', 1)
            ->groupBy('categories.id')
            ->orderBy('categories.id', 'DESC')->get();
        // Product
        $product_is_show_home = DB::table('products')->where('status', 1)->where('is_show_home', 1)->orderBy('id', 'DESC')->limit(8)->get();
        $product_is_new = DB::table('products')->where('status', 1)->where('is_new', 1)->orderBy('id', 'DESC')->limit(8)->get();
        $product_is_trending = DB::table('products')->where('status', 1)->where('is_trending', 1)->orderBy('id', 'DESC')->limit(8)->get();
        $product_is_sale = DB::table('products')->where('status', 1)->where('is_sale', 1)->orderBy('id', 'DESC')->limit(8)->get();

        return view('client.home', compact('categories', 'product_is_show_home', 'product_is_new', 'product_is_trending', 'product_is_sale', 'topBanners', 'middleBanners'));
    }

    public function Banner($position)
    {
        $banners = DB::table('banners')->where('status', 1)->get();
        $now = Carbon::now();

        foreach ($banners as $banner) {
            if ($now->between($banner->start_date, $banner->end_date)) {
                $banner->is_active = 1;
            } else {
                $banner->is_active = 0;
            }
            DB::table('banners')->where('id', $banner->id)->update(['is_active' => $banner->is_active]);
        }
        $updatedBanners = DB::table('banners')->where('is_active', 1)->where('position', $position)->orderBy('priority')->get();
        return $updatedBanners;
    }
}
