@extends('frontend.layouts.master')
@section('title', '| Cadastro')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="#">Início<i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Cadastrar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Cadastro</h2>
                        <p>Registre-se para finalizar a compra mais rapidamente</p>
                        <form class="form" method="POST" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Seu nome<span>*</span></label>
                                        <input type="text" name="name" placeholder="Nome" required="required"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Seu e-mail<span>*</span></label>
                                        <input type="text" name="email" placeholder="E-mail" required="required"
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
                                    <div class="form-group">
                                        <label>Confirmação de senha<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="Confirme a senha"
                                            required="required" value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Cadastrar</button>
                                        <a href="#" class="btn">Login</a>
                                        OU
                                        <a href="#" class="btn btn-facebook"><i
                                                class="fab fa-facebook"></i></a>
                                        <a href="#" class="btn btn-github"><i
                                                class="fab fa-github"></i></a>
                                        <a href="#" class="btn btn-google"><i
                                                class="fab fa-google"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
