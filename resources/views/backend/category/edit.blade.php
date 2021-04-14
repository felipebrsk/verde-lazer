@extends('backend.layouts.master')
@section('title', '| Editar uma categoria')

@section('content')

    <div class="card">
        <h5 class="card-header">Editar categoria</h5>
        <div class="card-body">
            <form method="post" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Título <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ isset($category->title) ? $category->title : old('title') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Sumário</label>
                    <textarea class="form-control" id="summary"
                        name="summary">{{ isset($category->summary) ? $category->summary : old('summary') }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_parent">É uma categoria paterna</label><br>
                    <input type="checkbox" name='is_parent' id='is_parent'
                        value='{{ isset($category->is_parent) ? $category->is_parent : old('is_parent') }}'
                        {{ $category->is_parent == 1 ? 'checked' : '' }}> Sim
                </div>

                <div class="form-group {{ $category->is_parent == 1 ? 'd-none' : '' }}" id='parent_cat_div'>
                    <label for="parent_id">Categoria filho</label>
                    <select name="parent_id" class="form-control">
                        <option value="">--Selecione qualquer categoria--</option>
                        @foreach ($parent_cats as $key => $parent_cat)

                            <option value='{{ $parent_cat->id }}'
                                {{ $parent_cat->id == $category->parent_id ? 'selected' : '' }}>
                                {{ $parent_cat->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <div>
                                <input type="file" name="photo" class="custom-file-input" id="customFile"
                                    value="{{ isset($category->photo) ? $category->photo : old('photo') }}">
                                <label class="custom-file-label" for="customFile">
                                    @if ($category->photo)
                                        {{ $category->photo }}
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
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('status')
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
        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Escreva uma breve descrição...",
                tabsize: 2,
                height: 150
            });

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });

    </script>
    <script>
        $('#is_parent').change(function() {
            var is_checked = $('#is_parent').prop('checked');
            // alert(is_checked);
            if (is_checked) {
                $('#parent_cat_div').addClass('d-none');
                $('#parent_cat_div').val('');
            } else {
                $('#parent_cat_div').removeClass('d-none');
            }
        })

    </script>
@endpush
