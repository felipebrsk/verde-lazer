@extends('frontend.layouts.master')
@section('title', '| Sobre nós')

@section('content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Início<i class="fas fa-arrow-right"></i></a></li>
                            <li class="active"><a href="{{ route('about-us') }}">Sobre nós</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- About Us -->
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="about-content">
                        @php
                            $settings = DB::table('settings')->get();
                        @endphp
                        <h3>Bem vindo à <span style="color: rgb(88, 218, 62)">Verde</span> Lazer</h3>
                        <p>
                            @foreach ($settings as $data) {!! $data->description !!}
                            @endforeach
                        </p>
                        <div class="button">
                            <a href="#" class="btn">Nosso blog</a>
                            <a href="{{ route('contact') }}" class="btn primary">Contate-nos</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-img overlay">
                        <div class="button">
                            <a href="https://www.youtube.com/watch?v=bfRUfy0Ywdo" class="video video-popup mfp-iframe"><i
                                    class="fa fa-play"></i></a>
                        </div>
                        <img src="@foreach ($settings as $data) {{ asset('frontend/img/' . $data->photo) }} @endforeach"
                            alt="   @foreach ($settings as $data)
                        {{ $data->photo }} @endforeach">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us -->

    <!-- Start Team -->
    <section id="team" class="team section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>NOSSO TIME</h2>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique totam dolorem tempora, atque
                            suscipit vero iusto. Odit, error natus similique, dicta corrupti minima, omnis explicabo hic
                            dolorum dignissimos deleniti veniam!
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Single Team -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-team">
                        <!-- Image -->
                        <div class="image">
                            <img src="{{ asset('backend/img/avatar.png') }}" alt="Felipe Oliveira"
                                style="border-radius: 100%; width: 100px;" class="mt-4">
                        </div>
                        <!-- End Image -->
                        <div class="info-head">
                            <!-- Info Box -->
                            <div class="info-box">
                                <h4 class="name"><a href="#">Felipe Oliveira</a></h4>
                                <span class="designation">Fullstack Developer</span>
                            </div>
                            <!-- End Info Box -->
                            <!-- Social -->
                            <div class="social-links">
                                <ul class="social">
                                    <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa fa-github"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            <!-- End Social -->
                        </div>
                    </div>
                </div>
                <!-- End Single Team -->
                <div class="col-lg-3 col-md-6 col-12">
					<div class="single-team">
						<!-- Image -->
						<div class="image">
							<img src="{{ asset('backend/img/avatar.png') }}" alt="Felipe Oliveira" style="border-radius: 100%; width: 100px;" class="mt-4">
						</div>
						<!-- End Image -->
						<div class="info-head">
							<!-- Info Box -->
							<div class="info-box">
								<h4 class="name"><a href="#">Felipe Oliveira</a></h4>
								<span class="designation">Designer</span>
							</div>
							<!-- End Info Box -->
							<!-- Social -->
							<div class="social-links">
								<ul class="social">
									<li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
									<li><a href="#"><i class="fa fa-github"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div>
							<!-- End Social -->
						</div>
					</div>
				</div>	
				<!-- End Single Team -->
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-team">
						<!-- Image -->
						<div class="image">
							<img src="{{ asset('backend/img/avatar.png') }}" alt="Felipe Oliveira" style="border-radius: 100%; width: 100px;" class="mt-4">
						</div>
						<!-- End Image -->
						<div class="info-head">
							<!-- Info Box -->
							<div class="info-box">
								<h4 class="name"><a href="#">Felipe Oliveira</a></h4>
								<span class="designation">CEO</span>
							</div>
							<!-- End Info Box -->
							<!-- Social -->
							<div class="social-links">
								<ul class="social">
									<li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
									<li><a href="#"><i class="fa fa-github"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div>
							<!-- End Social -->
						</div>
					</div>
				</div>	
				<!-- End Single Team -->
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-team">
						<!-- Image -->
						<div class="image">
							<img src="{{ asset('backend/img/avatar.png') }}" alt="Felipe Oliveira" style="border-radius: 100%; width: 100px;" class="mt-4">
						</div>
						<!-- End Image -->
						<div class="info-head">
							<!-- Info Box -->
							<div class="info-box">
								<h4 class="name"><a href="#">Felipe Oliveira</a></h4>
								<span class="designation">Co-worker</span>
							</div>
							<!-- End Info Box -->
							<!-- Social -->
							<div class="social-links">
								<ul class="social">
									<li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
									<li><a href="#"><i class="fa fa-github"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div>
							<!-- End Social -->
						</div>
					</div>
				</div>	
				<!-- End Single Team -->
            </div>
        </div>
    </section>
    <!--/ End Team Area -->

    <!-- Start Shop Services Area -->
    @include('frontend.layouts.services')
    <!-- End Shop Services Area -->

    @include('frontend.layouts.newsletter')
@endsection
