<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request,$id)
    {
        $userId = $request->user()->id;
        $productId = $id;
        $quantity = $request->input('quantity');

        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return response()->json($cart->load('items.product'), 200);
    }

    public function removeFromCart(Request $request)
    {
        $userId = $request->user()->id;
        $productId = $request->input('product_id');

        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json($cart->load('items.product'), 200);
    }

    public function getCart(Request $request)
    {
        $userId = $request->user()->id;

        $cart = Cart::where('user_id', $userId)->with('items.product')->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty'], 200);
        }

        return response()->json($cart, 200);
    }
}
