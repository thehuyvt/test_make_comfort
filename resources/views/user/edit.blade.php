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
    <a href="{{route('users.index')}}"  class="btn btn-success btn-sm mb-3">Trở về</a>
    <form action="{{route('users.update', $user->id)}}" method="post">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{$user->email}}">
        </div>

{{--        <div class="form-group">--}}
{{--            <label for="password">Mật khẩu</label>--}}
{{--            <input type="password" id="password" name="password" class="form-control" value="{{$user->password}}">--}}
{{--        </div>--}}

        <div class="form-group">
            <label for="name">Tên nhân viên</label>
            <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}">
        </div>

        <div class="form-group">
            <label for="phone_number">Số điện thoại</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{$user->phone_number}}">
        </div>

        <div class="form-group">
            <label for="status">Trạng thái: </label>
            <select name="status">
                @foreach($listStatus as $key => $status)
                    <option value="{{$status->value}}"
                            @if($user->status === $status->value) selected @endif>
                        {{$key}}</option>
                @endforeach
            </select>
        </div>

        <input class="btn btn-block btn-primary" type="submit" value="Sửa nhân viêsn">
    </form>
@endsection
