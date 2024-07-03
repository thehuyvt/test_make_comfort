@extends('layout.master')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <a href="{{route('management-customers.index')}}"  class="btn btn-success btn-sm mb-3">Trở về</a>
    <form action="{{route('management-customers.update', $customer->id)}}" method="post">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{$customer->email}}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Tên khách hàng</label>
            <input type="text" id="name" name="name" class="form-control" value="{{$customer->name}}">
        </div>

        <div class="form-group">
            <label for="phone_number">Số điện thoại</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{$customer->phone_number}}">
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" id="address" name="address" class="form-control" value="{{$customer->address}}">
        </div>
        <div class="form-group">
            <label for="status">Trạng thái: </label>
            <select name="status">
                @foreach($listStatus as $value => $status)
                    <option value="{{$value}}"
                            @if($customer->status === $value) selected @endif>
                        {{$status}}</option>
                @endforeach
            </select>
        </div>

        <input class="btn btn-block btn-primary" type="submit" value="Cập nhật thông tin khách hàng">
    </form>
@endsection
