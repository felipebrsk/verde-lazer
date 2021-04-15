<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    protected $product = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     *  Add an item to the wishlist.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function wishlist(Request $request)
    {
        if (!$request->slug) {
            return back()->with('error', 'Item inválido!');
        }

        $product = Product::where('slug', $request->slug)->first();

        if (!$product) {
            return back()->with('error', 'Item inválido!');
        }

        // Check if the item is alredy on the wishlist
        $already_wishlist = Wishlist::where('user_id', Auth::id())->where('cart_id', null)->where('product_id', $product->id)->first();

        if ($already_wishlist) {
            return back()->with('error', 'Esse item já se encontra na sua lista de desejos!');
        } else {
            $wishlist = new Wishlist;
            $wishlist->user_id = Auth::id();
            $wishlist->product_id = $product->id;
            $wishlist->price = ($product->price - ($product->price * $product->discount) / 100);
            $wishlist->quantity = 1;
            $wishlist->amount = $wishlist->price * $wishlist->quantity;

            if ($wishlist->product->stock < $wishlist->quantity || $wishlist->product->stock <= 0) return back()->with('error', 'Item não disponível.');
            $wishlist->save();
        }

        request()->session()->flash('success', 'Esse item foi adicionada à sua lista de desejos.');
        return redirect()->route('wishlist');
    }

    /**
     *  Remove an item from the wishlist.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function wishlistDelete(Request $request)
    {
        $wishlist = Wishlist::findOrFail($request->id);

        $wishlist->delete();

        request()->session()->flash('success', 'Item removido da lista de desejos.');
        return redirect()->route('home');
    }
}
