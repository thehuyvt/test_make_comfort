<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    MakeComfort Xin Chào{{", ". session()->get('customer_name')}}
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        Ngày: {{now()->format('d/m/Y')}}
                    </a>

                    @if(session()->has('customer_id'))

                        <a href="{{route('customers.profile')}}" class="flex-c-m trans-04 p-lr-25">Tài khoản</a>

                        <a href="{{route('orders.history')}}" class="flex-c-m trans-04 p-lr-25">Lịch sử mua hàng</a>


                        <a href="{{route('customers.logout')}}" class="flex-c-m trans-04 p-lr-25">
                            Đăng xuất
                        </a>
                    @endif
                    @if(!session()->has('customer_id'))
                        <a href="{{route("customers.login")}}" class="flex-c-m trans-04 p-lr-25">
                            Đăng nhập
                        </a>

                        <a href="{{route('customers.register')}}" class="flex-c-m trans-04 p-lr-25">
                            Đăng ký
                        </a>
                    @endif

                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="{{route('customers.index')}}" class="mr-5">
                    <img src="{{asset('customer/images/icons/logo-01.png')}}" height="68px" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="">
                            <a href="{{route('customers.index')}}">Trang chủ</a>
                        </li>

                        <li>
                            <a href="{{route('customers.all-product')}}">Sản phẩm</a>
                        </li>

                        <li>
                            <a href="{{route('customers.about')}}">Về chúng tôi</a>
                        </li>

                        <li>
                            <a href="{{route('customers.contact')}}">Liên hệ</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    @if(session()->has('customer_id'))
                        <div id="sum-cart" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="0">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    @endif
                    @if(!session()->has('customer_id'))
                        <a href="{{route('customers.login')}}" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 " data-notify="0">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>
                    @endif
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="{{asset('customer/images/icons/logo-01.png')}}" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>
            <div id="sum-cart-mobile" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="0">
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
                    MakeComfort Xin Chào{{", ". session()->get('customer_name')}}
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m trans-04 p-lr-10">
                        Ngày: {{now()->format('d/m/Y')}}
                    </a>

                    @if(session()->has('customer_id'))

                        <a href="{{route('customers.profile')}}" class=" flex-c-m trans-04 p-lr-10">
                            Tài khoản
                        </a>


                        <a href="{{route('customers.logout')}}" class="flex-c-m trans-04 p-lr-10">
                            Đăng xuất
                        </a>
                    @endif
                    @if(!session()->has('customer_id'))
                        <a href="{{route("customers.login")}}" class="flex-c-m trans-04 p-lr-10">
                            Đăng nhập
                        </a>

                        <a href="{{route('customers.register')}}" class="flex-c-m trans-04 p-lr-10">
                            Đăng ký
                        </a>
                    @endif
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li class="active-menu">
                <a href="{{route('customers.index')}}">Trang chủ</a>
            </li>

            <li>
                <a href="#">Sản phẩm</a>
            </li>

            <li>
                <a href="#">Về chúng tôi</a>
            </li>

            <li>
                <a href="#">Liên hệ</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="{{asset('customer/images/icons/icon-close2.png')}}" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>
