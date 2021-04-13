<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Verde Lazer @yield('title')</title>
	@include('frontend.layouts.head')	
</head>
<body class="js">
	
	{{-- Loading --}}
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	{{-- End Loading --}}
    
	@include('frontend.layouts.notification')

	{{-- Header --}}
	@include('frontend.layouts.header')
	{{-- End Header --}}
    
	@yield('content')

	{{-- Footer --}}
	@include('frontend.layouts.footer')
    {{-- End Footer --}}
    

</body>
</html>