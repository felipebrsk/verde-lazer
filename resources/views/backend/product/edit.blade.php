@extends('backend.layouts.master')
@section('title', '| Editar um produto')

@section('content')

    <div class="card">
        <h5 class="card-header">Editar produto</h5>
        <div class="card-body">
            <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Título <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Insira um título"
                        value="{{ isset($product->title) ? $product->title : old('title') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Sumário <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary"
                        name="summary">{{ isset($product->summary) ? $product->summary : old('summary') }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Descrição</label>
                    <textarea class="form-control" id="description"
                        name="description">{{ isset($product->description) ? $product->description : old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="is_featured">É destaque?</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='{{ $product->is_featured }}'
                        {{ $product->is_featured ? 'checked' : '' }}> Sim
                </div>

                <div class="form-group">
                    <label for="cat_id">Categoria <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Selecione qualquer categoria--</option>
                        @foreach ($categories as $key => $cat_data)
                            <option value='{{ $cat_data->id }}'
                                {{ $product->cat_id == $cat_data->id ? 'selected' : '' }}>
                                {{ $cat_data->title }}</option>
                        @endforeach
                    </select>
                </div>
                @php
                    $sub_cat_info = DB::table('categories')
                        ->select('title')
                        ->where('id', $product->child_cat_id)
                        ->get();
                @endphp
                <div class="form-group {{ $product->child_cat_id ? '' : 'd-none' }}" id="child_cat_div">
                    <label for="child_cat_id">Sub categoria</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Selecione qualquer sub categoria--</option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Valor/dia <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Insira o valor diário"
                        value="{{ isset($product->price) ? $product->price : old('price') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Desconto (%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100"
                        placeholder="Insira um valor de desconto" value="{{ $product->discount }}" class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
                        <option value="">--Selecione qualquer tamanho--</option>
                        @foreach ($items as $item)
                            @php
                                $data = explode(',', $item->size);
                            @endphp
                            <option value="S" @if (in_array('S', $data)) selected @endif>Pequeno</option>
                            <option value="M" @if (in_array('M', $data)) selected @endif>Médio</option>
                            <option value="L" @if (in_array('L', $data)) selected @endif>Grande</option>
                            <option value="XL" @if (in_array('XL', $data)) selected @endif>Extra grande</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand_id">Marca</label>
                    <select name="brand_id" class="form-control">
                        <option value="">--Selecione uma marca--</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Condição</label>
                    <select name="condition" class="form-control">
                        <option value="">--Selecione uma condição--</option>
                        <option value="default" {{ $product->condition == 'default' ? 'selected' : '' }}>Padrão</option>
                        <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>Novo</option>
                        <option value="hot" {{ $product->condition == 'hot' ? 'selected' : '' }}>Quente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Quantidade <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Insira uma quantidade"
                        value="{{ isset($product->stock) ? $product->stock : old('stock') }}" class="form-control">
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <div>
                                <input type="file" name="photo" class="custom-file-input" id="customFile"
                                    value="{{ isset($product->photo) ? $product->photo : old('photo') }}">
                                <label class="custom-file-label" for="customFile">
                                    @if ($product->photo)
                                        {{ $product->photo }}
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
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <h3 style="font-weight: bold; font-size: 32px;">Locações</h3>
                    <hr>
                </div>

                <div class="form-group">
                    <label for="address">Endereço <span class="text-danger">*</span></label>
                    <input type="text" name="address" placeholder="Insira o endereço"
                        value="{{ isset($product->address) ? $product->address : old('address') }}"
                        class="form-control">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="complement">Complemento <span class="text-danger">*</span></label>
                        <input type="text" name="complement" placeholder="Insira o complemento"
                            value="{{ isset($product->complement) ? $product->complement : old('complement') }}"
                            class="form-control">
                        @error('complement')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="number">Número residencial <span class="text-danger">*</span></label>
                        <input type="text" name="number" placeholder="Insira o número do local"
                            value="{{ isset($product->number) ? $product->number : old('number') }}"
                            class="form-control">
                        @error('number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="postalcode">CEP <span class="text-danger">*</span></label>
                    <input type="text" name="postalcode" placeholder="CEP" id="CEP"
                        value="{{ isset($product->postalcode) ? $product->postalcode : old('postalcode') }}"
                        class="form-control" data-viacep-cep>
                    @error('postalcode')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="city">Cidade <span class="text-danger">*</span></label>
                        <input type="text" name="city" placeholder="Insira a cidade" id="city"
                            value="{{ isset($product->city) ? $product->city : old('city') }}" class="form-control"
                            data-viacep-cidade>
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="UF">Estado <span class="text-danger">*</span></label>
                        <input type="text" name="UF" placeholder="Insira o estado" id="UF"
                            value="{{ isset($product->UF) ? $product->UF : old('UF') }}" class="form-control"
                            data-viacep-estado>
                        @error('UF')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="district">Bairro <span class="text-danger">*</span></label>
                        <input type="text" name="district" placeholder="Insira o bairro" id="bairro"
                            value="{{ isset($product->district) ? $product->district : old('district') }}"
                            class="form-control" data-viacep-bairro>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="bathroom">Quantos banheiros? <span class="text-danger">*</span></label>
                        <input type="number" name="bathroom" min="1" placeholder="Insira a quantidade de banheiros"
                            value="{{ isset($product->bathroom) ? $product->bathroom : old('bathroom') }}"
                            class="form-control">
                        @error('bathroom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bedroom">Quantos quartos? <span class="text-danger">*</span></label>
                        <input type="number" name="bedroom" min="1" placeholder="Insira a quantidade de quartos"
                            value="{{ isset($product->bedroom) ? $product->bedroom : old('bedroom') }}"
                            class="form-control">
                        @error('bedroom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="available_dates">Data disponível <span class="text-danger">*</span></label>
                    <input type="text" name="available_dates" placeholder="Datas disponíveis"
                        value="{{ isset($product->available_dates) ? $product->available_dates : old('available_dates') }}"
                        class="form-control">
                    @error('available_dates')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pool">Tem piscina? </label><br>
                    <input type="checkbox" name='pool' id='pool' value='{{ $product->pool }}'
                        {{ $product->pool ? 'checked' : '' }}> Sim
                </div>
                <div class="form-group">
                    <label for="barbecue">Tem churrasqueira? </label><br>
                    <input type="checkbox" name='barbecue' id='barbecue' value='{{ $product->barbecue }}'
                        {{ $product->barbecue ? 'checked' : '' }}> Sim
                </div>
                <div class="form-group">
                    <label for="soccer">Tem campo de futebol?</label><br>
                    <input type="checkbox" name='soccer' id='soccer' value='{{ $product->soccer }}'
                        {{ $product->soccer ? 'checked' : '' }}> Sim
                </div>
                <div class="form-group">
                    <label for="air_conditioning">Tem ar condicionado?</label><br>
                    <input type="checkbox" name='air_conditioning' id='air_conditioning'
                        value='{{ $product->air_conditioning }}' {{ $product->air_conditioning ? 'checked' : '' }}>
                    Sim
                </div>
                <div class="form-group">
                    <label for="wifi">Tem Wi-Fi? </label><br>
                    <input type="checkbox" name='wifi' id='wifi' value='{{ $product->wifi }}'
                        {{ $product->wifi ? 'checked' : '' }}> Sim
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

            $('#description').summernote({
                placeholder: "Escreva um detalhe da descrição",
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
        var child_cat_id = '{{ $product->child_cat_id }}';
        $('#cat_id').change(function() {
            var cat_id = $(this).val();

            if (cat_id != null) {

                // ajax call
                $.ajax({
                    url: "/admin/categories/" + cat_id + "/child",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response);
                        }
                        var html_option = "<option value=''>--Selecione a sub categoria--</option>";
                        if (response.status) {
                            var data = response.data;
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title) {
                                    html_option += "<option value='" + id + "' " + (
                                            child_cat_id == id ? 'selected ' : '') + ">" +
                                        title + "</option>";
                                });
                            } else {
                                console.log('Sem resposta.');
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);

                    }
                });
            } else {

            }

        });
        if (child_cat_id != null) {
            $('#cat_id').change();
        }

    </script>
@endpush
