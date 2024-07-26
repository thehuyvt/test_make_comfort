<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />--}}
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset('customer/images/icons/favicon.png')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/fonts/linearicons-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/slick/slick.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/MagnificPopup/magnific-popup.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('customer/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('customer/css/main.css')}}">
<!--===============================================================================================-->
    @stack('css')
</head>
<body class="animsition">

	<!-- Header -->
    @include('customer.layout.header')
	<!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Giỏ hàng của bạn
				</span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul id="cart-items" class="header-cart-wrapitem w-full">
{{--                    //Thêm sản phẩm vào cart ở đây--}}
                </ul>

                <div class="w-full">
                    <div id="total-view-cart" class="header-cart-total w-full p-tb-40">
{{--                        Total: $75.00--}}
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="{{route('carts.detail')}}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            Giỏ hàng
                        </a>
                        <a href="{{route("carts.index")}}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--    Content--}}
    @yield('content')

	<!-- Footer -->
	@include('customer.layout.footer')


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<!-- Modal1 -->

<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('dists/notify.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('customer/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/select2/select2.min.js')}}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
    <script src="{{asset('customer/vendor/slick/slick.min.js')}}"></script>
	<script src="{{asset('customer/js/slick-custom.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/parallax100/parallax100.js')}}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/sweetalert/sweetalert.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script>
		$(document).ready(function(){
			@if(session('error'))
				swal("Error", "{{session('error')}}", "error");
			@endif
            @if(session('success'))
                swal("Success", "{{session('success')}}", "success");
            @endif
		});
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail.blade.php').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail.blade.php').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail.blade.php').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail.blade.php').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

	</script>
<!--===============================================================================================-->
	<script src="{{asset('customer/vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="{{asset('customer/js/main.js')}}"></script>
    <script>
        //tính tổng số lượng sản phẩm trong giỏ hàng
        function getSumProductInCart() {
            $.ajax({
                url: '/sum-products-in-cart',
                type: 'GET',
                success: function(response) {
                    $('#sum-cart').attr('data-notify', response.total);
                    $('#sum-cart-mobile').attr('data-notify', response.total);
                    getProductsInCart();
                },
                error: function(xhr, status, error) {
                    toastr.error('Error:', error);
                }
            });
        }
        getSumProductInCart();

        function addCartItem(thumb, name, key, quantity, price) {
            var cartItemHtml = `
            <li class="header-cart-item flex-w flex-t m-b-12">
                <div class="header-cart-item-img">
                    <img src="${thumb}" alt="IMG">
                </div>

                <div class="header-cart-item-txt p-t-8">
                    <a href="#" class="header-cart-item-name m-b-0 hov-cl1 trans-04">
                        ${name}
                    </a>
                    <span class="block1-info stext-102 trans-04 m-b-8" style="font-size: 12px;">Loại: ${key}</span>
                    <span class="header-cart-item-info">
                        ${quantity} x ${price}
                    </span>
                </div>
            </li>
            `;

            $('#cart-items').append(cartItemHtml);
        }
        function getProductsInCart() {
            $('#cart-items').children().remove();
            $.ajax({
                url: '/list-products-in-cart',
                type: 'GET',
                success: function(response) {
                    let orderProducts = response.listProducts;
                    let asset = window.location.origin + '/storage/';

                    if (orderProducts.length > 0) {
                        $.each(orderProducts, function(index, orderProduct) {
                            addCartItem( asset + orderProduct.thumb,
                                orderProduct.variant.product.name,
                                orderProduct.variant.key,
                                orderProduct.quantity,
                                orderProduct.price.toLocaleString()+"đ"
                            );
                        })
                    }else{
                        $('#cart-items').append("<h4 class='stext-101 cl3'>Giỏ hàng trống!!!</h4>");
                    }
                    $('#total-view-cart').text("Tổng: " + response.order.total.toLocaleString() + "đ");
                },
                error: function(xhr, status, error) {
                    toastr.error('Error:', error);
                }
            });
        }
    </script>
@stack('js')
</body>
</html>
