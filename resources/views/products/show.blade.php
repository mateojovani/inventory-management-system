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
            <div class="panel panel-white" id="panel">
                <div class="panel-heading">
                    <div class="panel-title">Configure Materials</div>
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
                                <th>Actions</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
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
            $(this).click(function () {
                $.ajax({
                    url: "{{URL::asset('/products/delete')}}",
                    type: "POST",
                    data: {pk: $(this).attr('data-pk')}
                });
                tbl.row($(this).attr('data-pk')).remove().draw();
            });
        });

        //config table
        $('#table .config-btn').livequery(function() {
            $(this).click(function () {
                $('html, body').animate({ scrollTop: $('#panel').offset().top }, 'slow');
                var config_table = $('#config-table').DataTable({
                    bProcessing: true,
                    serverSide: true,
                    bDestroy: true,
                    bFilter: false,
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
                        { "data": "id" }
                    ],
                    columnDefs: [
                        {
                            render: function ( data, type, row ) {
                                return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>Delete</a>";
                            },
                            targets: 7
                        },
                        { orderable: false, "targets": 7 }
                    ]
                });

                //delete event
                $('#config-table .delete-btn').livequery(function() {
                    $(this).click(function () {
                        $.ajax({
                            url: "{{URL::asset('/product/raw-materials/delete')}}",
                            type: "POST",
                            data: {pk: $(this).attr('data-pk')}
                        });
                        config_table.row($(this).attr('data-pk')).remove().draw();
                        $('html, body').animate({ scrollTop: $('#panel').offset().top }, 'slow');
                    });
                });
            });
        });

    </script>
@endsection

@section('sources_bottom')
@endsection