@extends('frontend.layouts.master')
@section('title', '| Página inicial')

@section('content')
    <!-- Slider Area -->
    {{-- <section class="hero-slider">
        <!-- Single Slider -->

        <div class="single-slider">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-9 offset-lg-3 col-12">
                        <div class="text-inner">
                            <div class="row">
                                <div class="col-lg-7 col-12">
                                    <div class="hero-text">
                                        <h1><span>ATÉ 50% DE DESCONTO </span>Camisas para homens</h1>
                                        <p>tensaknh ajshd ahsdujhauw ahsduh  <br> kasjdk asjkd jkad jwiqeji jasid.</p>
                                        <div class="button">
                                            <a href="#" class="btn">Comprar agora!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Single Slider -->
    </section> --}}
    @if (count($banners) > 0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <li data-target="#Gslider" data-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}">
                    </li>
                @endforeach

            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="first-slide"
                            src="{{ asset('frontend/banners/' . $banner->photo) }}" alt="First slide">
                        <div class="carousel-caption d-none d-md-block text-left">
                            <h1 class="wow fadeInDown">{{ $banner->title }}</h1>
                            <p style="color: white;">{!! html_entity_decode($banner->description) !!}</p>
                            <a class="btn btn-lg ws-btn wow fadeInUpBig" href="#"
                                role="button">Ver agora <i class="far fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Próxima</span>
            </a>
        </section>
    @endif

    <!--/ End Slider Area -->

    {{-- <!-- Start Small Banner  -->
    <section class="small-banner section">
        <div class="container-fluid">
            <div class="row">
                @php
                    $category_lists = DB::table('categories')
                        ->where('status', 'active')
                        ->limit(3)
                        ->get();
                @endphp
                @if ($category_lists)
                    @foreach ($category_lists as $cat)
                        @if ($cat->is_parent == 1)
                            <!-- Single Banner  -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-banner">
                                    @if ($cat->photo)
                                        <img src="{{ $cat->photo }}" alt="{{ $cat->photo }}">
                                    @else
                                        <img src="https://via.placeholder.com/600x370" alt="#">
                                    @endif
                                    <div class="content">
                                        <h3>{{ $cat->title }}</h3>
                                        <a href="{{ route('product-cat', $cat->slug) }}">Veja agora</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- /End Single Banner  -->
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- End Small Banner --> --}}

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Chácaras em destaque</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @php
                                    $categories = DB::table('categories')
                                        ->where('status', 'active')
                                        ->where('is_parent', 1)
                                        ->get();
                                @endphp
                                @if ($categories)
                                    <button class="btn" style="background:black" data-filter="*">
                                        Todas as chácaras
                                    </button>
                                    @foreach ($categories as $key => $cat)

                                        <button class="btn" style="background:none;color:black;"
                                            data-filter=".{{ $cat->id }}">
                                            {{ $cat->title }}
                                        </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        <div class="tab-content isotope-grid" id="myTabContent">
                            <!-- Start Single Tab -->
                            @if ($product_lists)
                                @foreach ($product_lists as $key => $product)
                                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->cat_id }}">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="#">
                                                    <img src="{{ asset('frontend/products/' . $product->photo) }}" alt="{{ $product->photo }}">
                                                    @if ($product->stock <= 0)
                                                        <span class="out-of-stock">Esgotado</span>
                                                    @elseif($product->condition=='new')
                                                    <span class="new">Novo</span @elseif($product->condition=='hot')
                                                        <span class="hot">Quente</span>
                                                    @else
                                                        <span class="price-dec">{{ $product->discount }}% desconto</span>
                                                    @endif


                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                            title="Visualização rápida" href="#"><i class=" fas fa-eye"></i><span>Visualização
                                                                rápida</span></a>
                                                        <a title="Wishlist"
                                                            href="{{ route('add-to-wishlist', $product->slug) }}"><i class="far fa-heart"></i><span>Adicionar à lista de
                                                                desejos</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart"
                                                            href="#">Adicionar
                                                            ao carrinho</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a
                                                        href="#">{{ $product->title }}</a>
                                                </h3>
                                                <div class="product-price">
                                                    @php
                                                        $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                    @endphp
                                                    <span>R${{ number_format($after_discount, 2) }}</span>
                                                    <del
                                                        style="padding-left:4%;">R${{ number_format($product->price, 2) }}</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!--/ End Single Tab -->
                            @endif

                            <!--/ End Single Tab -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Area -->
    {{-- @php
    $featured=DB::table('products')->where('is_featured',1)->where('status','active')->orderBy('id','DESC')->limit(1)->get();
@endphp --}}
    <!-- Start Midium Banner  -->
    <section class="midium-banner">
        <div class="container">
            <div class="row">
                @if ($featured)
                    @foreach ($featured as $data)
                        <!-- Single Banner  -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="single-banner">
                                <img src="{{ asset('frontend/products/' . $product->photo) }}" alt="{{ $product->photo }}">
                                <div class="content">
                                    @if (isset($data->cat_info))
                                        <p>{{ $data->cat_info['title'] }}</p>
                                    @endif
                                    <h3 style="color: white;">{{ $data->title }} <br>Com<span> {{ $data->discount }}%</span></h3>
                                    <a href="#">Locar agora</a>
                                </div>
                            </div>
                        </div>
                        <!-- /End Single Banner  -->
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- End Midium Banner -->

    <!-- Start Most Popular -->
    <div class="product-area most-popular section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Chácaras em "quente"</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach ($product_lists as $product)
                            @if ($product->condition == 'hot')
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="#">
                                            <img src="{{ asset('frontend/products/' . $product->photo) }}" alt="{{ $product->photo }}">
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                    title="Visualização rápida" href="#"><i class=" fas fa-eye"></i><span>Visualização
                                                        rápida</span></a>
                                                <a title="Wishlist"
                                                    href="{{ route('add-to-wishlist', $product->slug) }}"><i class="far fa-heart"></i><span>Adicionar à lista de desejos</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a href="#">Adicionar ao
                                                    carrinho</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a
                                                href="#">{{ $product->title }}</a>
                                        </h3>
                                        <div class="product-price">
                                            <span class="old">R${{ number_format($product->price, 2) }}</span>
                                            @php
                                                $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                            @endphp
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

    <!-- Start Shop Home List  -->
    <section class="shop-home-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-section-title">
                                <h1>Adicionados recentemente</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $product_lists = DB::table('products')
                                ->where('status', 'active')
                                ->orderBy('id', 'DESC')
                                ->limit(6)
                                ->get();
                        @endphp
                        @foreach ($product_lists as $product)
                            <div class="col-md-4">
                                <!-- Start Single List  -->
                                <div class="single-list">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="list-image overlay">
                                                <img src="{{ asset('frontend/products/' . $product->photo) }}"
                                                    alt="{{ $product->photo }}" style="height: 150px;">
                                                <a href="#" class="buy"><i
                                                        class="fa fa-shopping-bag"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 no-padding">
                                            <div class="content">
                                                <h4 class="title"><a href="#">{{ $product->title }}</a></h4>
                                                <p class="price with-discount">
                                                    {{ number_format($product->discount) }}%
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single List  -->
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Home List  -->
    @foreach ($featured as $data)
        <!-- Start Cowndown Area -->
        <section class="cown-down">
            <div class="section-inner ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-12 padding-right">
                            <div class="image">
                                <img src="{{ asset('frontend/products/' . $product->photo) }}"
                                    alt="{{ $product->photo }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 padding-left">
                            <div class="content">
                                <div class="heading-block">
                                    <p class="small-title">Ofertas do dia</p>
                                    <h3 class="title">{{ $data->title }}</h3>
                                    <p class="text">{!! html_entity_decode($data->summary) !!}</p>
                                    @php
                                        $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                    @endphp
                                    <h1 class="price">R${{ number_format($after_discount) }}
                                        <s>R${{ number_format($data->price) }}</s>
                                    </h1>
                                    <div class="coming-time">
                                        <div class="clearfix" data-countdown="2021/09/30"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /End Cowndown Area -->
    @endforeach
    <!-- Start Shop Blog  -->
    <section class="shop-blog section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Do nosso blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($posts)
                    @foreach ($posts as $post)
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Start Single Blog  -->
                            <div class="shop-single-blog">
                                <img src="{{ asset('frontend/products/' . $product->photo) }}" alt="{{ $product->photo }}">
                                <div class="content">
                                    <p class="date">{{ $post->created_at->format('d M , Y. D') }}</p>
                                    <a href="#"
                                        class="title">{{ $post->title }}</a>
                                    <a href="#" class="more-btn">Continuar
                                        lendo</a>
                                </div>
                            </div>
                            <!-- End Single Blog  -->
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <!-- End Shop Blog  -->

    <!-- Start Shop Services Area -->
    @include('frontend.layouts.services')
    <!-- End Shop Services Area -->

    @include('frontend.layouts.newsletter')

    <!-- Modal -->
    @if ($product_lists)
        @foreach ($product_lists as $key => $product)
            <div class="modal fade" id="{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            <img src="{{ asset('frontend/products/' . $product->photo) }}" alt="{{ $product->photo }}" style="height: 510px; object-fit: cover;">
                                                <div class="single-slider">
                                                    <img src="{{ asset('frontend/products/' . $product->photo) }}" alt="{{ $product->photo }}">
                                                </div>
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2><a href="#">
                                                {{ $product->title }}</a></h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    {{-- <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="fa fa-star"></i> --}}
                                                    @php
                                                        $rate = DB::table('product_reviews')
                                                            ->where('product_id', $product->id)
                                                            ->avg('rate');
                                                        $rate_count = DB::table('product_reviews')
                                                            ->where('product_id', $product->id)
                                                            ->count();
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($rate >= $i) <i
                                                        class="yellow fa fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i> @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{ $rate_count }} Avaliações de usuários)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if ($product->stock > 0)
                                                    <span><i class="fas fa-check-circle"></i> {{ $product->stock }}
                                                        Livre </span>
                                                @else
                                                    <span><i class="far fa-times-circle text-danger"></i>
                                                        {{ $product->stock }} Locado</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <h3><small><del
                                                    class="text-muted">R${{ number_format($product->price, 2) }}</del></small>
                                            R${{ number_format($after_discount, 2) }} </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        @if ($product->size)
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Tamanho</h5>
                                                        <select>
                                                            @php
                                                                $sizes = explode(',', $product->size);
                                                                // dd($sizes);
                                                            @endphp
                                                            @foreach ($sizes as $size)
                                                                <option>{{ $size }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="col-lg-6 col-12">
                                                        <h5 class="title">Color</h5>
                                                        <select>
                                                            <option selected="selected">orange</option>
                                                            <option>purple</option>
                                                            <option>black</option>
                                                            <option>pink</option>
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($product->address != null)
                                            <div class="mt-2">
                                                <div class="mt-2 d-flex justify-content-between">
                                                    <ul>
                                                        <h6>Datas disponíveis</h6>
                                                        <li>{{ $product->available_dates }}</li>
                                                    </ul>
                                                    <ul class="d-flex flex-row">
                                                        @if ($product->pool === 1)
                                                            <li><img src="{{ asset('frontend/icons/pool-icon.png') }}"
                                                                    alt="Piscina" title="Piscina" width="20"> <i
                                                                    class="fas fa-check"></i>
                                                            </li>
                                                        @endif

                                                        @if ($product->barbecue === 1)
                                                            <li class="ml-3"><img
                                                                    src="{{ asset('frontend/icons/barbecue-icon.png') }}"
                                                                    alt="Churrasqueira" title="Churrasqueira" width="20"> <i
                                                                    class="fas fa-check"></i></li>
                                                        @endif

                                                        @if ($product->soccer === 1)
                                                            <li class="ml-3"><img
                                                                    src="{{ asset('frontend/icons/gramado-icon.png') }}"
                                                                    alt="Campo de futebol" title="Campo de futebol"
                                                                    width="20"> <i class="fas fa-check"></i></li>
                                                        @endif

                                                        @if ($product->air_conditioning === 1)
                                                            <li class="ml-3"><img
                                                                    src="{{ asset('frontend/icons/air-icon.png') }}"
                                                                    alt="Ar condicionado" title="Ar condicionado"
                                                                    width="20"> <i class="fas fa-check"></i></li>
                                                        @endif

                                                        @if ($product->wifi === 1)
                                                            <li class="ml-3"><img
                                                                    src="{{ asset('frontend/icons/wifi-icon.png') }}"
                                                                    alt="Wi-Fi" title="Wi-Fi" width="20"> <i
                                                                    class="fas fa-check"></i>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                        <form action="#" method="POST" class="mt-4">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{ $product->slug }}">
                                                    <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                        data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[1]">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Adicionar ao carrinho</button>
                                                <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                                    class="btn min"><i class="far fa-heart"></i></a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                            <!-- ShareThis BEGIN -->
                                            <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection

