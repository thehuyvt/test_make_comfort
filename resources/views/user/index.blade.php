@extends('layout.master')

@section('content')
    <a href="{{route('users.create')}}" class="btn btn-success btn-rounded">Thêm nhân viên</a>
    <table class="table table-centered mb-0">
        <thead>
        <tr>
            <th>Mã</th>
            <th>Email</th>
            <th>Tên</th>
            <th>Số điện thoại</th>
            <th>Ngày bắt đầu làm</th>
            <th>Trạng thái</th>
            <th>Chức năng</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->phone_number}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                    @if($user->status === 1) <span class="badge badge-success">Hoạt động</span> @endif
                    @if($user->status !== 1) <span class="badge badge-danger">Dừng hoạt động</span> @endif
                </td>
                <td  class="table-action">
                    <a href="{{route('users.edit', $user->id)}}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <nav class="float-right">
        <ul class="pagination pagination-rounded mb-0">
            {{$users->links()}}
        </ul>
    </nav>
@endsection
