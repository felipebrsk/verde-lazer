<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->category->getAllCategory()->where('status', 'active'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->category->find($id)) {
            return response()->json(['data' => $this->category->find($id)->where('status', 'active')], 200);
        } else {
            return response()->json(['data' => ['message' => 'Categoria não encontrada!']], 404);
        }
    }
}
