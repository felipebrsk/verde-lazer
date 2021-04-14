<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::getAllCategory();

        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();

        return view('backend.category.create')->with('parent_cats', $parent_cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        $slug = Str::slug($request->title);

        $count = Category::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;
        $data['is_parent'] = $request->input('is_parent', 0);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/categories/' . $filename);
            \Image::make($image)->resize(2250, 1500)->save($location);
            $data['photo'] = $filename;
        }

        $status = Category::create($data);

        if ($status) {
            request()->session()->flash('success', 'Categoria adicionada com sucesso.');
        }else {
            request()->session()->flash('error', 'Ocorreu um erro ao adicionar a categoria. Por favr, tente novamente.');
        }

        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parent_cats = Category::where('is_parent', 1)->get();
        
        return view('backend.category.edit', compact('category', 'parent_cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->all();

        $data['is_parent'] = $request->input('is_parent', 0);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/categories/' . $filename);
            \Image::make($image)->resize(2250, 1500)->save($location);
            if ($category->photo != null) {
                Storage::delete($category->photo);
                unlink(public_path('frontend/categories/' . $category->photo));
            }
            $data['photo'] = $filename;
        }
        
        $status = $category->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Categoria atualizada com sucesso.');
        }else {
            request()->session()->flash('error', 'Ocorreu um erro ao atualizar a categoria. Por favor, tente novamente');
        }

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $status = $category->delete();

        if ($status) {
            Storage::delete($category->photo);
            unlink(public_path('frontend/categories/' . $category->photo));
            request()->session()->flash('success', 'Categoria removida com sucesso.');
        }else {
            request()->session()->flash('error', 'Ocorreu um erro ao remover a categoria. Por favor, tente novamente.');
        }

        return redirect()->route('categories.index');
    }
}
