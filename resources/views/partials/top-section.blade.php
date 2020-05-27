
<nav class="nav-container hidden-xs" role="navigation">
    <div class="nav-inner">
        <div class="container">
            <div class="menu-bar">
                <div id="menu" class="main-menu">
                    <div class="nav-responsive"><span>Menu</span><div class="expandable"></div></div>
                    <ul class="nav navbar-nav main-navigation treeview">
                        <li class="top_level"><a  class="@if( Request::is('grill-parts', 'grill-parts/*')) active @endif"  href="{{route('grill-parts')}}">Grill Parts</a></li>
                        <li class="top_level"><a class="@if( Request::is('brands', 'brands/*', 'brand/*', 'brand/*')) active @endif" href="{{ route('brands') }}">BBQ Brands</a></li>
                        <li class="dropdown">
                            <a  class="dropdown-toggle disabled" data-toggle="dropdown"> Accessories <span class="caret"></span></a>

                            <ul class="dropdown-menu multi-column columns-3 dropdown-menu-large" style="display: none;">
                                @php $accessoriesCat=getAccessoriesCategoryList('2');
                                //print_r($accessoriesCat);
                                foreach($accessoriesCat as $accessoriesCatRec) {
                                    echo '<li class="col-sm-4"><a href="' . route('accessories-products',['slug'=>$accessoriesCatRec->slug])  . '">'.$accessoriesCatRec->name.'</a></li>';
                                }
                                @endphp

                            </ul>
                        </li>

                        <li class="top_level"><a href="bbq-cover.php"> BBQ Covers</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"> Propane Parts <span class="caret"></span></a>
                            <ul class="dropdown-menu multi-column columns-2 dropdown-menu-large" style="display: none;">
                                @php $accessoriesCat=getAccessoriesCategoryList('16');
                                //print_r($accessoriesCat);
                                foreach($accessoriesCat as $accessoriesCatRec) {
                                    echo '<li class="col-sm-6"><a href="' . route('propane-parts',['slug'=>$accessoriesCatRec->slug])  . '">'.$accessoriesCatRec->name.'</a></li>';
                                }
                                @endphp
                            </ul>
                        </li>
                        <li class="top_level"><a href="ipad-cover.php">Electronics & Misc.</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>



