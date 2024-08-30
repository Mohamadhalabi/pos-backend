<div class="col">
    <div class=" card card-flush   ">

        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark">{{__('backend.order.details')}}</span>
            </h3>
            @if($order->status =="processing")
            <div class="card-toolbar">
                <div class="">
                    <button type="button" class="btn btn-primary">
                        <a style="color:white" href="{{auth('admin')->check() ? route('backend.orders.completed', $order->uuid) : route('seller.orders.download' ,$order->uuid)}}">
                            Convert to completed
                        </a>
                    </button>
                </div>
                <div class="" style="margin-left:10px">
                    <button type="button" class="btn btn-danger">
                    <a style="color:white" href="{{auth('admin')->check() ? route('backend.orders.cancel', $order->uuid) : route('seller.orders.download' ,$order->uuid)}}">
                    Cancel the order
                        </a>
                    </button>
                </div>
            </div>
            @endif
        </div>
        <div class="card-body">
            <div class="col-12">

                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                    @if($order->type != 'pin_code')
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab"
                               href="#products">{{trans('backend.menu.products')}}</a>
                        </li>
                    @elseif($order->type == 'pin_code')
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab"
                               href="#pin_code">{{trans('backend.order.pin_code')}}</a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content" id="information_tabs">
                    @if($order->type != 'pin_code')
                        <div class=" tab-pane fade show active" id="products">

                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                    <tr class="text-start text-gray-900 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px">{{__('backend.menu.products')}}</th>
                                        <th class="min-w-70px text-center">{{__('backend.product.sku')}}</th>
                                        <th class="min-w-70px text-center">{{__('backend.product.quantity')}}</th>
                                        <th class="min-w-100px text-center">{{__('backend.product.price')}}</th>
                                        <th class="min-w-100px text-center">{{__('backend.order.total')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                    @foreach($products as $product)
                                        <tr @if( !empty($product->is_bundle == 1)) class="  border-dark" @endif>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{route('backend.products.edit', ['product'=>$product->id])}}"
                                                       class="symbol    symbol-50px  ">
                                                        <img class="symbol-label"
                                                             onerror="this.src='{{media_file(get_setting('default_images'))}}'"
                                                             src=" {{media_file($product->image)}}">
                                                    </a>
                                                    <div class="ms-5">
                                                        @if($product->deleted_at != null)
                                                            <span
                                                                class="badge badge-warning">{{$product->title}} </span>

                                                        @elseif(auth('admin')->check())
                                                            <a href="{{route('backend.products.edit', ['product'=>$product->id])}}"
                                                               class="fw-bolder text-gray-600 text-hover-primary">{{$product->title}}</a>
                                                        @elseif(auth('seller')->check())
                                                            <a href="{{rtrim(get_setting('app_url'),'/').'/product/'.$product->slug}}"
                                                               class="fw-bolder text-gray-600 text-hover-primary">{{$product->title}}</a>
                                                        @endif
                                                        @if(!empty($product->pivot->coupon_discount))
                                                            <br>
                                                            <b class="text-danger"><i
                                                                    class="las la-gift text-danger"></i> {{exc_currency($product->pivot->coupon_discount, $order->exchange_rate , $currency->symbol)}}
                                                            </b>

                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{$product->sku}}</td>
                                            <td class="text-center">{{$product->pivot->quantity}}</td>

                                            <td class="text-center">{{$product->pivot->price}}</td>

                                            <td class="text-center">{{$product->pivot->quantity * $product->pivot->price}}</td> 

                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan="6"
                                                class="fs-3 text-success text-end">Shipping</td>
                                            <td class="text-success fs-3 fw-boldest text-end">{{$order->shipping}} TL</td>
                                        </tr>

                                        <tr>
                                            <td colspan="6"
                                                class="fs-3 text-success text-end">Vat</td>
                                            <td class="text-success fs-3 fw-boldest text-end">{{get_setting('vat')}} TL</td>
                                        </tr>
                                    @if($order->coupon_value != 0)
                                        <tr>
                                            <td colspan="6"
                                                class="fs-3 text-success text-end">{{__('backend.order.discount')}}</td>
                                            <td class="text-success fs-3 fw-boldest text-end">{{$order->coupon_value}} TL</td>
                                        </tr>
                                    @endif

                        


                                    <tr>
                                        <td colspan="6"
                                            class="fs-3 text-dark text-end">{{__('backend.order.total')}}</td>
                                            <td style="color:red;">
                                                {{$order->total}} TL
                                            </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @elseif($order->type == 'pin_code')
                        @php
                            $note = json_decode($order->note);
                            $brand = \App\Models\Brand::find($note->brand);
                            $brand = $brand->make;
                        @endphp
                        <div class=" tab-pane fade show active" id="pin_code">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">{{__('backend.order.brand')}}</th>
                                        <th class="min-w-70px ">{{__('backend.order.contact_channel')}}</th>
                                        <th class="min-w-70px ">{{__('backend.order.contact_value')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <td class="min-w-50px">{{$brand}}</td>
                                        <td class="min-w-50px">{{$note->contact_channel}}</td>
                                        <td class="min-w-50px">{{$note->contact_value}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="tab-pane fade " id="payments">
                        @include('orders.card.payment_history')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{__('backend.order.make_order_confirmation')}}</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
            </div>

            <form class="form fv-plugins-bootstrap5 fv-plugins-framework"
                  action="{{auth('admin')->check() ? route('backend.orders.make-order',$order->id) : route('seller.orders.make-order',$order->uuid) }}"
                  id="proforma_to_order">
                @csrf
                <div class="modal-body">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" name="payment_method" type="radio" value="transfer"
                               id="transfer_payment"/>
                        <label class="form-check-label"
                               for="transfer_payment">{{trans('backend.order.transfer')}}</label>
                    </div>
                    <br>
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" name="payment_method" type="radio" value="stripe_link"
                               id="stripe_link_payment_input"/>
                        <label class="form-check-label"
                               for="stripe_link_payment_input">{{trans('backend.order.stripe_link')}}</label>
                    </div>
                    <br>
                    <div class="w-100" style="display:none" id="stripe_link_dev">
                        <div class="d-flex">
                            <input id="stripe_link_value" type="text"
                                   class="form-control form-control-solid me-3 flex-grow-1"
                                   value="test"/>

                            <button type="button" id="stripe_link_payment_btn"
                                    class="btn btn-light fw-bold flex-shrink-0"
                                     >Copy Link
                            </button>
                        </div>
                        <!--end::Title-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{trans('backend.global.close')}}</button>
                    <button id="submit_save_convert" type="submit" class="btn btn-primary">{{trans('backend.global.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
