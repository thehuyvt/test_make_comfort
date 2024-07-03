@php use App\Enums\OrderStatusEnum; @endphp
@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Thông tin khách hàng</h1>
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $customer->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Email:</strong> {{ $customer->email }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $customer->phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $customer->address }}</p>
                        <p><strong>Tổng đơn hàng:</strong> {{ $customer->total_orders }}</p>
                        <p><strong>Đơn hàng hoàn thành:</strong> {{ $customer->total_completed_orders }}</p>
                        <p><strong>Đơn hàng bị hủy:</strong> {{ $customer->total_cancelled_orders }}</p>
                        <p><strong>Tổng số tiền đã
                                mua:</strong> {{ number_format($customer->total_amount_bought, 0, ',', '.') }} VND</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Danh sách đơn hàng</h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customer->orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                @switch($order->status)
                                    @case(OrderStatusEnum::DRAFT->value)
                                        <span class="badge badge-secondary">{{ $order->statusName}}</span>
                                        @break
                                    @case(OrderStatusEnum::ORDERING->value)
                                        <span class="badge badge-info">{{ $order->statusName}}</span>
                                        @break
                                    @case(OrderStatusEnum::PENDING->value)
                                        <span class="badge badge-warning">{{ $order->statusName}}</span>
                                        @break
                                    @case(OrderStatusEnum::PROCESSED->value)
                                        <span class="badge badge-success">{{ $order->statusName}}</span>
                                        @break
                                    @case(OrderStatusEnum::CANCELLED->value)
                                        <span class="badge badge-danger">{{ $order->statusName}}</span>
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
        </div>
    </div>
@endsection
