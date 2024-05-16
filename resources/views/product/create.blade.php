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
{{--                                <div class="form-group mt-3 mt-xl-0">--}}
{{--                                    <label for="projectname">Ảnh sản phẩm</label>--}}
{{--                                    --}}{{--                                    <p class="text-muted font-14">Recommended thumbnail size 800x400 (px).</p>--}}
{{--                                    <!-- File Upload -->--}}
{{--                                    <div class="dropzone">--}}
{{--                                        <div class="fallback">--}}
{{--                                            <input type="file" name="images"  value="{{old('images')}}"/>--}}
{{--                                        </div>--}}

{{--                                        <div class="dz-message needsclick">--}}
{{--                                            <i class="h1 text-muted dripicons-cloud-upload"></i>--}}
{{--                                            <h3>Drop files here or click to upload.</h3>--}}
{{--                                        </div>--}}

{{--                                        <!-- Preview -->--}}
{{--                                        <div class="dropzone-previews mt-3" id="file-images"></div>--}}

{{--                                        <!-- file preview template -->--}}
{{--                                        <div class="d-none upload-product-preview">--}}
{{--                                            <div class="card mt-1 mb-0 shadow-none border">--}}
{{--                                                <div class="p-2">--}}
{{--                                                    <div class="row align-items-center">--}}
{{--                                                        <div class="col-auto">--}}
{{--                                                            <img data-dz-thumbnail src="#"--}}
{{--                                                                 class="avatar-sm rounded bg-light"--}}
{{--                                                                 alt="">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col pl-0">--}}
{{--                                                            <a href="javascript:void(0);"--}}
{{--                                                               class="text-muted font-weight-bold"--}}
{{--                                                               data-dz-name></a>--}}
{{--                                                            <p class="mb-0" data-dz-size></p>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-auto">--}}
{{--                                                            <!-- Button -->--}}
{{--                                                            <a href="" class="btn btn-link btn-lg text-muted"--}}
{{--                                                               data-dz-remove>--}}
{{--                                                                <i class="dripicons-cross"></i>--}}
{{--                                                            </a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- end file preview template -->--}}
{{--                                </div>--}}

{{--                                <div class="form-group mt-3 mt-xl-0">--}}
{{--                                    <label for="projectname">Ảnh nhỏ</label>--}}
{{--                                    --}}{{--                                    <p class="text-muted font-14">Recommended thumbnail size 800x400 (px).</p>--}}
{{--                                    <div class="dropzone" id="my-dropzone">--}}
{{--                                        <div class="fallback">--}}
{{--                                            <input type="file" name="thumb"  value="{{old('thumb')}}"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="dz-message needsclick">--}}
{{--                                            <i class="h1 text-muted dripicons-cloud-upload"></i>--}}
{{--                                            <h3>Drop files here or click to upload.</h3>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- File Upload -->--}}
{{--                                </div>--}}

                            </div> <!-- end col-->
                            <div class="container mt-5 mb-5">
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
                                    </tbody>
                                </table>
                                <span id="addVariantBtn" class="btn btn-primary">Thêm biến thể</span>
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
