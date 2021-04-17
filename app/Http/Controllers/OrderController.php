<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\StatusNotification;
use Helper;
use Barryvdh\DomPDF\Facade as PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);

        return view('backend.order.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['shipping' => 'required']);
        
        if (!Cart::where('user_id', Auth::user()->id)->where('order_id', null)->first()) {
            request()->session()->flash('error', 'Carrinho vazio.');
            return back();
        }

        $order = new Order();

        $order_data = $request->all();

        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = Auth::id();
        $order_data['shipping_id'] = $request->shipping;
        $shipping = Shipping::where('id', $order_data['shipping_id'])->pluck('price');
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();

        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
        }

        if ($request->shipping) {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0] - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0];
            }
        } else {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice();
            }
        }

        $order_data['status'] = "Em aberto";
        if (request('payment_method') == 'paypal') {
            $order_data['payment_method'] = 'paypal';
            $order_data['payment_status'] = 'Pago';
        } else {
            $order_data['payment_method'] = 'cod';
            $order_data['payment_status'] = 'Nao pago';
        }

        $order->fill($order_data);

        $status = $order->save();

        if ($order)
            $users = User::where('role', 'admin')->get();

        $details = [
            'title' => 'Nova compra registrada.',
            'actionURL' => route('orders.show', $order->id),
            'fas' => 'fa-file-alt'
        ];

        
        if (request('payment_method') == 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        } else {
            session()->forget('cart');
            session()->forget('coupon');
        }
        Cart::where('user_id', Auth::id())->where('order_id', null)->update(['order_id' => $order->id]);
        
        if ($status) {
            \Notification::send($users, new StatusNotification($details));

            request()->session()->flash('success', 'Obrigado pela compra! Seu pedido entrará em análise e logo, logo será enviado.');
            return redirect()->route('home');
        } else {
            return back()->with('error', 'Ocorreu um erro ao efetuar a compra. Por favor, tente novamente.');
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
        $order = Order::findOrFail($id);

        return view('backend.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        return view('backend.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OrderUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, $id)
    {
        $order = Order::findOrFail($id);

        $data = $request->all();

        if ($request->status == 'Entregue') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
        }

        $status = $order->fill($data)->update();

        if ($status) {
            request()->session()->flash('success', 'Compra atualizada com sucesso.');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao atualizar esta compra. Por favor, tente novamente.');
        }

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $status = $order->delete();

        if ($status) {
            request()->session()->flash('success', 'Compra deletada com sucesso.');
        } else {
            request()->session()->flash('error', 'Compra não pôde ser deletada. Por favor, tente novamente.');
        }

        return redirect()->route('order.index');
    }

    /**
     *  Income charts function.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function incomeChart()
    {
        $year = Carbon::now()->year;

        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'Entregue')->get()
            ->groupBy(function ($d) {
                return Carbon::parse($d->created_at)->format('m');
            });

        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                $m = intval($month);
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }

    /**
     *  Generate and download the PDF with order details.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function pdf(Request $request)
    {
        set_time_limit(180);

        $order = Order::getAllOrder($request->id);

        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';

        return $pdf = PDF::loadView('backend.order.pdf', compact('order'))->setPaper('a4', 'landscape')->setWarnings(false)->download($file_name . '.pdf');
    }
}
