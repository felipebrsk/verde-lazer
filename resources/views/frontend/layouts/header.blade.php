<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                $settings = DB::table('settings')->get();
                            @endphp
                            <li><i class="fas fa-phone"></i>
                                @foreach ($settings as $data)
                                    {{ $data->phone }}
                                @endforeach
                            </li>
                            <li><i class="fas fa-envelope"></i>
                                @foreach ($settings as $data)
                                    {{ $data->email }}
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    <!-- End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="fas fa-map-marker-alt"></i> <a href="#">Localizar compra</a>
                            </li>
                            @auth
                                @if (Auth::user()->role == 'admin')
                                    <li><i class="fas fa-user"></i> <a href="{{ route('admin') }}" target="_blank">Área
                                            administrativa</a>
                                    </li>
                                @else
                                    <li><i class="fas fa-user"></i> <a href="#" target="_blank">Área administrativa</a>
                                    </li>
                                @endif
                                <li><i class="fas fa-power-off"></i> <a href="#">Sair</a></li>

                            @else
                                <li><i class="fas fa-power-off"></i><a href="{{ route('login.form') }}">Login /</a> <a
                                        href="{{ route('register.form') }}">Cadastrar</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->

    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                            $settings = DB::table('settings')->get();
                        @endphp
                        <a href="#"><img src="@foreach ($settings as $data) {{ asset('/frontend/img/' . $data->logo) }} @endforeach"
                                alt="logo" width="150"></a>
                    </div>
                    <!-- End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#"><i class="fas fa-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Pesquisar..." name="search">
                                <button value="search" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <!-- End Search Form -->
                    </div>
                    <!-- End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <form method="POST" action="{{ route('product.search') }}">
                            <div class="search-bar">
                                @csrf
                                <select name="category_search">
                                    <option value="">Todas</option>
                                    @foreach (Helper::getAllCategory() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                                <input name="search" placeholder="Pesquise por algo aqui..." type="search">
                                <button class="btnn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php
                                $total_prod = 0;
                                $total_amount = 0;
                            @endphp
                            @if (session('wishlist'))
                                @foreach (session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod += $wishlist_items['quantity'];
                                        $total_amount += $wishlist_items['amount'];
                                    @endphp
                                @endforeach
                            @endif
                            <a href="{{ route('wishlist') }}" class="single-icon"><i class="far fa-heart"></i> <span
                                    class="total-count">{{ Helper::wishlistCount() }}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ count(Helper::getAllProductFromWishlist()) }} chácaras</span>
                                        <a href="{{ route('wishlist') }}">Ver lista de desejos</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @foreach (Helper::getAllProductFromWishlist() as $data)
                                            <li>
                                                <a href="{{ route('wishlist-delete', $data->id) }}" class="remove" title="Remover este item"><i
                                                        class="fas fa-trash"></i></a>
                                                <a class="cart-img" href="{{ route('product-detail', $data->product->slug) }}"><img src="{{ asset('frontend/products/' . $data->product->photo) }}"
                                                        alt="{{ $data->product->photo }}"></a>
                                                <h4><a href="{{ route('product-detail', $data->product->slug) }}" target="_blank">{{ $data->product['title'] }}</a></h4>
                                                <p class="quantity">{{ $data->quantity }} x - <span
                                                        class="amount">R${{ number_format($data->price, 2) }}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span
                                                class="total-amount">R${{ number_format(Helper::totalWishlistPrice(), 2) }}</span>
                                        </div>
                                        <a href="#" class="btn animate">Carrinho</a>
                                    </div>
                                </div>
                            @endauth
                            <!-- End Shopping Item -->
                        </div>

                        <div class="sinlge-bar shopping">
                            <a href="{{ route('cart') }}" class="single-icon"><i class="fas fa-shopping-bag"></i> <span
                                    class="total-count">{{ Helper::cartCount() }}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ count(Helper::getAllProductFromCart()) }} chácaras</span>
                                        <a href="{{ route('cart') }}">Ver carrinho</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @foreach (Helper::getAllProductFromCart() as $data)
                                            @php
                                                $photo = explode(',', $data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{ route('cart-delete', $data->id) }}" class="remove" title="Remover este item"><i
                                                        class="fas fa-trash"></i></a>
                                                <a class="cart-img" href="{{ route('product-detail', $data->product->slug) }}"><img src="{{ asset('frontend/products/' . $data->product->photo) }}"
                                                        alt="{{ asset('frontend/products/' . $data->product->photo) }}"></a>
                                                <h4><a href="{{ route('product-detail', $data->product->slug) }}" target="_blank">{{ $data->product['title'] }}</a></h4>
                                                <p class="quantity">{{ $data->quantity }} x - <span
                                                        class="amount">R${{ number_format($data->price, 2) }}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span
                                                class="total-amount">R${{ number_format(Helper::totalCartPrice(), 2) }}</span>
                                        </div>
                                        <a href="#" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!-- End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{ Request::path() == '/' ? 'active' : '' }}"><a
                                                    href="{{ route('home') }}">Início</a></li>
                                            <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}"><a
                                                    href="{{ route('about-us') }}">Sobre nós</a></li>
                                            <li class="@if (Request::path()== 'product-grids' ||
                                                Request::path()== 'product-lists' ) active @endif"><a href="{{ route('product-grids') }}">Produtos</a><span class="new">Novo</span></li>
                                            {{ Helper::getHeaderCategory() }}
                                            <li class="{{ Request::path() == 'blog' ? 'active' : '' }}"><a
                                                    href="{{ route('blog') }}">Blog</a></li>

                                            <li class="{{ Request::path() == 'contact' ? 'active' : '' }}"><a
                                                    href="{{ route('contact') }}">Contate-nos</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!-- End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Inner -->
</header>
