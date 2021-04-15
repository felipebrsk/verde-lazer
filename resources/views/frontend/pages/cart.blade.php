@extends('frontend.layouts.master')
@section('title', '| Meu carrinho')

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Início<i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="">Carrinho</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>
                        Caso haja alguma promoção e não esteja com o valor correto, clique em atualizar.
                    </p>
                    <!-- Shopping Summery -->
                    <table class="table shopping-summery">
                        <thead>
                            <tr class="main-hading text-center">
                                <th>ITEM</th>
                                <th>NOME</th>
                                <th>PREÇO DIÁRIO</th>
                                <th>QUANTIDADE</th>
                                <th>TOTAL</th>
                                <th><i class="fas fa-trash remove-icon"></i></th>
                            </tr>
                        </thead>
                        <tbody id="cart_item_list">
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                @if (Helper::getAllProductFromCart())
                                    @foreach (Helper::getAllProductFromCart() as $key => $cart)
                                        <tr class="text-center">
                                            <td class="image" data-title="No"><img
                                                    src="{{ asset('frontend/products/' . $cart->product->photo) }}"
                                                    alt="{{ asset('frontend/products/' . $cart->product->photo) }}"></td>
                                            <td class="product-des" data-title="Description">
                                                <p class="product-name"><a
                                                        href="{{ route('product-detail', $cart->product['slug']) }}"
                                                        target="_blank">{{ $cart->product['title'] }}</a></p>
                                                <p class="product-des">{!! $cart['summary'] !!}</p>
                                            </td>
                                            <td class="price" data-title="Price">
                                                <span>R${{ number_format($cart['price'], 2) }}</span>
                                            </td>
                                            <td class="qty" data-title="Qty">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus"
                                                            data-field="quant[{{ $key }}]">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="quant[{{ $key }}]"
                                                        class="input-number" data-min="1" data-max="100"
                                                        value="{{ $cart->quantity }}">
                                                    <input type="hidden" name="qty_id[]" value="{{ $cart->id }}">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[{{ $key }}]">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </td>
                                            <td class="total-amount cart_single_price" data-title="Total"><span
                                                    class="money">R${{ $cart['amount'] }}</span></td>

                                            <td class="action" data-title="Remove"><a href="{{ route('cart-delete', $cart->id) }}"><i
                                                        class="fas fa-trash remove-icon"></i></a></td>
                                        </tr>
                                    @endforeach
                                    <track>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="float-right">
                                        <button class="btn float-right" type="submit">Atualizar</button>
                                    </td>
                                    </track>
                                @else
                                    <tr>
                                        <td class="text-center">
                                            Seu carrinho está vazio. <a href="{{ route('product-grids') }}"
                                                style="color:blue;">Continue procurando</a>.

                                        </td>
                                    </tr>
                                @endif

                            </form>
                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="{{ route('coupons.apply') }}" method="POST">
                                            @csrf
                                            <input name="code" placeholder="Insira um cupom">
                                            <button class="btn">Aplicar</button>
                                        </form>
                                    </div>
                                    {{-- <div class="checkbox">`
										@php 
											$shipping=DB::table('shippings')->where('status','active')->limit(1)->get();
										@endphp
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox" onchange="showMe('shipping');"> Shipping</label>
									</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                            Subtotal
                                            <span>
                                                R${{ number_format(Helper::totalCartPrice(), 2) }}
                                            </span>
                                        </li>
                                        {{-- <div id="shipping" style="display:none;">
											<li class="shipping">
												Shipping {{session('shipping_price')}}
												@if (count(Helper::shipping()) > 0 && Helper::cartCount() > 0)
													<div class="form-select">
														<select name="shipping" class="nice-select">
															<option value="">Select</option>
															@foreach (Helper::shipping() as $shipping)
															<option value="{{$shipping->id}}" class="shippingOption" data-price="{{$shipping->price}}">{{$shipping->type}}: ${{$shipping->price}}</option>
															@endforeach
														</select>
													</div>
												@else 
													<div class="form-select">
														<span>Free</span>
													</div>
												@endif
											</li>
										</div> --}}
                                        @if (session()->has('coupon'))
                                            <li class="coupon_price" data-price="{{ Session::get('coupon')['value'] }}">
                                                Desconto
                                                <span>
                                                    R${{ number_format(Session::get('coupon')['value'], 2) }}
                                                </span>

                                                <form action="{{ route('coupons.remove') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" style="border: none; background: none;"
                                                        class="mt-2">remover cupom</button>
                                                </form>
                                            </li>
                                        @endif
                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if (session()->has('coupon')) {
                                                $total_amount = $total_amount - Session::get('coupon')['value'];
                                            }
                                        @endphp
                                        @if (session()->has('coupon'))
                                            <li class="last" id="order_total_price">Você
                                                pagará<span>R${{ number_format($total_amount, 2) }}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">
                                                Total<span>R${{ number_format($total_amount, 2) }}</span></li>
                                        @endif
                                    </ul>
                                    <div class="button5">
                                        <a href="#" class="btn">Pagamento</a>
                                        <a href="{{ route('product-grids') }}" class="btn">Continuar comprando</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    <!-- Start Shop Services Area  -->
    @include('frontend.layouts.services')
    <!-- End Shop Newsletter -->

    <!-- Start Shop Newsletter  -->
    @include('frontend.layouts.newsletter')
    <!-- End Shop Newsletter -->

@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: rgb(26, 202, 26) !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }

    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
        integrity="sha512-NqYds8su6jivy1/WLoW8x1tZMRD7/1ZfhWG/jcRQLOzV1k1rIODCpMgoBnar5QXshKJGV7vi0LXLNXPoFsM5Zg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();

    </script>
    <script>
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;

                $('#order_total_price span').text('R$' + (subtotal + cost - coupon).toFixed(2));
            });
        });

    </script>

@endpush
