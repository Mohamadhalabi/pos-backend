@extends('backend.layout.app')
@section('title',trans('backend.menu.setting').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('content')
    <div class="col">
        <form method="post" action="{{route('backend.setting.update')}}">
            @csrf
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                     aria-expanded="true">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{trans('backend.menu.setting')}}</h3>
                    </div>
                </div>
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                            @foreach(get_languages() as $key=> $item)
                                <li class="nav-item">
                                    <a class="nav-link  @if($key == 0 ) active @endif" data-bs-toggle="tab"
                                       href="#{{$item->code}}">{{$item->language}}</a>
                                </li>
                            @endforeach

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach(get_languages() as $key=> $item)
                                <div class="tab-pane fade   @if($key == 0 )show active @endif" id="{{$item->code}}"
                                     role="tabpanel">
                                    <div class="row mb-2">

                                        <label for="system_name_{{$item->code}}"
                                               class="col-lg-4 col-form-label required fw-bold fs-6">{{trans('backend.setting.system_name')}}</label>

                                        <input required autocomplete="off" type="text" class="form-control "
                                               id="system_name_{{$item->code}}" name="system_name_{{$item->code}}"
                                               value="{{old('system_name_'.$item->code, get_translatable_setting('system_name', $item->code))}}"
                                               placeholder="{{trans('backend.setting.system_name')}}"/>
                                        @error('system_name_'.$item->code) <b class="text-danger"><i
                                                    class="las la-exclamation-triangle"></i> {{$message}}
                                        </b> @enderror
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-5 mb-xl-10 flex-row-fluid p-2  ">
                <div class="card-body">




                        <div class="row mb-6">
                        <label for="system_logo_icon"
                        class="col-lg-4 col-form-label required fw-bold fs-6">{{trans('backend.setting.system_logo_icon')}}</label>
                            <div class="col-lg-8">


                                {!! single_image('system_logo_icon' , media_file(old('system_logo_icon',get_setting('system_logo_icon'))) , old('system_logo_icon',get_setting('system_logo_icon')),'image',['width'=>32 ,'height'=>32] ) !!}
                                <br>
                                @error('system_logo_icon') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror
                            </div>

                        </div>
                        <div class="row mb-6">
                        <label for="system_logo_white"
                            class="col-lg-4 col-form-label required fw-bold fs-6">{{trans('backend.setting.system_logo_white')}}</label>

                            <div class="col-lg-8">


                                {!! single_image('system_logo_white' , media_file(old('system_logo_white',get_setting('system_logo_white'))) , get_setting('system_logo_white') ,'image',['width'=>50 ,'height'=>50]) !!}
                                <br>
                                @error('system_logo_white') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror
                            </div>

                        </div>
                        <div class="row mb-6">
                        <label for="system_logo_black"
                        class="col-lg-4 col-form-label required fw-bold fs-6">{{trans('backend.setting.system_logo_black')}}</label>
                            <div class="col-lg-8">


                                {!! single_image('system_logo_black' , media_file(old('system_logo_black',get_setting('system_logo_black'))) , get_setting('system_logo_black'),'image',['width'=>1035 ,'height'=>316] ) !!}
                                <br>
                                @error('system_logo_black') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror
                            </div>

                        </div>
                        <div class="row mb-6">
                        <label for="default_images"
                            class="col-lg-4 col-form-label fw-bold fs-6">{{trans('backend.setting.default_images')}}</label>
                            <div class="col-lg-8">


                                {!! single_image('default_images' , media_file(old('default_images',get_setting('default_images'))) , get_setting('default_images') ,'image',['width'=>400 ,'height'=>400]) !!}
                                <br>
                                @error('default_images') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror
                            </div>

                        </div>

                        <div class="row mb-6">
                            <div class="col-lg-6 col-12">
                            <label for="shipping_price"
                            class="col-lg-12 col-form-label fw-bold fs-6">{{trans('backend.setting.shipping_price')}}</label>
                                <input type="number" id="shipping_price" value="{{get_setting('shipping_price')}}" step="any" name="shipping_price" class="form-control" />
                           </div>
                        </div>


                        <div class="col">
                        <div class=" mb-10">
                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-30px" @if(get_setting('free_shipping') == 1) checked @endif type="checkbox" value="1"
                                       name="free_shipping" id="free_shipping"/>
                                <label class="form-check-label" for="free_shipping">
                                {{trans('backend.setting.free_shipping')}}
                                </label>
                            </div>
                        </div>
                        </div>

                        
                        <div class="row mb-6">
                            <div class="col-lg-6 col-12">
                            <label for="vat"
                            class="col-lg-12 col-form-label fw-bold fs-6">{{trans('backend.setting.vat')}}</label>
                                <input type="number" id="vat" value="{{get_setting('vat')}}" step="any" name="vat" class="form-control" />
                           </div>
                        </div>

                        <div class="row mb-6">
                            <div class="col-lg-6 col-12">
                            <label for="longitude"
                            class="col-lg-4 col-form-label fw-bold fs-6">{{trans('backend.setting.longitude')}}</label>
                                <input type="number" id="longitude" value="{{get_setting('longitude')}}" step="any" name="longitude" class="form-control" />
                           </div>
                           <div class="col-lg-6 col-12">
                           <label for="latitude"
                            class="col-lg-4 col-form-label fw-bold fs-6">{{trans('backend.setting.latitude')}}</label>
                                <input type="number" id="latitude" step="any" value="{{get_setting('latitude')}}" name="latitude" class="form-control" />
                             </div>
                             <div class="col-lg-4 col-8 mt-4">
                             <button type="button" id="getLocation" class="btn btn-warning">{{trans('backend.setting.get_location')}}</button>
                             </div>
                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary">{{trans('backend.global.save')}}</button>
                    </div>
            </div>
        </form>

    </div>

@endsection
