@extends('layout.master')
@push('css')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-5 col-lg-6">
            <form id="search">
                <input 
                    type="date" 
                    name="date" 
                    class="form-control"
                    value="{{ date('Y-m-d') }}" 
                    id="date"
                    onchange="getAnalytic()"
                >
            </form>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon bg-primary-lighten text-primary"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Khách đăng ký mới</h5>
                            <h3 class="mt-3 mb-3 text-analytic" id="total_customer">0</h3>
                            <p class="mb-0 text-muted">
                                <span class="mr-2 text-analytic" id="total_customer-compare">0</span>
                                <br>
                                <span class="text-nowrap since-time">So với hôm qua</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-cart-plus widget-icon bg-danger-lighten text-warning"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0 " title="Number of Orders">Đơn hàng</h5>
                            <h3 class="mt-3 mb-3 text-analytic" id="total_order">0</h3>
                            <p class="mb-0 text-muted">
                                <span class="mr-2 text-analytic" id="total_order-compare">0</span>
                                <br>
                                <span class="text-nowrap since-time">So với hôm qua</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-currency-usd widget-icon bg-info-lighten text-info"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">Doanh thu</h5>
                            <h3 class="mt-3 mb-3 text-analytic" id="total_revenue">0</h3>
                            <p class="mb-0 text-muted">
                                <span class="mr-2 text-analytic" id="total_revenue-compare" >0</span>
                                <br>
                                <span class="text-nowrap since-time">So với hôm qua</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-pulse widget-icon bg-warning-lighten text-danger"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">Đơn hủy</h5>
                            <h3 class="mt-3 mb-3 text-analytic" id="total_cancel">0</h3>
                            <p class="mb-0 text-muted">
                                <span class="mr-2 text-analytic" id="total_cancel-compare">0</span>
                                <br>
                                <span class="text-nowrap since-time">So với hôm qua</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

        </div> <!-- end col -->

        <div class="col-xl-7  col-lg-6">
            <div class="card">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                        <p class="highcharts-description">
                            Biểu đồ thống kê số lượng đơn hàng trong 15 ngày gần đây
                        </p>
                    </figure>
            </div> <!-- end card-->

        </div> <!-- end col -->
        </div>
    </div>

{{--        Biểu đồ thống kê doanh thu và sản phẩm bán chạy--}}
        <div class="row">
            <div class="col-xl-5  col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container-1"></div>
                            <p class="highcharts-description">
                                Bảng thống kê các sản phẩm bán trong 15 ngày gần nhất
                            </p>
                        </figure>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div> <!-- end col -->

            <div class="col-xl-7  col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                            <p class="highcharts-description">
                                Biểu đồ thống kê số lượng đơn hàng cùng với doanh thu.
                            </p>
                        </figure>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>
@endsection

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script>
        $(document).ready(function () {
            //Biểu đồ thống kê đơn hàng
            $.ajax({
                url: '{{route('statistical.order-chart')}}',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Tạo biểu đồ Highcharts
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'E-commerce Performance Metrics'
                        },
                        xAxis: {
                            categories: data.date,
                            crosshair: true
                        },
                        yAxis: [{
                            min: 0,
                            title: {
                                text: 'Count'
                            }
                        }, {
                            title: {
                                text: 'Conversion Rate (%)'
                            },
                            opposite: true
                        }],
                        tooltip: {
                            shared: true
                        },
                        plotOptions: {
                            column: {
                                grouping: true
                            }
                        },
                        series: [{
                            name: 'Add to Cart',
                            data: data.add_to_cart,
                            tooltip: {
                                valueSuffix: ' times'
                            }
                        }, {
                            name: 'Checkout',
                            data: data.checkout,
                            tooltip: {
                                valueSuffix: ' times'
                            }
                        }, {
                            name: 'Orders',
                            data: data.order,
                            tooltip: {
                                valueSuffix: ' times'
                            }
                        }, {
                            name: 'Conversion Rate',
                            data: data.conversion_rate,
                            type: 'spline',
                            yAxis: 1,
                            tooltip: {
                                valueSuffix: ' %'
                            }
                        }]
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });

            //Biểu đồ thống kê sa phẩm bán chạy
            getAnalytic();
        });

        function getAnalytic() {
            $('.text-analytic').text('0');
            $.ajax({
                url: "{{ route('statistical.data') }}",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    date: $('#date').val()
                },
                type: "GET",
                success: function (data) {
                    let todayData = data[0];
                    let yesterdayData = data[1];
                    Object.keys(todayData).forEach(key => {
                        showAnalytic(key, todayData, yesterdayData);
                    })
                }
            })
        }

        function showAnalytic(key, todayData, yesterdayData){
            let data = Number (todayData[key]).toLocaleString('vi-VN');
            $(`#${key}`).text(data);

            let htmlCompare = '';
            let percentCompare = 0;
            if(todayData[key] === 0 || yesterdayData[key] === 0){
                percentCompare = 0;
            } else{
                percentCompare = ((todayData[key] - yesterdayData[key]) / yesterdayData[key]) * 100;
                percentCompare = percentCompare.toFixed(2);
            }

            if (percentCompare >= 0) {
                htmlCompare = `<i class="mdi mdi-arrow-up-bold"></i>${percentCompare}%`;
                classCompare = 'text-success';
            }else {
                htmlCompare = `<i class="mdi mdi-arrow-down-bold"></i>${percentCompare}%`;
                classCompare = 'text-danger';
            }
            $(`#${key}-compare`).html(htmlCompare);
            $(`#${key}-compare`).addClass(classCompare);
        }

        $.ajax({
            url: "{{ route('statistical.top-product-sell') }}",
            type: 'GET',
            success: function (response) {
                let totalQuantity = 0;
                let data = [];

                // Tính tổng số lượng bán
                response.forEach(function (product) {
                    totalQuantity += parseInt(product.total_quantity);
                });

                // Tính phần trăm và tạo dữ liệu cho Highcharts
                response.forEach(function (product) {
                    let percentage = (parseInt(product.total_quantity) / totalQuantity) * 100;
                    data.push({
                        name: product.name,
                        y: percentage,
                        quantity: product.total_quantity // Thêm thông tin số lượng bán để hiển thị tooltip
                    });
                });

                // Khởi tạo biểu đồ Highcharts
                Highcharts.chart('container-1', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Sản phẩm bán chạy'
                    },
                    tooltip: {
                        pointFormat: '<b>{point.quantity}</b>',
                        valueSuffix: '%'
                    },
                    plotOptions: {
                        series: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                distance: -50,
                                format: '{point.percentage:.1f}%',
                                style: {
                                    fontSize: '1.2em',
                                    textOutline: 'none',
                                    opacity: 0.7
                                },
                                filter: {
                                    operator: '>',
                                    property: 'percentage',
                                    value: 5
                                }
                            }
                        }
                    },
                    series: [
                        {
                            name: 'Percentage',
                            colorByPoint: true,
                            data: data
                        }
                    ]
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    </script>
@endpush
