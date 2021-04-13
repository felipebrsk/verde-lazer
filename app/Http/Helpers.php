<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class Helper
{
    // Collection with message list
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }

    // Collection with all categories
    public static function getAllCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();
        return $menu;
    }

    // Function to call the categories with the parent and childs in header menu
    public static function getHeaderCategory()
    {
        $category = new Category();

        $menu = $category->getAllParentWithChild();

        if ($menu) {
?>

            <li>
                <a href="javascript:void(0);">Categorias<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                    <?php
                    foreach ($menu as $cat_info) {
                        if ($cat_info->child_cat->count() > 0) {
                    ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach ($cat_info->child_cat as $sub_menu) {
                                    ?>
                                        <li><a href="<?php echo route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </li>
<?php
        }
    }

    // Collection with the list of products categories
    public static function productCategoryList($option = 'all')
    {
        if ($option = 'all') {
            return Category::orderBy('id', 'DESC')->get();
        }
        return Category::has('products')->orderBy('id', 'DESC')->get();
    }

    // Collection with the tag list of posts in blog section
    public static function postTagList($option = 'all')
    {
        if ($option = 'all') {
            return PostTag::orderBy('id', 'DESC')->get();
        }
        return PostTag::has('posts')->orderBy('id', 'DESC')->get();
    }

    // Collection with the category list of posts in blog section
    public static function postCategoryList($option = 'all')
    {
        if ($option = 'all') {
            return PostCategory::orderBy('id', 'DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id', 'DESC')->get();
    }

    // Count the quantity of products in cart section
    public static function cartCount($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = Auth::id();
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }

    // Relationship cart with product
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    // Collection with all products from the cart
    public static function getAllProductFromCart($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = Auth::id();
            return Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();
        } else {
            return 0;
        }
    }

    // Total amount from the cart
    public static function totalCartPrice($user_id = '')
    {
        if (Auth::check()) {
            if($user_id == "") Auth::id();
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('amount');
        }else {
            return 0;
        }
    }

    // Get the quantity of products in wishlist 
    public static function wishlistCount($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") Auth::id();
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('quantity');
        }else {
            return 0;
        }
    }

    // Collection with all products in wishlist
    public static function getAllProductFromWishlist($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") Auth::id();
            return Wishlist::with('product')->where('user_id', $user_id)->where('cart_id', null)->get();
        }else {
            return 0;
        }
    }

    // Get the total amount of the wishlist
    public static function totalWishlistPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") Auth::id();
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('amount');
        }else {
            return 0;
        }
    }

    // Get the total amount with the shipping and coupon
    public static function grandPrice($id, $user_id)
    {
        $order = Order::findOrFail($id);
        
        $shipping_price = (float)$order->shipping->price;
        $order_price = self::orderPrice($id, $user_id);
        return number_format((float)($order_price + $shipping_price), 2, '.', '');
    }

    
}
?>