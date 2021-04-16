@extends('backend.layouts.master')
@section('title', '| Editar avaliação')

@section('title', 'Review Edit')

@section('content')
    <div class="card">
        <h5 class="card-header">Editar avaliação</h5>
        <div class="card-body">
            <form action="{{ route('reviews.update', $productReview->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Avaliado por: </label>
                    <input type="text" disabled class="form-control" value="{{ isset($productReview->user_info->name) ? $productReview->user_info->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="review">Avaliação</label>
                    <textarea name="review" id="" cols="20" rows="10" class="form-control">{{ isset($productReview->review) ? $productReview->review : old('review') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status: </label>
                    <select name="status" id="" class="form-control">
                        <option value="">--Selecione um status--</option>
                        <option value="active" {{ $productReview->status == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ $productReview->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
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