@push('styles')
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=6073245c4d36eb0018700ae0&product=inline-share-buttons'
        async='async'></script>
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=6073245c4d36eb0018700ae0&product=inline-share-buttons'
        async='async'></script>
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
            background: #000000;
            color: black;
        }

        #Gslider .carousel-inner {
            height: 550px;
        }

        #Gslider .carousel-inner img {
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
            bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
            font-size: 50px;
            font-weight: bold;
            line-height: 100%;
            color: #F7941D;
        }

        #Gslider .carousel-inner .carousel-caption p {
            font-size: 18px;
            color: black;
            margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
            bottom: 70px;
        }

    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
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
							// document.location.href=document.location.href;
						});
					}
                    else{
                        window.location.href='user/login'
                    }
                }
            })
        });
    </script> --}}
    {{-- <script>
        $('.wishlist').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            // alert(pro_id);
            $.ajax({
                url:"{{route('add-to-wishlist')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id,
                },
                success:function(response){
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
							// document.location.href=document.location.href;
						}); 
                    }
                }
            });
        });
    </script> --}}
    <script>
        /*==================================================================
                                                            [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function() {
            $filter.on('click', 'button', function() {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({
                    filter: filterValue
                });
            });

        });

        // init Isotope
        $(window).on('load', function() {
            var $grid = $topeContainer.each(function() {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine: 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function() {
            $(this).on('click', function() {
                for (var i = 0; i < isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });

    </script>
    <script>
        function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el
                .exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el
                .msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }

    </script>

@endpush
