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
                        <div class="col-sm-4">
                            <a href="{{route('products.create')}}" class="btn btn-success mb-2"><i
                                    class="mdi mdi-plus-circle mr-2"></i> Tạo sản phẩm</a>
                        </div>
                    </div>
{{--                    search and fill product--}}
                    <form id="searchForm" action="" method="get" class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="category">Loại sản phẩm</label>
                                <select class="form-control" name="category">
                                    <option value="">Tất cả</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if((int)request()->get('category') === $category->id)
                                                selected
                                            @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="status">Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="">Tất cả</option>
                                    @foreach($listStatus as $key => $status)
                                        <option
                                            value="{{$key}}"
                                            @selected(request('status') == $key)
                                        >
                                            {{$status}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="key">Tìm kiếm bằng id, slug, tên,... </label>
                                <input type="text" class="form-control" placeholder="Tìm kiếm ..." value="{{request()->get('key')}}" name="key">
                            </div>
                        </div>
                        <div class="col-sm-3  form-group" >
                            <div class="">
                                <button type="submit" class="btn btn-primary form-control"  style="margin-top: 29px;">Tìm kiếm</button>
                            </div>
                        </div>

                    </form>

                    <table class="table table-striped text-center" id="table-index">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Loại sản phẩm</th>
                                <th>Thời gian tạo</th>
                                <th>Giá đang bán</th>
                                <th>Trạng thái</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($listProducts as $product)
                            <tr style="line-height: 40px">
                                <td>#{{$product->id}}</td>
                                <td>
                                    <a href="{{route('products.edit', $product->slug)}}" class="text-body">
                                        <img src="{{asset('storage/'.$product->thumb)}}" alt="img" title="contact-img" class="rounded mr-3" height="48">
                                    </a>
                                    <br>
                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->category?->name}}</td>
                                <td>{{$product->created_at}}</td>
                                <td>{{$product->sale_price}}</td>
                                <td>{{$product->status}}</td>
                                <td>
                                    <a href="{{route('products.edit', $product->slug)}}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card-body-->
                {{ $listProducts->links() }}
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection

