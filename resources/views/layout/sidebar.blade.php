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
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="mdi mdi-cart-outline"></i>
                    <span> Đơn hàng</span>
                </a>
                <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
                    <li>
                        <a href="{{route('orders.index')}}">Tất cả các đơn</a>
                    </li>
                    <li>
                        <a href="{{route('orders.get-orders-by-status', 3)}}">Đơn hàng chưa xử lý</a>
                    </li>
                    <li>
                        <a href="{{route('orders.get-orders-by-status', 4)}}">Đơn hàng đã xử lý</a>
                    </li>
                    <li>
                        <a href="{{route('orders.get-orders-by-status', 6)}}">Đơn hàng đã hủy</a>
                    </li>
                </ul>
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
            <li class="side-nav-item">
                <a href="{{route('management-customers.index')}}" class="side-nav-link">
                    <i class="uil-chat-bubble-user"></i>
                    <span> Danh sách khách hàng </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="2" class="side-nav-link">
                    <i class="uil-chart-bar-alt"></i>
                    <span> Thống kê doanh thu </span>
                </a>
            </li>
        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
