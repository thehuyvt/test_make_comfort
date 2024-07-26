@extends('customer.layout.master')

@section('content')
    <div class="container m-t-100 m-b-100">
        <h2 class="mb-4">Lịch Sử Đơn Hàng</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Ngày Đặt</th>
                    <th>Trạng Thái</th>
                    <th>Tổng Tiền</th>
                    <th>Thanh toán</th>
                    <th>Chi Tiết</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{$order->id}}</td>
                        <td>{{$order->placed_at}}</td>
                        <td>
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
                        </td>
                        <td>{{$order->total}}</td>
                        <td>{{$order->payment_method}}</td>
                        <td><a href="{{route('orders.detail', $order->id)}}" class="btn btn-info btn-sm">Xem</a></td>
                    </tr>
                @endforeach

                <!-- Add more rows as necessary -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
