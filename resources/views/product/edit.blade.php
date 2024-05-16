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

    </style>
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
{{--                    <form action="{{route('products.update', $product->id)}}" method="post" enctype="multipart/form-data" data-plugin="dropzone"--}}
{{--                          data-previews-container="#file-images"--}}
{{--                          data-upload-preview-template=".upload-product-preview">--}}
                    <form action="{{route('products.update', $product->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl-6" data-select2-id="6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           placeholder="Nhập tên sản phẩm" value="{{$product->name}}">
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control"
                                           placeholder="Nhập slug" value="{{$product->slug}}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="5"
                                              placeholder="Nhập mô tả">{{$product->description}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="old_price">Giá sản phẩm</label>
                                    <input type="number" min="0" id="old_price" name="old_price" class="form-control"
                                           placeholder="Giá sản phẩm" value="{{$product->old_price}}">
                                </div>

                                <div class="form-group">
                                    <label for="sale_price">Giá bán sản phẩm</label>
                                    <input type="number" min="0" id="sale_price" name="sale_price" class="form-control"
                                           placeholder="Giá bán sản phẩm" value="{{$product->sale_price}}">
                                </div>

                                <div class="form-group" data-select2-id="5">
                                    <label for="project-overview">Loại sản phẩm</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="category_id" data-toggle="select2"
                                            data-select2-id="1" tabindex="-1" aria-hidden="true">
{{--                                        <option data-select2-id="3">Select</option>--}}
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}"
                                                    @if($category->id === $product->category_id) selected @endif>
                                                {{$category->name}}
                                            </option>
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
                                                   @if ($status->value === $product->status)
                                                       checked
                                                   @endif>
                                            <label class="form-check-label mr-5" for="status{{$status->value}}">
                                                {{$key}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                            </div> <!-- end col-->

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label>Ảnh sản phẩm</label>
                                    <div>
                                        @foreach($product->images as $image)
                                            <div class="image-preview">
                                                <img src="{{asset('storage\\').$image->path}}" class="preview-image">
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="product_images">Thay đổi ảnh sản phẩm</label>
                                    <input type="file" class="form-control-file" id="product_images" name="images[]" multiple>
                                    <div id="preview-container"></div>
                                </div>
                                <hr class="" style="width:100%;height:1px;border-width:0;color:gray;background-color:#ddd">
                                <div class="form-group">
                                    <label for="single_image">Ảnh đại diện</label>
                                    <div>
                                        <div class="image-preview">
                                            <img src="{{asset('storage\\').$image->path}}" class="preview-image">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="single_image">Thay đổi ảnh đại diện</label>
                                    <input type="file" class="form-control-file" id="single_image" name="thumb">
                                    <div id="single_image_preview">
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <hr class="mt-3 mb-3" style="width:100%;height:2px;border-width:0;color:gray;background-color:#ddd">
                            <div class="container mb-4">
                                <h4>Thêm các biến thể sản phẩm</h4>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Key</th>
                                        <th>Số lượng</th>
                                    </tr>
                                    </thead>
                                    <tbody id="variantsTableBody">
                                    <!-- Variants will be added here -->
                                    @foreach($product->variants as $variant)
                                        <tr>
                                            <td><input type="text" class="form-control" name="keys[]" value="{{$variant->key}}" placeholder="Key"></td>
                                            <td><input type="number" class="form-control" name="quantities[]" min="0" value="{{$variant->quantity}}" placeholder="0"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
{{--                                <span id="addVariantBtn" class="btn btn-primary">Thêm biến thể</span>--}}
                                <div class="d-flex justify-content-center">
                                    <span id="addVariantBtn" class="btn btn-outline-success btn-rounded btn-sm">Thêm </span>
                                </div>
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

        //Xu ly them option
        function addOption() {
            var variantsTableBody = document.getElementById('variantsTableBody');
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="keys[]" placeholder="Key"></td>
                <td><input type="number" class="form-control" name="quantities[]" min='0' placeholder="0"></td>
          `;
            variantsTableBody.appendChild(newRow);
        }
        addOption();
        document.getElementById('addVariantBtn').addEventListener('click', addOption);

    </script>

{{--    <script>--}}
{{--        Dropzone.autoDiscover = false;--}}
{{--        $(document).ready(function () {--}}
{{--            // Initialize Dropzone--}}
{{--            var myDropzone = new Dropzone("#my-dropzone", {--}}
{{--                url: "{{route('products.store')}}",--}}
{{--                addRemoveLinks: true,--}}
{{--                dictRemoveFile: "Remove",--}}
{{--                dictDefaultMessage: "Drop files here or click to upload",--}}
{{--                maxFiles: 1// Allow only one file to be uploaded--}}
{{--            });--}}

{{--            // Event when files are removed--}}
{{--            myDropzone.on("removedfile", function (file) {--}}
{{--                // Do something when a file is removed, for example, update your server-side storage--}}
{{--                console.log("File removed: " + file.name);--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endpush
