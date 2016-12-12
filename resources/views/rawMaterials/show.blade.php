@extends('layouts.master')

@section('title')
    {{trans('title.materials')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('rm')
    class='active'
@endsection

@section('main')
    <!-- Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel-title col-sm-8">{{trans('materials.context')}}</div>
                        <div class="col-sm-4 text-right">
                            <a href="#" id="enable" class="btn btn-default">{{trans('ui.enable_btn')}}</a>&nbsp;
                            <a href="{{URL::asset('raw-materials/add')}}" class="btn btn-info">{{trans('materials.form.add')}}</a>
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
                                <th>{{trans('materials.table.code')}}</th>
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
                            <tfoot>
                            <tr>
                                <th>{{trans('materials.table.code')}}</th>
                                <th>{{trans('materials.table.name')}}</th>
                                <th>{{trans('materials.table.category')}}</th>
                                <th>{{trans('materials.table.unity')}}</th>
                                <th>{{trans('materials.table.price')}}</th>
                                <th>{{trans('materials.table.type')}}</th>
                                <th>{{trans('materials.table.vat')}}</th>
                                <th>{{trans('materials.table.quantity')}}</th>
                                <th>{{trans('ui.datatables.actions')}}</th>
                            </tr>
                            </tfoot>

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
                { "data": "quantity" },
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
                                "data-source='{{URL::asset('/raw-materials/categories')}}' " +
                                "data-name='item-category'"+
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 2
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Select Unity' " +
                                "data-pk='"+row.id+"' data-type='select' " +
                                "data-source='{{URL::asset('/raw-materials/unities')}}' "+
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
                                "data-source='{{URL::asset('/raw-materials/types')}}' "+
                                "data-name='item-type'"+
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 5
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Select VAT' " +
                                "data-pk='"+row.id+"' data-type='select' " +
                                "data-source='{{URL::asset('/raw-materials/vat')}}' "+
                                "data-name='item-vat'"+
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 6
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
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
        $('#enable').livequery(function() {
            $(this).click(function () {
                $('#table .editable').editable('toggleDisabled');
            });
        });

        $('#table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/raw-materials/edit')}}",
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
                    else
                    {
                        toastr.success(response.message);
                    }
                }
            });
        });

        //delete event
        $('#table .delete-btn').livequery(function() {
            $(this).click(function () {
                $.ajax({
                    url: "{{URL::asset('/raw-materials/delete')}}",
                    type: "POST",
                    data: {pk: $(this).attr('data-pk')},
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else {
                            toastr.success(response.message);
                            tbl.draw();
                        }
                    }
                });
            });
        });

    </script>
@endsection

@section('sources_bottom')
@endsection