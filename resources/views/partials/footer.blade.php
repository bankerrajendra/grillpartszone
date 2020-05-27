<footer>
    <?php //@if(isset($index_page_flag) && $index_page_flag=='1') ?>
    <div class="del-rib text-center hidden-xs">
        <div class="shadow-left"></div>
        <div class="img-block"></div>
        <h3>FREE Shipping on all orders</h3>
        <div class="shadow-right"></div>
    </div>
    <?php //@endif ?>
    <div class="container">
        <div class="row hidden-xs">
            <div class="col-sm-3">
                <br>
                <img src="{{ asset('img/l-logo.png') }}" class="img-responsive">
            </div>
            <div class="col-sm-3">
                <h5>Information</h5>
                <ul class="list-unstyled">
                    <li><a href="{{route('cmsroots', ['slug'=>'about-us'])}}">About Us</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'shipping-and-returns'])}}">Shipping & Returns</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'privacy'])}}">Privacy Policy</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'term-condition'])}}">Terms &amp; Conditions</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'contact-us'])}}">Contact Us</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'sitemap'])}}">Site Map</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'grill-tips'])}}">Grill Tips</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5>My Account</h5>
                <ul class="list-unstyled">
                    <li><a href="">My Account</a></li>
                    <li><a href="">Order History</a></li>
                    <li><a href="">Wish List</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'care-and-maintenance'])}}">Grill Care & Maintenance</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'troubleshooting'])}}">Troubleshooting</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'how-to-order'])}}">How to Order</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'what-we-sell'])}}">What We Sell</a></li>
                    <li><a href="{{route('cmsroots', ['slug'=>'where-and-how-we-ship'])}}">Where & How We Ship</a></li>
                </ul>
            </div>

            <div class="col-sm-3" id="contact_us">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li>
                        <div class="address">
                            <div class="value-address">13060 80th Ave,<br>
                                Surrey, BC, Canada
                            </div>
                        </div>
                        <div class="phone">
                            <div class="value-phone">1-778 - 564 - 5442</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row hidden-xs">
            <div class="col-sm-12">
                <div class="content_footer_bottom">
                    <div>
                        <div class="payment-block">
                            <div class="payment-block-inner">
                                <div class="payment-main-block">
                                    <ul class="list-unstyled">
                                        <li class="visa"><a href="#">&nbsp;</a></li>
                                        <li class="paypal"><a href="#">&nbsp;</a></li>
                                        <li class="mastro"><a href="#">&nbsp;</a></li>
                                        <li class="mastercard"><a href="#">&nbsp;</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <p>© 2018 Grillpartszone.com All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>
