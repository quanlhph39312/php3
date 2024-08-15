<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalProduct = Product::query()->where('status', 1)->count();
        $totalViews = Product::query()->sum('view');
        $totalUsers = User::query()->where('role', 'user')->count();
        $totalCategories = Category::query()->where('status', 1)->count();
        return view('admin.dashboard', compact('totalProduct', 'totalViews', 'totalCategories', 'totalUsers'));
    }
}
