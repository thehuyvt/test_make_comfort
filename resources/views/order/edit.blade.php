@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Chỉnh sửa đơn hàng #{{ $order->id }}</h4>

                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Tên:</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $order->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ:</label>

                            <input type="text" id="address" name="address" class="form-control" value="{{ $order->address }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Số điện thoại:</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ $order->phone_number }}" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Phương thức thanh toán:</label>
                            <input type="text" disabled id="payment_method" name="payment_method" class="form-control" value="{{ $order->payment_method }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật thông tin giao hàng</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Danh sách sản phẩm đơn hàng #{{ $order->id }}</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Loại</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="list-order-product">
                            @foreach($order->orderProducts as $orderProduct)
                                <tr style="line-height: 48px;">
                                    <td>
                                        <img src="{{ asset('storage/'.$orderProduct->thumb) }}" alt="img" title="contact-img" class="rounded mr-3" height="48">
                                        {{ $orderProduct->variant->product->name }}
                                    </td>
                                    <td>
                                        @foreach($orderProduct->variant->product->options as $key => $option)
                                            <label for="{{$key}}">{{$key}}: </label>
                                            <select name="{{$key}}" class="mr-2">
                                                @foreach($option as $value)
                                                    <option value="{{ $value }}" @selected($value === $orderProduct->variant->key)>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endforeach
                                    </td>
                                    <td>
                                        <input type="number" name="quantity" min="1" class="form-control w-50" value="{{ $orderProduct->quantity }}">
                                    </td>
                                    <td>{{ number_format($orderProduct->price) }}</td>
                                    <td>{{ number_format($orderProduct->quantity * $orderProduct->price) }}</td>
                                    <td>
{{--                                        <a href="" class="action-icon">--}}
{{--                                            <i class="mdi mdi-square-edit-outline"></i>--}}
{{--                                        </a>--}}
                                        <a href="#" class="action-icon">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <input type="text" id="product-name" name="name" class="form-control">
                                </td>
                            </tr>
                            </tbody>

                            <caption>
                                <button type="button" id="btn_add_product" class="btn btn-outline-dark d-block mx-auto">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Thêm sản phẩm
                                </button>
                            </caption>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div> <!-- end col -->S
    </div>
@endsection

