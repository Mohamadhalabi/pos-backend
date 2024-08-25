<div class=" col-md-6 col-lg-6 col-12   mt-3   ">
    <div class="card card-flush  h-100  ">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark">{{__('backend.order.details')}}</span>
                <span class="text-gray-400 mt-1 fw-bold fs-6">#{{$order->uuid}}</span>

            </h3>

            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body pt-5">
            {{-- created at --}}
            <div class="d-flex flex-stack">
                <div class="text-gray-700 fw-boldest fw-bold fs-6 me-2">  {{trans('backend.global.created_at')}}</div>
                <div class="d-flex align-items-senter">

                    <span class="    text-gray-900   fs-6    fs-6">{{$order->created_at}}</span>
                </div>
            </div>
            <div class="separator separator-dashed my-3"></div>
            {{-- type --}}
            <div class="d-flex flex-stack">
                <div class="text-gray-700 fw-boldest fs-6 me-2">Status</div>
                <div class="d-flex align-items-senter">

                    <span
                        class="text-gray-900 fw-boldest fs-6   ">
                        @php $class = $order->type == \App\Models\Order::$proforma? 'primary':'success' @endphp
                        <span class="badge-light-{{$class}} py-1 px-2 rounded-2">    {{$order->status }}
                        </span>
                </span>
                </div>
            </div>


            <div class="separator separator-dashed my-3"></div>

            {{--payment method--}}



        </div>
    </div>


</div>

