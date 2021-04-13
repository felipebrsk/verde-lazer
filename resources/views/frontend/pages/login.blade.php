@extends('frontend.layouts.master')
@section('title', '| Login')

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="#">Início<i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Login</h2>
                        <p>Registre-se para finalizar a compra mais rapidamente</p>
                        <!-- Form -->
                        <form class="form" method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Seu e-mail<span>*</span></label>
                                        <input type="email" name="email" placeholder="E-mail" required="required"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Sua senha<span>*</span></label>
                                        <input type="password" name="password" placeholder="Senha" required="required"
                                            value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Login</button>
                                        <a href="{{ route('register.form') }}" class="btn">Cadastrar</a>
                                        OU
                                        <a href="{{ route('login.redirect', 'facebook') }}" class="btn btn-facebook"><i
                                                class="fab fa-facebook"></i></a>
                                        <a href="{{ route('login.redirect', 'github') }}" class="btn btn-github"><i
                                                class="fab fa-github"></i></a>
                                        <a href="{{ route('login.redirect', 'google') }}" class="btn btn-google"><i
                                                class="fab fa-google"></i></a>

                                    </div>
                                    <div class="checkbox">
                                        <label class="checkbox-inline" for="2"><input name="news" id="2"
                                                type="checkbox">Lembrar-me</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="lost-pass" href="{{ route('password.request') }}">
                                            Esqueci minha senha
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->
@endsection
@push('styles')
    <style>
        .shop.login .form .btn {
            margin-right: 0;
        }

        .btn-facebook {
            background: #39579A;
        }

        .btn-facebook:hover {
            background: #073088 !important;
        }

        .btn-github {
            background: #444444;
            color: white;
        }

        .btn-github:hover {
            background: black !important;
        }

        .btn-google {
            background: #ea4335;
            color: white;
        }

        .btn-google:hover {
            background: rgb(243, 26, 26) !important;
        }

    </style>
@endpush
