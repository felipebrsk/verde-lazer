@extends('backend.layouts.master')
@section('title', '| Detalhes da locação')

@section('content')
    <div class="card">
        <h5 class="card-header">Compra #{{ $order->id }}<a href="#"
                class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i>
                Gerar PDF</a>
        </h5>
        <div class="card-body">
            @if ($order)
                <table class="table table-striped table-hover">
                    @php
                        $shipping_charge = DB::table('shippings')
                            ->where('id', $order->shipping_id)
                            ->pluck('price');
                    @endphp
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nº da locação</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Quantidade</th>
                            <th>Envio</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>
                                @if ($shipping_charge != null)
                                    @foreach ($shipping_charge as $data) R$
                                        {{ number_format($data, 2) }} @endforeach
                                @endif
                            </td>
                            <td>R${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @if ($order->status == 'Em aberto')
                                    <span class="badge badge-primary">{{ $order->status }}</span>
                                @elseif($order->status=='Em processamento')
                                    <span class="badge badge-primary">{{ $order->status }}</span>
                                @elseif($order->status=='Coletado pela transportadora')
                                    <span class="badge badge-primary">{{ $order->status }}</span>
                                @elseif($order->status=='A caminho')
                                    <span class="badge badge-primary">{{ $order->status }}</span>
                                @elseif($order->status=='Em rota de entrega')
                                    <span class="badge badge-warning">{{ $order->status }}</span>
                                @elseif($order->status=='Entregue')
                                    <span class="badge badge-success">{{ $order->status }} <i class="fas fa-check"></i></span>
                                @else
                                    <span class="badge badge-danger">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('orders.edit', $order->id) }}"
                                    class="btn btn-primary btn-sm float-left mr-1"
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                    data-placement="bottom"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('orders.destroy', [$order->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm dltBtn" data-id={{ $order->id }}
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>

                        </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            <div class="col-lg-6 col-lx-4">
                                <div class="order-info">
                                    <h4 class="text-center pb-4">INFORMAÇÕES DA LOCAÇÃO</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Número da locação</td>
                                            <td> : {{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Data da locação</td>
                                            <td> : {{ $order->created_at->format('D, d/m/Y') }} às
                                                {{ $order->created_at->format('g:i A') }} </td>
                                        </tr>
                                        <tr>
                                            <td>Quantidade</td>
                                            <td> : {{ $order->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status da locação</td>
                                            <td> : {{ $order->status }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                $shipping_charge = DB::table('shippings')
                                                    ->where('id', $order->shipping_id)
                                                    ->pluck('price');
                                            @endphp
                                            <td>Cobrança de envio</td>
                                            @if ($shipping_charge != null)
                                                <td> : R$ {{ number_format($shipping_charge[0], 2) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Cupom</td>
                                            <td> : R$ {{ number_format($order->coupon, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td> : R$ {{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Método de pagamento</td>
                                            <td> : @if ($order->payment_method == 'cod')
                                                Pagamento na entrega @else PayPal @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status do pagamento</td>
                                            <td> : {{ $order->payment_status }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-lx-4">
                                <div class="shipping-info">
                                    <h4 class="text-center pb-4">INFORMAÇÕES DE TRANSPORTE</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Nome completo</td>
                                            <td> : {{ $order->first_name }} {{ $order->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>E-mail</td>
                                            <td> : {{ $order->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nº de telefone</td>
                                            <td> : {{ $order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Endereço</td>
                                            <td> : {{ $order->address1 }}, {{ $order->address2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>País</td>
                                            <td> : {{ $order->country }}</td>
                                        </tr>
                                        <tr>
                                            <td>CEP</td>
                                            <td> : {{ $order->post_code }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-info,
        .shipping-info {
            background: #ECECEC;
            padding: 20px;
        }

        .order-info h4,
        .shipping-info h4 {
            text-decoration: underline;
        }

    </style>
@endpush
