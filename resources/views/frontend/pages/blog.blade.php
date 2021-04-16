@extends('frontend.layouts.master')
@section('title', '| Blog')

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Início<i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Blog Single -->
    <section class="blog-single shop-blog grid section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        @foreach ($posts as $post)
                            {{-- {{$post}} --}}
                            <div class="col-lg-6 col-md-6 col-12">
                                <!-- Start Single Blog  -->
                                <div class="shop-single-blog">
                                    <img src="{{ asset('frontend/blog/' . $post->photo) }}" alt="{{ $post->photo }}">
                                    <div class="content">
                                        @php
                                            $author_info = DB::table('users')
                                                ->select('name')
                                                ->where('id', $post->added_by)
                                                ->get();
                                        @endphp
                                        <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i>
                                            {{ $post->created_at->format('d M, Y. D') }}
                                            <span class="float-right">
                                                <i class="fas fa-user" aria-hidden="true"></i>
                                                @foreach ($author_info as $data)
                                                    @if ($data->name)
                                                        {{ $data->name }}
                                                    @else
                                                        Anônimo
                                                    @endif
                                                @endforeach
                                            </span>
                                        </p>
                                        <a href="#"
                                            class="title">{{ $post->title }}</a>
                                        <p>{!! html_entity_decode($post->summary) !!}</p>
                                        <a href="#" class="more-btn">Continuar
                                            lendo</a>
                                    </div>
                                </div>
                                <!-- End Single Blog  -->
                            </div>
                        @endforeach
                        <div class="col-12">
                            <!-- Pagination -->
                            {{-- {{$posts->appends($_GET)->links()}} --}}
                            <!--/ End Pagination -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget search">
                            <form class="form" method="GET" action="#">
                                <input type="text" placeholder="Pesquise aqui..." name="search">
                                <button class="button" type="sumbit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Categorias do blog</h3>
                            <ul class="categor-list">
                                @if (!empty($_GET['category']))
                                    @php
                                        $filter_cats = explode(',', $_GET['category']);
                                    @endphp
                                @endif
                                <form action="#" method="POST">
                                    @csrf
                                    {{-- {{count(Helper::postCategoryList())}} --}}
                                    @foreach (Helper::postCategoryList('posts') as $cat)
                                        <li>
                                            <a href="#">{{ $cat->title }} </a>
                                        </li>
                                    @endforeach
                                </form>

                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">Recentemente publicados</h3>
                            @foreach ($rcnt_posts as $post)
                                <!-- Single Post -->
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{ $post->photo }}" alt="{{ $post->photo }}">
                                    </div>
                                    <div class="content">
                                        <h5><a href="#">{{ $post->title }}</a></h5>
                                        <ul class="comment">
                                            @php
                                                $author_info = DB::table('users')
                                                    ->select('name')
                                                    ->where('id', $post->added_by)
                                                    ->get();
                                            @endphp
                                            <li><i class="fa fa-calendar"
                                                    aria-hidden="true"></i>{{ $post->created_at->format('d M, y') }}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                @foreach ($author_info as $data)
                                                    @if ($data->name)
                                                        {{ $data->name }}
                                                    @else
                                                        Anônimo
                                                    @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Post -->
                            @endforeach
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget side-tags">
                            <h3 class="title">Tags</h3>
                            <ul class="tag">
                                @if (!empty($_GET['tag']))
                                    @php
                                        $filter_tags = explode(',', $_GET['tag']);
                                    @endphp
                                @endif
                                <form action="#" method="POST">
                                    @csrf
                                    @foreach (Helper::postTagList('posts') as $tag)
                                        <li>
                                        <li>
                                            <a href="#">{{ $tag->title }} </a>
                                        </li>
                                        </li>
                                    @endforeach
                                </form>
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget newsletter">
                            <h3 class="title">Newslatter</h3>
                            <div class="letter-inner">
                                <h4>Inscreva-se e receba <br> as últimas atualizações.</h4>
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="form-inner">
                                        <input type="email" name="email" placeholder="Insira seu e-mail">
                                        <button type="submit" class="btn mt-2">Inscrever</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--/ End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blog Single -->
@endsection
@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }

    </style>

@endpush
