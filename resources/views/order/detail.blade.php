@extends('layout.master')

@section('content')
    <button id="printButton" class="btn btn-success mb-2"><i
            class="mdi mdi-plus-circle mr-2"></i>
            In đơn hàng
    </button>
    <div class="row" id="printOrder">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Thông tin giao hàng</h4>

                    <h5>Tên: {{$order->name}}</h5>

                    <address class="mb-0 font-14 address-lg">
                        Địa chỉ: {{$order->address}}
                    </address>
                    <p class="mb-1 font-14 address-lg">
                        Sđt: {{$order->phone_number}}
                    </p>
                    <h5>Phương thức : {{$order->payment_method}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Danh sách sản phẩm đơn hàng #{{$order->id}}</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderProducts as $orderProduct)
                                <tr>
                                    <td>
                                        <img src="{{asset('storage/'.$orderProduct->thumb)}}" alt="img" title="contact-img" class="rounded mr-3" height="48">
                                        {{$orderProduct->variant->product->name}}
                                        <span style="font-size: 12px;">({{$orderProduct->variant->key}})</span>
                                    </td>
                                    <td>{{$orderProduct->quantity}}</td>
                                    <td>{{number_format($orderProduct->price)}}</td>
                                    <td>{{number_format($orderProduct->quantity * $orderProduct->price)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Tóm tắt đơn hàng</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Mô tả</th>
                                <th>Giá</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Tổng :</td>
                                <td>{{number_format($order->total - 30000)}}đ</td>
                            </tr>
                            <tr>
                                <td>Chi phí ship :</td>
                                <td>{{number_format(30000)}}đ</td>
                            </tr>
                            <tr>
                                <th>Tổng cộng :</th>
                                <th>{{number_format($order->total)}}đ</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->

                </div>
            </div>
        </div>
        <!-- end col --><!-- end col -->
    </div>
{{--        <div class="col-lg-4">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <h4 class="header-title mb-3">Delivery Info</h4>--}}

{{--                    <div class="text-center">--}}
{{--                        <i class="mdi mdi-truck-fast h2 text-muted"></i>--}}
{{--                        <h5><b>UPS Delivery</b></h5>--}}
{{--                        <p class="mb-1"><b>Order ID :</b> xxxx235</p>--}}
{{--                        <p class="mb-0"><b>Payment Mode :</b> COD</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div> <!-- end col -->--}}
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            let orderId = {{$order->id}};
            $("#printButton").click(function(){
                var printContents = $("#printOrder").html();
                var originalContents = $("body").html();

                $("body").html(printContents);
                window.print();
                $("body").html(originalContents);

                processOrder(orderId);
            });

            function processOrder(orderId) {
                $.ajax({
                    url: "{{ route('orders.process-order', '') }}/" + orderId,
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}' // Bao gồm CSRF token để bảo mật
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Đơn hàng đã chuyển sang trạng thái đã xử lý!');
                        } else {
                            alert('Thất bại');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            }
        });
    </script>
@endpush
