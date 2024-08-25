@extends('backend.layout.app')
@section('title',trans('backend.menu.sliders').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('content')
    <div class="col">
        <form action="{{route('backend.cms.sliders.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card flex-row-fluid mb-2  ">
                <div class="card-header">
                    <h3 class="card-title"> {{trans('backend.slider.create_new_slider')}}</h3>
                    <div class="card-toolbar">
                        <a href="{{route('backend.cms.sliders.index')}}" class="btn btn-info"><i
                                class="las la-redo fs-4 me-2"></i> {{trans('backend.global.back')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @foreach(get_languages() as $key=> $language)
                            <div class="tab-pane fade   @if($key == 0 )show active @endif" id="{{$language->code}}"
                                 role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label @if($key == 0)required @endif"
                                                   for="link_{{$language->code}}">{{trans('backend.slider.link')}}</label>
                                            <input type="text" class="form-control" @if($key == 0)required
                                                   @endif id="name_{{$language->code}}"
                                                   name="link_{{$language->code}}"
                                                   value="{{old('link_'.$language->code)}}">
                                            @error('link_'.$language->code)<b class="text-danger"> <i
                                                    class="las la-exclamation-triangle"></i> {{$message}}
                                            </b>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col form-group ">
                                        <label class="form-label"
                                               for="">Image 1800X454</label>
                                        <br>
                                        {!! single_image('image_'.$language->code , media_file(old('image_'.$language->code)) , old('image_'.$language->code) , 'image' , ['width'=>1800 ,'height'=>454 , 'watermark'=>'no']  ) !!}
                                        <br>
                                        @error('image_'.$language->code)<b class="text-danger"> <i
                                                class="las la-exclamation-triangle"></i> {{$message}}</b>@enderror
                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="card flex-row-fluid mb-2 mt-5  ">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col  align-items-center">
                            <div class="form-group  align-items-center">
                                <br>
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-30px" @if(old('status') == 1) checked
                                           @endif type="checkbox" value="1"
                                           name="status" id="status"/>
                                    <label class="form-check-label" for="status">
                                        {{trans('backend.global.do_you_want_active')}}
                                    </label>
                                </div>
                            </div>
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
@section('script')
    <script>
        var languags = {!! get_languages() !!}
        function check_size() {
            var width = $("#type").find(':selected').data('width');
            var height = $("#type").find(':selected').data('height');
            for (var i = 0; i < languags.length; i++) {
                $("#button_single_image_" + languags[i].code).attr('data-width', width);
                $("#button_single_image_" + languags[i].code).attr('data-height', height);
                $("label[for=image_" + languags[i].code + "]").text("{{trans('backend.slider.image')}} (" + height + '*' + width + ")")
            }
        }
        $(document).ready(function () {
            check_size()
        })
        $(document).on('change', '#type', function () {
            check_size();
        })
    </script>
@endsection
