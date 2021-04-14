@extends('backend.layouts.master')
@section('title', '| Cadastrar um produto')

@section('content')

    <div class="card">
        <h5 class="card-header">Adicionar produto</h5>
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}" id="product-form" enctype="multipart/form-data" data-viacep>
                @csrf
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Título <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Insira um título"
                        value="{{ old('title') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Sumário <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ old('summary') }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Descrição</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="is_featured">É destaque?</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1'> Sim
                </div>

                <div class="form-group">
                    <label for="cat_id">Categoria <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Selecione qualquer categoria--</option>
                        @foreach ($categories as $key => $cat_data)
                            <option value='{{ $cat_data->id }}'>{{ $cat_data->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-none" id="child_cat_div">
                    <label for="child_cat_id">Sub categoria</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Selecione qualquer categoria--</option>
                        {{-- @foreach ($parent_cats as $key => $parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
              @endforeach --}}
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Valor/dia <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Insira o valor diário"
                        value="{{ old('price') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Desconto (%)<span class="text-danger">*</span></label>
                    <input id="discount" type="number" name="discount" min="0" max="100"
                        placeholder="Insira um desconto (0 min)" value="{{ old('discount') }}" class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="size">Tamanho</label>
                    <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
                        <option value="">--Selecione qualquer tamanho--</option>
                        <option value="S">Pequeno (S)</option>
                        <option value="M">Médio (M)</option>
                        <option value="L">Grande (L)</option>
                        <option value="XL">Extra grande (XL)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Marca</label>
                    <select name="brand_id" class="form-control">
                        <option value="">--Selecione uma marca--</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Condição</label>
                    <select name="condition" class="form-control">
                        <option value="">--Selecione uma condição--</option>
                        <option value="default">Padrão</option>
                        <option value="new">Novo</option>
                        <option value="hot">Quente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Quantidade (2 para locações)<span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Insira a quantidade"
                        value="{{ old('stock') }}" class="form-control">
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Produto <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <div>
                                <input type="file" name="photo" class="custom-file-input" id="customFile"
                                    value="{{ old('photo') }}">
                                <label class="custom-file-label" for="customFile">
                                    Escolher arquivo
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
                        <option value="active">Ativo</option>
                        <option value="inactive">Inativo</option>
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
                    <input type="text" name="address" placeholder="Insira o endereço" value="{{ old('address') }}"
                        class="form-control">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="complement">Complemento <span class="text-danger">*</span></label>
                        <input type="text" name="complement" placeholder="Insira o complemento"
                            value="{{ old('complement') }}" class="form-control">
                        @error('complement')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="number">Número residencial <span class="text-danger">*</span></label>
                        <input type="text" name="number" placeholder="Insira o número do local"
                            value="{{ old('number') }}" class="form-control">
                        @error('number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="postalcode">CEP <span class="text-danger">*</span></label>
                    <input type="text" name="postalcode" placeholder="CEP" id="CEP" value="{{ old('postalcode') }}"
                        class="form-control" data-viacep-cep>
                    @error('postalcode')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="city">Cidade <span class="text-danger">*</span></label>
                        <input type="text" name="city" placeholder="Insira a cidade" id="city" value="{{ old('city') }}"
                            class="form-control" data-viacep-cidade>
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="UF">Estado <span class="text-danger">*</span></label>
                        <input type="text" name="UF" placeholder="Insira o estado" id="UF" value="{{ old('UF') }}"
                            class="form-control" data-viacep-estado>
                        @error('UF')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="district">Bairro <span class="text-danger">*</span></label>
                        <input type="text" name="district" placeholder="Insira o bairro" id="bairro"
                            value="{{ old('district') }}" class="form-control" data-viacep-bairro>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="bathroom">Quantos banheiros? <span class="text-danger">*</span></label>
                        <input type="number" name="bathroom" min="1" placeholder="Insira a quantidade de banheiros"
                            value="{{ old('bathroom') }}" class="form-control">
                        @error('bathroom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bedroom">Quantos quartos? <span class="text-danger">*</span></label>
                        <input type="number" name="bedroom" min="1" placeholder="Insira a quantidade de quartos"
                            value="{{ old('bedroom') }}" class="form-control">
                        @error('bedroom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="available_dates">Data disponível <span class="text-danger">*</span></label>
                    <input type="text" name="available_dates" placeholder="Datas disponíveis"
                        value="{{ old('available_dates') }}" class="form-control">
                    @error('available_dates')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pool">Tem piscina? </label><br>
                    <input type="checkbox" name='pool' id='pool' value='1'> Sim
                </div>
                <div class="form-group">
                    <label for="barbecue">Tem churrasqueira? </label><br>
                    <input type="checkbox" name='barbecue' id='barbecue' value='1'> Sim
                </div>
                <div class="form-group">
                    <label for="soccer">Tem campo de futebol?</label><br>
                    <input type="checkbox" name='soccer' id='soccer' value='1'> Sim
                </div>
                <div class="form-group">
                    <label for="air_conditioning">Tem ar condicionado?</label><br>
                    <input type="checkbox" name='air_conditioning' id='air_conditioning' value='1'> Sim
                </div>
                <div class="form-group">
                    <label for="wifi">Tem Wi-Fi? </label><br>
                    <input type="checkbox" name='wifi' id='wifi' value='1'> Sim
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vsilva472/jquery-viacep/dist/jquery-viacep.min.js"></script>
    <script src="{{ asset('backend/js/mask.js') }}"></script>

    <script>
        $('#product-form').on('viacep.ajax.complete', function() {
            var $this = $(this),
                fields_to_block = ['city', 'UF'];

            fields_to_block.forEach(function(name) {
                $this.find('[id="' + name + '"]').attr('readonly', true);
            });
        });

    </script>

    <script>
        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Escreva uma breve descrição...",
                tabsize: 2,
                height: 100
            });
            
            $('#description').summernote({
                placeholder: "Escreva algum detalhe de descrição...",
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
        $('#cat_id').change(function() {
            var cat_id = $(this).val();

            if (cat_id != null) {

                // Ajax call
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }

                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;

                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title) {
                                    html_option += "<option value='" + id + "'>" + title +
                                        "</option>"
                                });
                            } else {}
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            } else {}
        })

    </script>
@endpush
