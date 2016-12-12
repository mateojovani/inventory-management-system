@extends('layouts.master')

@section('title')
    {{trans('title.clients')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('cl')
    class='active'
@endsection

@section('main')
    <!-- Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel-title col-sm-8">{{trans('clients.context')}}</div>
                        <div class="col-sm-4 text-right">
                            <a href="#" id="enable" class="btn btn-default">{{trans('ui.enable_btn')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h3 class="panel-title">{{trans('clients.form.add_client')}}</h3>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{trans('clients.form.name_label')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client-name" name="client-name" placeholder="{{trans('clients.form.name_placeholder')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{trans('clients.form.address')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client-address" name="client-address" placeholder="{{trans('clients.form.address')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{trans('clients.form.email')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client-email" name="client-email" placeholder="{{trans('clients.form.email')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{trans('clients.form.phone')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client-phone" name="client-phone" placeholder="{{trans('clients.form.phone')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{trans('clients.form.mobile')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client-mobile" name="client-mobile" placeholder="{{trans('clients.form.mobile')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success" id="add-btn">{{trans('clients.form.add')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th>{{trans('clients.context')}}</th>
                                <th>{{trans('clients.form.address')}}</th>
                                <th>{{trans('clients.form.email')}}</th>
                                <th>{{trans('clients.form.phone')}}</th>
                                <th>{{trans('clients.form.mobile')}}</th>
                                <th>{{trans('ui.datatables.actions')}}</th>
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
                url: "{{URL::asset('/grid/clients')}}",
                type: "post"
            },

            columns: [
                { "data": "client" },
                { "data": "address" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "mobile" },
                { "data": "id" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Name' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='client' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Address' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='address' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Email' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='email' class='editable'>"+data+"</a>"
                    },
                    targets: 2
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Phone' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='phone' class='editable'>"+data+"</a>"
                    },
                    targets: 3
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Mobile' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='mobile' class='editable'>"+data+"</a>"
                    },
                    targets: 4
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
                    },
                    targets: 5
                },
                { orderable: false, "targets": 5 }
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
                url: "{{URL::asset('/clients/edit')}}",
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
                    }
                    else {
                        toastr.success(response.message);
                    }
                }
            });
        });

        //delete event
        $('#table .delete-btn').livequery(function() {
            $(this).click(function () {
                $.ajax({
                    url: "{{URL::asset('/clients/delete')}}",
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

        //add event
        $('#add-btn').livequery(function() {
            $(this).click(function () {
                var data = {};
                data.client_name = $("#client-name").val();
                data.client_address = $("#client-address").val();
                data.client_email = $("#client-email").val();
                data.client_phone = $("#client-phone").val();
                data.client_mobile = $("#client-mobile").val();

                $.ajax({
                    url: "{{URL::asset('/clients/add')}}",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else {
                            toastr.success(response.message);
                            tbl.draw();
                            $("#client-name").val("");
                            $("#client-address").val("");
                            $("#client-email").val("");
                            $("#client-phone").val("");
                            $("#client-mobile").val("");
                        }
                    }
                });
            });
        });
    </script>
@endsection


@section('sources_bottom')
@endsection