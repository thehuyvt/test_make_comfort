@extends('customer.layout.master')

@section('content')
    <!-- breadcrumb -->
    <div class="container" style="margin-top: 84px">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="product.html" class="stext-109 cl8 hov-cl1 trans-04">
                Sản phẩm
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
        </div>
    </div>


    <div class="container p-t-50">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-3 m-lr-auto mdi-box-shadow">
                <div class="side-menu">
                    <!-- Search product -->
                    <div class="panel-search w-full p-t-10 p-b-15">
                        <div class="bor8 dis-flex p-l-15">
                            <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                            <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" id="search-product" placeholder="Tìm kiếm">
                        </div>
                    </div>

                    <!-- Filter by category -->
                    <div class="p-t-24">
                        <h4 class="cl2 p-b-16">
                            Danh mục sản phẩm
                        </h4>
                        <ul class="flex-w flex-l-m filter-tope-group m-tb-10">
                            <li class="p-t-4">
                                <button class="filter-category stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-category="*">
                                    Tất cả
                                </button>
                            </li>
                            @foreach($categories as $category)
                                <li class="p-t-4">
                                    <button class=" filter-category stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-category="{{$category->id}}">
                                        {{$category->name}}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Filter by price -->
                    <div class="p-t-24">
                        <h4 class="cl2 p-b-16">
                            Giá sản phẩm
                        </h4>
                        <ul class="flex-w flex-l-m filter-tope-group m-tb-10">
                            <li class="pb-3"><button class="filter-price stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-price="0-999999999">Tất cả</button></li>
                            <li class="pb-3"><button class="filter-price stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-price="0-200000">Dưới 200,000đ</button></li>
                            <li class="pb-3"><button class="filter-price stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-price="200000-500000">200,000đ - 500,000đ</button></li>
                            <li class="pb-3"><button class="filter-price stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-price="500000-1000000">500,000đ - 1,000,000đ</button></li>
                            <li class="pb-3"><button class="filter-price stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-price="1000000-999999999">Trên 1,000,000đ</button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm -->
            <div class="col-md-9 col-lg-9">
                <div class="row" id="product-list">
{{--                    @foreach($listProducts as $product)--}}
{{--                        <div class="col-sm-6 col-md-6 col-lg-4 p-b-35 isotope-item product-item {{$product->category_id}}" data-price="{{$product->price}}">--}}
{{--                            <!-- Block2 - Chi tiết sản phẩm -->--}}
{{--                            <div class="block2">--}}
{{--                                <div class="block2-pic hov-img0">--}}
{{--                                    <img src="{{asset('storage')."/".$product->thumb}}" alt="IMG-PRODUCT">--}}

{{--                                    <a href="{{route('product.detail', $product->slug)}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product-slug="{{$product->slug}}">--}}
{{--                                        Chi tiết--}}
{{--                                    </a>--}}
{{--                                </div>--}}

{{--                                <div class="block2-txt flex-w flex-t p-t-14">--}}
{{--                                    <div class="block2-txt-child1 flex-col-l ">--}}
{{--                                        <a href="{{route('product.detail', $product->slug)}}" style="font-size: 16px" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">--}}
{{--                                            {{$product->name}}--}}
{{--                                        </a>--}}

{{--                                        <span class="stext-105 cl3" style="color: #f53d2d">--}}
{{--									Giá: {{$product->sale_price}}đ <span class="ml-2" style="color:#333;text-decoration: line-through;font-size:12px">{{$product->old_price}}đ</span>--}}
{{--								</span>--}}
{{--                                    </div>--}}

{{--                                    <div class="block2-txt-child2 flex-r p-t-3">--}}
{{--                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">--}}
{{--                                            <img class="icon-heart1 dis-block trans-04" src="{{asset('customer/images/icons/icon-heart-01.png')}}" alt="ICON">--}}
{{--                                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('customer/images/icons/icon-heart-02.png')}}" alt="ICON">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            function renderProducts(products) {
                var productList = $('#product-list');
                productList.children().remove();
                products.forEach(function(product) {
                    var productHtml = `
                        <div class="col-sm-6 col-md-6 col-lg-4 p-b-35 isotope-item product-item ${product.category_id}" data-price="${product.price}">
                            <!-- Block2 - Chi tiết sản phẩm -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ asset('storage/') }}/${product.thumb}" alt="IMG-PRODUCT">

                                    <a href="/product/${product.slug}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product-slug="${product.slug}">
                                        Chi tiết
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="{route('product.detail', product.slug)}" style="font-size: 16px" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            ${product.name}
                                        </a>

                                        <span class="stext-105 cl3" style="color: #f53d2d">
                                             Giá: ${product.sale_price}đ <span class="ml-2" style="color:#333;text-decoration: line-through;font-size:12px">${product.old_price}đ</span>
								        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04" src="{{asset('customer/images/icons/icon-heart-01.png')}}" alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('customer/images/icons/icon-heart-02.png')}}" alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    productList.append(productHtml);
                });
            }

            function fetchProducts(params) {
                console.log(params);
                $.ajax({
                    url: "{{ route('customers.list-products') }}",
                    type: "GET",
                    delay: 250,
                    data: params,
                    success: function(response) {
                        renderProducts(response.listProducts.data);
                    }
                });
            }

            var params = {
                category: '',
                price: '',
                key: ''
            };

            // Lọc theo danh mục
            $('.filter-category').click(function(e) {
                e.preventDefault();
                var category = $(this).data('category');
                params.category = category;
                $('.filter-price').each(function() {
                    var price = $(this).data('price');

                    if(price == params.price) {
                        $(this).addClass('how-active1');
                    }else{
                        $(this).removeClass('how-active1');
                    }
                });
                fetchProducts(params);
            });

            // Lọc theo giá
            $('.filter-price').click(function(e) {
                e.preventDefault();
                var price = $(this).data('price');
                params.price = price

                $('.filter-category').each(function() {
                    var category = $(this).data('category');

                    if(category == params.category) {
                        $(this).addClass('how-active1');
                    }else{
                        $(this).removeClass('how-active1');
                    }
                });

                fetchProducts(params);
            });

            // Tìm kiếm sản phẩm
            $('#search-product').on('keyup', function() {
                var search = $(this).val();
                params.key = search
                fetchProducts(params);
            });

            // Initial load
            fetchProducts();
        });
    </script>
@endpush
