<div class="card mt-3">
    <div class="card-body">
        @foreach([
'status',
] as $item)
            <div class="col-12 col-md-12">
                <div class="form-group  align-items-center">
                    <br>
                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-20px w-30px" @if(old($item, 0) == 1 ) checked
                               @endif type="checkbox"
                               value="1"
                               name="{{$item}}" id="{{$item}}"/>
                        <label class="form-check-label" for="{{$item}}">
                            {{trans('backend.product.'.$item)}}
                        </label>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>
