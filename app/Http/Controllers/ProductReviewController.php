<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReviewRequest;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\StatusNotification;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = ProductReview::getAllReview();

        return view('backend.review.index', compact('reviews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function addReview(ProductReviewRequest $request)
    {
        $product = Product::getProductBySlug($request->slug);

        $data = $request->all();

        $data['product_id'] = $product->id;
        $data['user_id'] = Auth::id();
        $data['status'] = 'active';

        $repeatedReview = DB::table('product_reviews')->where('user_id', Auth::id())->where('product_id', $product->id)->first();

        if ($repeatedReview) {
            return back()->with('error', 'Você já possui uma avaliação neste produto.');
        } else {
            $stats = ProductReview::create($data);
        }

        $admin = User::where('role', 'admin')->get();

        $details = [
            'title' => 'Nova avaliação de produto!',
            'actionURL' => route('product-detail', $product->slug),
            'fas' => 'fa-star',
        ];

        if ($stats){
            \Notification::send($admin, new StatusNotification($details));
            request()->session()->flash('success', 'Avaliação publicada com sucesso. Obrigado pelo feedback!');
            return back();
        }else {
            return back()->with('error', 'Ocorreu um erro ao avaliar o produto. Por favor, tente novamente.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productReview = ProductReview::findOrFail($id);

        return view('backend.review.edit', compact('productReview'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productReview = ProductReview::findOrFail($id);

        $product = Product::getProductBySlug($request->slug);

        $data = $request->all();

        $status = $productReview->fill($data)->update();

        // $admins = User::where('role', 'admin')->get();

        // $details = [
        //     'title' => 'Atualização de avaliação de produto!',
        //     'actionURL' => route('product-detail', $product->id),
        //     'fas' => 'fa-star'
        // ];

        
        if ($status) {
            // \Notification::send($admins, new StatusNotification($details));
            request()->session()->flash('success', 'Avaliação atualizada com sucesso.');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao atualizar a sua avaliação. Por favor, tente novamente.');
        }

        return redirect()->route('reviews.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);

        $status = $productReview->delete();

        if ($status) {
            request()->session()->flash('success', 'Avaliação deletada com sucesso.');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao remover essa avaliação. Por favor, tente novamente.');
        }
        
        return redirect()->route('reviews.index');
    }
}
