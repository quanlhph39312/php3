<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = session()->get('cart', []);
        return view('client.cart', compact('carts'));
    }

    public function store(Request $request)
    {
        $productId = $request->input('id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }

        $cart = session()->get('cart', []);
        $maxQuantity = 5;

        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] < $maxQuantity) {
                $cart[$productId]['quantity']++;
            } else {
                return response()->json(['error' => '1 sản phẩm chỉ được thêm tối đa 5 lần'], 400);
            }
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price_sale ?: $product->price_regular,
                "image" => $product->image_thumbnail
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'totalProducts' => count($cart)
        ]);
    }


    public function update(Request $request)
    {
        $productId = $request->input('id');
        $action = $request->input('action');

        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json(['error' => 'Sản phẩm không tồn tại trong giỏ hàng'], 404);
        }
        $quantity = $cart[$productId]['quantity'];

        if ($action === 'increase') {
            if ($quantity < 5) {
                $cart[$productId]['quantity']++;
            } else {
                return response()->json([
                    'error' => 'Sản phẩm chỉ được thêm tối đa 5 lần',
                ], 400);
            }
        } elseif ($action === 'decrease' && $quantity > 1) {
            $cart[$productId]['quantity']--;
        }
        $carts = session()->put('cart', $cart);

        return response()->json([
            'new_quantity' => $cart[$productId]['quantity'],
            'new_total_price' => $cart[$productId]['quantity'] * $cart[$productId]['price'],
        ]);
    }


    public function remove(Request $request)
    {
        $productId = $request->id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        $cartCount = count($cart);

        return response()->json([
            'cart_count' => $cartCount,
        ]);
    }

    public function cartSummary()
    {
        $carts = session()->get('cart', []);
        $subtotal = 0;

        foreach ($carts as $product) {
            $subtotal += $product['price'] * $product['quantity'];
        }

        $shipping = 10;
        $total = $subtotal + $shipping;

        return view('cart', [
            'carts' => $carts,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
        ]);
    }
}
