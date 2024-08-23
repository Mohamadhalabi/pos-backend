@extends('backend.layout.app')
@section('title',trans('backend.menu.setting').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('content')
    <div class="col">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                 aria-expanded="true">
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">{{trans('backend.setting.social.contact')}}</h3>
                </div>
            </div>
            <div class="collapse show">
                {{ Form::model( array('method' => 'POST', 'route' => array('backend.setting.social.update'))) }}
                @csrf
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label for="contact_whatsapp"
                               class="col-lg-4 col-form-label required fw-bold fs-6">{{trans('backend.setting.social.social_whatsapp')}}</label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" id="contact_whatsapp" name="contact_whatsapp"
                                   class="form-control form-control-lg form-control-solid"
                                   value="{{old('contact_whatsapp',get_setting('contact_whatsapp'))}}">
                            @error('contact_whatsapp')<b class="text-danger"><i
                                        class="las la-exclamation-triangle"></i> {{$message}}</b> @enderror
                        </div>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary">{{trans('backend.global.save')}}</button>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>


@endsection
