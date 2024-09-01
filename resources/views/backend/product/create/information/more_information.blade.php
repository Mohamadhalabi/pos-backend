<div class="card card-flush">
    <div class="card-header">
        <div class="card-title">
            <h2>General</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 mt-2 ">
                <div class="form-group">
                    <label for="sku" class="required form-label">{{trans('backend.product.sku')}}</label>
                    <input type="text" class="form-control" required id="sku" name="sku" value="{{old('sku' , $sku)}}">
                    <b class="text-danger" id="error_sku"> @error('sku')<i class="fa fa-exclamation-triangle"></i> {{$message}}@enderror</b>
                </div>
            </div>

            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label class="required" for="price">{{trans('backend.product.price')}}</label>
                    <input type="number" step="0.01" class="form-control" name="price" id="price"
                           value="{{old('price')}}">
                    <b class="text-danger" id="error_price"> @error('price') <i
                            class="las la-exclamation-triangle"></i> {{$message}} @enderror
                    </b>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label for="sale_price">{{trans('backend.product.sale_price')}}</label>
                    <input type="number"   class="form-control" value="{{old('sale_price')}}"
                           name="sale_price"
                           id="sale_price">
                    <b class="text-danger" id="error_sale_price">     @error('sale_price') <i
                            class="las la-exclamation-triangle"></i> {{$message}} @enderror
                    </b>
                </div>
            </div>

            <div class="col-12 col-md-12 mt-2">
                <label for="category" class="required form-label">{{trans('backend.product.category')}}</label>
                <select data-control="select2" class="form-control" required id="category" name="category[]" data-placeholder="Select Category">
                    {!! \App\Models\Category::select2(old('category', []), 0, 0) !!}
                </select>
                <b class="text-danger" id="error_category"> @error('category') <i class="fa fa-exclamation-triangle"></i> {{$message}} @enderror</b>
            </div>

            <div class="col-12 col-md-12 mt-2">
                <div class="form-group">
                    <label >{{trans('backend.product.quantity')}}</label>
                    <input type="number" name="quantity" id="quantity"  class="form-control" value="0">
                </div>
            </div>       
        </div>
    </div>
</div>
