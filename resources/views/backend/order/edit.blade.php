@extends('backend.layouts.master')
@section('title', '| Editar status da compra')

@section('content')
    <div class="card">
        <h5 class="card-header">Editar status da compra</h5>
        <div class="card-body">
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="status">Status: </label>
                    <select name="status" id="" class="form-control">
                        <option value="">--Selecionar status--</option>
                        <option value="Em aberto" {{ $order->status == 'Em aberto' ? 'selected' : '' }}>Em aberto</option>
                        <option value="Em processamento" {{ $order->status == 'Em processamento' ? 'selected' : '' }}>Em processamento</option>
                        <option value="Coletado pela transportadora" {{ $order->status == 'Coletado pela transportadora' ? 'selected' : '' }}>Coletado pela transportadora</option>
                        <option value="A caminho" {{ $order->status == 'A caminho' ? 'selected' : '' }}>À caminho</option>
                        <option value="Em rota de entrega" {{ $order->status == 'Em rota de entrega' ? 'selected' : '' }}>Em rota de entrega</option>
                        <option value="Entregue" {{ $order->status == 'Entregue' ? 'selected' : '' }}>Entregue</option>
                        <option value="Cancelado" {{ $order->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
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
