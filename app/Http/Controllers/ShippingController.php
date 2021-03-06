<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Shipping::orderBy('id', 'DESC')->paginate(10);

        return view('backend.shipping.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ShippingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingRequest $request)
    {
        $data = $request->all();

        $status = Shipping::create($data);

        if ($status) {
            request()->session()->flash('success', 'Forma de envio criada com sucesso.');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao criar a forma de envio. Por favor, tente novamente.');
        }

        return redirect()->route('shippings.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipping = Shipping::findOrFail($id);

        return view('backend.shipping.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ShippingRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingRequest $request, $id)
    {
        $shipping = Shipping::findOrFail($id);

        $data = $request->all();

        $status = $shipping->fill($data)->update();

        if ($status) {
            request()->session()->flash('success', 'Forma de envio atualizada com sucesso.');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao atualizar a forma de envio. Por favor, tente novamente.');
        }

        return redirect()->route('shippings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping = Shipping::findOrFail($id);

        $status = $shipping->delete();

        if ($status) {
            request()->session()->flash('success', 'Forma de envio deletada com sucesso.');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao deletar a forma de envio. Por favor, tente novamente.');
        }

        return redirect()->route('shippings.index');
    }
}
