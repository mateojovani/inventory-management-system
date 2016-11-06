@extends('layouts.master')

@section('title')
    Products
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('pr')
    class='active'
@endsection

@section('main')
    <!-- Alerts -->

    <!-- Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel-title col-sm-8">Products</div>
                        <div class="col-sm-4 text-right">
                            <a href="#" id="enable" class="btn btn-default">Enable Editing</a>&nbsp;
                            <a href="{{URL::asset('products/add')}}" class="btn btn-info">Add</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Unity</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>VAT</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Code</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Unity</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>VAT</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>

            <!--Config Panel-->
            <div class="panel panel-white" id="config-panel">
                <div class="panel-heading">
                    <div class="panel-title">Configure Materials</div>
                    <button type="button" class="close" id="close-btn"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="config-table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Unity</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>VAT</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                    <hr>
                    <!-- get raw material -->
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#item-modal">Get Existing Item</button>
                        </div>
                    </div>
                    <br>
                    <div class="form-inline" id="new-row">
                        <input type="hidden" id="item-pk" name="item-pk">
                        <input type="hidden" id="product" name="product">

                        <input type="text" class="custom-input col-sm-1" id="item-code" name="item-code" placeholder="Code" disabled>

                        <input type="text" class="custom-input col-sm-2" id="item-name" name="item-name" placeholder="Item Name" disabled>

                        <select class="custom-input col-sm-2" id="item-category" name="item-category" disabled>
                            @foreach($categories as $category)
                                <option value="{{$category->value}}">{{$category->text}}</option>
                            @endforeach
                            </select>

                        <select class="custom-input col-sm-1" id="item-unity" name="item-unity" disabled>
                            @foreach($unities as $unity)
                                <option value="{{$unity->value}}">{{$unity->text}}</option>
                            @endforeach
                        </select>

                        <input type="text" class="custom-input col-sm-1" id="item-price" name="item-price" placeholder="Price" disabled>

                        <select class="custom-input col-sm-1" id="item-type" name="item-type" disabled>
                            @foreach($itemtypes as $itemtype)
                                <option value="{{$itemtype->value}}">{{$itemtype->text}}</option>
                            @endforeach
                        </select>

                        <select class="custom-input col-sm-1" id="item-vat" name="item-vat" disabled>
                            @foreach($itemvats as $itemvat)
                                <option value="{{$itemvat->value}}">{{$itemvat->text}}</option>
                            @endforeach
                        </select>

                        <input class="custom-input col-sm-1" type="text" id="item-quantity" name="item-quantity" placeholder="Quantity">

                        <button type="submit" class="btn btn-success" id="add-btn">Add</button>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--modal-->
    <div class="modal fade bs-example-modal-lg" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="raw-materials-table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Unity</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>VAT</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script>
        //config hide
        $("#config-panel").hide();
        $("#new-row").hide();
        $("#close-btn").livequery(function() {
            $(this).click(function () {
                $("#config-panel").hide();
            });
        });

        //datatables
        var tbl = $('#table').DataTable({
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: "{{URL::asset('/grid/products')}}",
                type: "post"
            },

            columns: [
                { "data": "code" },
                { "data": "item" },
                { "data": "category" },
                { "data": "unity" },
                { "data": "price" },
                { "data": "type" },
                { "data": "vat" },
                { "data": "id" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Item Code' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='item-code' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Item Name' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='item-name' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Select Category' " +
                                "data-pk='"+row.id+"' data-type='select' " +
                                "data-source='{{URL::asset('/products/categories')}}' " +
                                "data-name='item-category'"+
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 2
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Select Unity' " +
                                "data-pk='"+row.id+"' data-type='select' " +
                                "data-source='{{URL::asset('/products/unities')}}' "+
                                "data-name='item-unity'"+
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 3
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Item Price' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='item-price' class='editable'>"+data+"</a>"
                    },
                    targets: 4
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Select Type' " +
                                "data-pk='"+row.id+"' data-type='select' " +
                                "data-source='{{URL::asset('/products/types')}}' "+
                                "data-name='item-type'"+
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 5
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Select VAT' " +
                                "data-pk='"+row.id+"' data-type='select' " +
                                "data-source='{{URL::asset('/products/vat')}}' "+
                                "data-name='item-vat'"+
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 6
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='config-btn btn btn-sm btn-default'>Config</a> "+
                                "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>Delete</a>";
                    },
                    targets: 7
                },
                { orderable: false, "targets": 7 }
            ]
        });

        var rm_tbl = $('#raw-materials-table').DataTable({
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: "{{URL::asset('/grid/raw-materials')}}",
                type: "post"
            },

            columns: [
                { "data": "code" },
                { "data": "item" },
                { "data": "category" },
                { "data": "unity" },
                { "data": "price" },
                { "data": "type" },
                { "data": "vat" },
                { "data": "id" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-code='"+row.code+"' " +
                                "data-item='"+row.item+"' " +
                                "data-price='"+row.price+"' " +
                                "data-pk='"+row.id+"' " +
                                "data-category='"+row.category+"' " +
                                "data-unity='"+row.unity+"' " +
                                "data-type='"+row.type+"' " +
                                "data-vat='"+row.vat+"' " +
                                "class='select-btn btn btn-sm btn-danger'>Select</a>";
                    },
                    targets: 7
                },
                { orderable: false, "targets": 7 }
            ]
        });

        //editable
        $.fn.editable.defaults.mode = 'inline';
        //enable / disable
        $('#enable').livequery(function() {
            $(this).click(function () {
                $('#table .editable').editable('toggleDisabled');
            });
        });

        $('#table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/products/edit')}}",
                disabled: true,
                validate: function(value) {
                    if($.trim(value) == '') {
                        return 'This field is required';
                    }
                }
            });
        });

        //delete event
        $('#table .delete-btn').livequery(function() {
            $(this).unbind().click(function () {
                $.ajax({
                    url: "{{URL::asset('/products/delete')}}",
                    type: "POST",
                    data: {pk: $(this).attr('data-pk')},
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error('Product could not be deleted!')
                        }
                        else {
                            toastr.success('Product successfully removed!');
                            tbl.draw();
                        }
                    }
                });
            });
        });

        //select event
        $('#raw-materials-table .select-btn').livequery(function() {
            $(this).click(function () {
                var pk = $(this).attr('data-pk');
                var code = $(this).attr('data-code');
                var name = $(this).attr('data-item');
                var category = $(this).attr('data-category');
                var unity = $(this).attr('data-unity');
                var type = $(this).attr('data-type');
                var price = $(this).attr('data-price');
                var vat = $(this).attr('data-vat');

                $("#item-pk").val(pk);
                $("#item-code").val(code);
                $("#item-name").val(name);
                $("#item-price").val(price);
                $("#item-quantity").val("");

                $("#item-category option").filter(function() {
                    return $(this).text() == category;
                }).prop('selected', true);
                $("#item-unity option").filter(function() {
                    return $(this).text() == unity;
                }).prop('selected', true);
                $("#item-type option").filter(function() {
                    return $(this).text() == type;
                }).prop('selected', true);
                $("#item-vat option").filter(function() {
                    return $(this).text() == vat;
                }).prop('selected', true);

                $('#item-modal').modal('toggle');
                $("#new-row").show();
            });
        });


        //config table
        $('#table .config-btn').livequery(function() {
            $(this).click(function () {
                $('html, body').animate({ scrollTop: $('#config-panel').offset().top }, 'slow');
                $("#config-panel").show();
                $("#product").val($(this).attr('data-pk'));
                console.log($("#product").val());
                var config_table = $('#config-table').DataTable({
                    bProcessing: true,
                    serverSide: true,
                    bDestroy: true,
                    bFilter: false,
                    bPaginate: false,
                    bInfo : false,
                    ajax: {
                        url: "{{URL::asset('/grid/product/raw-materials')}}",
                        type: "post",
                        data: {id:  $(this).attr('data-pk')}
                    },

                    columns: [
                        { "data": "code" },
                        { "data": "item" },
                        { "data": "category" },
                        { "data": "unity" },
                        { "data": "price" },
                        { "data": "type" },
                        { "data": "vat" },
                        { "data": "quantity" },
                        { "data": "id" }
                    ],
                    columnDefs: [
                        {
                            render: function ( data, type, row ) {
                                return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>Delete</a>";
                            },
                            targets: 8
                        },
                        { orderable: false, "targets": 8 }
                    ]
                });

                //add to item compounds
                $('#add-btn').livequery(function() {
                    $(this).unbind().click(function () {
                        var data = {};
                        data.pk = $("#item-pk").val();
                        data.product = $("#product").val();
                        data.code = $("#item-code").val();
                        data.item = $("#item-name").val();
                        data.category = $("#item-category").val();
                        data.unity = $("#item-unity").val();
                        data.price = $("#item-price").val();
                        data.type = $("#item-type").val();
                        data.vat = $("#item-vat").val();
                        data.quantity = $("#item-quantity").val();

                        $.ajax({
                            url: "{{URL::asset('/item-compound/add')}}",
                            type: "POST",
                            data: data,
                            success: function (response) {
                                if(response.status != 200)
                                {
                                    toastr.error('Raw material could not be added!')
                                }
                                else{
                                    toastr.success('Raw material added successfully to the table');
                                    config_table.draw();
                                    $("#new-row").hide();
                                }
                            }
                        });
                    });
                });

                //delete event
                $('#config-table .delete-btn').livequery(function() {
                    $(this).unbind().click(function () {
                        $.ajax({
                            url: "{{URL::asset('/product/raw-materials/delete')}}",
                            type: "POST",
                            data: {pk: $(this).attr('data-pk')},
                            success: function (response) {
                                if(response.status != 200)
                                {
                                    toastr.error('Raw material could not be deleted!')
                                }
                                else {
                                    toastr.success('Raw material successfully removed!');
                                    config_table.draw();
                                    $('html, body').animate({ scrollTop: $('#panel').offset().top }, 'slow');
                                }

                            }
                        });
                    });
                });
            });

        });

    </script>
@endsection

@section('sources_bottom')
@endsection