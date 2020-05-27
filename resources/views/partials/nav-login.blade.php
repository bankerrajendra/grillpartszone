@php( $logout_url = route('logout') )
<nav class="navbar navbar-default hidden-lg navbar-fixed-top mobile-nav">
    <div class="container">
        <div class="row">
            <div class="col-xs-2 text-center nopadding">
                <span style="cursor:pointer;" onclick="openNav()"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30"viewBox="0 0 172 172" style=" fill:#000000;"><g transform="translate(4.3,4.3) scale(0.95,0.95)"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none" stroke="none"></path><g id="original-icon" fill="#000000" stroke="none"><path d="M14.33333,35.83333v14.33333h143.33333v-14.33333zM14.33333,78.83333v14.33333h143.33333v-14.33333zM14.33333,121.83333v14.33333h143.33333v-14.33333z"></path></g><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none" stroke="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none" stroke="none"></path><path d="M0,172v-172h172v172z" fill="none" stroke="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none" stroke="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none" stroke="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none" stroke="none"></path></g></g></svg></span>
            </div>
            <div id="mySidenav" class="sidenav">
                <div class="Sidemenu">
                    <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a></li>
                    <li><a href="{{ config('app.url') }}"><img src="{{ asset('img/m-logo.png') }}"></a></li>
                    <li><a href="#myAccntMobMenu" data-toggle="collapse">My Account <i
                                class="fa fa-angle-down pull-right"></i></a></li>
                    <div id="myAccntMobMenu" class="collapse">
                        @if(Auth::check())
                        <li><a href="">Order History</a></li>
                        <li><a class="nav-link" href="javascript:void(0);"
                               onclick="window.document.getElementById('logout-form').submit();"
                            >
                                <i class="fa fa-fw fa-power-off"></i> {{ __('adminlte::adminlte.log_out') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ $logout_url }}" method="POST"
                              style="display: none;">
                            @if(config('adminlte.logout_method'))
                            {{ method_field(config('adminlte.logout_method')) }}
                            @endif
                            {{ csrf_field() }}
                        </form>
                        @else
                        <li><a href="{{ route('register') }}">Signup</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="">Forgot Password</a></li>
                        @endif
                    </div>
                    <li><a href="">Search</a></li>
                    <li><a href="#MobMenuHlpSprt" data-toggle="collapse">Care &amp; Support <i
                                class="fa fa-angle-down pull-right"></i></a></li>
                    <div id="MobMenuHlpSprt" class="collapse">
                        <li><a href="">Grill Care &amp; Maintenance</a></li>
                        <li><a href="">Troubleshooting</a></li>
                    </div>
                    <li><a href="#LearnMore" data-toggle="collapse">Learn More <i
                                class="fa fa-angle-down pull-right"></i></a></li>
                    <div id="LearnMore" class="collapse">
                        <li><a href="">Site Map</a></li>
                        <li><a href="">Terms &amp; Conditions</a></li>
                        <li><a href="">Privacy Policy</a></li>
                    </div>
                    <ul class="social">
                        <li class="fb"><a href="0" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li class="tw"><a href="0" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li class="lin"><a href="0" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li class="youtube"><a href="0" target="_blank"><i class="fa fa-youtube"></i></a></li>
                        <li class="insta"><a href="0" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-7 text-center nopadding">
                <a class="mobile-navbar-brand" href=""><img src="{{ asset('img/m-logo.png') }}" alt="Logo"></a>
            </div>
            <div class="col-xs-3 text-center nopadding">
                @if(Auth::check())
                <a class="nav-link" href="javascript:void(0);"
                   onclick="window.document.getElementById('logout-form').submit();"
                >
                    <i class="fa fa-fw fa-power-off"></i> {{ __('adminlte::adminlte.log_out') }}
                </a>
                @else
                <a href="{{ route('login') }}" class="m-login-btn">Login</a>
                @endif
            </div>
        </div>
    </div>
</nav>
<div id="header" class="hidden-xs user-head">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-4 col-xs-6 header-left">
                <a href="{{ config('app.url') }}"><img src="{{ asset('img/l-logo.png') }}"></a>
            </div>
            <div class="col-lg-6 col-sm-4 col-xs-6 header-right">
                <a href="{{ route('show-cart') }}">
                <div class="cart-image">
                    <span id="cart-total" class="cart-total-counter">{{getTotalCartItems()}}</span>
                </div>
                </a>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check())
                    <li><a class="nav-link" href="javascript:void(0);"
                           onclick="window.document.getElementById('logout-form').submit();"
                        >
                            <i class="fa fa-fw fa-power-off"></i> {{ __('adminlte::adminlte.log_out') }}
                        </a></li>
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}"><i class="fa fa-user" aria-hidden="true"></i> SignUp</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
