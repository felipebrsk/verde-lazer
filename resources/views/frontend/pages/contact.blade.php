@extends('frontend.layouts.master')
@section('title', '| Entrar em contato')

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Início<i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Contato</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Contact -->
    <section id="contact-us" class="contact-us section">
        <div class="container">
            <div class="contact-head">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="form-main">
                            <div class="title">
                                @php
                                    $settings = DB::table('settings')->get();
                                @endphp
                                <h4>Entre em contato</h4>
                            <h3>Escreva-nos uma mensagem @auth @else<span style="font-size:12px;"
                                        class="text-danger">[Você precisa logar primeiro. <a
                                        href="{{ route('login.form') }}">Fazer login</a>.]</span>@endauth</h3>
                        </div>
                        <form class="form-contact form contact_form" method="POST"
                            action="{{ route('message.store') }}" id="contactForm" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Seu nome<span>*</span></label>
                                        <input name="name" id="name" type="text" placeholder="Insira o seu nome">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Assunto<span>*</span></label>
                                        <input name="subject" type="text" id="subject" placeholder="Diga-nos o assunto">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Seu e-mail<span>*</span></label>
                                        <input name="email" type="email" id="email" placeholder="Insira o seu e-mail">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Seu telefone<span>*</span></label>
                                        <input id="phone" name="phone" type="tel"
                                            placeholder="Insira o seu telefone">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group message">
                                        <label>Sua mensagem<span>*</span></label>
                                        <textarea name="message" id="message" cols="30" rows="9"
                                            placeholder="Mensagem..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group button">
                                        <button type="submit" class="btn ">Enviar mensagem</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="single-head">
                        <div class="single-info">
                            <i class="fa fa-phone"></i>
                            <h4 class="title">Ligue para nós: </h4>
                            <ul>
                                <li>
                                    @foreach ($settings as $data) {{ $data->phone }}
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-envelope-open"></i>
                            <h4 class="title">E-mail: </h4>
                            <ul>
                                <li><a href="mailto:info@yourwebsite.com">
                                        @foreach ($settings as $data)
                                            {{ $data->email }} @endforeach
                                    </a></li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-location-arrow"></i>
                            <h4 class="title">Nosso endereço: </h4>
                            <ul>
                                <li>
                                    @foreach ($settings as $data)
                                        {{ $data->address }}
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Contact -->

<!-- Map Section -->
<div id="map"></div>
<!--/ End Map Section -->

<!-- Start Shop Newsletter  -->
{{-- @include('frontend.layouts.newsletter') --}}
<!-- End Shop Newsletter -->
<!--================Contact Success  =================-->
<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-success">Obrigado!</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-success">Sua mensagem foi enviada com sucesso.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modals error -->
<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-warning">Desculpe!</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-warning">Ocorreu um erro ao enviar a sua mensagem.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .modal-dialog .modal-content .modal-header {
        position: initial;
        padding: 10px 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-dialog .modal-content .modal-body {
        height: 100px;
        padding: 10px 20px;
    }

    .modal-dialog .modal-content {
        width: 50%;
        border-radius: 0;
        margin: auto;
    }

    #map {
        height: 50vh;
        width: auto;
    }

</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
    integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
    integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
    crossorigin="anonymous"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
<script src="{{ asset('frontend/js/map.js') }}"></script>
<script src="{{ asset('frontend/js/mask.js') }}"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYFO7ionUxxrShMBDJjgTiKSGwH6CgoBs&callback=initMap&libraries=&v=weekly"
    async></script>
@endpush
