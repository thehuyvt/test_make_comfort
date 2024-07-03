@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                    </div>
                    <form id="searchForm" action="" method="get" class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="status">Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="all" selected>Tất cả</option>
                                    @foreach($listStatus as $key => $status)
                                        <option
                                            value="{{$key}}"
                                            @selected(request('status') !== "" && (request('status') === "$key"))
                                        >
                                            {{$status}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="key">Tìm kiếm bằng id, tên, số điện thoại...</label>
                                <input type="text" class="form-control" placeholder="Tìm kiếm..." value="{{request()->get('key')}}" name="key">
                            </div>
                        </div>
                        <div class="col-sm-3 form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary form-control" style="margin-top: 29px;">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped text-center" id="table-index">
                        <thead>
                            <tr>
                                <th>Mã KH</th>
                                <th>Tên KH</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Số đơn đã mua</th>
                                <th>Số tiền đã mua</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>#{{$customer->id}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->phone_number}}</td>
                                <td>{{$customer->address}}</td>
                                <td>{{$customer->total_orders}}</td>
                                <td>{{number_format($customer->total_amount_bought)}}đ</td>
                                <td>
                                    <a href="{{route('management-customers.show', $customer->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                    <a href="" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card-body-->
                {{ $customers->links() }}
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection

