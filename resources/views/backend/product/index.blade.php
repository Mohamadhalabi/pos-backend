@extends('backend.layout.app')
@section('title',trans('backend.menu.products').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('style')
    {!! datatable_style() !!}
@endsection
@section('content')
    <div class="col">
        <div class="card  flex-row-fluid mb-2">
            <div class="card-header">
                <h3 class="card-title"> {{trans('backend.menu.products')}}</h3>
                <div class="card-toolbar">
                    {!! @$create_button !!}
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-striped table-row-bordered gy-5 gs-7">
                    <thead>
                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th style="text-align: center"><input type="checkbox" id="select_all"/></th>
                        <th class="text-start">{{trans('backend.global.id')}}</th>
                        <th class="text-start ">{{trans('backend.product.sku')}}</th>
                        <th class="text-start">{{trans('backend.product.title')}}</th>
                        <!-- <th class="text-start">{{trans('backend.product.short_title')}}</th> -->
                        <!-- <th class="text-start">{{trans('backend.product.colors')}}</th> -->
                        <!-- <th class="text-start">{{trans('backend.product.manufacturer')}}</th> -->
                        <!-- <th class="text-start">{{trans('backend.product.type')}}</th> -->
                        <th class="text-start">{{trans('backend.product.image')}}</th>
                        <th class="text-start">{{trans('backend.product.price')}}</th>
                        <th class="text-start">{{trans('backend.product.sale_price')}}</th>
                        <th class="text-start">{{trans('backend.product.in_stock')}}</th>
                        <!-- <th class="text-start">{{trans('backend.product.priority')}}</th> -->
                        <th class="text-start">{{trans('backend.product.category')}}</th>
                        <th class="text-start">{{trans('backend.global.created_at')}}</th>
                        <th class="text-start">{{trans('backend.global.updated_at')}}</th>
                        <th class="text-start">{{trans('backend.global.status')}}</th>
                        <!-- <th class="text-start">{{trans('backend.product.featured')}}</th> -->
                        <!-- <th class="text-start">{{trans('backend.product.super_sales')}}</th> -->
                        <!-- <th class="text-start">{{trans('backend.product.best_seller')}}</th> -->
                        <!-- <th class="text-start">{{trans('backend.product.free_shipping')}}</th> -->
                        <th class="text-start min-w-250px">{{trans('backend.global.actions')}}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! datatable_script() !!}
    {!! $datatable_script !!}
    {!! $switch_script !!}
    {!!  $switch_script_featured !!}
    {!!  $switch_script_free_shipping !!}
    {!!  $switch_script_super_sales !!}
    {!!  $switch_script_best_seller !!}

    <script>
        var start = moment().subtract(29, "days");
        var end = moment();

        function cb(start, end) {
            $("#date").html(start.format("dd/mm/yyyy") + " - " + end.format("dd/mm/yyyy"));
        }

        $("#date").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                "{{trans('backend.global.today')}}": [moment().subtract(1, "days"), moment().endOf("day")],
                "{{trans('backend.global.yesterday')}}": [moment().subtract(1, "days"), moment().subtract(1, "days").endOf("day")],
                "{{trans('backend.global.last_7_days')}}": [moment().subtract(6, "days"), moment()],
                "{{trans('backend.global.last_30_days')}}": [moment().subtract(29, "days"), moment()],
                "{{trans('backend.global.this_month')}}": [moment().startOf("month"), moment().endOf("month")],
                "{{trans('backend.global.last_month')}}": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            },
            locale: {
                format: 'DD-MM-YYYY'
            }

        }, function (start, end, label) {
            $('#start_date').val(start.format('DD-MM-YYYY'));
            $('#end_date').val(end.format('DD-MM-YYYY'));
        });
        cb(start, end);

        $(document).on('change', '#brand', function () {
            var brand = $(this).val();
            var url = "{{route('backend.products.brands')}}";

            $.ajax({
                url: url,
                method: "post",
                data: {
                    '_token': "{{csrf_token()}}",
                    brand: brand,
                    model: null,
                }, success(response) {
                    $("#model").empty();
                    $("#model").append("<option selected value=''>All</option>");
                    $.each(response.data.models, function (key, value) {
                        $("#model").append("<option  value='" + key + "'>" + value + "</option>");
                    });
                }
            })
        });
        $(document).on('change', '#model', function () {
            var brand = $('#brand').val();
            var model = $(this).val();
            var url = "{{route('backend.products.brands')}}";

            $.ajax({
                url: url,
                method: "post",
                data: {
                    '_token': "{{csrf_token()}}",
                    brand: brand,
                    model: model,
                }, success(response) {
                    $("#year").empty();
                    $("#year").append("<option selected value=''>All</option>");
                    $.each(response.data.years, function (key, value) {
                        $("#year").append("<option  value='" + key + "'>" + value + "</option>");
                    });
                }
            })
        });
    </script>
@endsection
