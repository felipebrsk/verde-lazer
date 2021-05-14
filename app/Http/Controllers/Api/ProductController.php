<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Api\ApiError;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => $this->product->getAllProduct()->where('status', 'active')], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->wantsJson();

            $this->product->create($data);

            return response()->json(['data' => ['message' => 'O seu produto foi adicionado com sucesso! Obrigado.']], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), $e->getCode()));
            } else {
                return response()->json(ApiError::errorMessage('Houve um erro ao adicionar o produto!', 500));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->product->find($id)) {
            return response()->json(['data' => $this->product->find($id)], 200);
        } else {
            return response()->json(['data' => ['message' => 'Não foi possível encontrar o produto solicitado.']], 404);
        }
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
        try {
            $data = $request->wantsJson();

            $product = $this->product->find($id);

            $product->update($data);

            return response()->json(['data' => ['message' => 'Os dados do produto foram alterados com sucesso!']], 201);
        } catch (\Throwable $e) {
            if (config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(), $e->getCode()));
            } else {
                return response()->json(ApiError::errorMessage('Houve um erro ao atualizar o produto!', 500));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->product->delete();

            return response()->json(['data' => ['message' => 'O produto foi removido com sucesso!']], 200);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), $e->getCode()));
            } else {
                return response()->json(ApiError::errorMessage('Houve um erro ao remover o produto. Por favor, tente novamente!', 500));
            }
        }
    }
}
