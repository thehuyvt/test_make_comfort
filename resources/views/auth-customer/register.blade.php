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
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Đăng ký</h4>
                            <p class="text-muted mb-4"></p>
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
                        <form action="{{route('customers.process-register')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="emailaddress">Email</label>
                                <input class="form-control" type="email" id="emailaddress"  name="email" required="" value="{{old('email')}}" placeholder="Nhập email của bạn">
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

                            <div class="form-group">
                                {{--                                <a href="pages-recoverpw.html" class="text-muted float-right"><small>Forgot your password?</small></a>--}}
                                <label for="password_confirmation">Nhập lại mật khẩu</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu của bạn">
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Họ và tên</label>
                                <input class="form-control" type="text" id="name"  name="name" required="" value="{{old('name')}}" placeholder="Nhập tên của bạn">
                            </div>

                            <div class="form-group">
                                <label>Giới tính</label>
                                <div class="form-check">
                                    @foreach($genders as $key => $gender)
                                        <input class="form-check-input" type="radio" name="gender" id="gender{{$gender->value}}"
                                               value="{{$gender->value}}"
                                               @if ($loop->first)
                                                   checked
                                            @endif>
                                        <label class="form-check-label mr-5" for="gender{{$gender->value}}">
                                            {{$key}}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone_number">Số điện thoại</label>
                                <input class="form-control" type="text" id="phone_number"  name="phone_number" required="" value="{{old('phone_number')}}" placeholder="Nhập sđt của bạn">
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input class="form-control" type="text" id="address"  name="address" required="" value="{{old('address')}}" placeholder="Nhập địa chỉ của bạn">
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button type="submit" class="btn btn-outline-dark" >Đăng kí </button>
                            </div>

                        </form>
                        <div class="text-center mt-3">
                            <p class="text-muted">Do you have an account? <a href="{{route('customers.login')}}" class="text-muted ml-1"><b>Login</b></a></p>
                        </div>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                {{--                <div class="row mt-3">--}}
                {{--                    <div class="col-12 text-center">--}}
                {{--                        <p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-muted ml-1"><b>Sign Up</b></a></p>--}}
                {{--                    </div> <!-- end col -->--}}
                {{--                </div>--}}
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
