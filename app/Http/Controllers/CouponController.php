<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->paginate(10);

        return view('backend.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CouponRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        $status = Coupon::create($request->all());

        if ($status) {
            request()->session()->flash('success', 'Cupom adicionado com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao adicionar cupom. Por favor, tente novamente.');
        }

        return redirect()->route('coupons.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('backend.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CouponRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $status = $coupon->update($request->all());

        if ($status) {
            request()->session()->flash('success', 'Cupom atualizado com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao atualizar o cupom. Por favor, tente novamente.');
        }

        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        $status = $coupon->delete();

        if ($status) {
            request()->session()->flash('success', 'Cupom deletado com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao deletar cupom. Por favor, tente novamente.');
        }

        return redirect()->route('coupons.index');
    }
}
