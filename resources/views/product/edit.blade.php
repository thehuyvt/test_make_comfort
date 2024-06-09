@extends('layout.master')
@push('css')
    <style>
        .image-preview {
            display: inline-block;
            margin-top: 10px;
            margin-right: 10px;
        }

        .image-preview img {
            max-width: 100px;
            max-height: 150px;
            margin-bottom: 5px;
        }

        .delete-icon {
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('dists/select2-4.0.13/dist/css/select2.min.css') }}">
    <link href="{{asset('css/vendor/summernote-bs4.css')}}" rel="stylesheet" type="text/css" />
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
                    <form action="{{route('products.update', $product->id)}}" id="form" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-xl-6" data-select2-id="6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           placeholder="Nhập tên sản phẩm" value="{{ $product->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control"
                                           placeholder="Nhập slug" value="{{ $product->slug }}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả sản phẩm</label>
{{--                                    <div id="summernote-basic"></div>--}}
                                    <textarea id="summernote-basic" class="form-control" id="description" name="description" rows="5"
                                              placeholder="Nhập mô tả">{{ $product->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="old_price">Giá cũ sản phẩm</label>
                                    <input type="number" min="0" id="old_price" name="old_price" class="form-control"
                                           placeholder="Giá sản phẩm" value="{{ $product->old_price }}">
                                </div>

                                <div class="form-group">
                                    <label for="sale_price">Giá bán</label>
                                    <input type="number" min="0" id="sale_price" name="sale_price" class="form-control"
                                           placeholder="Giá bán sản phẩm" value="{{ $product->sale_price }}">
                                </div>

                                <div class="form-group" data-select2-id="5">
                                    <label for="project-overview">Loại sản phẩm</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="category_id" data-toggle="select2"
                                    id='category_id' data-select2-id="1" tabindex="-1" aria-hidden="true">
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category->id}}"
                                                @selected($product->category_id == $category->id)
                                            >
                                                {{$category->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <div class="form-check">
                                        @foreach($listStatus as $key => $status)
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="status"
                                                id="status{{$key}}"
                                                value="{{$key}}"
                                                @checked($product->status == $key)
                                            >
                                            <label class="form-check-label mr-5" for="status{{$key}}">
                                                {{$status}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label id="options">Options</label>
                                    <table class="table" id="table_options">
                                        <input type="hidden" id="options_count" value="{{ count($product->options ?? []) }}">
                                        <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th width='75%'>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->options ?? [] as $key => $values)
                                                <tr>
                                                    <td>
                                                        <select class="form-control options_key" name="options_key[{{$key}}]">
                                                            <option selected>{{ $key }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control options_values" name="options_values[{{$key}}][]" multiple>
                                                            @foreach($values as $value)
                                                                <option value="{{ $value }}" selected>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                                    <label for="images">Ảnh sản phẩm</label>
                                    <input type="file" class="form-control-file" id="images" name="images[]" multiple accept="image/*">
                                    <div id="preview-container" class="image-preview">
                                        @foreach($product->images as $image)
                                            <input type="text" class="d-none" name="old_images[]" value="{{ $image->path }}">
                                            <img src="{{ asset('storage/'.$image->path) }}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="thumb">Ảnh chính</label>
                                    <input type="file" class="form-control-file" id="thumb" name="thumb" accept="image/*">
                                    <div id="thumb_preview" class="image-preview">
                                        @if($product->thumb)
                                            <img src="{{ asset('storage/'.$product->thumb) }}">
                                        @endif
                                    </div>
                                    <input type="text" class="d-none" name="old_thumb" value="{{ $product->thumb }}">
                                </div>
                            </div> <!-- end col-->
                            <div class="container mt-5 mb-5">
                                <h4>Variants</h4>
                                <table class="table" id="table_variants">
                                    <thead>
                                    <tr>
                                        @if($product->options)
                                            @foreach($product->options as $key => $values)
                                                <th>{{ $key }}</th>
                                            @endforeach
                                            <th>Số lượng</th>
                                        @endif
                                    </tr>

                                    </thead>
                                    <tbody>
                                        @foreach($product->variants as $variant)
                                            <tr>
                                                @foreach(explode('-', $variant->key) as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                                <td>
                                                    <input type="number" class="form-control" name="variants[{{ $variant->key }}]" value="{{ $variant->quantity }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-block btn-primary">
                                Lưu thông tin sản phẩm
                            </button>
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
    <script src="{{ asset('js/ui/component.fileupload.js')}}"></script>
    <script src="{{ asset('dists/select2-4.0.13/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('dists/jquery.form.js') }}"></script>
    <script src="{{ asset('dists/notify.min.js') }}"></script>
    <script src="{{ asset('js/vendor/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/pages/demo.summernote.js') }}"></script>
    <script>
        //Preview ảnh
        document.getElementById('images').addEventListener('change', function(event) {
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

                    previewContainer.appendChild(imagePreview);
                };

                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        });

        //Hiển thị ảnh thumb
        document.getElementById('thumb').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('thumb_preview');
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

        //Add options
        function setSelect2(){
            $('.options_values').select2({
                tags: true,
            });
            $('.options_key').select2({
                tags: true,
                ajax: {
                    delay: 250,
                    cache: true,
                    minimumInputLength: 1,
                    url: '{{ route('products.search-options') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            key: params.term,
                            category_id: $('#category_id').val(),
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item,
                                    id: item
                                }
                            })
                        };
                    },
                }
            });
        }

        $(document).ready(function () {
            $('#form').ajaxForm({
                beforeSubmit: function(arr, $form, options) {
                    console.log(arr, $form, options);
                    return true;
                },
                success:    function() {
                    $.notify("Cập nhật thành công", "success");
                },
                error: function(response){
                    $.notify("Không thành công, vui lòng kiểm tra", "error");

                    $('.error-message').remove();

                    errors = response.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        // nếu field chứa chữ images thì field sẽ thành images
                        if(field.includes('images')) {
                            field = 'images';
                            messages = ['Please select at least 1 image'];
                        }

                        var errorElement = 'error_' + field;
                        var inputElementId = '#' + field;

                        $(inputElementId).after(`
                        <div id="${errorElement}" class="error-message alert alert-danger">
                            ${messages.join(', ')}
                        </div>`);
                    });
                }
            });

            $('#name').on('input', function() {
                var name = $(this).val();
                var slug = convertToSlug(name);
                $('#slug').val(slug);
            });

            setSelect2();
            let index = $('#options_count').val();
            $('#btn_add_option').click(function () {
                // Tạo phần tử tr và td mới
                var $tr = $("<tr>");
                var $keyTd = $("<td>");
                var $valueTd = $("<td>");

                // Tạo và cấu hình các input
                var $key = $("<input>").attr({
                    type: "text",
                    class: "form-control options_key",
                    name: `options_key[${index}]`,
                });
                var $value = $("<select>").attr({
                    class: "form-control options_values",
                    multiple: true,
                    name: `options_values[${index}][]`,
                });
                index++;

                // Gắn các input vào các td
                $keyTd.append($key);
                $valueTd.append($value);

                // Gắn các td vào tr
                $tr.append($keyTd).append($valueTd);

                // Thêm tr vào table
                $("#table_options tbody").append($tr);
                setSelect2();
            });
            //nếu khi bấm nút generate thì sẽ tạo ra b
            var oldVariants = @json($product->variants ?? []);
            console.log(oldVariants);
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
                $headerRow.append('<th>Số lượng</th>'); // Thêm cột quantity
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
                            var check = true;
                            for (let i = 0; i < oldVariants.length; i++) {
                                if (oldVariants[i].key === variantKey) {
                                    $tr.append($('<td>').append($('<input>').attr({
                                        type: 'number',
                                        name: `variants[${variantKey}]`,
                                        class: 'form-control',
                                        value: oldVariants[i].quantity,
                                    })));
                                    check = false;
                                    break;
                                }
                            }
                            if (check){
                                $tr.append($('<td>').append($('<input>').attr({
                                    type: 'number',
                                    name: `variants[${variantKey}]`,
                                    class: 'form-control',
                                    value: '1'
                                })));// Cột quantity với input
                            }

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
        function convertToSlug(str) {
            // Hàm loại bỏ dấu tiếng Việt
            str = str.toLowerCase();
            str = str.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a');
            str = str.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e');
            str = str.replace(/i|í|ì|ỉ|ĩ|ị/g, 'i');
            str = str.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o');
            str = str.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u');
            str = str.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y');
            str = str.replace(/đ/g, 'd');
            // Loại bỏ các ký tự đặc biệt
            str = str.replace(/[^\w\s-]/g, '');
            // Thay thế khoảng trắng bằng dấu gạch ngang
            str = str.replace(/\s+/g, '-');
            // Loại bỏ dấu gạch ngang thừa
            str = str.replace(/-+/g, '-');
            return str;
        }
    </script>
@endpush
