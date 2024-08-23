<div class="col-md-6  col-lg-4 col-xl-4 col-md-6 col-12 m-auto">
    <!--begin::Mixed Widget 1-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Body-->
        <div class="card-body p-0">
            <!--begin::Header-->
            <div class="px-5 pt-5 card-rounded h-225px w-100 bg-primary">
                <!--begin::Heading-->
                <div class="d-flex flex-stack">
                    <h3 class="m-0 text-white fw-bolder fs-3">{{trans('backend.dashboard.order')}}</h3>

                </div>
                <!--end::Heading-->
                <!--begin::Balance-->
                <div class="d-flex text-center flex-column text-white pt-8">
                    <span class="fw-bold fs-7">{{trans('backend.dashboard.total')}} {{$count_order_processing}}</span>
                    <span class="fw-bolder fs-2x pt-1">{{$total_order_processing}} TL</span>
                </div>
                <!--end::Balance-->
            </div>
            <!--end::Header-->
            <!--begin::Items-->
            <div class="bg-body shadow-sm card-rounded mx-9  px-6 py-9 position-relative z-index-1" style="margin-top: -100px">
                <!--begin::Item-->
                <!--end::Item-->
                <!--begin::Item-->
                <!--end::Item-->
                <!--begin::Item-->
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-45px w-40px me-5">
															<span class="symbol-label bg-lighten">
																<!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor"></path>
																		<rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor"></rect>
																		<rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor"></rect>
																		<rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor"></rect>
																		<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
																	</svg>
																</span>
                                                                <!--end::Svg Icon-->
															</span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Description-->
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <!--begin::Title-->
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{route('backend.orders.index',['status_filter' => 'processing'])}}" class="fs-7 text-gray-800 text-hover-primary fw-bolder">{{trans('backend.dashboard.order_processing')}}</a>
                            <div class="text-gray-400 fw-bold fs-7">{{$count_order_processing}}</div>
                        </div>
                        <!--end::Title-->
                        <!--begin::Label-->
                        <div class="d-flex align-items-center">
                            <div class="fw-bolder fs-7 text-gray-800 pe-1">{{$total_order_processing}} TL</div>

                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Description-->
                </div>
                <!--end::Item-->
            </div>
            <!--end::Items-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Mixed Widget 1-->
</div>
