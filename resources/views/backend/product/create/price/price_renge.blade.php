<div class="col-12">
    <div class="card card-flush mt-3">
        <div class="card-header">
            <div class="card-title">
                <h2>Offer</h2>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <div class="col">
                    <table class="table table-hover table-bordered table-striped text-center" style="overflow-x: scroll">
                        <thead class="bg-dark text-light ">
                        <tr>
                            <th>{{trans('backend.product.from')}}</th>
                            <th>{{trans('backend.product.to')}}</th>
                            <th>{{trans('backend.product.price')}}</th>
                            <th class="">{{trans('backend.global.actions')}}</th>


                        </tr>
                        </thead>
                        <tbody id="offer_table">

                        @if(!empty(old('from', [])))
                            @foreach(old('from' ) as  $key=>$from)
                                <tr data-row='{{$key}}'>
                                    <td><input type='number' value="{{$from}}" required class='form-control' name='from[]'></td>
                                    <td><input type='number'  @if(!empty(old('to')[$key]))  value="{{old('to')[$key]}}" @endif
                                        required class='form-control' name='to[]'></td>

                                    <td><input required type='number'
                                               @if(!empty(old('packages_price')[$key])) value="{{old('packages_price')[$key]}}"
                                               @endif  step="0.01"  class='form-control ' name='packages_price[]'></td>
                                    <td>
                                        <button type='button' data-uuid='{{$key}}'
                                                class='btn btn-danger btn-icon btn-sm remove-row'><i class='fa fa-times'></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <button type="button" class="btn btn-icom btn-primary" id="add_new_offer"><i
                                        class=" fa fa-plus"></i> {{trans('backend.product.add_new_offer')}}
                                </button>
                            </td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            </div>
    </div>
</div>
