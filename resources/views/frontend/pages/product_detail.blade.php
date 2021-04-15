@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{ $product_detail->summary }}">
    <meta property="og:asset" content="{{ route('product-detail', $product_detail->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $product_detail->title }}">
    <meta property="og:image" content="{{ $product_detail->photo }}">
    <meta property="og:description" content="{{ $product_detail->description }}">
@endsection
@section('title', '| Detalhes do produto')

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Início<i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="">Detalhes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Single -->
    <section class="shop single section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div>
                                <a href="{{ asset('frontend/products/' . $product_detail->photo) }}">
                                    <img src="{{ asset('frontend/products/' . $product_detail->photo) }}" alt="Product" class="thumb" />
                                </a>
                            </div>

                            <div class="thumbnails changeimage text-center" style="cursor: pointer;">
                                <img src="{{ asset('frontend/products/' .$product_detail->photo) }}" alt="Product" class="img-small" width="75"
                                    style="padding: 8px;" />
                                @foreach ($imageGalleries as $imagesGallery)
                                    <img src="{{ asset('frontend/products/large/' . $imagesGallery->image) }}"
                                        alt="Galeria" width="75" style="padding: 8px;" class="img-small">
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="product-des">
                                <!-- Description -->
                                <div class="short">
                                    <h4>{{ $product_detail->title }}</h4>
                                    <div class="rating-main">
                                        <ul class="rating">
                                            @php
                                                $rate = ceil($product_detail->getReview->avg('rate'));
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($rate >= $i) <li><i
                                                class="fa fa-star"></i></li>
                                            @else
                                                <li><i class="far fa-star"></i></li> @endif
                                            @endfor
                                        </ul>
                                        <a href="#" class="total-review">({{ $product_detail['getReview']->count() }})
                                            Avaliações</a>
                                    </div>
                                    @php
                                        $after_discount = $product_detail->price - ($product_detail->price * $product_detail->discount) / 100;
                                    @endphp
                                    <p class="price"><span
                                            class="discount">R${{ number_format($after_discount, 2) }}</span><s>R${{ number_format($product_detail->price, 2) }}</s>
                                    </p>
                                    <p class="description">{!! $product_detail->summary !!}</p>
                                </div>
                                <!--/ End Description -->
                                <!-- Color -->
                                {{-- <div class="color">
												<h4>Opções disponíveis <span>Cores</span></h4>
												<ul>
													<li><a href="#" class="one"><i class="ti-check"></i></a></li>
													<li><a href="#" class="two"><i class="ti-check"></i></a></li>
													<li><a href="#" class="three"><i class="ti-check"></i></a></li>
													<li><a href="#" class="four"><i class="ti-check"></i></a></li>
												</ul>
											</div> --}}
                                <!--/ End Color -->
                                <!-- Size -->
                                @if ($product_detail->size)
                                    <div class="size mt-4">
                                        <h4>Tamanhos</h4>
                                        <ul>
                                            @php
                                                $sizes = explode(',', $product_detail->size);
                                            @endphp
                                            @foreach ($sizes as $size)
                                                <li><a href="#" class="one">{{ $size }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($product_detail->address != null)
                                    <div class="mt-2">
                                        <div class="mt-2 d-flex justify-content-between">
                                            <ul>
                                                <h6>Datas disponíveis</h6>
                                                <li>{{ $product_detail->available_dates }}</li>
                                            </ul>
                                            <ul class="d-flex flex-row">
                                                @if ($product_detail->pool === 1)
                                                    <li><img src="{{ asset('frontend/icons/pool-icon.png') }}"
                                                            alt="Piscina" title="Piscina" width="20"> <i
                                                            class="fa fa-check"></i>
                                                    </li>
                                                @endif

                                                @if ($product_detail->barbecue === 1)
                                                    <li class="ml-3"><img
                                                            src="{{ asset('frontend/icons/barbecue-icon.png') }}"
                                                            alt="Churrasqueira" title="Churrasqueira" width="20"> <i
                                                            class="fa fa-check"></i></li>
                                                @endif

                                                @if ($product_detail->soccer === 1)
                                                    <li class="ml-3"><img
                                                            src="{{ asset('frontend/icons/gramado-icon.png') }}"
                                                            alt="Campo de futebol" title="Campo de futebol" width="20"> <i
                                                            class="fa fa-check"></i></li>
                                                @endif

                                                @if ($product_detail->air_conditioning === 1)
                                                    <li class="ml-3"><img
                                                            src="{{ asset('frontend/icons/air-icon.png') }}"
                                                            alt="Ar condicionado" title="Ar condicionado" width="20"> <i
                                                            class="fa fa-check"></i></li>
                                                @endif

                                                @if ($product_detail->wifi === 1)
                                                    <li class="ml-3"><img
                                                            src="{{ asset('frontend/icons/wifi-icon.png') }}"
                                                            alt="Wi-Fi" title="Wi-Fi" width="20"> <i
                                                            class="fa fa-check"></i>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                @if ($product_detail->available_dates)
                                    <div class="form-row mt-3">
                                        <ul class="col-md-6">
                                            <h6>Data desejável</h6>
                                            <input type="date" name="location_date">
                                        </ul>
                                        <ul class="col-md-6">
                                            <h6>Até</h6>
                                            <input type="date" name="location_date">
                                        </ul>
                                    </div>
                                @endif
                                <!--/ End Size -->
                                <!-- Product Buy -->
                                <div class="product-buy">
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="quantity">
                                            <h6>Quantidade: </h6>
                                            <!-- Input Order -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        disabled="disabled" data-type="minus" data-field="quant[1]">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="slug" value="{{ $product_detail->slug }}">
                                                <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                    data-max="1000" value="1" id="quantity">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        data-type="plus" data-field="quant[1]">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!--/ End Input Order -->
                                        </div>
                                        <div class="add-to-cart mt-4">
                                            <button type="submit" class="btn">Adicionar ao carrinho</button>
                                            <a href="{{ route('add-to-wishlist', $product_detail->slug) }}"
                                                class="btn min"><i class="far fa-heart"></i></a>
                                        </div>
                                    </form>

                                    @if (isset($product_detail->cat_info))
                                        <p class="cat">Categoria: <a
                                                href="{{ route('product-cat', $product_detail->cat_info['slug']) }}">{{ $product_detail->cat_info['title'] }}</a>
                                        </p>
                                    @endif
                                    @if (isset($product_detail->sub_cat_info))
                                        {{-- <p class="cat mt-1">Sub Category :<a
                                                href="{{ route('product-sub-cat', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']]) }}">{{ $product_detail->sub_cat_info['title'] }}</a>
                                        </p> --}}
                                    @endif
                                    <p class="availability">Estoque: @if ($product_detail->stock > 0)<span
                                            class="badge badge-success">{{ $product_detail->stock }}</span>@else
                                            <span class="badge badge-danger">{{ $product_detail->stock }}</span>
                                        @endif
                                    </p>
                                </div>
                                <!--/ End Product Buy -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product-info">
                                <div class="nav-main">
                                    <!-- Tab Nav -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                href="#description" role="tab">Descrição</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews"
                                                role="tab">Avaliações</a></li>
                                    </ul>
                                    <!--/ End Tab Nav -->
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <!-- Description Tab -->
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        <div class="tab-single">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="single-des">
                                                        <p>{!! $product_detail->description !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Description Tab -->
                                    <!-- Reviews Tab -->
                                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                                        <div class="tab-single review-panel">
                                            <div class="row">
                                                <div class="col-12">

                                                    <!-- Review -->
                                                    <div class="comment-review">
                                                        <div class="add-review">
                                                            <h5>Adicionar uma avaliação</h5>
                                                            <p>Seu endereço de e-mail não será publicado. Os campos
                                                                obrigatórios marcados.</p>
                                                        </div>
                                                        <h4>Sua avaliação <span class="text-danger">*</span></h4>
                                                        <div class="review-inner">
                                                            <!-- Form -->
                                                            @auth
                                                                <form class="form" method="post"
                                                                    action="#">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="rating_box">
                                                                                <div class="star-rating">
                                                                                    <div class="star-rating__wrap">
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-5" type="radio"
                                                                                            name="rate" value="5">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-5"
                                                                                            title="5 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-4" type="radio"
                                                                                            name="rate" value="4">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-4"
                                                                                            title="4 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-3" type="radio"
                                                                                            name="rate" value="3">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-3"
                                                                                            title="3 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-2" type="radio"
                                                                                            name="rate" value="2">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-2"
                                                                                            title="2 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-1" type="radio"
                                                                                            name="rate" value="1">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-1"
                                                                                            title="1 out of 5 stars"></label>
                                                                                        @error('rate')
                                                                                            <span
                                                                                                class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group">
                                                                                <label>Escrever uma avaliação</label>
                                                                                <textarea name="review" rows="6"
                                                                                    placeholder=""></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group button5">
                                                                                <button type="submit"
                                                                                    class="btn">Enviar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <p class="text-center p-5">
                                                                    Você precisa fazer <a href="{{ route('login.form') }}"
                                                                        style="color:rgb(54, 54, 204)">Login</a> OU <a
                                                                        style="color:blue"
                                                                        href="{{ route('register.form') }}">Cadastrar</a>

                                                                </p>
                                                                <!--/ End Form -->
                                                            @endauth
                                                        </div>
                                                    </div>

                                                    <div class="ratting-main">
                                                        <div class="avg-ratting">
                                                            {{-- @php 
																			$rate=0;
																			foreach($product_detail->rate as $key=>$rate){
																				$rate +=$rate
																			}
																		@endphp --}}
                                                            <h4>{{ ceil($product_detail->getReview->avg('rate')) }}
                                                                <span>(Geral)</span>
                                                            </h4>
                                                            <span>Baseado em {{ $product_detail->getReview->count() }}
                                                                comentários</span>
                                                        </div>
                                                        @foreach ($product_detail['getReview'] as $data)
                                                            <!-- Single Rating -->
                                                            <div class="single-rating">
                                                                <div class="rating-author">
                                                                    @if ($data->user_info['photo'])
                                                                        <img src="{{ $data->user_info['photo'] }}"
                                                                            alt="{{ $data->user_info['photo'] }}">
                                                                    @else
                                                                        <img src="{{ asset('backend/img/avatar.png') }}"
                                                                            alt="Profile.jpg">
                                                                    @endif
                                                                </div>
                                                                <div class="rating-des">
                                                                    <h6>{{ $data->user_info['name'] }}</h6>
                                                                    <div class="ratings">

                                                                        <ul class="rating">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($data->rate >=
                                                                                $i) <li><i
                                                                                class="fa
                                                                                fa-star"></i></li>
                                                                            @else
                                                                                <li><i class="far
                                                                                fa-star"></i></li> @endif
                                                                            @endfor
                                                                        </ul>
                                                                        <div class="rate-count">
                                                                            (<span>{{ $data->rate }}</span>)</div>
                                                                    </div>
                                                                    <p>{{ $data->review }}</p>
                                                                </div>
                                                            </div>
                                                            <!--/ End Single Rating -->
                                                        @endforeach
                                                    </div>

                                                    <!--/ End Review -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Reviews Tab -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Shop Single -->

    <!-- Start Most Popular -->
    <div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Produtos relacionados</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- {{$product_detail->rel_prods}} --}}
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach ($product_detail->rel_prods as $data)
                            @if ($data->id !== $product_detail->id)
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{ route('product-detail', $data->slug) }}">
                                            @php
                                                $photo = explode(',', $data->photo);
                                            @endphp
                                            <img class="default-img" src="{{ $photo[0] }}" alt="{{ $photo[0] }}">
                                            <img class="hover-img" src="{{ $photo[0] }}" alt="{{ $photo[0] }}">
                                            <span class="price-dec">{{ $data->discount }} % Off</span>
                                            {{-- <span class="out-of-stock">Hot</span> --}}
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#modelExample" title="Quick View"
                                                    href="#"><i class="fas fa-eye"></i><span>Compra rápida</span></a>
                                                <a title="Wishlist" href="#"><i class="far fa-heart"></i><span>Adicionar à
                                                        lista de desejos</span></a>
                                                <a title="Compare" href="#"><i
                                                        class="fas fa-chart-bar"></i><span>Comparar</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Add to cart" href="#">Adicionar ao carrinho</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a
                                                href="{{ route('product-detail', $data->slug) }}">{{ $data->title }}</a>
                                        </h3>
                                        <div class="product-price">
                                            @php
                                                $after_discount = $data->price - ($data->discount * $data->price) / 100;
                                            @endphp
                                            <span class="old">R${{ number_format($data->price, 2) }}</span>
                                            <span>R${{ number_format($after_discount, 2) }}</span>
                                        </div>

                                    </div>
                                </div>
                                <!-- End Single Product -->

                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Most Popular Area -->


    <!-- Modal -->
    {{-- <div class="modal fade" id="modelExample" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close"
                            aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <!-- Product Slider -->
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider">
                                        <img src="images/modal1.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal2.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal3.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal4.png" alt="#">
                                    </div>
                                </div>
                            </div>
                            <!-- End Product slider -->
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>Flared Shift Dress</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="#"> (1 customer review)</a>
                                    </div>
                                    <div class="quickview-stock">
                                        <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                    </div>
                                </div>
                                <h3>$29.00</h3>
                                <div class="quickview-peragraph">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad
                                        impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo
                                        ipsum numquam.</p>
                                </div>
                                <div class="size">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Size</h5>
                                            <select>
                                                <option selected="selected">s</option>
                                                <option>m</option>
                                                <option>l</option>
                                                <option>xl</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Color</h5>
                                            <select>
                                                <option selected="selected">orange</option>
                                                <option>purple</option>
                                                <option>black</option>
                                                <option>pink</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="quantity">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled"
                                                data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="qty" class="input-number" data-min="1" data-max="1000"
                                            value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                                data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn">Add to cart</a>
                                    <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                    <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                                </div>
                                <div class="default-social">
                                    <h4 class="share-now">Share:</h4>
                                    <ul>
                                        <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                        <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Modal end -->

@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/easyzoom.css') }}">
    <style>
        /* Rating */
        .rating_box {
            display: inline-flex;
        }

        .star-rating {
            font-size: 0;
            padding-left: 10px;
            padding-right: 10px;
        }

        .star-rating__wrap {
            display: inline-block;
            font-size: 1rem;
        }

        .star-rating__wrap:after {
            content: "";
            display: table;
            clear: both;
        }

        .star-rating__ico {
            float: right;
            padding-left: 2px;
            cursor: pointer;
            color: #F7941D;
            font-size: 16px;
            margin-top: 5px;
        }

        .star-rating__ico:last-child {
            padding-left: 0;
        }

        .star-rating__input {
            display: none;
        }

        .star-rating__ico:hover:before,
        .star-rating__ico:hover~.star-rating__ico:before,
        .star-rating__input:checked~.star-rating__ico:before {
            content: "\F005";
        }

    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('frontend/js/easyzoom.js') }}"></script>

    <script>
        // Change thumg image
        $(document).ready(function() {
            let thumb = document.querySelector('img.thumb');
            let imgSmall = document.querySelectorAll('img.img-small');

            imgSmall.forEach(function(el) {
                el.addEventListener('click', function() {
                    let srcImgSmall = el.src;
                    thumb.src = srcImgSmall;
                });
            });
        });

        // Easyzoom
        $(document).ready(function() {
            var $easyzoom = $('.easyzoom').easyZoom();
            var api1 = $easyzoom.filter('click', 'a', function(e) {
                var $this = $(this);

                e.preventDefault();

                api1.swap($this.data('standard'), $this.attr('href'));
            });

            var api2 = $easyzoom.filter('click', function(e) {
                var $this = $(this);

                if ($this.data("active") === true) {
                    $this.text("Switch on").data("active", false);
                    api2.teardown();
                } else {
                    $this.text("Switch off").data("active", true);
                    api2.init();
                }
            });
        });

    </script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                asset:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}

@endpush
