@if(permission_can('show statuses' ,'admin')||permission_can('show menus' ,'admin')||permission_can('show sliders' ,'admin') )
    <div data-kt-menu-trigger="click"
         class="menu-item menu-accordion @if(request()->routeIs('backend.cms.*') ) show @endif ">
									<span class="menu-link">
										<span class="menu-icon">
<!--begin::Svg Icon | path: assets/media/icons/duotune/art/art003.svg-->
<span class="svg-icon svg-icon-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
<path opacity="0.3" d="M6.45801 14.775L9.22501 17.542C11.1559 16.3304 12.9585 14.9255 14.605 13.349L10.651 9.39502C9.07452 11.0415 7.66962 12.8441 6.45801 14.775Z" fill="currentColor"/>
<path d="M9.19301 17.51C9.03401 19.936 6.76701 21.196 3.55701 21.935C3.34699 21.9838 3.12802 21.9782 2.92074 21.9189C2.71346 21.8596 2.52471 21.7484 2.37231 21.5959C2.2199 21.4434 2.10886 21.2545 2.04967 21.0472C1.99048 20.8399 1.98509 20.6209 2.034 20.411C2.772 17.201 4.03401 14.934 6.45801 14.775L9.19301 17.51ZM21.768 4.43697C21.9476 4.13006 22.0204 3.77232 21.9751 3.41963C21.9297 3.06694 21.7687 2.73919 21.5172 2.48775C21.2658 2.2363 20.9381 2.07524 20.5854 2.02986C20.2327 1.98449 19.8749 2.0574 19.568 2.23701C16.2817 4.20292 13.2827 6.61333 10.656 9.39998L14.61 13.354C17.395 10.7252 19.8037 7.72455 21.768 4.43697Z" fill="currentColor"/>
</svg></span>
                                            <!--end::Svg Icon-->
                     					</span>
										<span class="menu-title">{{trans('backend.menu.cms')}}</span>
										<span class="menu-arrow"></span>
									</span>
        <div class="menu-sub menu-sub-accordion  ">
                @if(permission_can('show sliders' ,'admin'))
                    <div class="menu-item @if(request()->routeIs('backend.cms.sliders.*')   ) show @endif">
                        <a class="menu-link" href="{{route('backend.cms.sliders.index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                            <span class="menu-title">{{trans('backend.menu.sliders')}}</span>
                        </a>
                    </div>
                @endif

        </div>
    </div>
@endif