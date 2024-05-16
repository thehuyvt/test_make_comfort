@extends('layout.master')
@push('css')
    <style>
        .image-preview {
            display: inline-block;
            margin-right: 10px;
        }

        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            margin-bottom: 5px;
        }

        .delete-icon {
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('dists/select2-4.0.13/dist/css/select2.min.css') }}">
@endpush
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data" data-plugin="dropzone"
                          data-previews-container="#file-images"
                          data-upload-preview-template=".upload-product-preview">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6" data-select2-id="6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           placeholder="Nhập tên sản phẩm" value="{{old('name')}}">
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control"
                                           placeholder="Nhập slug" value="{{old('slug')}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="5"
                                              placeholder="Nhập mô tả">{{old('description')}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="old_price">Giá sản phẩm</label>
                                    <input type="number" min="0" id="old_price" name="old_price" class="form-control"
                                           placeholder="Giá sản phẩm" value="{{old('old_price')}}">
                                </div>

                                <div class="form-group">
                                    <label for="sale_price">Giá bán sản phẩm</label>
                                    <input type="number" min="0" id="sale_price" name="sale_price" class="form-control"
                                           placeholder="Giá bán sản phẩm" value="{{old('sale_price')}}">
                                </div>

                                <div class="form-group" data-select2-id="5">
                                    <label for="project-overview">Loại sản phẩm</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="category_id" data-toggle="select2"
                                            data-select2-id="1" tabindex="-1" aria-hidden="true">
{{--                                        <option data-select2-id="3">Select</option>--}}
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="form-check">
                                        @foreach($listStatus as $key => $status)
                                            <input class="form-check-input" type="radio" name="status" id="status{{$status->value}}"
                                                   value="{{$status->value}}"
                                                   @if ($loop->first)
                                                       checked
                                                   @endif>
                                            <label class="form-check-label mr-5" for="status{{$status->value}}">
                                                {{$key}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Options</label>
                                    <table class="table" id="table_options">
                                        <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th width='75%'>Values</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control options_key">
                                                </td>
                                                <td>
                                                    <select multiple class="select2 options_values"></select>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">
                                                    <button type="button" id="btn_add_option" class="btn btn-secondary">
                                                        Add option
                                                    </button>
                                                    <button type="button" id="btn_generate" class="btn btn-primary">
                                                        Generate
                                                    </button>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div> <!-- end col-->

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="product_images">Ảnh sản phẩm</label>
                                    <input type="file" class="form-control-file" id="product_images" name="images[]" multiple>
                                    <div id="preview-container"></div>
                                </div>
                                <div class="form-group">
                                    <label for="single_image">Ảnh đại diện</label>
                                    <input type="file" class="form-control-file" id="single_image" name="thumb">
                                    <div id="single_image_preview"></div>
                                </div>
                            </div> <!-- end col-->
                            <div class="container mt-5 mb-5">
                                <h4>Variants</h4>
                                <table class="table" id="table_variants">
                                    <thead>
                                        <tr>
                                            <!-- Đầu bảng sẽ được thêm động -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Các hàng sẽ được thêm vào đây -->
                                    </tbody>
                                </table>
                            </div>
                            <input type="submit" class="btn btn-block btn-primary" value="Thêm sản phẩm">
                        </div>
                    </form>

                    <!-- end row -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
@endsection
@push('js')
    <script src="{{asset('js/vendor/dropzone.min.js')}}"></script>

    <!-- File upload js -->
    <script src="{{asset('js/ui/component.fileupload.js')}}"></script>
    <script src="{{ asset('dists/select2-4.0.13/dist/js/select2.min.js') }}"></script>

    <script>

        document.getElementById('product_images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // Xóa bất kỳ xem trước nào đã tồn tại trước đó

            const files = event.target.files;
            for (const file of files) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imagePreview = document.createElement('div');
                    imagePreview.classList.add('image-preview');

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.classList.add('preview-image');
                    imagePreview.appendChild(img);

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Xóa';
                    deleteButton.classList.add('delete-button');
                    deleteButton.addEventListener('click', function() {
                        previewContainer.removeChild(imagePreview);
                        // Có thể thêm mã ở đây để xóa ảnh tương ứng khỏi cơ sở dữ liệu hoặc bất kỳ xử lý nào khác.
                    });

                    imagePreview.appendChild(deleteButton);
                    previewContainer.appendChild(imagePreview);
                };

                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        });

        document.getElementById('single_image').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('single_image_preview');
            previewContainer.innerHTML = ''; // Xóa bất kỳ xem trước nào đã tồn tại trước đó

            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                const imagePreview = document.createElement('div');
                imagePreview.classList.add('image-preview');

                const img = document.createElement('img');
                img.src = event.target.result;
                img.classList.add('preview-image');
                imagePreview.appendChild(img);

                previewContainer.appendChild(imagePreview);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        });

        function setSelect2(){
            $('.options_values').select2({
                tags: true
            });
        }
        $(document).ready(function () {
            setSelect2();
            $('#btn_add_option').click(function () {
                // Tạo phần tử tr và td mới
                var $tr = $("<tr>");
                var $keyTd = $("<td>");
                var $valueTd = $("<td>");

                // Tạo và cấu hình các input
                var $key = $("<input>").attr({
                    type: "text",
                    class: "form-control options_key",
                });
                var $value = $("<select>").attr({
                    class: "form-control options_values",
                    multiple: true,
                });

                // Gắn các input vào các td
                $keyTd.append($key);
                $valueTd.append($value);

                // Gắn các td vào tr
                $tr.append($keyTd).append($valueTd);

                // Thêm tr vào table
                $("#table_options tbody").append($tr);
                setSelect2();
            });

            $('#btn_generate').click(function() {
                var options = {}; // Đối tượng để lưu trữ tất cả các options

                // Thu thập tất cả các options từ các input và select
                $('.options_key').each(function(index) {
                    var key = $(this).val();
                    var values = $(this).closest('tr').find('.options_values').val() || [];
                    options[key] = values;
                });

                // Tạo tiêu đề cho bảng
                var $headerRow = $('#table_variants thead tr');
                $headerRow.empty(); // Làm trống tiêu đề cũ
                $headerRow.append('<th>Quantity</th>'); // Thêm cột quantity
                Object.keys(options).forEach(function(key) {
                    $headerRow.prepend($('<th>').text(key)); // Thêm tiêu đề cột cho mỗi option
                });

                // Tạo các hàng dựa trên sự kết hợp của các options
                var productVariants = generateProductVariants(Object.keys(options), options);
                var $tbody = $('#table_variants tbody');
                $tbody.empty(); // Làm trống tbody trước khi thêm hàng mới
                productVariants.forEach(function(variant) {
                    let variantKey = [];
                    var $tr = $('<tr>');
                    let values = Object.keys(variant);

                    values.forEach(function(key, index) {
                        $tr.prepend($('<td>').text(variant[key]));
                        variantKey.push(variant[key]);
                        
                        if(index === values.length - 1){
                            variantKey = variantKey.join('-');
                            $tr.append($('<td>').append($('<input>').attr({
                                type: 'number',
                                name: `options[${variantKey}]`,
                                class: 'form-control',
                                value: '1'
                            }))); // Cột quantity với input
                        }
                    });
                    $tbody.append($tr);
                });
            });
        });

        function generateProductVariants(optionKeys, options) {
            var results = [];
            var currentCombo = {};

            function combineOptions(depth) {
                if (depth === optionKeys.length) {
                    results.push({...currentCombo});
                    return;
                }

                var optionKey = optionKeys[depth];
                var values = options[optionKey];

                if (values.length === 0) values = ['']; // Nếu không có giá trị nào, thêm một giá trị rỗng

                values.forEach(function(value) {
                    currentCombo[optionKey] = value;
                    combineOptions(depth + 1);
                });
            }

            combineOptions(0);
            return results;
        }
    </script>
@endpush
