<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::getAllProduct();

        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();

        $categories = Category::where('is_parent', 1)->get();

        return view('backend.product.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $slug = Str::slug($request->title);

        $count = Product::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;

        $size = $request->input('size');

        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/products/' . $filename);
            \Image::make($image)->resize(2250, 1500)->save($location);
            $data['photo'] = $filename;
        }

        $status = Product::create($data);

        if ($status) {
            request()->session()->flash('success', 'Produto adicionado com sucesso!');
        } else {
            request()->session()->flash('error', 'Ocorreu um ero ao adicionar o produto. Por favor, tente novamente.');
        }

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::all();
        $categories = Category::where('is_parent', 1)->get();
        $items = Product::where('id', $id)->get();

        return view('backend.product.edit', compact('product', 'brands', 'categories', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->all();
        
        $data['is_featured'] = isset($request['is_featured']) ? 1 : 0;
        $data['pool'] = isset($request['pool']) ? 1 : 0;
        $data['barbecue'] = isset($request['barbecue']) ? 1 : 0;
        $data['soccer'] = isset($request['soccer']) ? 1 : 0;
        $data['air_conditioning'] = isset($request['air_conditioning']) ? 1 : 0;
        $data['wifi'] = isset($request['wifi']) ? 1 : 0;

        $size = $request->input('size');

        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/products/' . $filename);
            \Image::make($image)->resize(2250, 1500)->save($location);
            if ($product->photo != null) {
                Storage::delete($product->photo);
                unlink(public_path('frontend/products/' . $product->photo));
            }
            $data['photo'] = $filename;
        }

        $status = $product->fill($data)->save();
        
        if ($status) {
            request()->session()->flash('success', 'Produto atualizado com sucesso!');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao atualizar o produto. Por favor, tente novamente.');
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $status = $product->delete();
        
        if ($status) {
            request()->session()->flash('success', 'Produto removido com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao remover o produto. Por favor, tente novamente.');
        }

        return redirect()->route('products.index');
    }
}
