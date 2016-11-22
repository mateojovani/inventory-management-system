@extends('en.layouts.master')

@section('title')
    Add Product
@endsection

@section('sources_top')
    @include('en.layouts._sources_tbl_top')
@endsection

@section('pr')
    class='active'
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Product</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="col-md-8"><br>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="item-code" class="col-sm-2 control-label">Item Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item-code" name="item-code" placeholder="Item Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item-name" class="col-sm-2 control-label">Item Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item-name" name="item-name" placeholder="Item Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item-price" class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item-price" name="item-price" placeholder="Price">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Item Category</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-category" id="item-category">
                                        @foreach($categories as $category)
                                            <option value="{{$category->value}}">{{$category->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Item Unity</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-unity" id="item-unity">
                                        @foreach($unities as $unity)
                                            <option value="{{$unity->value}}">{{$unity->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Item Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-type" id="item-type">
                                        @foreach($itemtypes as $itemtype)
                                            <option value="{{$itemtype->value}}">{{$itemtype->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">VAT</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-vat" id="item-vat">
                                        @foreach($itemvats as $itemvat)
                                            <option value="{{$itemvat->value}}">{{$itemvat->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item-quantity" class="col-sm-2 control-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item-quantity" name="item-quantity" placeholder="Quantity">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success" id="save-btn">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        //submit form
        $('#save-btn').livequery(function() {
            $(this).unbind().click(function () {
                var data = {};
                data.code = $("#item-code").val();
                data.name = $("#item-name").val();
                data.price = $("#item-price").val();
                data.category = $("#item-category").val();
                data.unity = $("#item-unity").val();
                data.type = $("#item-type").val();
                data.vat = $("#item-vat").val();
                data.quantity = $("#item-quantity").val();

                $.ajax({
                    url: "{{URL::asset('/products/add')}}",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message);
                        }
                        else{
                            toastr.success(response.message);
                            window.location.href = "{{URL::asset('/products')}}";
                        }
                    }
                });
            });
        });
    </script>
@endsection

@section('sources_bottom')
@endsection
