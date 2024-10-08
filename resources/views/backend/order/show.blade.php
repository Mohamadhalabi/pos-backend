@extends('backend.layout.app')
@section('title',trans('backend.menu.orders').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('style')
    {!! datatable_style() !!}
@endsection
@section('content')
    <div class="col">
        <div class="card   flex-row-fluid mb-2  ">
            <div class="card-header">
                <h3 class="card-title"> {{trans('backend.menu.orders')}}</h3>
            </div>
            <!--begin::Card Body-->
            <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
                <div class="table-responsive">
                    <table id="datatable" class="table  table-rounded table-striped border gy-7 w-100 gs-7">
                        <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200 small">
                            <th class="small">{{trans('backend.global.uuid')}}</th>
                            <th class="small">{{trans('backend.order.user')}}</th>
                            <th class="small">{{trans('backend.order.total')}}</th>
                            <th class="small">{{trans('backend.global.status')}}</th>
                            <th class="small">Date</th>
                            <th class="min-w-125px">{{trans('backend.global.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Card Body-->
        </div>
    </div>
@endsection
@section('script')
    {!! datatable_script() !!}
    {!! $datatable_script !!}
@endsection