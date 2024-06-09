@extends('layout.master')
@push('css')
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
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-5 col-lg-6">

            <div class="row">
                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon bg-success-lighten text-success"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Customers</h5>
                            <h3 class="mt-3 mb-3">36,254</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                <span class="text-nowrap since-time">Since last month</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-cart-plus widget-icon bg-danger-lighten text-danger"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">Đơn hàng</h5>
                            <h3 class="mt-3 mb-3" id="sum-orders">0</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2" id="order-percent"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                                <span class="text-nowrap since-time">Since last month</span>
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
                            <h3 class="mt-3 mb-3" id="sum-revenue">0</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2" ><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>
                                <span class="text-nowrap since-time">Since last month</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-pulse widget-icon bg-warning-lighten text-warning"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">Đơn hủy</h5>
                            <h3 class="mt-3 mb-3" id="sum-cancel-order">0</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2" id="cancel-order-percent"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                                <span class="text-nowrap since-time">Since last month</span>
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
                            Biểu đồ thống kê số lượng đơn hàng cùng với doanh thu.
                        </p>
                    </figure>
            </div> <!-- end card-->

        </div> <!-- end col -->
        </div>
    </div>

{{--        Biểu đồ thống kê doanh thu và sản phẩm bán chạy--}}
        <div class="row">
            <<div class="col-xl-5  col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container-1"></div>
                            <p class="highcharts-description">
                                Sản phẩm bán chạy
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
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        $(document).ready(function () {
            //Biểu đồ thống kê đơn hàng
            Highcharts.chart('container', {

                title: {
                    text: 'Biểu đồ thống kê đơn hàng 7 ngày gần nhất',
                    align: 'left'
                },
                yAxis: {
                    title: {
                        text: 'Đơn hàng'
                    }
                },

                xAxis: {
                    categories: [22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33],
                    accessibility: {
                        rangeDescription: '10 ngày gần nhất'
                    },
                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                //
                // plotOptions: {
                //     series: {
                //         label: {
                //             connectorAllowed: false
                //         },
                //         pointStart: 2010
                //     }
                // },

                series: [
                    {
                    name: 'Đơn hàng',
                    data: [
                        1, 2, 3, 4, 2, 1,
                        1, 2, 4, 5, 7
                    ]
                },
                // {
                //     name: 'Sales & Distribution',
                //     data: [
                //         11744, 30000, 16005, 19771, 20185, 24377,
                //         32147, 30912, 29243, 29213, 25663
                //     ]
                // }
                ],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }

            });

            //Biểu đồ thống kê sa phẩm bán chạy
            Highcharts.chart('container-1', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Sản phẩm bán chạy'
                },
                tooltip: {
                    valueSuffix: '%'
                },
                // subtitle: {
                //     text:
                //         'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
                // },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: [{
                            enabled: true,
                            distance: 20
                        }, {
                            enabled: true,
                            distance: -40,
                            format: '{point.percentage:.1f}%',
                            style: {
                                fontSize: '1.2em',
                                textOutline: 'none',
                                opacity: 0.7
                            },
                            filter: {
                                operator: '>',
                                property: 'percentage',
                                value: 10
                            }
                        }]
                    }
                },
                series: [
                    {
                        name: 'Percentage',
                        colorByPoint: true,
                        data: [
                            {
                                name: 'Water',
                                y: 55.02
                            },
                            {
                                name: 'Fat',
                                y: 26.71
                            },
                            {
                                name: 'Carbohydrates',
                                y: 1.09
                            },
                            {
                                name: 'Protein',
                                y: 15.5
                            },
                            {
                                name: 'Ash',
                                y: 1.68
                            }
                        ]
                    }
                ]
            });
            getSumRevenue();
            getOrders();
        });

        function getSumRevenue() {
            $.ajax({
                url: "/statistical/sum-revenue",
                type: "GET",
                success: function (data) {
                    let sumRevenue = Number (data.total_revenue).toLocaleString('vi-VN');
                    $("#sum-revenue").text(sumRevenue + "đ");
                }
            })
        }

        function getOrders() {
            $.ajax({
                url: "statistical/sum-orders",
                type: "GET",
                success: function (data) {
                    let orders = Number (data.orders).toLocaleString();
                    let cancelOrders = Number (data.cancel_orders).toLocaleString();
                    $("#sum-orders").text(orders);
                    $("#sum-cancel-order").text(cancelOrders);
                }
            })
        }
    </script>
@endpush
