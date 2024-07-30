<div class="aside-menu flex-column-fluid">
    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
         data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
         data-kt-scroll-offset="0">
        <div
            class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
            id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
            @include('backend.dashboard.sidebar')
            <div class="menu-item">
                <h4 class="menu-content text-muted mb-0 fs-7 text-uppercase">{{trans('backend.menu.products')}}</h4>
            </div>
            @include('backend.category.sidebar')
            @include('backend.attribute.sidebar')
            @include('backend.media.sidebar')
            @include('backend.manufacturer.sidebar')
            @include('backend.product.sidebar')
            @include('backend.coupon.sidebar')
            @include('backend.currency.sidebar')
            <div class="menu-item">
                <h4 class="menu-content text-muted mb-0 fs-7 text-uppercase">{{trans('backend.menu.orders')}}</h4>
            </div>
            @include('backend.order.sidebar')
            @include('backend.offer.sidebar')
            <div class="menu-item">
                <h4 class="menu-content text-muted mb-0 fs-7 text-uppercase">General</h4>
            </div>
            @include('backend.cms.sidebar')
            @include('backend.setting.sidebar')
            @include('backend.language.sidebar')
            @include('backend.statistics.sidebar')
            <div class="menu-item">
                <h4 class="menu-content text-muted mb-0 fs-7 text-uppercase">{{trans('backend.menu.users')}}</h4>
            </div>
            @include('backend.user.sidebar')
            @include('backend.management.sidebar')


        </div>
    </div>
</div>

