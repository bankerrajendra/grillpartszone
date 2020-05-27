<!doctype html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="{{ config('app.locale') }}" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="{{ config('app.locale') }}" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="{{ config('app.locale') }}">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('template_title')</title>

    <meta name="description" content="@yield('meta_description')">
    <meta name="keyword" content="@yield('meta_keyword')">
    @if(isset($index_page_flag) && $index_page_flag=='1')
        <link rel="canonical" href="@yield('canonical')"/>
    @endif

    <script>
        window.App = {!! json_encode([
        'user' => Auth::user(),
        'signedIn' => Auth::check()
    ]) !!};
    </script>

    {{-- Fonts --}}
    @yield('template_linked_fonts')

    <!--Style CSS-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <!--Responsive CSS-->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <!--Font Awesome CSS-->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!--Owl carousel-->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
    <!--Owl Theme-->
    <link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet">
    @yield('template_linked_css')
    <style type="text/css">
        @yield('template_fastload_css')
    </style>
    @yield('head')
</head>
<body>
<header>
    @include('partials.nav')
</header>
@include('partials.top-section')
@yield('content')
<!--Start Footer-->
@include('partials.footer')
<!--End Footer-->
@routes
<!--Main JS-->
<script src="{{ asset('js/main.js') }}"></script>
<!--Bootstrap JS-->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.js') }}"></script>
@yield('footer_scripts')
@stack('footer_scripts')
@include('front.pages.includes.scripts. app-part-cart-with')
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
        document.body.style.overflowY = "hidden";
        document.body.style.position = "fixed";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.body.style.overflowY = "auto";
        document.body.style.position = "relative";
    }

    $(document).ready(function () {

        var owl = $("#owl-demo1");

        owl.owlCarousel({
            pagination: false,

            items: 4, //10 items above 1000px browser width
            itemsDesktop: [1000, 5], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
            itemsTablet: [600, 1], //2 items between 600 and 0;
            itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
            navigation: true
        });
    });
</script>
<script>
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
</script>
</body>
</html>
