@extends('layouts.master')

@section('title')
    {{trans('products.form.configure_product')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('pr')
    class='active'
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{trans('products.form.configure_product')}}</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default">
                                <div class="panel-body">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#item-modal">{{trans('products.modals.existing')}}</button>
                                    <span><a href="#" id="enable-conf" class="btn btn-default">{{trans('ui.enable_btn')}}</a></span>
                                    <div class="table-responsive">
                                        <table id="config-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                            <tr>
                                                <th>{{trans('products.table.code')}}</th>
                                                <th>{{trans('products.table.name')}}</th>
                                                <th>{{trans('products.table.quantity')}}</th>
                                                <th>{{trans('ui.datatables.actions')}}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>

                                    <!-- get raw material -->
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-inline" id="new-row">
                                                <input type="hidden" id="item-pk" name="item-pk">
                                                <input type="hidden" id="product" name="product" value="{{$id}}">

                                                <input type="text" class="form-control" id="item-code" name="item-code" placeholder="{{trans('products.table.code')}}" disabled>

                                                <input type="text" class="form-control" id="item-name" name="item-name" placeholder="{{trans('products.table.name')}}" disabled>

                                                <input class="form-control" type="text" id="item-quantity" name="item-quantity" placeholder="{{trans('products.table.quantity')}}">

                                                <button type="submit" class="form-control" id="add-btn">{{trans('products.modals.add')}}</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>

                    <div class="modal fade bs-example-modal-lg" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myLargeModalLabel">{{trans('materials.context')}}</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table id="raw-materials-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>{{trans('materials.table.name')}}</th>
                                                <th>{{trans('materials.table.category')}}</th>
                                                <th>{{trans('materials.table.unity')}}</th>
                                                <th>{{trans('materials.table.price')}}</th>
                                                <th>{{trans('materials.table.type')}}</th>
                                                <th>{{trans('materials.table.vat')}}</th>
                                                <th>{{trans('materials.table.quantity')}}</th>
                                                <th>{{trans('ui.datatables.actions')}}</th>
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

                </div>
            </div>
        </div>
    </div>
    <script>
        //keys of selected records
        var keyArray = [];
        var url = "{{URL::asset('/grid/raw-materials')}}";

        function tableURL(key, action)
        {
            if(action == 'push')
                keyArray.push(key);
            else  keyArray.splice(keyArray.indexOf(key), 1);
            return url+"?selected="+keyArray;
        }

        function selectedMaterials(pk)
        {
            keyArray = [];
            $.ajax({
                url: "{{URL::asset('/product/raw-materials/get')}}",
                type: "POST",
                data: {id: pk},
                success: function (response) {
                    response.forEach(function(item, index){
                        keyArray.push(item.id);
                    });

                    rm_tbl.ajax.url("{{URL::asset('/grid/raw-materials')}}"+"?selected="+keyArray).load();
                }
            });
        }

        //config hide
        $("#new-row").hide();

        var rm_tbl = $('#raw-materials-table').DataTable({
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: url,
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
                { "data": "quantity" },
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
                                "class='select-btn btn btn-sm btn-danger'>{{trans('ui.datatables.select')}}</a>";
                    },
                    targets: 8
                },
                { orderable: false, "targets": 8 }
            ],

            language: {
                lengthMenu: "{{trans('ui.datatables.length')}}",
                zeroRecords: "{{trans('ui.datatables.zero_records')}}",
                info: "{{trans('ui.datatables.info')}}",
                infoEmpty: "{{trans('ui.datatables.info_empty')}}",
                search: "{{trans('ui.datatables.search')}}",
                paginate: {
                    previous: "{{trans('ui.datatables.previous')}}",
                    next: "{{trans('ui.datatables.next')}}"
                }
            }
        });

        //editable
        $.fn.editable.defaults.mode = 'inline';
        //enable / disable

        $('#enable-conf').livequery(function() {
            $(this).unbind().click(function () {
                $('#config-table .editable').editable('toggleDisabled');
            });
        });


        $('#config-table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/item-compound/edit')}}",
                disabled: true,
                validate: function(value) {
                    if($.trim(value) == '') {
                        return "{{trans('ui.editable.required')}}";
                    }
                },
                success: function(response) {
                    if(response.status != 200)
                    {
                        toastr.error(response.message);
                        return "";
                    }
                    else {
                        toastr.success(response.message);
                    }
                }
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
                rm_tbl.ajax.url(tableURL(pk, 'push'));
                rm_tbl.draw();
            });
        });


        //config table

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
                data: {id:  "{{$id}}"}
            },

            columns: [
                { "data": "code" },
                { "data": "item" },
                { "data": "quantity" },
                { "data": "id" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Item Quantity' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='item-quantity' class='editable'>"+data+"</a>"
                    },
                    targets: 2
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
                    },
                    targets: 3
                },
                { orderable: false, "targets": 3 }
            ],

            language: {
                lengthMenu: "{{trans('ui.datatables.length')}}",
                zeroRecords: "{{trans('ui.datatables.zero_records')}}",
                info: "{{trans('ui.datatables.info')}}",
                infoEmpty: "{{trans('ui.datatables.info_empty')}}",
                search: "{{trans('ui.datatables.search')}}",
                paginate: {
                    previous: "{{trans('ui.datatables.previous')}}",
                    next: "{{trans('ui.datatables.next')}}"
                }
            }
        });

        //add to item compounds
        $('#add-btn').livequery(function() {
            $(this).unbind().click(function () {
                var data = {};
                data.pk = $("#item-pk").val();
                data.product = $("#product").val();
                data.quantity = $("#item-quantity").val();

                $.ajax({
                    url: "{{URL::asset('/item-compound/add')}}",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else{
                            toastr.success(response.message);
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
                            toastr.error(response.message);
                        }
                        else {
                            toastr.success(response.message);
                            rm_tbl.ajax.url(tableURL($(this).attr('data-pk'), 'remove'));
                            rm_tbl.draw();
                            config_table.draw();
                        }
                    }
                });
            });
        });

    </script>
@endsection

@section('sources_bottom')
@endsection
