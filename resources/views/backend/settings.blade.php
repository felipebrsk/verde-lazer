@extends('backend.layouts.master')
@section('title', '| Editar configurações gerais')

@section('content')

    <div class="card">
        <h5 class="card-header">Editar configurações gerais</h5>
        <div class="card-body">
            <form method="post" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="short_des" class="col-form-label">Breve descrição <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="quote"
                        name="short_des">{{ isset($data->short_des) ? $data->short_des : old('short_des') }}</textarea>
                    @error('short_des')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="col-form-label">Descrição <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description"
                        name="description">{{ isset($data->description) ? $data->description : old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputLogo" class="col-form-label">Logo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <div>
                                <input type="file" name="logo" class="custom-file-input" id="customFile"
                                    value="{{ isset($data->logo) ? $data->logo : old('logo') }}">
                                <label class="custom-file-label" for="customFile">
                                    @if ($data->logo)
                                        {{ $data->logo }}
                                    @else
                                        Escolher arquivo
                                    @endif
                                </label>
                            </div>
                        </span>
                    </div>
                    @error('logo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <div>
                                <input type="file" name="photo" class="custom-file-input" id="customFile"
                                    value="{{ isset($data->photo) ? $data->photo : old('photo') }}">
                                <label class="custom-file-label" for="customFile">
                                    @if ($data->photo)
                                        {{ $data->photo }}
                                    @else
                                        Escolher arquivo
                                    @endif
                                </label>
                            </div>
                        </span>
                    </div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="col-form-label">Endereço <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address" required
                        value="{{ isset($data->address) ? $data->address : old('address') }}">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">E-mail <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" required
                        value="{{ isset($data->email) ? $data->email : old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="col-form-label">Número de telefone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phone" required
                        value="{{ isset($data->phone) ? $data->phone : old('phone') }}">
                    @error('phone')
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
    crossorigin="anonymous" />@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"
        integrity="sha512-kZv5Zq4Cj/9aTpjyYFrt7CmyTUlvBday8NGjD9MxJyOY/f2UfRYluKsFzek26XWQaiAp7SZ0ekE7ooL9IYMM2A=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Escreva uma breve descrição...",
                tabsize: 2,
                height: 150
            });

            $('#quote').summernote({
                placeholder: "Escreva uma breve citação...",
                tabsize: 2,
                height: 100
            });

            $('#description').summernote({
                placeholder: "Escreva um breve detalhe da decrição...",
                tabsize: 2,
                height: 150
            });

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });

    </script>
@endpush
