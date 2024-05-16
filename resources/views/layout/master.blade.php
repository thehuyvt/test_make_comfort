
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Make Comfort - {{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/app-creative.min.css')}}" rel="stylesheet" type="text/css" id="light-style" />
    @stack('css')

</head>
@yield('body')
<body data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

<!-- Begin page -->
<div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    @include('layout.sidebar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            @include('layout.header')
            <!-- end Topbar -->

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h3 class="page-title">{{$title}}</h3>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        {{session()->get('success')}}
                                    </div>
                                @endif

                        @yield('content')
                    </div>
                </div>
                <!-- end page title -->
            </div>
            <!-- container -->
        </div>
        <!-- content -->
        <!-- Footer Start -->
        @include('layout.footer')
        <!-- end Footer -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->

<!-- bundle -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{asset('js/vendor.min.js')}}"></script>
<script src="{{asset('js/app.min.js')}}"></script>
@stack('js')

{{--<!-- third party js -->--}}
{{--<script src="assets/js/vendor/apexcharts.min.js"></script>--}}
{{--<script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>--}}
{{--<script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>--}}
{{--<!-- third party js ends -->--}}

{{--<!-- demo app -->--}}
{{--<script src="assets/js/pages/demo.dashboard.js"></script>--}}
{{--<!-- end demo js-->--}}
</body>
</html>
