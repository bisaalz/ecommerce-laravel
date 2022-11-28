<!-- Header -->
<header class="header-v4">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Free shipping for standard order over NPR. 5,000
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="{{ route('help-faq') }}" class="flex-c-m trans-04 p-lr-25">
                        Help & FAQs
                    </a>

                    @guest
                        <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25">
                            Register
                        </a>
                        <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">
                            Login
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="flex-c-m trans-04 p-lr-25">
                            {{ Auth::user()->name }}
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="{{ route('homepage') }}" class="logo">
                    <img src="{{ asset('assets/home/images/icons/logo-01.png') }}" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu">
                            <a href="{{ route('homepage') }}">Home</a>
                        </li>

                        <li>
                            <a href="{{ route('all-product-list') }}">Shop</a>
                        </li>


                        {{ getCategoryLinks() }}

                        <li class="label1" data-label1="hot">
                            <a href="{{ url('/product?is_featured=1') }}">Features</a>
                        </li>



                        <li>
                            <a href="{{ route('about-us') }}">About</a>
                        </li>

                        <li>
                            <a href="{{ route('contact-us') }}">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    @php
                        $counter = 0;
                    @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $cart_items)
                            @php
                                $counter += $cart_items['quantity'];
                            @endphp
                        @endforeach
                    @endif
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="{{ $counter }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>


                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="{{ asset('assets/home/images/icons/logo-01.png') }}" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="{{ $counter }}">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>


        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Free shipping for standard order over NPR. 5,000
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="{{ route('help-faq') }}" class="flex-c-m p-lr-10 trans-04">
                        Help & FAQs
                    </a>

                    @guest
                        <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25">
                            Register
                        </a>
                        <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">
                            Login
                        </a>
                    @else
                        <a href="#" class="flex-c-m trans-04 p-lr-25">
                            {{ Auth::user()->name }}
                        </a>
                    @endguest


                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>

                <span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
            </li>

            <li>
                <a href="product.html">Shop</a>
            </li>

            <li>
                <a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
            </li>



            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="{{ asset('assets/home/images/icons/icon-close2.png') }}" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15" method="get" action="{{ route('search') }}">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>

<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            @php
                $total = 0;
            @endphp
            @if(session('cart'))

                <ul class="header-cart-wrapitem w-full">

                @foreach(session('cart') as $index => $cart_items)
                    @php
                        $total += $cart_items['amount'];
                    @endphp
                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <div class="header-cart-item-img">
                                <img src="{{ $cart_items['image'] }}" alt="IMG">
                            </div>

                            <div class="header-cart-item-txt p-t-8">
                                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                    {{ $cart_items['title'] }}
                                </a>

                                <span class="header-cart-item-info">
								{{ $cart_items['quantity'] }} x NPR. {{ number_format($cart_items['price']) }}
							</span>
                            </div>
                            <a href="javascript:0;" onclick="removeFromCart({{ $index }}, {{ 1 }})" >
                                <i class="fa fa-trash"></i>
                            </a>
                        </li>

                @endforeach

                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: NPR. {{ number_format($total) }}
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="{{ route('cart') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="{{ route('checkout') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>
