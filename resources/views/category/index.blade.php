@extends('layout.master')

@section('content')
    <a href="{{route('categories.create')}}" class="btn btn-success btn-rounded">Thêm loại sản phẩm</a>
    <table class="table table-centered mb-0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên loại sản phẩm</th>
            <th>Mô tả</th>
            <th>Chức năng</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->description}}</td>
                <td  class="table-action">
                    <a href="{{route('categories.edit', $category->id)}}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <nav class="float-right">
        <ul class="pagination pagination-rounded mb-0">
            {{$categories->links()}}
        </ul>
    </nav>
@endsection
