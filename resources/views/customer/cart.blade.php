@extends('customer.layout.master')
@push('css')
    <style>
        .btn-num-product{
            width: 45px;
            height: 100%;
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="container" style="margin-top: 100px;">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
				Shoping Cart
			</span>
        </div>
    </div>
    <div class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            @if($listProducts->toArray() !== [])
                                <table class="table-shopping-cart">
                                    <tbody>
                                    <tr class="table_head">
                                        <th class="column-1">Sản phẩm</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Giá</th>
                                        <th class="column-5">Số lượng</th>
                                    </tr>
                                    @foreach($listProducts as $product)
                                        <tr class="table_row" data-product-id="{{ $product->id }}" data-order-id="{{$order->id}}">
                                            <td class="column-1">
                                                <a href="{{route('product.detail', $product->variant->product->slug)}}">
                                                    <div class="how-itemcart1">
                                                        <img src="{{asset('storage/' . $product->thumb)}}" alt="IMG">
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="column-2">
                                                <span class="stext-105 cl3">{{$product->variant->product->name}}</span>
                                                <h5 class="stext-105 cl3">Loại: {{$product->variant->key}}</h5>
                                            </td>
                                            <td class="column-3">{{number_format($product->price)}}</td>
                                            <td class="column-5">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <div class="btn-num-product cl8 hov-btn3 trans-04 flex-c-m" onclick="updateQuantity(this, -1)">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>
                                                    <input class="mtext-104 cl3 txt-center num-product"
                                                           type="number" min="1" name="quantity"
                                                           value="{{$product->quantity}}" oninput="checkQuantity(this)">
                                                    <input type="hidden" name="key" value="{{$product->variant->key}}">
                                                    <div class="btn-num-product cl8 hov-btn3 trans-04 flex-c-m" onclick="updateQuantity(this, 1)">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">
                                    </div>
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                            Dùng voucher
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm" style="border-bottom: none;">
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 class="stext-110 cl2">Tạm tính:</h4>
                                    </div>
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 id="sum-order" class="mtext-110 cl2">{{number_format($order->total)}}đ</h4></span>
                                    </div>
                                </div>
                                <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm" style="border-bottom: none;">
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 class="stext-110 cl2">Giảm giá:</h4>
                                    </div>
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 class="mtext-110 cl2">0đ</h4></span>
                                    </div>
                                </div>
                                <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 class="stext-110 cl2">Phí giao hàng:</h4>
                                    </div>
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 class="mtext-110 cl2">{{number_format(30000)}}đ</h4></span>
                                        <input type="hidden" name="shipping" value="30000">
                                    </div>
                                </div>
                                <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 class="mtext-109 cl2" style="text-transform: none">Tổng: </h4>
                                    </div>
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <h4 id="total-order" class="mtext-109 cl2" style="text-transform: none">{{number_format($order->total+30000)}}đ</h4></span>
                                    </div>
                                </div>
                            @endif
                            @if($listProducts->toArray() === [])
                                <div class="text-center">
                                    <h4 class="stext-101 cl3">Giỏ hàng của bạn đang trống, hãy mua sắm ngay nhé</h4>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>

                <div class="col-sm-10 col-lg-10 col-xl-5 m-lr-auto m-b-50">
                    <form action="{{route('carts.check-out', $order->id)}}" method="post">
                        @csrf
                        <div class="bor10 p-lr-40 p-t-30 m-l-30  m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Thông tin vận chuyển
                            </h4>
                            <div class="w-100 bor12 ">
                                <label class="stext-102 cl2 p-t-4 w-100">Họ và tên
                                    <div class="bor8 bg0">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name" value="{{$order->name}}">
                                    </div>
                                </label>
                                <label class="stext-102 cl2 p-t-4 w-100 mb-2">Số điện thoại
                                    <div class="bor8 bg0 ">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="phone_number" value="{{$order->phone_number}}">
                                    </div>
                                </label>
                                <label class="stext-102 cl2 p-t-4 w-100 mb-2">Địa chỉ
                                    <div class="bor8 bg0 ">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="address" value="{{$order->address}}">
                                    </div>
                                </label>
                                <label class="stext-102 cl2 p-t-4 w-100 mb-2">Ghi chú
                                    <div class="bor8 bg0 ">
                                        <textarea class="stext-111 cl8 plh3  p-lr-15 p-t-15" cols="43" rows="4" name="note" placeholder="Ghi chú ...">{{$order->note??''}}</textarea>
                                    </div>
                                </label>
                            </div>

                            <div class="flex-w flex-t p-t-27 p-b-33">
                                <div class="mb-3">
                                    <label class="mtext-101 cl2">
                                        Phương thức thanh toán
                                    </label>
                                </div>
                                <div class="col-lg-12">

                                    @foreach($listPaymentMethods as $value =>$paymentMethod)
                                        <div class="border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="d-flex align-items-center">
                                                        <input type="radio" id="{{$paymentMethod['name']}}" name="payment_method" value="{{$value}}" class="mr-3" checked>
                                                        <label for="{{$paymentMethod['name']}}" class=" font-16 font-weight-bold mb-0 w-100 pointer">{{$paymentMethod['name']}}</label>
                                                    </div>
                                                    <p class="ml-3 mb-0 mt-2 pl-3 pt-1">{{$paymentMethod['description']}}</p>
                                                </div>
                                                <div class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                                    <img src="{{asset('')}}/images/payments/{{$paymentMethod['name']}}.png" height="20" alt="payment-method-img">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function checkQuantity(input) {
            if (input.value <= 0) {
                removeProductRow(input.closest('.table_row'));
            }
        }

        function updateQuantity(element, change) {
           const input = element.closest('.wrap-num-product').querySelector('.num-product');
           input.value = parseInt(input.value) + change;
           quantity = input.value;
           const row = $(element).closest('.table_row');
           console.log(row);
           const orderProductId = row.data('product-id');
           let sumOrder = $('#sum-order');
           let totalOrder = $('#total-order');

            console.log(orderProductId);
            if (quantity > 0) {
                updateCart(orderProductId, quantity, input, sumOrder, totalOrder);
            } else {
                removeProductRow(row, orderProductId, sumOrder, totalOrder);
            }
        }

        function updateCart(orderProductId, quantity, input, sumOrder, totalOrder) {
            $.ajax({
                url: `/update-cart/${orderProductId}`,
                type: 'POST',
                data: {
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Số lượng đã thay đổi thành công!');
                        sumOrder.text(response.order.total.toLocaleString() +"đ");
                        totalOrder.text((response.order.total + 30000).toLocaleString() +"đ");
                        getSumProductInCart();
                    } else {
                        input.value = quantity-1;
                        toastr.error('Số lượng sản phẩm trong kho không đủ!');
                    }
                },
                error: function() {
                    toastr.error('Đã xảy ra lỗi khi cập nhật giỏ hàng.');
                }
            });
        }

        function removeProductRow(row, orderProductId, sumOrder, totalOrder) {
            row.remove();
            // Optionally, make an AJAX request to the server to update the cart
            // Example AJAX request (adjust the URL and data format as needed)
            $.ajax({
                url: `/remove-product/${orderProductId}`,
                type: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token if using Laravel
                },
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    console.log(response.success);
                    if (response.success) {
                        sumOrder.text(response.order.total.toLocaleString() + "đ");
                        totalOrder.text((response.order.total + 30000).toLocaleString() + "đ");
                        getSumProductInCart();
                        toastr.warning('Đã xóa sản phẩm khỏi giỏ hàng!');
                    } else {
                        toastr.error('Xóa sản phẩm thất bại.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error('Đã xảy ra lỗi khi xóa sản phẩm.');
                }
            });
        }
    </script>
@endpush
