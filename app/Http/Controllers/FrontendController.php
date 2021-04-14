<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Category;

class FrontendController extends Controller
{
    /** 
     *  Home view.
     *  
     *  @return \Illuminate\Http\Response
     */
    public function home()
    {
        $featured = Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get();

        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get();

        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get();

        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();

        return view('frontend.index')
            ->with('featured', $featured)
            ->with('posts', $posts)
            ->with('banners', $banners)
            ->with('product_lists', $products)
            ->with('category_lists', $category);
    }


    /**
     *  Submit the register form.
     *  
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function registerSubmit(Request $request)
    {
        $data = $request->all();

        $check = $this->create($data);

        Auth::login($check);

        Session::put('user', $data['email']);

        if ($check) {
            request()->session()->flash('success', 'Registrado com sucesso.');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Houve um erro ao criar a sua conta. Por favor, tente novamente.');
            return back();
        }
    }

    /**
     *  Submit the login form.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function loginSubmit(Request $request)
    {
        $data = $request->all();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Login efetuado com sucesso!');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'E-mail ou senha inválidos. Por favor, tente novamente!');
            return redirect()->back();
        }
    }

    /**
     *  Function to register the user in database.
     * 
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }

    /**
     *  Search for a specific product.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    // public function productSearch(Request $request)
    // {
    //     $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

    //     $query = Product::query();

    //     if ($request->filled('search')) {
    //         $query->where('title', 'like', '%' . $request->search . '%')
    //             ->orwhere('slug', 'like', '%' . $request->search . '%')
    //             ->orwhere('description', 'like', '%' . $request->search . '%')
    //             ->orwhere('summary', 'like', '%' . $request->search . '%')
    //             ->orwhere('price', 'like', '%' . $request->search . '%');
    //     }

    //     if ($request->filled('category_search')) {
    //         $query->where('cat_id', $request->category_search);
    //     }

    //     $products = $query->orderBy('id', 'DESC')->paginate('9');

    //     return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    // }
}
