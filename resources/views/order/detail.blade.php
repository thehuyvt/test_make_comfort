@extends('layout.master')

@section('content')
    <a href="{{route('orders.index')}}" class="btn btn-secondary">Trở về</a>
    <div class="d-flex justify-content-between">
        <div>
            @if($order->status === 'Chờ xử lý')
                <button id="accessButton" class="btn btn-success mb-2"></i>
                    Xác nhận đơn
                </button>
                <button  type="button" id="rejectButton" class="btn btn-danger mb-2" data-toggle="modal" data-target="#danger-header-modal">Từ chối </button>
            @endif
        </div>
        @if($order->status !== 'Đã từ chối')
            <button id="printButton" class="btn btn-secondary mb-2"><i
                    class="mdi mdi-plus-circle mr-2"></i>
                In đơn hàng
            </button>
        @endif

    </div>

    <div class="row" id="printOrder">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="user-information">
                        @if($order->status === 'Đã xử lý')
                        <h4 class="header-title mb-3">Người xử lý đơn</h4>
                        <h5 class="mb-3">Tên: {{$user->name}}</h5>
                        @endif

                        @if($order->status === 'Đã từ chối')
                            <h4 class="header-title mb-3">Người từ chối đơn</h4>
                            <h5 class="mb-3">Tên: {{$user->name}}</h5>
                        @endif
                    </div>
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

        <div id="danger-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-danger">
                        <h4 class="modal-title" id="danger-header-modalLabel">Từ chối đơn hàng</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        Xác nhận từ chối đơn hàng  #{{$order->id}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-danger" id="acceptReject">Xác nhận</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
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

            });


            $("#accessButton").click(function(){
                processOrder(orderId);
            });

            $("#acceptReject").click(function(){
                rejectOrder(orderId);
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
                            let data = response.data;
                            let html = `<h4 class="header-title mb-3">Người xử lý đơn</h4>
                            <h5 class="mb-3">Tên: ${data.user_name}</h5>`
                            alert('Đơn hàng đã chuyển sang trạng thái đã xử lý!');
                            $("#rejectButton").css('display','none');
                            $("#accessButton").css('display','none');
                            $("#user-information").html(html);
                        } else {
                            alert('Thất bại');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            }

            function rejectOrder(orderId) {
                $.ajax({
                    url: "{{ route('orders.reject-order', '') }}/" + orderId,
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}' // Bao gồm CSRF token để bảo mật
                    },
                    success: function (response) {
                        if (response.success) {
                            let data = response.data;
                            let html = `<h4 class="header-title mb-3">Người từ chối đơn</h4>
                            <h5 class="mb-3">Tên: ${data.user_name}</h5>`
                            $("#rejectButton").css('display','none');
                            $("#accessButton").css('display','none');
                            $("#printButton").css('display','none');
                            $("#danger-header-modal").modal('hide');

                            $("#user-information").html(html);
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
