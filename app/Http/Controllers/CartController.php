<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shop()
    {
        $products  = Product::all();
        return view('cart.shop',  compact('products'));
    }

    public function cart()
    {
        //dd(Cart::content());
        return view('cart.cart');
    }

    public  function addToCart(Product $product)
    {
        //$product = Product::findOrFail($productId);
       /*Saving this product to cart  session**/
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 0,
            'options' => [
                'image' => $product->image
                //'size' => 'large'
            ]
        ]);
        return redirect()
            ->back()
            ->with('success', 'Product is added into the cart');
    }

    public function qtyIncrement($id)
    {
        /*Getting  the current qty*/
        $product = Cart::get($id);
        /*Updating the qty by 1*/
        $updateQty = $product->qty + 1;
        //dd($updateQty);

        Cart::update($id, $updateQty);

        return redirect()
            ->back()
            ->with('success', 'Product Increment successfully');
    }

    public function qtyDecrement($id)
    {
        /*Getting  the current qty*/
        $product = Cart::get($id);
        /*Updating the qty by 1*/
        $updateQty = $product->qty - 1;

        if ($updateQty > 0){
            Cart::update($id, $updateQty);
        }

        return redirect()
            ->back()
            ->with('success', 'Product decrement successfully');
    }
}
