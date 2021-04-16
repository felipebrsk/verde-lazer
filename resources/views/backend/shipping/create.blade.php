@extends('backend.layouts.master')
@section('title', '| Criar forma de envio')

@section('content')

    <div class="card">
        <h5 class="card-header">Criar forma de envio</h5>
        <div class="card-body">
            <form method="POST" action="{{ route('shippings.store') }}">
                @csrf
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tipo <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="type" placeholder="Insira o tipo" value="{{ old('type') }}"
                        class="form-control">
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Preço <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Insira um valor" value="{{ old('price') }}"
                        class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Ativo</option>
                        <option value="inactive">Inativo</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Resetar</button>
                    <button class="btn btn-success" type="submit">Enviar</button>
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
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Escreva uma breve descrição",
                tabsize: 2,
                height: 150
            });
        });

    </script>
@endpush
