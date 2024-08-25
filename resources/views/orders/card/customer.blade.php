@if(!empty($order->user_id))
<div class=" col-md-6 col-lg-6 col-12   mt-3 ">
    <div class="card card-flush    h-100   ">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark">{{__('backend.order.customer_details')}}</span>
            </h3>
        </div>
        <div class="card-body pt-5">
            {{-- user  --}}
            <div class="d-flex flex-stack">
                <div class="text-gray-700 fw-boldest fs-6 me-2">

                    {{trans('backend.order.user')}}
                </div>
                <a href="{{auth('seller')->check() ? route('seller.users.show' , $user->uuid) : route('backend.users.show' , $user->id)}}" class="d-flex align-items-senter">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <b class="  text-gray-900  text-hover-primary fs-6">
                                @if($user->deleted_at != null) <span class="badge badge-warning">
                                            {{$user->name}} </span> @else
                                    <span class="text-gray-900 text-hover-primary">{{$user->name}}</span>@endif</b>

                        </div>
                    </div>



                </a>
            </div>
            <div class="separator separator-dashed my-3"></div>

            {{-- email  --}}
            @if(!empty($user->email))
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-boldest fs-6 me-2">

                        {{trans('backend.auth.email')}}
                    </div>
                    <div class="d-flex align-items-senter">

                    <span class="text-gray-900 fs-6">
                                <a href="" style="font-size:  x-small"
                                   class="text-gray-900  fs-6  text-hover-primary">{{$user->email}}</a>

                    </span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
            @endif
            {{-- phone  --}}
            @if(!empty($user->phone))
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-boldest fs-6 me-2">

                        {{trans('backend.user.phone')}}
                    </div>
                    <div class="d-flex align-items-senter">

                    <span class="text-gray-900   fs-6">
                                <a href="" style="font-size:  x-small"
                                   class="text-gray-900  fs-6 text-hover-primary">{{$user->phone}}</a>

                    </span>
                    </div>
                </div>


            @endif


            @include('orders.card.seller')
        </div>

    </div>

</div>

@else
<div class=" col-md-6 col-lg-6 col-12   mt-3 ">
    <div class="card card-flush    h-100   ">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark">{{__('backend.order.customer_details')}}</span>
            </h3>
        </div>
        <div class="card-body pt-5">
            {{-- user  --}}
            <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-boldest fs-6 me-2">

                        Customer
                    </div>
                    <div class="d-flex align-items-senter">

                    <span class="text-gray-900   fs-6">
                                <a href="" style="font-size:  x-small"
                                   class="text-gray-900  fs-6 text-hover-primary">
                                {{$order->note}}
                                </a>

                    </span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
            {{-- phone  --}}
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-boldest fs-6 me-2">

                        {{trans('backend.user.phone')}}
                    </div>
                    <div class="d-flex align-items-senter">

                    <span class="text-gray-900   fs-6">
                                <a href="" style="font-size:  x-small"
                                   class="text-gray-900  fs-6 text-hover-primary">
                                {{$order->phone}}
                                </a>

                    </span>
                    </div>
                </div>
            {{--note--}}
            <div class="separator separator-dashed my-3"></div>

            <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-boldest fs-6 me-2">

                        Address
                    </div>
                    <div class="d-flex align-items-senter">

                    <span class="text-gray-900   fs-6">
                                <a href="" style="font-size:  x-small"
                                   class="text-gray-900  fs-6 text-hover-primary">
                                {{$order->address}}
                                </a>

                    </span>
                    </div>
                </div>
        </div>

    </div>

</div>

@endif


