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
                    <label for="inputTitle" class="col-form-label">Código do cupom <span
                            class="text-danger">*</span></label>
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
                    <label for="inputTitle" class="col-form-label">Valor (em porcentagem ou fixo, insira o valor inteiro).
                        <span class="text-danger">*</span></label>
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
                    <label for="expiry_date" class="col-form-label" style="width: 100%;">Expira em <span
                            class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="expiry_date"
                        value="{{ isset($coupon->expiry_date) ? $coupon->expiry_date : old('expiry_date') }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css"
        integrity="sha512-KbfxGgOkkFXdpDCVkrlTYYNXbF2TwlCecJjq1gK5B+BYwVk7DGbpYi4d4+Vulz9h+1wgzJMWqnyHQ+RDAlp8Dw=="
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
        integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
        crossorigin="anonymous" />
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"
        integrity="sha512-kZv5Zq4Cj/9aTpjyYFrt7CmyTUlvBday8NGjD9MxJyOY/f2UfRYluKsFzek26XWQaiAp7SZ0ekE7ooL9IYMM2A=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous"></script>
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
