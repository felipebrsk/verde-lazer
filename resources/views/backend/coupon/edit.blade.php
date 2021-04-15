@extends('backend.layouts.master')
@section('title', '| Editar um cupom')

@section('content')

    <div class="card">
        <h5 class="card-header">Editar cupom</h5>
        <div class="card-body">
            <form method="post" action="{{ route('coupons.update', $coupon->id) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Código do cupom <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="code" placeholder="Insira o código do cupom"
                        value="{{ isset($coupon->code) ? $coupon->code : old('code') }}" class="form-control">
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="col-form-label">Tipo <span class="text-danger">*</span></label>
                    <select name="type" class="form-control">
                        <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixo</option>
                        <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percentual</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Valor (em porcentagem ou fixo, insira o valor inteiro). <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="number" name="value" placeholder="Enter Coupon value"
                        value="{{ isset($coupon->value) ? $coupon->value : old('value') }}" class="form-control">
                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expiry_date" class="col-form-label" style="width: 100%;">Expira em <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="expiry_date" value="{{ isset($coupon->expiry_date) ? $coupon->expiry_date : old('expiry_date') }}">
                    @error('expiry_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Atualizar</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Escreva uma breve descrição...",
                tabsize: 2,
                height: 150
            });
        });

    </script>
@endpush
