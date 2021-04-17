<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    /**
     *  Payment with PayPal.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function payment()
    {
        $cart = Cart::where('user_id', Auth::id())->where('order_id', null)->get()->toArray();

        $data = [];

        $data['items'] = array_map(function ($item) use ($cart) {
            $name = Product::where('id', $item['product_id'])->pluck('title');
            return [
                'name' => $name,
                'price' => $item['price'],
                'desc'  => 'Obrigado por usar o PayPal',
                'qty' => $item['quantity']
            ];
        }, $cart);

        $data['invoice_id'] = 'ORD-' . strtoupper(uniqid());
        $data['invoice_description'] = "Fatura da compra #{$data['invoice_id']}";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;
        if (session('coupon')) {
            $data['shipping_discount'] = session('coupon')['value'];
        }

        Cart::where('user_id', Auth::id())->where('order_id', null)->update(['order_id' => session()->get('id')]);

        $provider = new ExpressCheckout;

        $response = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Seu pagamento foi cancelado.');
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            request()->session()->flash('success', 'Seu pagamento pelo PayPal foi aprovado. Obrigado pela compra! :)');
            session()->forget('cart');
            session()->forget('coupon');
            return redirect()->route('home');
        }

        request()->session()->flash('error', 'Ocorreu um erro ao realizar o seu pagamente. Por favor, cheque as informações e tente novamente.');
        return redirect()->back();
    }
}
