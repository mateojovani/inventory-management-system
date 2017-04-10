@extends('layouts.master')

@section('title')
    {{trans('title.configure')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('cf')
    class='active'
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel-title col-sm-8">{{trans('configure.context')}}</div>
                        <div class="col-sm-4 text-right">
                            <a href="#" id="enable" class="btn btn-default">{{trans('ui.enable_btn')}}</a>&nbsp;
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-white">
                <div class="panel-body">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab-category" role="tab" data-toggle="tab">{{trans('configure.tabs.categories')}}</a></li>
                            <li role="presentation"><a href="#tab-unity" role="tab" data-toggle="tab">{{trans('configure.tabs.unity')}}</a></li>
                            <li role="presentation"><a href="#tab-type" role="tab" data-toggle="tab">{{trans('configure.tabs.types')}}</a></li>
                            <li role="presentation"><a href="#tab-vat" role="tab" data-toggle="tab">{{trans('configure.tabs.vat')}}</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active fade in" id="tab-category">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">{{trans('configure.categories.form.add_category')}}</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="item-code" class="col-sm-2 control-label">{{trans('configure.categories.form.name')}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="category-name" name="category-name" placeholder="{{trans('configure.categories.form.name')}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">{{trans('configure.categories.form.type')}}</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control m-b-sm" id="category-item" name="category-item">
                                                                <option value="0">Raw Material</option>
                                                                <option value="1">Product</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-success" id="cat-btn">{{trans('configure.categories.form.add')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive col-md-6">
                                        <table id="cat-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                            <tr>
                                                <th>{{trans('configure.categories.name')}}</th>
                                                <th>{{trans('configure.categories.item')}}</th>
                                                <th>{{trans('ui.datatables.actions')}}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab-unity">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">{{trans('configure.unities.form.add_unity')}}</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="item-code" class="col-sm-2 control-label">{{trans('configure.unities.form.name')}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="unity-name" name="category-name" placeholder="{{trans('configure.unities.form.name')}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">{{trans('configure.unities.form.type')}}</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control m-b-sm" id="unity-item" name="unity-item">
                                                                <option value="0">Raw Material</option>
                                                                <option value="1">Product</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-success" id="unity-btn">{{trans('configure.unities.form.add')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-6">
                                        <table id="unity-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                            <tr>
                                                <th>{{trans('configure.unities.name')}}</th>
                                                <th>{{trans('configure.unities.item')}}</th>
                                                <th>{{trans('ui.datatables.actions')}}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab-type">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">{{trans('configure.types.form.add_type')}}</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="item-type" class="col-sm-2 control-label">{{trans('configure.types.form.name')}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="type-name" name="type-name" placeholder="{{trans('configure.types.form.name')}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">{{trans('configure.types.form.type')}}</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control m-b-sm" id="type-item" name="type-item">
                                                                <option value="0">Raw Material</option>
                                                                <option value="1">Product</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-success" id="type-btn">{{trans('configure.types.form.add')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-6">
                                        <table id="type-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                            <tr>
                                                <th>{{trans('configure.types.name')}}</th>
                                                <th>{{trans('configure.types.item')}}</th>
                                                <th>{{trans('ui.datatables.actions')}}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab-vat">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">{{trans('configure.vat.form.add_vat')}}</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="item-code" class="col-sm-2 control-label">{{trans('configure.vat.form.name')}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="vat-name" name="vat-name" placeholder="{{trans('configure.vat.form.name')}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">{{trans('configure.vat.form.value')}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="vat-value" name="vat-value" placeholder="{{trans('configure.vat.form.value_placeholder')}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-success" id="vat-btn">{{trans('configure.vat.form.add')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive col-md-6">
                                        <table id="vat-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                            <tr>
                                                <th>{{trans('configure.vat.name')}}</th>
                                                <th>{{trans('configure.vat.item')}}</th>
                                                <th>{{trans('ui.datatables.actions')}}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--delete modal-->
    <div id="delete-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <p>{{trans('ui.delete_confirm')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id='confirm-delete-btn' data-dismiss="modal">{{trans('ui.yes')}}</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        //editable
        $.fn.editable.defaults.mode = 'inline';
        //enable / disable
        $('#enable').livequery(function() {
            $(this).click(function () {
                $('#cat-table .editable').editable('toggleDisabled');
                $('#unity-table .editable').editable('toggleDisabled');
                $('#type-table .editable').editable('toggleDisabled');
                $('#vat-table .editable').editable('toggleDisabled');
            });
        });

        /* Category */
        //datatables
        var cat_tbl = $('#cat-table').DataTable({
            bProcessing: true,
            serverSide: true,
            bDestroy: true,
            bFilter: false,
            pageLength: 5,
            bLengthChange: false,
            ajax: {
                url: "{{URL::asset('/grid/categories')}}",
                type: "post"
            },

            columns: [
                { "data": "category" },
                { "data": "item" },
                { "data": "id" },
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Category' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='category' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        if(data == 0)
                            return "<a href='#' data-title='Select Item' " +
                                "data-pk='"+row.id+"' data-type='select' " +
                                "data-source='{{URL::asset('/configure/items')}}' "+
                                "data-name='name' "+
                                "class='editable'>Raw Material</a>";
                        else
                            return "<a href='#' data-title='Select Item' " +
                                    "data-pk='"+row.id+"' data-type='select' " +
                                    "data-source='{{URL::asset('/configure/items')}}' "+
                                    "data-name='type'"+
                                    "class='editable'>Product</a>";
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
                    },
                    targets: 2
                },
                { orderable: false, "targets": 2 }
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

        //delete event
        $('#cat-table .delete-btn').livequery(function() {
            $(this).unbind().click(function () {
                $('#delete-modal').modal('show');
                var pk = $(this).attr('data-pk');
                $('#confirm-delete-btn').unbind().click(function() {
                    $.ajax({
                        url: "{{URL::asset('/configure/category/delete')}}",
                        type: "POST",
                        data: {pk: pk},
                        success: function (response) {
                            if (response.status != 200) {
                                toastr.error(response.message)
                            }
                            else {
                                toastr.success(response.message);
                                cat_tbl.draw();
                            }
                        }
                    });
                });
            });
        });

        $('#cat-table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/configure/category/edit')}}",
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

        //submit form
        $('#cat-btn').unbind().livequery(function() {
            $(this).click(function () {
                var name = $('#category-name').val();
                var type = $('#category-item').val();
                $.ajax({
                    url: "{{URL::asset('/configure/category/add')}}",
                    type: "POST",
                    data: {name: name, type: type},
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else {
                            toastr.success(response.message);
                            cat_tbl.draw();
                        }
                    }
                });
            });
        });

        /* Unity */
        //datatables
        var unity_tbl = $('#unity-table').DataTable({
            bProcessing: true,
            serverSide: true,
            bDestroy: true,
            bFilter: false,
            pageLength: 5,
            bLengthChange: false,
            ajax: {
                url: "{{URL::asset('/grid/unity')}}",
                type: "post"
            },

            columns: [
                { "data": "unity" },
                { "data": "item" },
                { "data": "id" },
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Unity' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='unity' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        if(data == 0)
                            return "<a href='#' data-title='Select Item' " +
                                    "data-pk='"+row.id+"' data-type='select' " +
                                    "data-source='{{URL::asset('/configure/items')}}' "+
                                    "data-name='name' "+
                                    "class='editable'>Raw Material</a>";
                        else
                            return "<a href='#' data-title='Select Item' " +
                                    "data-pk='"+row.id+"' data-type='select' " +
                                    "data-source='{{URL::asset('/configure/items')}}' "+
                                    "data-name='type'"+
                                    "class='editable'>Product</a>";
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
                    },
                    targets: 2
                },
                { orderable: false, "targets": 2 }
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

        //delete event
        $('#unity-table .delete-btn').livequery(function() {
            $(this).unbind().click(function () {
                $('#delete-modal').modal('show');
                var pk = $(this).attr('data-pk');
                $('#confirm-delete-btn').unbind().click(function() {
                    $.ajax({
                        url: "{{URL::asset('/configure/unity/delete')}}",
                        type: "POST",
                        data: {pk: pk},
                        success: function (response) {
                            if (response.status != 200) {
                                toastr.error(response.message)
                            }
                            else {
                                toastr.success(response.message);
                                unity_tbl.draw();
                            }
                        }
                    });
                });
            });
        });


        $('#unity-table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/configure/unity/edit')}}",
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

        //submit form
        $('#unity-btn').unbind().livequery(function() {
            $(this).click(function () {
                var name = $('#unity-name').val();
                var type = $('#unity-item').val();
                $.ajax({
                    url: "{{URL::asset('/configure/unity/add')}}",
                    type: "POST",
                    data: {name: name, type: type},
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else {
                            toastr.success(response.message);
                            unity_tbl.draw();
                        }
                    }
                });
            });
        });

        /* Type */
        //datatables
        var type_tbl = $('#type-table').DataTable({
            bProcessing: true,
            serverSide: true,
            bDestroy: true,
            bFilter: false,
            pageLength: 5,
            bLengthChange: false,
            ajax: {
                url: "{{URL::asset('/grid/type')}}",
                type: "post"
            },

            columns: [
                { "data": "type" },
                { "data": "item" },
                { "data": "id" },
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Type' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='type' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        if(data == 0)
                            return "<a href='#' data-title='Select Item' " +
                                    "data-pk='"+row.id+"' data-type='select' " +
                                    "data-source='{{URL::asset('/configure/items')}}' "+
                                    "data-name='name' "+
                                    "class='editable'>Raw Material</a>";
                        else
                            return "<a href='#' data-title='Select Item' " +
                                    "data-pk='"+row.id+"' data-type='select' " +
                                    "data-source='{{URL::asset('/configure/items')}}' "+
                                    "data-name='type'"+
                                    "class='editable'>Product</a>";
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
                    },
                    targets: 2
                },
                { orderable: false, "targets": 2 }
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

        //delete event
        $('#type-table .delete-btn').livequery(function() {
            $(this).unbind().click(function () {
                $('#delete-modal').modal('show');
                var pk = $(this).attr('data-pk');
                $('#confirm-delete-btn').unbind().click(function() {
                    $.ajax({
                        url: "{{URL::asset('/configure/type/delete')}}",
                        type: "POST",
                        data: {pk: pk},
                        success: function (response) {
                            if (response.status != 200) {
                                toastr.error(response.message)
                            }
                            else {
                                toastr.success(response.message);
                                type_tbl.draw();
                            }
                        }
                    });
                });
            });
        });


        $('#type-table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/configure/type/edit')}}",
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

        //submit form
        $('#type-btn').unbind().livequery(function() {
            $(this).click(function () {
                var name = $('#type-name').val();
                var type = $('#type-item').val();
                $.ajax({
                    url: "{{URL::asset('/configure/type/add')}}",
                    type: "POST",
                    data: {name: name, type: type},
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else {
                            toastr.success(response.message);
                            type_tbl.draw();
                        }
                    }
                });
            });
        });

        /* VAT */
        //datatables
        var vat_tbl = $('#vat-table').DataTable({
            bProcessing: true,
            serverSide: true,
            bDestroy: true,
            bFilter: false,
            pageLength: 5,
            bLengthChange: false,
            ajax: {
                url: "{{URL::asset('/grid/vat')}}",
                type: "post"
            },

            columns: [
                { "data": "vat" },
                { "data": "value" },
                { "data": "id" },
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter VAT' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='vat-name' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Value' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='vat-value' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
                    },
                    targets: 2
                },
                { orderable: false, "targets": 2 }
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

        //delete event
        $('#vat-table .delete-btn').livequery(function() {
            $(this).unbind().click(function () {
                $('#delete-modal').modal('show');
                var pk = $(this).attr('data-pk');
                $('#confirm-delete-btn').unbind().click(function() {
                    $.ajax({
                        url: "{{URL::asset('/configure/vat/delete')}}",
                        type: "POST",
                        data: {pk: pk},
                        success: function (response) {
                            if (response.status != 200) {
                                toastr.error(response.message)
                            }
                            else {
                                toastr.success(response.message);
                                vat_tbl.draw();
                            }
                        }
                    });
                });
            });
        });

        $('#vat-table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/configure/vat/edit')}}",
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

        //submit form
        $('#vat-btn').unbind().livequery(function() {
            $(this).click(function () {
                var name = $('#vat-name').val();
                var type = $('#vat-value').val();
                $.ajax({
                    url: "{{URL::asset('/configure/vat/add')}}",
                    type: "POST",
                    data: {name: name, type: type},
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else {
                            toastr.success(response.message);
                            vat_tbl.draw();
                        }
                    }
                });
            });
        });

    </script>
@endsection

@section('sources_bottom')
@endsection