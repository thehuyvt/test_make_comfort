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

