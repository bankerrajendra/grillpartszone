@extends('layouts.app')

@section('content')

    <div class="mobile-banner hidden-md hidden-lg">
        <img src="img/m-banner.jpg" class="img-responsive">
    </div>

    <div class="search-item hidden-md hidden-lg">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <form>
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control" placeholder="Search by Brand, Model or Part Number">
                            <span class="input-group-addon">
							<button type="submit">
								<span class="fa fa-search"></span>
							</button>
						</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="search-manual-item hidden-md hidden-lg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h4>Find Parts For Your Grill</h4>
                    <p>Use our BBQ parts finger to get the perfect match for your BBQ Grill </p>
                </div>
                <div class="col-lg-5 col-md-3 col-sm-12">
                    <label>Brand</label>
                    <select class="form-control search-slt" id="exampleFormControlSelect1">
                        <option>Select Brand</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                    </select>
                </div>
                <div class="col-lg-5 col-md-3 col-sm-12">
                    <label>Modal</label>
                    <select class="form-control search-slt" id="exampleFormControlSelect1">
                        <option>Select Modal</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                        <option>Example one</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <button type="button" class="btn btn-search btn-block">Search</button>
                </div>
            </div>
        </div>
    </div>


    <div class="desktop-banner hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Grill Parts</h1>
                    <h2>Charcoal & Gas Grill</h2>
                    <h3>Replacement Parts</h3>
                </div>
                <div class="col-sm-6">
                    <img src="http://punjabibhangra.com/grillpartzone/img/bb1.jpg" class="img-responsive">
                </div>
            </div>
        </div>
    </div>

    <div class="ctg">
        <div class="del-rib hidden-xs">
            <div class="shadow-left"></div>
            <div class="img-block"></div>
            <h3>FREE Shipping on all orders  <!--<span>- Only £8.99 *</span>--></h3>
            <div class="shadow-right"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1>Shop By Categories</h1>
                    <p>There are many variations of passages of lorem Ipsum available but the majority have suffered alteration.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="owl-demo1" class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="slide">
                                <a href="bbq-cover.php">
                                    <img src="http://punjabibhangra.com/grillpartzone/img/cat1.jpg" style="width:100%;">
                                    <div class="cat-name">Covers</div>
                                    <div class="cat-content">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                <a href="propane-regulator.php">
                                    <img src="http://punjabibhangra.com/grillpartzone/img/cat2.jpg" style="width:100%;">
                                    <div class="cat-name">Regulators</div>
                                    <div class="cat-content">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                <a href="">
                                    <img src="http://punjabibhangra.com/grillpartzone/img/cat3.jpg" style="width:100%;">
                                    <div class="cat-name">Burners</div>
                                    <div class="cat-content">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                <a href="">
                                    <img src="http://punjabibhangra.com/grillpartzone/img/cat4.jpg" style="width:100%;">
                                    <div class="cat-name">Side Burners</div>
                                    <div class="cat-content">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                <a href="">
                                    <img src="http://punjabibhangra.com/grillpartzone/img/cat5.jpg" style="width:100%;">
                                    <div class="cat-name">Napoleon OEM</div>
                                    <div class="cat-content">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                <a href="">
                                    <img src="http://punjabibhangra.com/grillpartzone/img/cat6.jpg" style="width:100%;">
                                    <div class="cat-name">Indicator</div>
                                    <div class="cat-content">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                <a href="">
                                    <img src="http://punjabibhangra.com/grillpartzone/img/cat1.jpg" style="width:100%;">
                                    <div class="cat-name">Covers</div>
                                    <div class="cat-content">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sub-ctg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="h-title"><h1>BBQ Covers</h1></div>
                    <p>Lorem Ipsum is Simply dummy text of the printing and typesetting of the industry. Lorem ipsume has been the industry's standard dummy text</p>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/bbqcover1.jpg" class="img-responsive">
                            </a>
                            <ul class="social">
                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Seville Coffee (Cointreau)</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/bbqcover2.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Cafe Mendoza</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/bbqcover3.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Brandy Coffee</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/bbqcover4.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">English Coffee (Gin)</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4 text-center">
                    <a href="bbq-cover.php" class="read-more_s btn-block">View All BBQ Covers</a>
                </div>
            </div>
        </div>
    </div>

    <div class="sub-ctg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="h-title"><h1>Regulators & Hose</h1></div>
                    <p>Lorem Ipsum is Simply dummy text of the printing and typesetting of the industry. Lorem ipsume has been the industry's standard dummy text</p>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/rg1.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Seville Coffee (Cointreau)</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/rg2.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Cafe Mendoza</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/rg3.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Brandy Coffee</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/rg4.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">English Coffee (Gin)</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4 text-center">
                    <a href="propane-regulator.php" class="read-more_s btn-block">View All Regulator</a>
                </div>
            </div>
        </div>
    </div>

    <div class="sub-ctg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="h-title"><h1>Propane Connectors</h1></div>
                    <p>Lorem Ipsum is Simply dummy text of the printing and typesetting of the industry. Lorem ipsume has been the industry's standard dummy text</p>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/burner1.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Seville Coffee (Cointreau)</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/burner2.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Cafe Mendoza</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/burner3.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">Brandy Coffee</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="product-detail.php">
                                <img class="pic-1" src="http://punjabibhangra.com/grillpartzone/img/burner1.jpg" class="img-responsive">
                            </a>
                            <ul class="social">

                                <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>

                        <div class="product-content">
                            <h3 class="title"><a href="product-detail.php">English Coffee (Gin)</a></h3>
                            <div class="p-desc">Lorem Ipsum is Simply dummy text of the printing and typesetting..</div>
                            <p class="price">
                                $92.00 <span>$122.00</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4 text-center">
                    <a href="propane-adapter.php" class="read-more_s btn-block">View All Propane</a>
                </div>
            </div>
        </div>
    </div>


    <div class="blog">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="blog-title"><h1>Latest News</h1></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <img src="http://punjabibhangra.com/grillpartzone/img/blog1.jpg" class="img-responsive">
                    <div class="caption">
                        <h4><a href="">Nostrum Iesum Christum cupidatat</a></h4>
                        <div class="blog-desc">Darling first heard of Peter when she was tidying up her children’s minds. Lorem ipsum dolor sit ame...</div>
                        <p class="read_more"><a href="">Read More..</a></a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <img src="http://punjabibhangra.com/grillpartzone/img/blog2.jpg" class="img-responsive">
                    <div class="caption">
                        <h4><a href="">Nostrum Iesum Christum cupidatat</a></h4>
                        <div class="blog-desc">Darling first heard of Peter when she was tidying up her children’s minds. Lorem ipsum dolor sit ame...</div>
                        <p class="read_more"><a href="">Read More..</a></a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <img src="http://punjabibhangra.com/grillpartzone/img/blog3.jpg" class="img-responsive">
                    <div class="caption">
                        <h4><a href="">Nostrum Iesum Christum cupidatat</a></h4>
                        <div class="blog-desc">Darling first heard of Peter when she was tidying up her children’s minds. Lorem ipsum dolor sit ame...</div>
                        <p class="read_more"><a href="">Read More..</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
