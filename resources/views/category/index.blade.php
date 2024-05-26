@extends('layout.master')

@section('content')
    <a href="{{route('categories.create')}}" class="btn btn-success btn-rounded">Add Category</a>
    <table class="table table-centered mb-0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
{{--            <th>Active</th>--}}
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->description}}</td>
                {{--            <td>--}}
                {{--                <!-- Switch-->--}}
                {{--                <div>--}}
                {{--                    <input type="checkbox" id="switch1" checked data-switch="success"/>--}}
                {{--                    <label for="switch1" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>--}}
                {{--                </div>--}}
                {{--            </td>--}}
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
