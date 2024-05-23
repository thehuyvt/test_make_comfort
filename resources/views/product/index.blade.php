@extends('layout.master')
@push('css')
{{--    <link href="{{asset('css/vendor/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css"/>--}}
{{--    <link href="{{asset('css/vendor/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{route('products.create')}}" class="btn btn-success mb-2"><i
                                    class="mdi mdi-plus-circle mr-2"></i> Add Products</a>
                        </div>
{{--                        <div class="col-sm-8">--}}
{{--                            <div class="text-sm-right">--}}
{{--                                <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i>--}}
{{--                                </button>--}}
{{--                                <button type="button" class="btn btn-light mb-2 mr-1">Import</button>--}}
{{--                                <button type="button" class="btn btn-light mb-2">Export</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- end col-->--}}
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
                                            value="{{$status}}" 
                                            @if(request('status') == $status) 
                                                selected 
                                            @endif
                                        >
                                            {{$key}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="key">Tên hoặc slug sản phẩm</label>
                                <input type="text" class="form-control" value="{{request()->get('key')}}" name="key">
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
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại sản phẩm</th>
                            <th>Ngày tạo</th>
                            <th>Giá bán</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listProducts as $product)
                            <tr>
                                <td class="sorting_1">
                                    <a href="{{route('products.edit', $product->slug)}}" class="text-body">
                                        <img src="{{asset('storage/'.$product->thumb)}}" alt="img" title="contact-img" class="rounded mr-3" height="48">
                                    </a>
                                    <br>
                                </td>
                                <td class="sorting_1">{{$product->name}}</td>
                                <td>{{$product->category_name}}</td>
                                <td>{{$product->created_date}}</td>
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

