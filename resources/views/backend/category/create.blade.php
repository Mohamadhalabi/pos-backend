@extends('backend.layout.app')
@section('title',trans('backend.menu.categories').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('content')
    <div class="col">
        <form action="{{route('backend.categories.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card flex-row-fluid mb-2  ">
                <div class="card-header">
                    <h3 class="card-title"> {{trans('backend.category.create_new_category')}}</h3>
                    <div class="card-toolbar">
                        <a href="{{route('backend.categories.index')}}" class="btn btn-info"><i
                                class="las la-redo fs-4 me-2"></i> {{trans('backend.global.back')}}</a>
                    </div>
                </div>
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
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label @if($key == 0 ) required @endif"
                                                   for="name_{{$item->code}}">{{trans('backend.category.name')}}</label>
                                            <input type="text" class="form-control" id="name_{{$item->code}}" @if($key == 0 ) required @endif
                                                   name="name_{{$item->code}}" value="{{old('name_'.$item->code)}}">
                                            @error('name_'.$item->code)<b class="text-danger"> <i
                                                    class="las la-exclamation-triangle"></i> {{$message}}</b>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="col form-group ">
                        
                        <br>
                            <label class="form-label" for="icon">200x200</label>
                            <br>
                            {!! single_image('icon' , media_file(old('icon')) , old('icon')  ) !!}
                            <br>
                            @error('icon')<b class="text-danger"> <i
                                    class="las la-exclamation-triangle"></i> {{$message}}</b>@enderror
                        </div>

                    <div class="form-group row">
                        <div class="col  align-items-center">

                        <br><br>
                        <div class="col form-group">
                            <label class="form-label" for="parent">{{trans('backend.category.parent')}}</label>
                            <select class="form-control parent" data-placeholder="{{trans('backend.category.parent')}}" data-control="select2" name="parent" id="parent">
                                <option selected value="0">{{trans('backend.category.parent')}}</option>

                                @foreach($categories as $category)
                                    @if($category->parent_id == NULL)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                @endforeach

                                <!--<option value="1">{{trans('backend.category.other_value')}}</option> <!-- Add the second value option -->-->
                            </select>
                            @error('parent')<b class="text-danger"> <i class="las la-exclamation-triangle"></i> {{$message}}</b>@enderror
                        </div>


                            <div class="form-group  align-items-center">
                                <br>
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-30px" @if(old('status') == 1 ) checked
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
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary">{{trans('backend.global.save')}}</button>
                </div>
        </form>
    </div>
@endsection
@section('script')
@endsection
