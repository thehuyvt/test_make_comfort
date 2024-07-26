@php use App\Enums\OrderStatusEnum; @endphp
@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Thông tin nhân viên</h1>
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $user->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
                        <p><strong>Tổng đơn hàng:</strong> {{ $totalOrders }}</p>
                        <p><strong>Đơn hàng xác nhận:</strong> {{ $processedOrders }}</p>
                        <p><strong>Đơn hàng từ chối:</strong> {{ $rejectedOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Danh sách đơn hàng đã xử lý </h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Ngày xử lý</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ $order->updated_at->format('d/m/Y') }}</td>
                            <td>
                                @switch($order->status)
                                    @case(OrderStatusEnum::PROCESSED->value)
                                        <span class="badge badge-success">{{ OrderStatusEnum::getNameStatus($order->status) }}</span>
                                        @break
                                    @case(OrderStatusEnum::REJECT->value)
                                        <span class="badge badge-danger">{{ OrderStatusEnum::getNameStatus($order->status) }}</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ number_format($order->total, 0, ',', '.') }} VND</td>
                            <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-success">Chi tiết</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{$orders->links()}}
        </div>
    </div>
@endsection
