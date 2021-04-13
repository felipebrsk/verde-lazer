<!DOCTYPE html>
<html lang="pt-BR">
@section('title', '| Login')
    @include('backend.layouts.head')

    <body class="bg-gradient-primary">
        <div class="container">
            <div class="row justify-conent-center">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bem-vindo de volta!</h1>
                                    </div>
                                    <form action="{{ route('login') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="email" value="{{ old('email') }}"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                aria-describedat="emailHelp" placeholder="Digite o seu e-mail" required
                                                autocomplete="email" id="exampleInputEmail" autofocus />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                placeholder="Digite a sua senha" required id="exampleInputPassword"
                                                autocomplete="current-password" autofocus />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }} />
                                                <label for="remember" class="form-check-label">
                                                    Lembrar-me
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>

                                    <div class="text-center">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="btn btn-link small">
                                                Esqueci minha senha
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
