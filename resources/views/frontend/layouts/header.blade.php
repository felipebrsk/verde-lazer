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
                                    <li><i class="fas fa-user"></i> <a href="{{ route('admin') }}"
                                            target="_blank">Área administrativa</a>
                                    </li>
                                @else
                                    <li><i class="fas fa-user"></i> <a href="#"
                                            target="_blank">Área administrativa</a>
                                    </li>
                                @endif
                                <li><i class="fas fa-power-off"></i> <a href="#">Sair</a></li>

                            @else
                                <li><i class="fas fa-power-off"></i><a href="#">Login /</a> <a
                                        href="#">Cadastrar</a></li>
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
                        <a href="#"><img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" alt="logo" width="150"></a>
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
                        <div class="search-bar">
                            <select>
                                <option>Todas</option>
                                @foreach (Helper::getAllCategory() as $cat)
                                    <option>{{ $cat->title }}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="#">
                                @csrf
                                <input name="search" placeholder="Pesquise por algo aqui..." type="search">
                                <button class="btnn" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
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
                            <a href="#" class="single-icon"><i class="far fa-heart"></i> <span
                                    class="total-count">{{ Helper::wishlistCount() }}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ count(Helper::getAllProductFromWishlist()) }} chácaras</span>
                                        <a href="#">Ver lista de desejos</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @foreach (Helper::getAllProductFromWishlist() as $data)
                                            @php
                                                $photo = explode(',', $data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="#" class="remove"
                                                    title="Remove this item"><i class="fas fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{ $photo[0] }}"
                                                        alt="{{ $photo[0] }}"></a>
                                                <h4><a href="#"
                                                        target="_blank">{{ $data->product['title'] }}</a></h4>
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
                            <a href="#" class="single-icon"><i class="fas fa-shopping-bag"></i> <span
                                    class="total-count">{{ Helper::cartCount() }}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ count(Helper::getAllProductFromCart()) }} chácaras</span>
                                        <a href="#">Ver carrinho</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @foreach (Helper::getAllProductFromCart() as $data)
                                            @php
                                                $photo = explode(',', $data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="#" class="remove"
                                                    title="Remove this item"><i class="fas fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{ $photo[0] }}"
                                                        alt="{{ $photo[0] }}"></a>
                                                <h4><a href="#"
                                                        target="_blank">{{ $data->product['title'] }}</a></h4>
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
                                                    href="#">Início</a></li>
                                            <li class="{{ Request::path() == 'sobre-nos' ? 'active' : '' }}"><a
                                                    href="#">Sobre nós</a></li>
                                            <li class="@if (Request::path()=='chacaras-grids' ||
                                                Request::path()=='chacaras-listas' ) active @endif"><a href="#">Chácaras</a><span
                                                    class="new">Novo</span></li>
                                            {{-- {{ Helper::getHeaderCategory() }} --}}
                                            <li class="{{ Request::path() == 'blog' ? 'active' : '' }}"><a
                                                    href="#">Blog</a></li>

                                            <li class="{{ Request::path() == 'contato' ? 'active' : '' }}"><a
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
