<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Make Comfort - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/app-creative.min.css')}}" rel="stylesheet" type="text/css" id="light-style"/>
    @stack('css')

</head>
<body class="authentication-bg" data-layout-config="{&quot;darkMode&quot;:false}" data-leftbar-compact-mode="condensed">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">

                    <!-- Logo -->
                    <div class="card-header pt-4 pb-4 text-center bg-dark-lighten">
                        <a href="index.html">
                            <span><img src="{{asset('/')}}images/logo-1.png" alt="" height="100"></span>
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Đăng nhập</h4>
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{session()->get('success')}}
                                </div>
                            @endif
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('message'))
                            <div class="alert alert-danger">
                                {{session()->get('message')}}
                            </div>
                        @endif
                        <form action="{{route('customers.process-login')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email"  name="email" required="" value="{{old('email')}}" placeholder="Nhập email của bạn">
                            </div>

                            <div class="form-group">
{{--                                <a href="pages-recoverpw.html" class="text-muted float-right"><small>Forgot your password?</small></a>--}}
                                <label for="password">Mật khẩu</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu của bạn">
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="url" value="{{url()->previous()}}">

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" name="remember">
                                    <label class="custom-control-label" for="checkbox-signin">Ghi nhớ tài khoản</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button type="submit" class="btn btn-outline-dark" >Đăng nhập </button>
                            </div>

                        </form>
                        <div class="text-center mt-3">
                            <p class="text-muted">Bạn chưa có tài khoản? <a href="{{route('customers.register')}}" class="text-muted ml-1"><b>Đăng ký</b></a></p>
                        </div>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt">
    2024 © Make Comfort
</footer>

<!-- bundle -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{asset('js/vendor.min.js')}}"></script>
<script src="{{asset('js/app.min.js')}}"></script>



</body>

</html>
