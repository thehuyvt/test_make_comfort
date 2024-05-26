<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <!-- LOGO -->
    <a href="{{route('dashboard')}}" class="logo text-center logo-light">
                    <span class="logo-lg mt-3 mb-3" >
                        <img src="{{asset('images/logo.png')}}" alt="" height="68" style="border-radius: 50%;">
                    </span>
                    <span class="logo-sm">
                        <img src="{{asset('/images/logo.png')}}" alt="" height="60" style="border-radius: 50%;">
                    </span>
    </a>

    <div class="h-100" id="left-side-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav mt-3">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item">
                <a href="{{route('dashboard')}}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Trang chủ </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('categories.index')}}" class="side-nav-link">
                    <i class="uil-layer-group"></i>
                    <span> Các loại sản phẩm</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('products.index')}}" class="side-nav-link">
                    <i class="uil-gift"></i>
                    <span> Danh sách sản phẩm </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('users.index')}}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Danh sách nhân viên </span>
                </a>
            </li>

        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
