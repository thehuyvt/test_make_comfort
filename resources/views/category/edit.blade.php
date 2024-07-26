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
    <a href="{{route('categories.index')}}"  class="btn btn-success btn-sm mb-3">Trở về</a>
    <form action="{{route('categories.update', $category->id)}}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên phân loại</label>
            <input type="text" id="name" name="name" class="form-control" value="{{$category->name}}">
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{$category->description}}</textarea>
        </div>
        <input class="btn btn-block btn-primary" type="submit" value="Sửa loại sản phẩm">
    </form>
@endsection
