@extends('customer.layout.master')

@section('content')
    <div class="container m-t-100 m-b-100">
        <h2 class="mb-4">Chi Tiết Đơn Hàng</h2>

        <!-- Order Details -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Mã Đơn Hàng:</strong> #{{ $order->id }}
            </div>
            <div class="card-body">
                <p><strong>Ngày Đặt:</strong> {{ $order->placed_at }}</p>
                <p><strong>Trạng Thái:</strong>
                    @switch($order->status)
                        @case(3)
                            <span class="badge badge-warning">{{$order->status_name }}</span>
                            @break
                        @case(4)
                            <span class="badge badge-success">{{ $order->status_name}}</span>
                            @break
                        @case(5)
                            <span class="badge badge-secondary">{{ $order->status_name }}</span>
                            @break
                        @case(6)
                            <span class="badge badge-danger">{{$order->status_name }}</span>
                            @break
                        @default
                            <span class="badge badge-secondary">Không rõ</span>
                    @endswitch
                </p>
                <p><strong>Tổng Tiền:</strong> {{$order->total}} VND</p>
            </div>
        </div>

        <!-- Recipient Details -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Thông Tin Người Nhận</strong>
            </div>
            <div class="card-body">
                <p><strong>Họ và Tên:</strong> {{ $order->name}}</p>
                <p><strong>Số Điện Thoại:</strong> {{ $order->phone_number }}</p>
                <p><strong>Địa Chỉ:</strong> {{ $order->address }}</p>
{{--                <p><strong>Email:</strong> {{ $order->recipient_email }}</p>--}}
            </div>
        </div>

        <!-- Products Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Loại</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->orderProducts as $orderProduct)

                        <tr style="line-height: 60px;">
                            <td><img src="{{asset('storage/'.$orderProduct->thumb)}}" alt="{{ $orderProduct->variant->product->name }}" height="60"></td>
                            <td>
                                <a href="{{route('product.detail', $orderProduct->variant->product->slug)}}" style="color: #666;">
                                {{ $orderProduct->variant->product->name }}
                                </a>
                            </td>
                            <td>{{ $orderProduct->variant->key }}</td>
                            <td>{{ $orderProduct->quantity }}</td>
                            <td>{{ number_format($orderProduct->price, 0, ',', '.') }} VND</td>
                            <td>{{ number_format($orderProduct->price * $orderProduct->quantity, 0, ',', '.') }} VND</td>
                        </tr>

                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('orders.history') }}" class="btn btn-primary">Quay Lại Lịch Sử Đơn Hàng</a>
            @if($order->status === 3)
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#confirmCancelModal">
                    Hủy đơn hàng
                </button>
            @endif

        </div>

        <!-- Modal -->
        <div class="modal fade" id="confirmCancelModal"  tabindex="-1" role="dialog" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="margin-top: 100px;"  role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmCancelModalLabel">Xác Nhận Hủy Đơn Hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn hủy đơn hàng này không?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <a href="{{ route('orders.cancel', $order->id) }}" class="btn btn-danger">Xác Nhận</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
{{--    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>--}}
@endpush
