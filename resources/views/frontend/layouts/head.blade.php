<!-- Meta Tag -->
@yield('meta')
<!-- Title Tag  -->
<title>@yield('title')</title>
<!-- Favicon -->
<link rel="icon" type="image/png" href="images/favicon.png">
<!-- Web Font -->
<link
    href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
    rel="stylesheet">

<!-- StyleSheet -->
@yield('styles')
<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<!-- Magnific Popup -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css"
    integrity="sha512-nIm/JGUwrzblLex/meoxJSPdAKQOe2bLhnrZ81g5Jbh519z8GFJIWu87WAhBH+RAyGbM4+U3S2h+kL5JoV6/wA=="
    crossorigin="anonymous" />

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
    crossorigin="anonymous" />

<!-- Fancybox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
    integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
    crossorigin="anonymous" />

<!-- Themify Icons -->
<link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css"
    integrity="sha512-FEQLazq9ecqLN5T6wWq26hCZf7kPqUbFC9vsHNbXMJtSZZWAcbJspT+/NEAQkBfFReZ8r9QlA9JHaAuo28MTJA=="
    crossorigin="anonymous" />

<!-- Nice Select CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
    integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
    crossorigin="anonymous" />

<!-- Animate CSS -->
<link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">

<!-- Flex Slider CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css"
    integrity="sha512-c7jR/kCnu09ZrAKsWXsI/x9HCO9kkpHw4Ftqhofqs+I2hNxalK5RGwo/IAhW3iqCHIw55wBSSCFlm8JP0sw2Zw=="
    crossorigin="anonymous" />

<!-- Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
    crossorigin="anonymous" />

<!-- Slicknav -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/slicknav.min.css"
    integrity="sha512-heyoieAHmpAL3BdaQMsbIOhVvGb4+pl4aGCZqWzX/f1BChRArrBy/XUZDHW9WVi5p6pf92pX4yjkfmdaIYa2QQ=="
    crossorigin="anonymous" />

<!-- Jquery Ui -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
    integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ=="
    crossorigin="anonymous" />


<!-- Verde Lazer StyleSheet -->
<link rel="stylesheet" href="{{ asset('frontend/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

<script type='text/javascript'
    src='https://platform-api.sharethis.com/js/sharethis.js#property=6073245c4d36eb0018700ae0&product=inline-follow-buttons'
    async='async'></script>
<style>
    /* Multilevel dropdown */
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>a:after {
        content: "\f0da";
        float: right;
        border: none;
        font-family: 'FontAwesome';
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: 0px;
        margin-left: 0px;
    }

</style>
@stack('styles')
