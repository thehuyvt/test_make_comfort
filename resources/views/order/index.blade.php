@extends('layout.master')
@push('css')
    {{--    <link href="{{asset('css/vendor/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css"/>--}}
    {{--    <link href="{{asset('css/vendor/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css"/>--}}
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
{{--                        <div class="col-sm-4">--}}
{{--                            <a href="{{route('orders.create')}}" class="btn btn-success mb-2"><i--}}
{{--                                    class="mdi mdi-plus-circle mr-2"></i> Tạo đơn</a>--}}
{{--                        </div>--}}
                    </div>
                    {{--                    search and fill product--}}
                    <form id="searchForm" action="" method="get" class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="status">Trạng thái đơn hàng</label>
                                <select class="form-control" name="status">
                                    <option value="">Tất cả</option>
                                    @foreach($listStatus as $value => $key)
                                        @if($value !== 1)
                                            <option value="{{ $value}}"
                                                @selected(request()->get('status') == $value)
                                            >
                                                {{ $key }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="payment_method">Phương thức thanh toán</label>
                                <select class="form-control" name="payment_method">
                                    <option value="">Tất cả</option>
                                    @foreach($paymentMethods as $value => $paymentMethod)
                                        <option
                                            value="{{$value}}"
                                            @selected(request('payment_method') == $value)
                                        >
                                            {{$paymentMethod['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="id">Mã đơn hàng </label>
                                <input type="text" class="form-control" placeholder="Tìm kiếm ..." value="{{request()->get('id')}}" name="id">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="key">Số điện thoại, tên </label>
                                <input type="text" class="form-control" placeholder="Tìm kiếm ..." value="{{request()->get('key')}}" name="key">
                            </div>
                        </div>
                        <div class="col-sm-2  form-group" >
                            <div class="">
                                <button type="submit" class="btn btn-primary form-control"  style="margin-top: 29px;">Tìm kiếm</button>
                            </div>
                        </div>

                    </form>

                    <table class="table table-striped text-center" id="table-index">
                        <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Tổng giá trị đơn</th>
                            <th>Phương thức thanh toán</th>
                            <th>Thời gian đặt</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr style="line-height: 40px">
                                <td>#{{$order->id}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->phone_number}}</td>
                                <td>{{$order->total}}</td>
                                <td>{{$order->payment_method}}</td>
                                <td>{{$order->placed_at}}</td>
                                <td>{{$order->status}}</td>
                                <td>
                                    <a href="{{route('orders.show', $order->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                    <a href="{{route('orders.edit', $order->id)}}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card-body-->
                {{ $orders->links() }}
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection

