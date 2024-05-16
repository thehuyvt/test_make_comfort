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
    <a href="{{route('dashboard')}}"  class="btn btn-success btn-sm mb-3">Trở về</a>
    <form action="{{route('users.update-password')}}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="password">Mật khẩu cũ</label>
            <input type="password" id="password" name="password" class="form-control" value="{{old('password')}}">
        </div>

        <div class="form-group">
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" id="new_password" name="new_password" class="form-control" value="{{old('new_password')}}">
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Nhập lại mật khẩu</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" value="{{old('new_password_confirmation')}}">
        </div>

        <input class="btn btn-block btn-primary" type="submit" value="Đổi mật khẩu">
    </form>
@endsection
