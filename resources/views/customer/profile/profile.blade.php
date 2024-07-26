@extends('customer.layout.master')
@section('content')
    <div class="container m-t-100 m-b-50">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Chỉnh sửa thông tin khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('customers.update-profile', $customer->id)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="customerEmail">Email</label>
                                <input type="email" disabled class="form-control" id="customerEmail" value="{{$customer->email}}" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <label for="customerName">Tên khách hàng</label>
                                <input type="text" class="form-control" id="customerName" name="name" value="{{$customer->name}}" placeholder="Nhập tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label for="customerPhone">Số điện thoại</label>
                                <input type="text" class="form-control" id="customerPhone" name="phone_number" value="{{$customer->phone_number}}" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="form-group">
                                <label for="customerAddress">Địa chỉ</label>
                                <input type="text" class="form-control" id="customerAddress" name="address" value="{{$customer->address}}" placeholder="Nhập địa chỉ">
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <div class="form-check">
                                    @foreach($genders as $value => $key)
                                        <input
                                            class="form-check-input m-0"
                                            type="radio"
                                            name="gender"
                                            id="status{{$key}}"
                                            value="{{$value}}"
                                            @checked($customer->gender == $value)
                                        >
                                        <label class="form-check-label mr-5" for="status{{$key}}">
                                            {{$key}}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                            <a href="{{route('customers.index')}}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
