<!DOCTYPE html>
<html>

<head>
    <title>Locação @if ($order)- {{ $order->order_number }} @endif
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    @if ($order)
        <style type="text/css">
            .invoice-header {
                background: #f7f7f7;
                padding: 10px 20px 10px 20px;
                border-bottom: 1px solid gray;
            }

            .site-logo {
                margin-top: 20px;
            }

            .invoice-right-top h3 {
                padding-right: 20px;
                margin-top: 20px;
                color: green;
                font-size: 30px !important;
                font-family: serif;
            }

            .invoice-left-top {
                border-left: 4px solid green;
                padding-left: 20px;
                padding-top: 20px;
            }

            .invoice-left-top p {
                margin: 0;
                line-height: 20px;
                font-size: 16px;
                margin-bottom: 3px;
            }

            thead {
                background: green;
                color: #FFF;
            }

            .authority h5 {
                margin-top: -10px;
                color: green;
            }

            .thanks h4 {
                color: green;
                font-size: 25px;
                font-weight: normal;
                font-family: serif;
                margin-top: 20px;
            }

            .site-address p {
                line-height: 6px;
                font-weight: 300;
            }

            .table tfoot .empty {
                border: none;
            }

            .table-bordered {
                border: none;
            }

            .table-header {
                padding: .75rem 1.25rem;
                margin-bottom: 0;
                background-color: rgba(0, 0, 0, .03);
                border-bottom: 1px solid rgba(0, 0, 0, .125);
            }

            .table td,
            .table th {
                padding: .30rem;
            }

        </style>
        <div class="invoice-header">
            <div class="float-left site-logo">
                <img src="{{ asset('frontend/img/1618406385.png') }}" alt="">
            </div>
            <div class="float-right site-address">
                <h4>{{ env('APP_NAME', 'Verde Lazer') }}</h4>
                <p>{{ env('APP_ADDRESS', 'Rua Imaginária dos Santos, 273. Cidade imaginária - FA, Centro.') }}</p>
                <p>Telefone: <a
                        href="tel:{{ env('APP_PHONE', '+55 (79) 99867-7272') }}">{{ env('APP_PHONE', '+55 (79) 99867-7272') }}</a>
                </p>
                <p>E-mail: <a
                        href="mailto:{{ env('APP_EMAIL', 'felipe.ufs97@gmail.com') }}">{{ env('APP_EMAIL', 'felipe.ufs97@gmail.com') }}</a>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="invoice-description">
            <div class="invoice-left-top float-left">
                <h6>Fatura para</h6>
                <h3>{{ $order->first_name }} {{ $order->last_name }}</h3>
                <div class="address">
                    <p>
                        <strong>Cidade: </strong>
                        {{ $order->country }}
                    </p>
                    <p>
                        <strong>Endereço: </strong>
                        {{ $order->address1 }} OU {{ $order->address2 }}
                    </p>
                    <p><strong>Telefone: </strong> {{ $order->phone }}</p>
                    <p><strong>E-mail: </strong> {{ $order->email }}</p>
                </div>
            </div>
            <div class="invoice-right-top float-right" class="text-right">
                <h3>Fatura #{{ $order->order_number }}</h3>
                <p>{{ $order->created_at->format('D, d/m/Y') }}</p>
                {{-- <img class="img-responsive" src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(150)->generate(route('admin.product.order.show', $order->id )))}}"> --}}
            </div>
            <div class="clearfix"></div>
        </div>
        <section class="order_details pt-3">
            <div class="table-header">
                <h5>Detalhes da locação</h5>
            </div>
            <table class="table table-bordered table-stripe">
                <thead>
                    <tr>
                        <th scope="col" class="col-6">Local</th>
                        <th scope="col" class="col-3">Quantidade</th>
                        <th scope="col" class="col-3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->cart_info as $cart)
                        @php
                            $product = DB::table('products')
                                ->select('title')
                                ->where('id', $cart->product_id)
                                ->get();
                        @endphp
                        <tr>
                            <td><span>
                                    @foreach ($product as $pro)
                                        {{ $pro->title }}
                                    @endforeach
                                </span></td>
                            <td>x{{ $cart->quantity }}</td>
                            <td><span>R${{ number_format($cart->price, 2) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col" class="empty"></th>
                        <th scope="col" class="text-right">Subtotal: </th>
                        <th scope="col"> <span>R${{ number_format($order->sub_total, 2) }}</span></th>
                    </tr>
                    @if (isset($order->coupon))
                        <tr>
                            <th scope="col" class="empty"></th>
                            <th scope="col" class="text-right">Desconto: </th>
                            <th scope="col">
                                <span>- R${{ number_format($order->coupon, 2) }}</span>
                            </th>
                        </tr>
                    @endif
                    <tr>
                        <th scope="col" class="empty"></th>
                        @php
                            $shipping_charge = DB::table('shippings')
                                ->where('id', $order->shipping_id)
                                ->pluck('price');
                        @endphp
                        <th scope="col" class="text-right ">Transporte: </th>
                        <th><span>R${{ number_format($shipping_charge[0], 2) }}</span></th>
                    </tr>
                    <tr>
                        <th scope="col" class="empty"></th>
                        <th scope="col" class="text-right">Total: </th>
                        <th>
                            <span>
                                R${{ number_format($order->total_amount, 2) }}
                            </span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </section>
        <div class="thanks mt-3">
            <h4>Obrigado por comprar com a gente! :)</h4>
        </div>
        <div class="clearfix"></div>
    @else
        <h5 class="text-danger">Geração inválida.</h5>
    @endif
</body>

</html>
