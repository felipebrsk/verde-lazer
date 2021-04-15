<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingleAddCartRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $product = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     *  Add an item to the cart.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        if (!$request->slug) {
            return back()->with('error', 'Item inválido!');
        }

        $product = Product::where('slug', $request->slug)->firstOrFail();

        // Check if the product is alredy in the cart
        $alredyCart = Cart::where('user_id', Auth::id())->where('order_id', null)->where('product_id', $product->id)->first();
    
        if ($alredyCart) {
            return back()->with('error', 'Este item já se encontra no seu carrinho.');
        }else {
            $cart = new Cart;
            $cart->user_id = Auth::id();
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;

            if ($cart->product->stock < $cart->quantity || $cart->product->stock < 0) return back()->with('error', 'Item não disponível. Tente outras opções.');
            $cart->save();

            // Add cart_id to the wishlist
            Wishlist::where('user_id', Auth::id())->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }

        request()->session()->flash('success', 'Item adicionado ao seu carrinho!');
        return redirect()->route('cart');
    }

    /**
     *  Single add to cart.
     *  
     *  @param \App\Http\Requests\SingleAddCartRequest $request
     *  @return \Illuminate\Http\Response
     */
    public function singleAddToCart(SingleAddCartRequest $request)
    {
        $product = Product::where('slug', $request->slug)->first();

        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Item não disponível. Tente outras opções.');
        }

        if (($request->quant[1] < 1) || empty($product)) {
            request()->session()->flash('error', 'Item iválido.');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();

        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error', 'Item não disponível. Tente outras opções.');
            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = $request->quant[1];
            $cart->amount = ($product->price * $request->quant[1]);

            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error', 'Item não disponível. Tente outras opções.');
            $cart->save();
        }

        request()->session()->flash('success', 'Item adicionado ao carrinho.');
        return back();
    }

    /**
     *  Delete cart items.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function cartDelete(Request $request)
    {
        $cart = Cart::findOrFail($request->id);

        $cart->delete();

        request()->session()->flash('success', 'Item removido com sucesso.');
        return back();
    }

    /**
     *  Update items in cart.
     *  
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function cartUpdate(Request $request)
    {
        if ($request->quant) {
            $error = [];
            $success = '';
            foreach ($request->quant as $k => $quant) {
                $id = $request->qty_id[$k];
                $cart = Cart::findOrFail($id);

                if ($quant > 0 && $cart) {
                    if ($cart->product->stock < $quant) {
                        request()->session()->flash('error', 'Item não disponível. Tente outras opções.');
                        return back();
                    }

                    $cart->quantity = ($cart->product->stock > $quant) ? $quant : $cart->product->stock;

                    if ($cart->product->stock <= 0) continue;
                    $after_price = ($cart->product->price - ($cart->product->price * $cart->product->discount) / 100);
                    $cart->amount = $after_price * $quant;
                    $cart->save();
                    $success = 'Carrinho atualizado com sucesso.';
                }else {
                    $error[] = 'Carrinho inválido.';
                }
            }
            return back()->with($error)->with('success', $success);
        }else {
            return back()->with('Carrinho inválido.');
        }
    }
}
