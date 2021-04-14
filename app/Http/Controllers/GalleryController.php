<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Product;

class GalleryController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        if ($request->file('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $filename = time() . '.' . $image->getClientOriginalExtension();

                    $large_image_path = public_path('frontend/products/large/' . $filename);
                    $medium_image_path = public_path('frontend/products/medium/' . $filename);
                    $small_image_path = public_path('frontend/products/small/' . $filename);

                    //// Resize Images
                    \Image::make($image)->resize(2250, 1500)->save($large_image_path);
                    \Image::make($image)->resize(600, 600)->save($medium_image_path);
                    \Image::make($image)->resize(300, 300)->save($small_image_path);

                    $inputData['image'] = $filename;

                    Gallery::create($inputData);
                }
            }
        }
        
        request()->session()->flash('success', 'Imagens adicionadas com sucesso.');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $imageGalleries = Gallery::where('product_id', $id)->get();

        return view('backend.product.add-images', compact('product', 'imageGalleries'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Gallery::findOrFail($id);

        $image_large = public_path() . '/frontend/products/large/' . $delete->image;
        $image_medium = public_path() . '/frontend/products/medium/' . $delete->image;
        $image_small = public_path() . '/frontend/products/small/' . $delete->image;

        if ($delete->delete()) {
            unlink($image_large);
            unlink($image_medium);
            unlink($image_small);
        }

        request()->session()->flash('success', 'A imagem foi removida da galeria.');
        return back();
    }
}
