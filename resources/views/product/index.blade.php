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
                            <a href="{{route('products.create')}}" class="btn btn-danger mb-2"><i
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

                    </table>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@push('js')
    <!-- third party js -->
{{--    <script src="{{asset('js/vendor/jquery.dataTables.min.js')}}"></script>--}}
{{--    <script src="{{asset('js/vendor/dataTables.bootstrap4.js')}}"></script>--}}
{{--    <script src="{{asset('js/vendor/dataTables.responsive.min.js')}}"></script>--}}
{{--    <script src="{{asset('js/vendor/responsive.bootstrap4.min.js')}}"></script>--}}
{{--    <script src="{{asset('js/vendor/dataTables.checkboxes.min.js')}}"></script>--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.js"></script>
    <!-- third party js ends -->
    <script>
        $(function () {
            //select2
            // $('#select-courses').select2('data', null);

            //
            var buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            let table = $('#table-index').DataTable({
                dom:  'Blfrtip',
                select: true,
                "lengthMenu": [1, 10, 15, 20, 25],
                "pageLength": 10,
                buttons: [
                    $.extend(true, {}, buttonCommon, {
                        extend: 'excelHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'pdfHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'print'
                    }),
                    'colvis'
                ],
                processing: true,
                serverSide: true,
                ajax: '{!! route('products.api') !!}',
                columnDefs: [
                    {className: "not-export", "targets": [5]}
                ],
                columns: [
                    {
                        data: 'product',
                        targets: 0,
                        orderable: false,
                        searchable: true,
                        render: function (data) {
                            if (!data) {
                                return '';
                            } else {
                                var imageUrl = data['image'] ? "{{asset('storage')}}"+ "\\" + data['image'] : '';
                                var productId = data['id'] ? data['id'] : '';
                                return `<td class="sorting_1">
                                            <a href="{{route('products.edit', '')}}/${productId}" class="text-body">
                                                <img src="${imageUrl}" alt="img" title="contact-img" class="rounded mr-3" height="48">
                                            </a>
                                            <br>
                                        </td>`;
                            }
                        }
                    },
                    {data: 'name', name: 'name'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'sale_price', name: 'sale_price'},
                    {data: 'status', name: 'status'},
                    {
                        data: 'action',
                        targets: 6,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return `<td class="table-action">
<!--                                        <a href="${data['show']}" class="action-icon"> <i class="mdi mdi-eye"></i></a>-->
                                        <a href="${data['edit']}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                    </td>`;
                        }
                    },
                ]
            });

        });
    </script>
@endpush
